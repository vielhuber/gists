### steps to generate google api keys
  - go to google cloud console
  - create a new project
  - gcp console > enable "Cloud Translation API"
  - add billing information
  - api's and services > accounts > add a new api key (suitable for v2)
  - iam & admin > create a new service account (role: owner) > download json file (suitable for v3)
  
### v2
```
__translate_google('Sein oder Nichtsein; das ist hier die Frage.', 'de', 'en', '**API Key**'); // from stringhelper
```

### v3
```php
use Google\Cloud\Translate\V3\TranslationServiceClient;
function __translate_google_v3($str, $from_lng, $to_lng, $creds)
{
    $trans = null;
    // set common fields
    $creds['type'] = 'service_account';
    $creds['auth_uri'] = 'https://accounts.google.com/o/oauth2/auth';
    $creds['token_uri'] = 'https://oauth2.googleapis.com/token';
    $creds['auth_provider_x509_cert_url'] = 'https://www.googleapis.com/oauth2/v1/certs';
    $filename = sys_get_temp_dir() . '/' . md5(uniqid()) . '.json';
    file_put_contents($filename, json_encode($creds));
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $filename);
    try {
        $translationServiceClient = new TranslationServiceClient();
        $response = $translationServiceClient->translateText(
            [$str],
            $to_lng,
            $translationServiceClient->locationName($creds['project_id'], 'global'),
            [
                'sourceLanguageCode' => $from_lng,
                'mimeType' => 'text/html'
            ]
        );
        foreach ($response->getTranslations() as $translation) {
            $trans = $translation->getTranslatedText();
            break;
        }
        $translationServiceClient->close();
    } catch (\Exception $e) {
    }
    @unlink($filename);
    return $trans;
}

__translate_google_v3('Sein oder Nichtsein; das ist hier die Frage.', 'de', 'en', [
    'project_id' => getenv('GOOGLE_TRANSLATION_API_V3_PROJECT_ID'),
    'private_key_id' => getenv('GOOGLE_TRANSLATION_API_V3_PRIVATE_KEY_ID'),
    'private_key' => getenv('GOOGLE_TRANSLATION_API_V3_PRIVATE_KEY'),
    'client_email' => getenv('GOOGLE_TRANSLATION_API_V3_CLIENT_EMAIL'),
    'client_id' => getenv('GOOGLE_TRANSLATION_API_V3_CLIENT_ID'),
    'client_x509_cert_url' => getenv('GOOGLE_TRANSLATION_API_V3_CLIENT_X509_CERT_URL')
]); // 'To be or not to be; that is the question.'
```