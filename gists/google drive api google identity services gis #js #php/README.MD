- this example is fully compatible with google identity services (this means compatible also from march 2023, when the old js api is deprecated)

### links

- https://developers.google.com/identity/protocols/oauth2/web-server#php
- https://stackoverflow.com/questions/72619167/clarification-on-google-authentication-and-authorization-with-oauth-in-2022
- https://www.youtube.com/watch?v=C0DUNy6RjNw
- https://stackoverflow.com/questions/72418822/google-identity-services-how-to-refresh-access-token-for-google-api-after-one
- https://stackoverflow.com/questions/72080698/refresh-google-oauth2-token-automatically
- https://developers.google.com/identity/oauth2/web/guides/choose-authorization-model?hl=en
- https://stackoverflow.com/questions/72468848/google-identity-services-how-to-preserve-session
- https://www.paultman.com/google-authentication-authorization-via-oauth-in-2022/
- https://overclocked.medium.com/seamless-api-access-with-google-identity-services-b9901009a8ce
- https://github.com/googleapis/google-api-php-client/issues/2344


### installation

```sh
composer require google/apiclient:^2.10
```

### backend (that can also act as plain frontend)

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

class GoogleDrivePhp
{
    private $session_time = 60 * 60 * 24 * 30; // 1 month

    function init()
    {
        $this->setBaseurl();
        $this->extendSession();
        $this->initGoogleClient();
        $this->bindLogout();
        $this->bindLogin();
        $this->bindMain();
    }

    function response($data, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }

    function isAjax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ||
            (!empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    }

    function bindMain()
    {
        if (@$_GET['login'] != '1' && @$_GET['logout'] != '1') {
            if (@$_SESSION['access_token'] != '') {
                $access_token = $_SESSION['access_token'];
                $this->client->setAccessToken($access_token);
                // if access token is expired, create new from refresh token
                if ($this->client->isAccessTokenExpired()) {
                    $response = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                    if (@$response['access_token'] != '') {
                        $_SESSION['access_token'] = $response;
                        $this->client->setAccessToken($response);
                    }
                }
                $drive = new Google\Service\Drive($this->client);
                $files = $drive->files->listFiles([])->getFiles();
                $expiration = round(($access_token['created'] + $access_token['expires_in'] - 30 - time()) / 60);

                $data = [
                    'expiration' => $expiration,
                    'access_token' => $access_token,
                    'access_token2' => $this->client->getAccessToken(),
                    'files' => $files
                ];

                if ($this->isAjax()) {
                    $this->response([
                        'success' => true,
                        'data' => $data
                    ]);
                } else {
                    echo '<pre>';
                    var_dump($data);
                    echo '</pre>';
                    echo '<a href="' . $this->baseurl . '?logout=1">Logout</a>';
                }
            } else {
                if ($this->isAjax()) {
                    $this->response(
                        [
                            'success' => false
                        ],
                        401
                    );
                } else {
                    echo '<a href="' . $this->baseurl . '?login=1">Login</a>';
                }
            }
        }
    }

    function bindLogout()
    {
        if (@$_GET['logout'] == '1') {
            session_unset();
            session_destroy();
            if ($this->isAjax()) {
                $this->response(['success' => true]);
            } else {
                $this->redirect($this->baseurl);
            }
            die();
        }
    }

    function bindLogin()
    {
        if (@$_GET['login'] == '1') {
            if (!isset($_GET['code'])) {
                if ($this->isAjax()) {
                    $_SESSION['redirect_after'] = $_SERVER['HTTP_REFERER'];
                    $this->response(['success' => true, 'data' => ['redirect_url' => $this->client->createAuthUrl()]]);
                } else {
                    $_SESSION['redirect_after'] = $this->baseurl;
                    $this->redirect($this->client->createAuthUrl());
                }
            } else {
                $this->client->authenticate($_GET['code']);
                $_SESSION['access_token'] = $this->client->getAccessToken();
                $this->redirect(@$_SESSION['redirect_after'] != '' ? $_SESSION['redirect_after'] : $this->baseurl);
            }
            die();
        }
    }

    function redirect($url)
    {
        header('Location: ' . filter_var($url, FILTER_SANITIZE_URL));
    }

    function setBaseurl()
    {
        $this->baseurl =
            'http' .
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 's' : '') .
            '://' .
            $_SERVER['HTTP_HOST'] .
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    function extendSession()
    {
        ini_set('session.gc_maxlifetime', $this->session_time);
        session_set_cookie_params($this->session_time);
        session_start();
    }

    function initGoogleClient()
    {
        $this->client = new Google\Client();
        $this->client->setAuthConfig('client_secret.json');
        $this->client->addScope(Google\Service\Drive::DRIVE_READONLY);
        $this->client->setRedirectUri($this->baseurl . '?login=1');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
        $this->client->setIncludeGrantedScopes(true);
    }
}

$g = new GoogleDrivePhp();
$g->init();
```

### frontend (if needed)

```html
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" />
        <title>gis</title>
        <script>
            class GoogleDriveJs {
                init() {
                    this.bindLogin();
                    this.bindLogout();
                    this.loadDataAndBuildHtml();
                }

                loadDataAndBuildHtml() {
                    window.addEventListener('load', async e => {
                        let response = await this.makeCall('');
                        if (response.success === true) {
                            document.body.insertAdjacentHTML('beforeend', '<a href="#" class="logout">Logout!</a>');
                            document.body.insertAdjacentHTML(
                                'beforeend',
                                '<pre>' + JSON.stringify(response.data.files) + '</pre>'
                            );
                        } else {
                            document.body.insertAdjacentHTML('beforeend', '<a href="#" class="login">Login!</a>');
                        }
                    });
                }

                bindLogin() {
                    document.addEventListener('click', async e => {
                        if (e.target.closest('.login')) {
                            e.preventDefault();
                            let response = await this.makeCall('?login=1');
                            if (response.success === true) {
                                window.location.href = response.data.redirect_url;
                            }
                        }
                    });
                }

                bindLogout() {
                    document.addEventListener('click', async e => {
                        if (e.target.closest('.logout')) {
                            e.preventDefault();
                            let response = await this.makeCall('?logout=1');
                            if (response.success === true) {
                                window.location.reload();
                            }
                        }
                    });
                }

                makeCall(url) {
                    return new Promise((resolve, reject) => {
                        let target = window.location.protocol + '//' + window.location.host + '/index.php' + url;
                        console.log(target);
                        fetch(target, {
                            method: 'GET',
                            body: null,
                            cache: 'no-cache',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => {
                                let data = response.json(),
                                    status = response.status;
                                if (status == 200 || status == 304) {
                                    return data;
                                }
                                return { success: false, message: status };
                            })
                            .catch(error => {
                                return { success: false, message: error };
                            })
                            .then(response => {
                                resolve(response);
                            });
                    });
                }
            }
          
            let g = new GoogleDriveJs();
            g.init();
        </script>
    </head>
    <body></body>
</html>
```
