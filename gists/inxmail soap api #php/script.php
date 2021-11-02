<?php
inxmailAddRecipient([
    'email' => 'david@vielhuber.de',
    'salutation' => 'Herr',
    'first_name' => 'David',
    'last_name' => 'Vielhuber'
]);

function inxmailAddRecipient($data) {
    // settings
    $INXMAIL_ENDPOINT = 'https://api.inxmail.com/xxxxxx';
    $INXMAIL_SUBSCRIPTION_LIST = 'xxxxxx'; // choose name (not id)
    $INXMAIL_USERNAME = 'xxxxxx';
    $INXMAIL_PASSWORD = 'xxxxxx';
    $INXMAIL_SITENAME = 'tld.com';

    // load inxmail api (you get this directly from inxmail inside "inxmail-api-v1.20.3-php5.zip")
    require_once(__DIR__ . '/inxmail_api/Apiimpl/Loader.php');
    \Inx_Apiimpl_Loader::registerAutoload();

    // open connection
    $inxSession = \Inx_Api_Session::createRemoteSession($INXMAIL_ENDPOINT, $INXMAIL_USERNAME, $INXMAIL_PASSWORD);

    try {
        // get list
        $inxListManager = $inxSession->getListContextManager();
        $inxList = $inxListManager->findByName($INXMAIL_SUBSCRIPTION_LIST);

        if ($inxList == null) {
            //echo 'list does not exist';
            return false;
        } else {

            // inxmail list attributes
            $inxAttr = [];
            $inxAttr['anrede'] = $data['salutation'] == 'Herr' ? 'Herr' : 'Frau';
            $inxAttr['vorname'] = $data['first_name'];
            $inxAttr['nachname'] = $data['last_name'];

            // get subscription manager
            $inxSubManager = $inxSession->getSubscriptionManager();

            // subscribe
            $res = $inxSubManager->processSubscription(
              $INXMAIL_SITENAME,
              $_SERVER['REMOTE_ADDR'],
              $inxList,
              $data['email'],
              $inxAttr
            );

            // result
            switch ($res)
            {
                case \Inx_Api_Subscription_SubscriptionManager::PROCESS_ACTIVATION_SUCCESSFULLY:
                    return true;
                    break;
                case \Inx_Api_Subscription_SubscriptionManager::PROCESS_ACTIVATION_FAILED_ADDRESS_ILLEGAL:
                    return false;
                    break;
                default:
                    return false;
            }
        }
    }
    catch (EntityStorageException $e) {
        //echo 'error: '.$e->getMessage();
        return false;
    }

    // close session
    if ($inxSession != null) {
        $inxSession->close();
    }
}
