<?php
// composer require php-imap/php-imap

require_once __DIR__ . '/vendor/autoload.php';

use PhpImap\Mailbox;

$settings = [
    'host' => '',
    'port' => 993,
    'username' => '***',
    'password' => '***',
    'folder_inbox' => 'INBOX'
];

$mails = [];
try {
    $mailbox = new Mailbox(
        '{' . $settings['host'] . ':' . $settings['port'] . '/imap/ssl}' . $settings['folder_inbox'],
        $settings['username'],
        $settings['password'],
        sys_get_temp_dir(),
        'UTF-8'
    );
    $mails_ids = $mailbox->searchMailbox('ALL');
    foreach ($mails_ids as $mails_id__value) {
        $mail = $mailbox->getMail($mails_id__value, false); // don't mark as unread

        // save as eml
        $mail->embedImageAttachments();
        $eml_filename = tempnam(sys_get_temp_dir(), 'mail_') . '.eml';
        $unseen = in_array($mails_id__value, $mailbox->searchMailbox('UNSEEN', true));
        $mailbox->saveMail($mails_id__value, $eml_filename);
        if ($unseen) {
            $mailbox->markMailAsUnread($mail_id); // undo saveMail setting mail as read
        }

        $mails[] = [
            'id' => (string) $mail->id,
            'mailbox' => $settings['username'],
            'from_name' => (string) (isset($mail->fromName) ? $mail->fromName : $mail->fromAddress),
            'from_email' => (string) $mail->fromAddress,
            'to' => (string) $mail->toString,
            'date' => $mail->date,
            'subject' => (string) $mail->subject,
            'eml' => base64_encode(file_get_contents($eml_filename)),
            'attachments' => count($mail->getAttachments()),
            'content_html' =>
                mb_detect_encoding($mail->textHtml, 'UTF-8, ISO-8859-1') !== 'UTF-8'
                    ? utf8_encode($mail->textHtml)
                    : $mail->textHtml,
            'content_plain' =>
                mb_detect_encoding($mail->textPlain, 'UTF-8, ISO-8859-1') !== 'UTF-8'
                    ? utf8_encode($mail->textPlain)
                    : $mail->textPlain
        ];
    }
} catch (\Exception $e) {
    print_r($e->getMessage());
}
print_r($mails);
