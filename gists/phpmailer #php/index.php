<?php
require_once(__DIR__ . '/vendor/autoload.php');

file_put_contents(__DIR__.'/test1.jpg', 'https://picsum.photos/200/300');
file_put_contents(__DIR__.'/test2.jpg', 'https://picsum.photos/200/300');

mailSend('david@vielhuber.de', 'Test1', 'Test <strong>bestanden</strong>!');
mailSend(['david@vielhuber.de', 'david@vlhbr.de'], 'Test2', 'Test <strong>bestanden</strong>!');
mailSend(['name' => 'David Vielhuber', 'email' => 'david@vielhuber.de'], 'Test3', 'Test <strong>bestanden</strong>!');
mailSend([['name' => 'David Vielhuber', 'email' => 'david@vielhuber.de'], ['name' => 'David Vielhuber', 'email' => 'david@vlhbr.de']], 'Test4', 'Test <strong>bestanden</strong>!');
mailSend('david@vielhuber.de', 'Test5', 'Test <strong>bestanden</strong>!', __DIR__ . '/test1.jpg');
mailSend('david@vielhuber.de', 'Test6', 'Test <strong>bestanden</strong>!', [__DIR__ . '/test1.jpg', __DIR__ . '/test2.jpg']);
mailSend('david@vielhuber.de', 'Test7', 'Test <strong>bestanden</strong>!', ['name' => 'foo1.jpg', 'file' => __DIR__ . '/test1.jpg']);
mailSend('david@vielhuber.de', 'Test8', 'Test <strong>bestanden</strong>!', [['name' => 'foo1.jpg', 'file' => __DIR__ . '/test1.jpg'], ['name' => 'foo2.jpg', 'file' => __DIR__ . '/test2.jpg']]);

function mailSend($recipients, $subject = '', $content = '', $attachments = null)
{
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = @$_SERVER['MAIL_HOST'];
        $mail->Port = @$_SERVER['MAIL_PORT'];
        $mail->Username = @$_SERVER['MAIL_USERNAME'];
        $mail->Password = @$_SERVER['MAIL_PASSWORD'];
        $mail->SMTPSecure = @$_SERVER['MAIL_ENCRYPTION'];
        $mail->setFrom(@$_SERVER['MAIL_FROM_ADDRESS'], @$_SERVER['MAIL_FROM_NAME']);
        $mail->SMTPAuth = true;
        $mail->SMTPOptions = [
            'tls' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true],
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]
        ];
        $mail->CharSet = 'utf-8';
        $mail->isHTML(true);
      
        // only send on production to real recipient
        if (in_array(@$_SERVER['SERVER_ADMIN'], ['david@vielhuber.de'])) {
          $recipients = $_SERVER['SERVER_ADMIN'];
        }
        if (!is_array($recipients) || isset($recipients['email'])) {
            $recipients = [$recipients];
        }
        foreach ($recipients as $recipients__value) {
            if (is_string($recipients__value) && $recipients__value != '') {
                $mail->addAddress($recipients__value);
            } elseif (is_array($recipients__value)) {
                if (
                    isset($recipients__value['email']) &&
                    $recipients__value['email'] != '' &&
                    isset($recipients__value['name']) &&
                    $recipients__value['name'] != ''
                ) {
                    $mail->addAddress($recipients__value['email'], $recipients__value['name']);
                } elseif (isset($recipients__value['email']) && $recipients__value['email'] != '') {
                    $mail->addAddress($recipients__value['email']);
                }
            }
        }
      
        // embed images (base64 and relative urls to cid)
        $images = [];
        preg_match_all('/src="([^"]*)"/i', $content, $images);
        $images = $images[1];
        $images = array_unique($images);
        foreach ($images as $images__value) {
            if (strpos($images__value, 'cid:') === false && strpos($images__value, 'http') === false) {
                $image_cid = md5($images__value);

                $image_extension = $images__value;
                if (strpos($images__value, 'base64,') !== false) {
                    if (strpos($images__value, 'image/png') !== false) {
                        $image_extension = 'png';
                    } else {
                        $image_extension = 'jpg';
                    }
                } else {
                    $image_extension = explode('.', $image_extension);
                    $image_extension = $image_extension[count($image_extension) - 1];
                }

                $image_baseurl = $_SERVER['DOCUMENT_ROOT']; // modify this if needed

                $image_tmp_path = sys_get_temp_dir() . '/' . md5(uniqid()) . '.' . $image_extension;

                // base64
                if (strpos($images__value, 'base64,') !== false) {
                    file_put_contents(
                        $image_tmp_path,
                        base64_decode(
                            trim(substr($images__value, strpos($images__value, 'base64,') + strlen('base64')))
                        )
                    );
                    $content = str_replace($images__value, 'cid:' . $image_cid, $content);
                    $mail->addEmbeddedImage($image_tmp_path, $image_cid);
                }

                // relative paths
                elseif (file_exists($image_baseurl . '/' . $images__value)) {
                    $content = str_replace($images__value, 'cid:' . $image_cid, $content);
                    $mail->addEmbeddedImage($image_baseurl . '/' . $images__value, $image_cid);
                }
            }
        }
      
        $mail->Subject = $subject;
        $mail->Body = $content;
        $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\r\n", $content));
        if ($attachments !== null) {
            if (!is_array($attachments) || isset($attachments['file'])) {
                $attachments = [$attachments];
            }
            if (!empty($attachments)) {
                foreach ($attachments as $attachments__value) {
                    if (
                        is_string($attachments__value) &&
                        $attachments__value != '' &&
                        file_exists($attachments__value)
                    ) {
                        $mail->addAttachment($attachments__value);
                    } elseif (is_array($attachments__value)) {
                        if (
                            isset($attachments__value['file']) &&
                            $attachments__value['file'] != '' &&
                            isset($attachments__value['name']) &&
                            $attachments__value['name'] != '' &&
                            file_exists($attachments__value['file'])
                        ) {
                            $mail->addAttachment($attachments__value['file'], $attachments__value['name']);
                        } elseif (
                            isset($attachments__value['file']) &&
                            $attachments__value['file'] != '' &&
                            file_exists($attachments__value['file'])
                        ) {
                            $mail->addAttachment($attachments__value['file']);
                        }
                    }
                }
            }
        }
        $mail->send();
        return true;
    } catch (\Exception $e) {
        //return $mail->ErrorInfo
        return false;
    }
}