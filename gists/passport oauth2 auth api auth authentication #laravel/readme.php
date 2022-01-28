/*
https://laravel.com/docs/5.5/passport
http://esbenp.github.io/2017/03/19/modern-rest-api-laravel-part-4/
https://www.youtube.com/watch?v=9i_0ia1eCdA
https://scotch.io/@neo/getting-started-with-laravel-passport
https://oauth2.thephpleague.com/authorization-server/which-grant/
*/

// add dependency to composer
composer require laravel/passport

// below laravel 5.4, register the provider in config/app.php
<?php
// ...
'providers' => [
  // ...
  Laravel\Passport\PassportServiceProvider::class
]
?>

// migrate needed tables (beginning with "oauth_...")
// the migrations are independent from the database migrations and are not found in the migrations folder
php artisan migrate

// now create encryption keys and clients (in oauth_clients)
php artisan passport:install

// modify User.php and add a trait
<?php
// ...
use Laravel\Passport\HasApiTokens;
// ...
class User extends Authenticable
{
   use hasApiTokens;
   use Notifiable;
   // ...
}
?>

// add routes function to app/Providers/AuthServiceProvider.php and set reasonable expiration times
<?php
// ...
use Laravel\Passport\Passport;
use Carbon\Carbon;
// ...
public function boot()
{
    $this->registerPolicies();
    
    Passport::routes();
    Passport::tokensExpireIn(Carbon::now()->addMinutes(10)); // access token lifetime
    Passport::refreshTokensExpireIn(Carbon::now()->addDays(10)); // refresh token lifetime; should be the same or more than in config/session.php 'lifetime'
}
?>

// enable passport in config (config/auth.php) and execute php artisan config:cache afterwards
<?php
'guards' => [
  // ...       
  'api' => [
    'driver' => 'passport',
    'provider' => 'users',
  ],
],
?>
  
// if you get a database error (user could not be authenticated), run this to create a config file (where you edit the sql credentials):
php artisan vendor:publish --tag=passport-config

// now create a simple protected route in routes/api.php
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// in laravel <5.5 catch the newest .htaccess from laravel 5.5 (with the following lines)
# Handle Authorization Header
RewriteCond %{HTTP:Authorization} .
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
 
// to allow login with email OR username and case insensitive, add this to User.php
<?php
// ...
public function findForPassport($identifier) {
  return $this->whereRaw('LOWER(email) = ?', [mb_strtolower($identifier)])
    ->orWhereRaw('LOWER(username) = ?', [mb_strtolower($identifier)])
    ->first();
}

// to allow "login on behalf of", add this to User.php
<?php
public function validateForPassportPasswordGrant($password) {
  if (Input::get('login_on_behalf_of_access_token') !== null) {
    $http = new \GuzzleHttp\Client();
    $response = $http->get(url('/') . '/api/user', ['headers' => ['Authorization' => Input::get('login_on_behalf_of_access_token')], 'http_errors' => false]);
    if ($response->getStatusCode() != 200) { return false; }
    $user_id = json_decode((string) $response->getBody())->data->id;
    Auth::login(User::find($user_id));
    // now check if the current user is able to login as another user based on custom rules
    return Auth::user()->id == 42;
  }
  return Hash::check($password, $this->password);
}  

// hide authentication from error log, edit app/Exceptions/Handler.php
<?php
protected $dontReport = [
  /* ... */
  \League\OAuth2\Server\Exception\OAuthServerException::class,
  \Laravel\Passport\Exceptions\OAuthServerException::class
];


// now we have fully setup laravel passport / oauth2
// we can interact with the routes /oauth/token etc. in a normal manner
// but we want the following things:
// - provide a very simple api with custom routes for logging in and logging out
// - not showing client_id and client_secret to the consuming client
// - simplifying scopes
// - adding the possibility to generate new access tokens through refresh tokens
// we do not use Implicit Grant (because that breaks the user flow)
// we simply introduce a proxy that adds the client id and secret to the request
           
// we first add three routes in routes/api.php
Route::post('login', 'ApiController@login');
Route::post('login/refresh', 'ApiController@refresh');
Route::post('logout', 'ApiController@logout')->middleware('auth:api');
           
