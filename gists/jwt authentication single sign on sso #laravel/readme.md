### links
- https://jwt.io/
- https://blog.pusher.com/build-rest-api-laravel-api-resources/
- https://stackoverflow.com/questions/33723033/single-sign-on-flow-using-jwt-for-cross-domain-authentication
- https://stackoverflow.com/questions/33900667/how-to-implement-logout-in-a-jwt-based-single-sign-on-authentication-architectur
- https://developer.mozilla.org/en-US/docs/Web/API/Window/postMessage
- https://jcubic.wordpress.com/2014/06/20/cross-domain-localstorage/
- https://blog.zok.pw/web/2015/10/21/3rd-party-cookies-in-practice/
- https://gist.github.com/pbojinov/8965299
- https://stormpath.com/blog/where-to-store-your-jwts-cookies-vs-html5-web-storage
- https://github.com/auth0/jwt-decode/issues/4
- https://dev.to/rdegges/please-stop-using-local-storage-1i04
- https://stackoverflow.com/questions/50704507/jwt-single-sign-on-iframe-technique-with-third-party-cookies-disabled
- https://stackoverflow.com/questions/17710897/how-to-use-sha1-encryption-instead-of-bcrypt-in-laravel-4
- https://github.com/tymondesigns/jwt-auth/issues/983
- https://github.com/tymondesigns/jwt-auth/issues/1584

### installation
```bash
# we use this for the whole api
composer require tymon/jwt-auth "1.0.*"
# we use guzzle for http calls in tests
composer require guzzlehttp/guzzle
```

### publish config
```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

### generate secret key
```bash
php artisan jwt:secret
```

### make settings in .env (access token expiration: 1 hour, refresh expiration: 1 month)
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=root

JWT_SECRET=WM38tprPABEgkldbt2yTAgxf2CGstfr5
JWT_TTL=60
JWT_REFRESH_TTL=40320
JWT_BLACKLIST_GRACE_PERIOD=30
JWT_TESTUSER=david@vielhuber.de:secret
```

### adjust user model
```php
// app/User.php
/* ... */
use Tymon\JWTAuth\Contracts\JWTSubject;
/* ... */
class User extends Authenticatable implements JWTSubject
{

    /* ... */
    protected $table = 'customers'; // modify this if needed!
    protected $primaryKey = 'id'; // modify this if needed!
    public function getAuthPassword()
    {
        return $this->password; // modify this if needed!
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
```

### adjust auth driver
```php
// config/auth.php
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],
/* ... */
'guards' => [
    /* ... */
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

### remove default migrations
```bash
rm database/migrations/*
```

### create table / dummy user
```php
$hash = password_hash('secret', PASSWORD_BCRYPT);
```
```sql
CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL
)

INSERT INTO `customers` VALUES (
   42,
   'david@vielhuber.de',
   '$2y$10$pRF1snmA18QNA72U4eVjHOB5g5tD.6msMuyYlY0mLn/hMpa.yvmpm'
)
```

### remove api from urls
```php
// app/Providers/RouteServiceProvider.php
protected function mapApiRoutes()
    {
        Route::middleware('api')
             //->prefix('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
```

### increase api throtting
```php
// app/Http/Kernel.php
protected $middlewareGroups = [
	/* ... */
	'api' => [
    	'throttle:600,1',
    	'bindings',
    ],
];
```

### add cors
```php
// app/Http/Middleware/Cors.php
namespace App\Http\Middleware;
use Closure;
class Cors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', '*');
    }
}
```
```php
// app/Http/Kernel.php
/* ... */
protected $middleware = [
	/* ... */
	\App\Http\Middleware\Cors::class,
];
/* ... */
```


### add json response for unknown routes
```php
// app/Exceptions/Handler.php
/* ... */
public function render($request, Exception $exception)
{
	if($exception instanceof \Illuminate\Auth\AuthenticationException)
	{
	    return response()->json([
		'success' => false,
		'message' => 'unauthorized',
		'public_message' => 'E-Mail-Adresse oder Passwort falsch'
	    ], 401);
	}           
	if($exception instanceof \Exception)
	{
	    return response()->json([
		'success' => false,
		'message' => 'internal server error',
		'public_message' => get_class($exception)
	    ], 500);
	}
    return parent::render($request, $exception);
}
/* ... */
```

### add routes
```php
// routes/api.php
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->middleware('auth:api');
Route::post('refresh', 'AuthController@refresh');
Route::post('check', 'AuthController@check');
Route::get('user', 'AuthController@user')->middleware('auth:api');
```

### create auth controller
```php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Firebase\JWT\JWT;

