require __DIR__ . '/google-api-php-client/src/Google/autoload.php';

define('APPLICATION_NAME', 'Drive API PHP Quickstart');
define('CREDENTIALS_PATH', __DIR__.'/drive-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  ...