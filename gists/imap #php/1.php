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
        $unseen = !$mail->isSeen;
        $mailbox->saveMail($mails_id__value, $eml_filename);
        if ($unseen) {
            $mailbox->markMailAsUnread($mails_id__value); // undo saveMail setting mail as read
        }
      	// $mailbox->moveMail($mails_id__value, 'INBOX/ARCHIV');

        $mails[] = [
            'id' => (string) $mail->id,
            'mailbox' => $settings['username'],
            'from_name' => (string) (isset($mail->fromName) ? $mail->fromName : $mail->fromAddress),
            'from_email' => (string) $mail->fromAddress,
            'to' => (string) $mail->toString,
            'cc' => !empty($mail->cc) ? (string) array_values($mail->cc)[0] : null,
            'bcc' => !empty($mail->bcc) ? (string) array_values($mail->bcc)[0] : null,
            'date' => $mail->date,
            'subject' => (string) $mail->subject,
            'eml' => base64_encode(file_get_contents($eml_filename)),
            'attachments' => count($mail->getAttachments()),
            'content_html' =>
                mb_detect_encoding($mail->textHtml, 'UTF-8, ISO-8859-1') !== 'UTF-8'
                    ? \UConverter::transcode($mail->textHtml, 'UTF8', 'ISO-8859-1')
                    : $mail->textHtml,
            'content_plain' =>
                mb_detect_encoding($mail->textPlain, 'UTF-8, ISO-8859-1') !== 'UTF-8'
                    ? \UConverter::transcode($mail->textPlain, 'UTF8', 'ISO-8859-1')
                    : $mail->textPlain
        ];
    }
} catch (\Exception $e) {
    print_r($e->getMessage());
}
print_r($mails);