class AuthController extends Controller
{

    public function login()
    {
        $credentials = request([
            'email',
            'password'
        ]);
      	/* if you instead have additionally a username column and want to provide a login via username OR email (both via the email field!), use this */
      	/*
        if ($request->has(['email', 'password'])) {
            $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
        } else {
            $credentials = ['benutzer' => $request->input('username'), 'password' => $request->input('password')];
        }
        */
        /* if you both provide via the email field (for simplicity reasons), use this */
      	/*
        $credentials = request(['email', 'password']);
          if (filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) == false) {
              $credentials['benutzer'] = $credentials['email'];
              unset($credentials['email']);
          }
        */
        if (! $token = auth()->attempt($credentials))
        {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
                'public_message' => 'Fehlende Authentifizerung'
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'logout successful',
            'public_message' => 'Erfolgreich ausgeloggt'
        ], 200);
    }

    public function refresh()
    {
        try
        {
            $token = auth()->refresh();
        }
        catch(\Tymon\JWTAuth\Exceptions\JWTException $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
                'public_message' => 'Falsches Token'
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'message' => 'auth successful',
            'public_message' => 'Erfolgreich authentifiziert',
            'data' => [
                'access_token' => $token,
                'expires_in' => (auth()->factory()->getTTL() * 60),
                'user_id' => auth()->user()->id
            ]
        ], 200);
    }

    public function check(Request $request)
    {
        $token = $request->input('access_token');
        try
        {
            auth()->setToken($token);
            if( auth()->check() === true ) { $success = true; }
            else { $success = false; }
        }
        catch(\Exception $e)
        {
            $success = false;
        }
        if( $success === true )
        {
            return response()->json([
                'success' => true,
                'message' => 'valid token',
                'public_message' => 'Korrektes Token',
                'data' => [
                    'expires_in' => (auth()->payload()->get('exp')-strtotime('now')),
                    'user_id' => auth()->user()->id
                ]
            ], 200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'invalid token',
                'public_message' => 'Falsches Token'
            ], 401);
        }
    }

    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => auth()->user()->id,
                'email' => auth()->user()->email
            ]
        ], 200);
    }

}
```

### switch bcrypt with another hashing algorithm
```php
// app/Providers/SHAHasher.php
namespace App\Providers;

use Illuminate\Contracts\Hashing\Hasher;

