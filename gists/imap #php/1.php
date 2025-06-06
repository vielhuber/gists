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
        '{' . $settings['host'] . ':' . $settings['port'] . '/imap/ssl/novalidate-cert}' . $settings['folder_inbox'],
        $settings['username'],
        $settings['password'],
        sys_get_temp_dir(),
        'UTF-8'
    );
  
  	/*
    $mailbox->setConnectionArgs(0, 0, ['DISABLE_AUTHENTICATOR' => 'GSSAPI']);
    $mailbox->setTimeouts(5);
    $mailbox->setAttachmentsIgnore(true);
    $mailbox->switchMailbox('INBOX.Foo');
    $folders = $mailbox->getMailboxes('*');
    */
  
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
      
      	// attachments
        $attachments = $mail->getAttachments();
        if (!empty($attachments)) {
        	foreach ($attachments as $attachments__value) {
      			$unique_id = $mail->id . '_' . md5($attachments__value->getContents()); // $attachments__value->id is not unique!
              	print_r($attachments__value->getContents());
                $attachments__value->setFilePath($_SERVER['DOCUMENT_ROOT'] . '...' . '.pdf');
                $attachments__value->saveToDisk();
            }
        }      	

        $mails[] = [
            'id' => (string) $mail->id, // this is the unique uid (not message sequence id)
            'mailbox' => $settings['username'],
            'from_name' => (string) (isset($mail->fromName) ? $mail->fromName : $mail->fromAddress),
            'from_email' => (string) $mail->fromAddress,
            'to' => !empty($mail->to) ? array_map(function ($key, $value) {
              return [
                'email' => $key,
                'name' => $key === $value ? null : str_replace(' ('.$key.')', '', $value)

              ];
            }, array_keys($mail->to), $mail->to) : null,
            'cc' => !empty($mail->cc) ? array_map(function ($key, $value) {
              return [
                'email' => $key,
                'name' => $key === $value ? null : str_replace(' ('.$key.')', '', $value)

              ];
            }, array_keys($mail->cc), $mail->cc) : null,
            'bcc' => !empty($mail->bcc) ? array_map(function ($key, $value) {
              return [
                'email' => $key,
                'name' => $key === $value ? null : str_replace(' ('.$key.')', '', $value)

              ];
            }, array_keys($mail->bcc), $mail->bcc) : null,
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
