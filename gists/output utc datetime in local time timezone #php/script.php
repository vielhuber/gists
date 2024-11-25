$date_in_utc = '2024-01-01 12:00:00';

 // this both outputs "2024-01-01 13:00:00"
date('Y-m-d H:i:s', strtotime($date_in_utc . ' UTC'));
(new \DateTime($date_in_utc, new \DateTimeZone('UTC')))->setTimezone(new \DateTimeZone(date_default_timezone_get()))->format('Y-m-d H:i:s'));
Carbon::createFromFormat('Y-m-d H:i:s', $date_in_utc, 'UTC')->setTimezone(date_default_timezone_get())->toDateTimeString();