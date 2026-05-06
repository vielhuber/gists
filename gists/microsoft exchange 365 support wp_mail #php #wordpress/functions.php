<?php
// smtp microsoft 365 exchange support
add_filter(
    'pre_wp_mail',
    function ($pre_wp_mail, $attributes) {
        $from_email = 'noreply@vielhuber.de';
        $mailhelper = new \vielhuber\mailhelper\mailhelper([
            $from_email => [
                'smtp' => [
                    'host' => 'smtp.office365.com',
                    'port' => '587',
                    'tenant_id' => '************************************',
                    'client_id' => '************************************',
                    'client_secret' => '************************************',
                    'encryption' => 'tls'
                ]
            ]
        ]);

        $normalize_recipients = function ($recipients) {
            if ($recipients === null || $recipients === '') {
                return [];
            }
            if (is_string($recipients)) {
                $recipients = explode(',', $recipients);
            }
            if (!is_array($recipients)) {
                $recipients = [$recipients];
            }
            $normalized_recipients = [];
            foreach ($recipients as $recipient) {
                if (!is_string($recipient)) {
                    continue;
                }
                $recipient = trim($recipient);
                if ($recipient === '') {
                    continue;
                }
                if (preg_match('/^(.*)<(.+)>$/', $recipient, $matches) === 1) {
                    $name = trim(trim($matches[1]), '"\'');
                    $email = trim($matches[2]);
                    if ($email !== '') {
                        $normalized_recipients[] = [
                            'name' => $name,
                            'email' => $email
                        ];
                    }
                    continue;
                }
                $normalized_recipients[] = $recipient;
            }
            return $normalized_recipients;
        };

        $extract_from_headers = function ($headers, $normalize_recipients) {
            $from_name = null;
            $cc = [];
            $bcc = [];
            if (is_string($headers)) {
                $headers = preg_split('/\r\n|\r|\n/', $headers);
            }
            if (!is_array($headers)) {
                $headers = [];
            }
            foreach ($headers as $header) {
                if (!is_string($header) || strpos($header, ':') === false) {
                    continue;
                }
                [$header_key, $header_value] = explode(':', $header, 2);
                $header_key = strtolower(trim($header_key));
                $header_value = trim($header_value);
                if ($header_key === 'cc') {
                    $cc = array_merge($cc, $normalize_recipients($header_value));
                }
                if ($header_key === 'bcc') {
                    $bcc = array_merge($bcc, $normalize_recipients($header_value));
                }
                if ($header_key === 'from') {
                    if (preg_match('/^(.*)<(.+)>$/', $header_value, $matches) === 1) {
                        $from_name = trim(trim($matches[1]), '"\'');
                    }
                }
            }
            return [$from_name, $cc, $bcc];
        };

        $to = $normalize_recipients($attributes['to'] ?? []);
        [$from_name, $cc, $bcc] = $extract_from_headers($attributes['headers'] ?? [], $normalize_recipients);

        try {
            $mailhelper->sendMail(
                mailbox: $from_email,
                subject: $attributes['subject'] ?? '',
                content: $attributes['message'] ?? '',
                to: $to,
                cc: $cc,
                bcc: $bcc,
                from_name: $from_name ?? '',
                attachments: $attributes['attachments'] ?? []
            );

            return true;
        } catch (\Throwable $t) {
            return false;
        }
    },
    10,
    2
);