// and then we add the ApiController.php:
<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        return $this->proxy([
            'grant_type' => 'password',
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'login_on_behalf_of_access_token' => $request->header('Authorization') // only needed if you want to enable "login on behalf of"
        ]);
    }
    public function refresh(Request $request)
    {
        return $this->proxy([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->cookie('refreshToken')
        ]);
    }
    public function proxy($params)
    {
        $http = new Client();
        $client = DB::table('oauth_clients')->where('name', 'LIKE', '%Password Grant Client')->first();
    
        if ($client === null)
        {
            return response()->json([
                'success' => false,
                'message' => 'something went wrong',
            ], 401);
        }
      
        $response = $http->post(url('/').'/oauth/token', [
            'form_params' => array_merge($params, [
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'scope' => '*',
            ]),
            'http_errors' => false
        ]);

        if ($response->getStatusCode() != 200)
        {
            return response()->json([
                'success' => false,
                'message' => 'something went wrong',
            ], $response->getStatusCode());
        }        

        $data = json_decode((string)$response->getBody());

        // attach a refresh token to the response via HttpOnly cookie
        return response([
            'success' => true,
            'data' => [
                'access_token' => $data->access_token,
                'expires_in' => $data->expires_in
            ]
        ])->cookie(
            'refreshToken',
            $data->refresh_token,
            (60 * 24 * 10), // 10 days (should be the same as in AuthServiceProvider.php)
            null,
            null,
            false,
            true // HttpOnly
        );
    }
    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);
        $accessToken->revoke();
        return response([
            'success' => true
        ])->cookie(Cookie::forget('refreshToken'));
    }
}


  
// after that we simply can get the token and use it in all further requests

// e.g. with postman
Method: POST
URL: http://laravel.local/api/login
Body (form-data):
username: david@vielhuber.de
password: 123456

Method: GET
URL: http://laravel.local/api/user
Headers:
Authorization = Bearer TOKEN
  
Method: POST
URL: http://laravel.local/api/logout
Headers:
Authorization = Bearer TOKEN
  
Method: POST
URL: http://laravel.local/api/login
Body (form-data):
username: other@vielhuber.de
password: 
Authorization = Bearer TOKEN

// e.g. with laravel itself
Route::get('/test', function() {
    $http = new GuzzleHttp\Client;
    // login
    $response = $http->post('http://laravel.local/api/login', [
        'form_params' => [
            'username' => 'david@vielhuber.de',
            'password' => '123456'
        ],
    ]);    
    // store this in session/local storage/cookie and use it for all futher requests
    $auth = json_decode((string)$response->getBody());
    // example call
    $response = $http->get('http://laravel.local/api/user', [
        'headers' => [
            'Authorization' => 'Bearer '.$auth->data->access_token,
        ]
    ]);
    // result
    dump((string)$response->getBody());
    // logout
    $response = $http->post('http://laravel.local/api/logout', [
        'headers' => [
            'Authorization' => 'Bearer '.$auth->data->access_token,
        ]
    ]);
});
           
