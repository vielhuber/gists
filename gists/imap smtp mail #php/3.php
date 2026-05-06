<?php
// composer require phpmailer/phpmailer

require_once __DIR__ . '/vendor/autoload.php';

$mail = new \PHPMailer\PHPMailer\PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->Port = '587';
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->CharSet = 'utf-8';
$mail->isHTML(true);
//$mail->Username = 'mailbox@tld.com';
//$mail->Password = '...';
$mail->AuthType = 'XOAUTH2';
$mail->setOAuth(
    new class (
        'mailbox@tld.com',
        $this->getMicrosoftOAuthToken(
            '<TENANT_ID>',
            '<CLIENT_ID>',
            '<CLIENT_SECRET>'
        )
    ) implements \PHPMailer\PHPMailer\OAuthTokenProvider {
        private string $userEmail;
        private string $accessToken;
        public function __construct(string $userEmail, string $accessToken) {
            $this->userEmail = $userEmail;
            $this->accessToken = $accessToken;
        }
        public function getOauth64(): string {
            return base64_encode(
                'user=' . $this->userEmail . "\001auth=Bearer " . $this->accessToken . "\001\001"
            );
        }
    }
);

$mail->Subject = '...';
$mail->Body = '...';
$mail->send();