class SHAHasher implements Hasher
{

    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }

    public function make($value, array $options = array())
    {
        return md5($value);
    }

    public function check($value, $hashedValue, array $options = array())
    {
        return $this->make($value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }

}
```

```php
// app/Providers/SHAHashServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SHAHashServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('hash', function()
        {
            return new SHAHasher();
        });
    }

    public function provides()
    {
        return array('hash');
    }

}
```

```php
// config/app.php
/* ... */
//Illuminate\Hashing\HashServiceProvider::class,
App\Providers\SHAHashServiceProvider::class,
/* ... */
```
```bash
composer dump-autoload
```


### test
```bash
php artisan make:test AuthTest
```

```php
// tests/Feature/AuthTest.php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    protected static $access_token;

    public static function setUpBeforeClass()
    {
        self::$access_token = null;
    }

    public static function tearDownAfterClass()
    {
        self::$access_token = null;
    }

    public function testLogin()
    {
        $response = $this->api(
            'POST',
            '/login',
            ['email' => $this->getTestUser()->email, 'password' => $this->getTestUser()->password]
        );  

        self::$access_token = $this->getData($response)->data->access_token;

        $this->assertTrue( $this->compareResponse($response, [
            'success' => true,
            'message' => 'auth successful',
            'public_message' => '#STRING#',
            'data' => [
                'access_token' => '#STRING#',
                'expires_in' => '#INTEGER#',
                'user_id' => '#INTEGER#'
            ]
        ], 200) );
    }

    public function testLoginFailure()
    {
        $response = $this->api(
            'POST',
            '/login',
            ['email' => 'foo', 'password' => 'bar']
        );  

        $this->assertTrue( $this->compareResponse($response, [
            'success' => false,
            'message' => 'unauthorized',
            'public_message' => '#STRING#'
        ], 401) );
    }

    public function testCheck()
    {
        $response = $this->api(
            'POST',
            '/check',
            ['access_token' => self::$access_token]
        );

        $this->assertTrue( $this->compareResponse($response, [
            'success' => true,
            'message' => 'valid token',
            'public_message' => '#STRING#',
            'data' => [
                'expires_in' => '#INTEGER#',
                'user_id' => '#INTEGER#'
            ]
        ], 200) );
    }

    public function testCheckFailure()
    {
        $response = $this->api(
            'POST',
            '/check',
            ['access_token' => 'WRONG']
        );

        $this->assertTrue( $this->compareResponse($response, [
            'success' => false,
            'message' => 'invalid token',
            'public_message' => '#STRING#'
        ], 401) );
    }

    public function testUser()
    {
        $response = $this->api(
            'GET',
            '/user',
            null,
            ['Authorization' => 'Bearer '.self::$access_token]
        );

        $this->assertTrue( $this->compareResponse($response, [
            'success' => true,
            'data' => [
                'id' => '#INTEGER#',
                'email' => '#STRING#'
            ]
        ], 200) );
    }

    public function testUserFailure()
    {
        $response = $this->api(
            'GET',
            '/user',
            null,
            ['Authorization' => 'Bearer foo']
        );

        $this->assertTrue( $this->compareResponse($response, [
            'success' => false,
            'message' => 'unauthorized',
            'public_message' => '#STRING#'
        ], 401) );
    }

    public function testRefresh()
    {
        // refresh invalidates the old token
        $response = $this->api(
            'POST',
            '/refresh',
            null,
            ['Authorization' => 'Bearer '.self::$access_token]
        );

        $access_token_old = self::$access_token;
        self::$access_token = $this->getData($response)->data->access_token;

        $this->assertTrue( $this->compareResponse($response, [
            'success' => true,
            'message' => 'auth successful',
            'public_message' => '#STRING#',
            'data' => [
                'access_token' => '#STRING#',
                'expires_in' => '#INTEGER#',
                'user_id' => '#INTEGER#'
            ]
        ], 200) );

        $response = $this->api(
            'POST',
            '/check',
            ['access_token' => self::$access_token]
        );
        $this->assertEquals($this->getData($response)->success, true);

        // in 30 seconds this should be false (because of JWT_BLACKLIST_GRACE_PERIOD)
        /* not tested atm */
        /*
        $response = $this->api(
            'POST',
            '/check',
            ['access_token' => $access_token_old]
        );
        $this->assertEquals($this->getData($response)->success, false);
        */
    }

    public function testRefreshFailure()
    {
        $response = $this->api(
            'POST',
            '/refresh',
            null,
            ['Authorization' => 'Bearer foo']
        );

        $this->assertTrue( $this->compareResponse($response, [
            'success' => false,
            'message' => 'unauthorized',
            'public_message' => '#STRING#'
        ], 401) );
    }

    public function testLogout()
    {
        // this invalidates also the new token
        $response = $this->api(
            'POST',
            '/logout',
            null,
            ['Authorization' => 'Bearer '.self::$access_token]
        );

        $this->assertTrue( $this->compareResponse($response, [
            'success' => true,
            'message' => 'logout successful',
            'public_message' => '#STRING#'
        ], 200) );
    }

    public function testLogoutFailure()
    {
        $response = $this->api(
            'POST',
            '/logout',
            null,
            ['Authorization' => 'Bearer foo']
        );

        $this->assertTrue( $this->compareResponse($response, [
            'success' => false,
            'message' => 'unauthorized',
            'public_message' => '#STRING#'
        ], 401) );
    }

    public function getTestUser()
    {
        return (object)[
            'email' => explode(':',env('JWT_TESTUSER'))[0],
            'password' => explode(':',env('JWT_TESTUSER'))[1]
        ];
    }

    public function api($method = 'GET', $route = '/', $args = [], $headers = [])
    {
        $http = new \GuzzleHttp\Client();
        $response = $http->request(
            $method,
            url('/').$route,
            [
                'form_params' => $args,
                'headers' => $headers,
                'http_errors' => false
            ]
        );
        return $response;
    }

    public function getData($response)
    {
        return json_decode((string)$response->getBody());
    }

    public function compareResponse($response, $data, $code)
    {
        if( $response->getStatusCode() !== $code ) 
        {
            echo 'wrong status code: '.$response->getStatusCode().' vs. '.$code.PHP_EOL;
            return false;
        }

        $result = $this->compareHelper(
            json_decode(json_encode($data)), // first convert array to object
            $this->getData($response)
        );

        if( $result === false )
        {
            print_r([json_decode(json_encode($data)), $this->getData($response)]);
        }

        return $result;
    }

    protected function compareHelper($d1, $d2)
    {
        if( ($d1 === '#STRING#' && is_string($d2)) || ($d2 === '#STRING#' && is_string($d1)) )
        {
            return true;
        }
        if( ($d1 === '#INTEGER#' && is_integer($d2)) || ($d2 === '#INTEGER#' && is_integer($d1)) )
        {
            return true;
        }
        if( $d1 === '*' || $d2 === '*' )
        {
            return true;
        }
        if( gettype($d1) !== gettype($d2) )
        {
            return false;
        }
        if( is_string($d1) )
        {
            if( $d1 !== $d2 )
            {
                return false;
            }
        }
        if( is_numeric($d1) )
        {
            if( $d1 !== $d2 )
            {
                return false;
            }
        }
        if( is_array($d1) || is_object($d1) )
        {
            if( is_object($d1) )
            {
                $d1 = (array)$d1;
                $d2 = (array)$d2;
                ksort($d1);
                ksort($d2);
            }
            foreach($d1 as $data__key=>$data__value)
            {
                if( !isset($d2[$data__key]) )
                {
                    return false;
                }
                if( $this->compareHelper($d1[$data__key], $d2[$data__key]) === false )
                {
                    return false;
                }
            }
        }
        return true;
    }

}
```

### helper library for setting up a single sign on with jwt in a multi domain environment in no time

https://github.com/vielhuber/ssohelper


### notes

- we store the access token inside cookies (localstorage does not make ANY difference at all. third party problems are also available here)
- there are 2 iframe techniques:
    - top-down: pass data from parent to all child pages and set cookies inside
    - bottom-up: read data from child page and set cookies in parent
    - both strategies do NOT work when third party cookies disabled(!)
- the expiration time of the cookie is the ttl for refresh (4 weeks)
- the tokens are invalidated (cannot be used anymore) on both refresh and logout
- invalidation is stored in laravel cache on the main server
- if we therefore check on another server if the token is valid after logout, it is still valid (until the lifetime is expired)
- in a single sign on environment you can trick the application when signing out on the main auth server and leaving the tokens saved. this is not a big deal, because the tokens are expiring soon
- tokens are used until they are dead. if they are dead, first refresh is tried and the last request is repeated. if that also fails, a login form is rendered
- the frontend forms are located on the pages (and not on the auth server)
- normally a client (js) communicates with a server in an authenticated manner; if a client communicates with a server that needs to communicate with another server, the access token is simply passed through. if something fails in between, the error is propagated back to the client. only the client refreshes the token, never the servers in between.
- third party cookies: sometimes users disable third party cookies. the whole machinery is always in one of the following states
  - third party cookies enabled: cookies on pageA, pageB, pageC are ALWAYS in sync
  - third party cookies disabled: pageA/pageB/pageC always have a different cookie, single sign on is basically disabled