// and here is a full javascript implementation with auto refresh cookie mechanism
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', () => {
                // login
                document.querySelector('#login').addEventListener('click', (e) => {
                    login(
                        document.querySelector('#username').value,
                        document.querySelector('#password').value,
                        () => {
                            alert('successfully logged in');
                        },
                        () => {
                            alert('an error occured');
                        }
                    );
                    e.preventDefault();
                });
                // logout
                document.querySelector('#logout').addEventListener('click', (e) => {
                    logout(() => {
                        alert('successfully logged out');
                    });
                    e.preventDefault();
                });
                // fetch
                document.querySelector('#fetch').addEventListener('click', (e) => {
                    call(
                        document.querySelector('#fetch').getAttribute('data-route'),
                        'GET',
                        null,
                        (response) => {
                            console.log(response);
                        },
                        (error) => {
                            console.log(error);
                        }
                    );
                    e.preventDefault();
                });

                function call(route, method, data, complete = null, error = null) {
                    method = method.toUpperCase();
                    var url = null;
                    if (route.indexOf('http') > -1) {
                        url = route;
                    } else {
                        url =
                            window.location.protocol +
                            '//' +
                            window.location.host +
                            '/' +
                            (route.indexOf('api/') === -1 ? 'api/' : '') +
                            route;
                    }

                    let headers = {};
                    headers['Authorization'] = 'Bearer ' + localStorage.getItem('accessToken');
                    let body = null;
                    if (method !== 'GET') {
                        body = data;
                        // also accept FormData
                        if (data === null || !(data instanceof FormData)) {
                            headers['Content-Type'] = 'application/json';
                            body = JSON.stringify(data);
                        }
                    }

                    let status = null;
                    fetch(url, {
                        method: method,
                        body: body,
                        cache: 'no-cache',
                        headers: headers
                    })
                        .then((response) => {
                            let data = response.json();
                            status = response.status;
                            if (status == 200 || status == 304) {
                                return data;
                            }
                            return { success: false, message: status };
                        })
                        .catch((error) => {
                            return { success: false, message: error };
                        })
                        .then((response) => {
                            console.log(JSON.stringify(response));
                            if (status == 401 || localStorage.getItem('accessToken') === null) {
                                // OK, the auth seems to be have expired
                                // rerequest new auth with request token saved as httponly
                                fetch(window.location.protocol + '//' + window.location.host + '/api/login/refresh', {
                                    method: 'POST',
                                    body: null,
                                    cache: 'no-cache',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    }
                                })
                                    .then((response) => {
                                        console.log(JSON.stringify(response));
                                        let data = response.json(),
                                            status = response.status;
                                        if (status == 200 || status == 304) {
                                            return data;
                                        }
                                        return { success: false, message: status };
                                    })
                                    .catch((error) => {
                                        return { success: false, message: error };
                                    })
                                    .then((response) => {
                                        if (response.success !== true) {
                                            localStorage.removeItem('accessToken');
                                            window.location.href =
                                                window.location.protocol +
                                                '//' +
                                                window.location.host +
                                                '/' +
                                                'logout';
                                        } else {
                                            localStorage.setItem('accessToken', response.data.access_token);
                                            // redo the request from outside(!)
                                            call(url, method, data, complete, error);
                                        }
                                    });
                            } else if (status == 200) {
                                if (complete !== null) {
                                    complete(response);
                                }
                            } else {
                                if (error !== null) {
                                    error(response);
                                } else {
                                    window.location.href =
                                        window.location.protocol +
                                        '//' +
                                        window.location.host +
                                        '/' +
                                        'logout';
                                }
                            }
                        });
                }

                function logout(complete = null) {
                    fetch(window.location.protocol + '//' + window.location.host + '/api/logout', {
                        method: 'POST',
                        body: null,
                        cache: 'no-cache',
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('accessToken')
                        }
                    })
                        .then((response) => {
                            let data = response.json(),
                                status = response.status;
                            if (status == 200 || status == 304) {
                                return data;
                            }
                            return { success: false, message: status };
                        })
                        .catch((error) => {
                            return { success: false, message: error };
                        })
                        .then((response) => {
                            console.log(JSON.stringify(response));
                            localStorage.removeItem('accessToken');
                            if (complete !== null) {
                                complete();
                            }
                        });
                }

                function login(username, password, complete = null, error = null) {
                    fetch(window.location.protocol + '//' + window.location.host + '/api/login', {
                        method: 'POST',
                        body: JSON.stringify({ username: username, password: password }),
                        cache: 'no-cache',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                        .then((response) => {
                            let data = response.json(),
                                status = response.status;
                            if (status == 200 || status == 304) {
                                return data;
                            }
                            return { success: false, message: status };
                        })
                        .catch((error) => {
                            return { success: false, message: error };
                        })
                        .then((response) => {
                            console.log(JSON.stringify(response));
                            if (response.success === true) {
                                localStorage.setItem('accessToken', response.data.access_token);
                                if (complete !== null) {
                                    complete();
                                }
                            } else {
                                if (error !== null) {
                                    error();
                                }
                            }
                        });
                }

                function loginAs(username, complete = null, error = null) {
                    fetch(window.location.protocol + '//' + window.location.host + '/api/login', {
                        method: 'POST',
                        body: JSON.stringify({
                            username: username,
                            password: ''
                        }),
                        cache: 'no-cache',
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('accessToken')
                        }
                    })
                        .then((response) => {
                            let data = response.json(),
                                status = response.status;
                            if (status == 200 || status == 304) {
                                return data;
                            }
                            return { success: false, message: status };
                        })
                        .catch((error) => {
                            return { success: false, message: error };
                        })
                        .then((response) => {
                            console.log(JSON.stringify(response));
                            if (response.success === true) {
                                localStorage.setItem('accessToken', response.data.access_token);
                                if (complete !== null) {
                                    complete();
                                }
                            } else {
                                if (error !== null) {
                                    error();
                                }
                            }
                        });
                }
            });
        </script>
    </head>
    <body>
        <div>
            <input type="text" id="username" />
            <input type="password" id="password" />
            <a id="login" href="#">Anmelden</a>
        </div>

        <a id="fetch" href="#" data-route="user">Geschützte Daten abrufen</a><br />

        <a id="logout" href="#">Abmelden</a>
    </body>
</html>
