## php

- normally on servers we own the timezone is set to "Europe/Berlin"
- functions like `date()` or `strtotime()` respect this setting

#### important functions

```php
// output date
date()
// convert string to time
strtotime()
// get time since epoch (always in UTC!)
time()
// get current timezone
date_default_timezone_get() // Europe/Berlin
// set timezone for the current session (otherwise the setting in php.ini applies)
date_default_timezone_set('Europe/Berlin');
date_default_timezone_set('UTC'); // default timezone
```

## wordpress

- tl;dr: ~~`date()`~~ => `wp_date()` and ~~`strtotime()`~~ => `strtotime(get_gmt_from_date())`
- tl;dr: if you access via js and create Date objects, use this format: `echo wp_date('Y-m-d\TH:i:sP', strtotime(get_gmt_from_date('2022-06-01 15:00:00')));`
- wordpress always sets the timezone to "UTC" (regardless what the server timezone is set to), which is the same as "GMT"
- if you have to take care of timezones, save all dates in the database in UTC-time
- if you don't take care of timezones, only work with local times and use `wp_date()`/`strtotime(get_gmt_from_date())`
- don't use `date_i18n()`, since it is deprecated (use `wp_date()` instead)
- never overwrite the timezone with `date_default_timezone_set()`, because WordPress assumes UTC everywhere
- exception: you want to use primarily native php functions and don't use or rely on the WordPress' ones

#### important functions

```php
// equivalent of date() that respects the timezone set in options
wp_date()
// convert europe/berlin to utc
get_gmt_from_date('2021-06-23 12:00:00') // 2021-06-23 10:00:00
$d = new \DateTime('2021-06-23 12:00:00', new \DateTimeZone('Europe/Berlin')); $d->setTimeZone(new \DateTimeZone('UTC')); echo $d->format('Y-m-d H:i:s');
// utc to europe/berlin
get_date_from_gmt('2021-06-23 12:00:00') // 2021-06-23 14:00:00
$d = new \DateTime('2021-06-23 12:00:00' new \DateTimeZone('UTC')); $d->setTimeZone(new \DateTimeZone('Europe/Berlin')); echo $d->format('Y-m-d H:i:s');
// get timezone from settings
get_option('timezone_string') // Europe/Berlin
```

#### translations

##### output in source language

```php
$date_time = '2021-09-30 17:00:00';
echo wp_date(__('d.m.Y H:i', 'custom'),strtotime(get_gmt_from_date($date_time)));
```

##### translate format via wpml string translations

- `d.m.Y H:i` => `Y-m-d G:i a`

##### funny problem

- `wp_date(__('d.m.Y H:i \U\h\r', 'custom'))` does not work, because \r is interpreted as a carriage return by the auto register function of wpml
- use this workaround: `wp_date(ICL_LANGUAGE_CODE == 'en' ? 'Y-m-d H:i a' : 'd.m.Y H:i \U\h\r')`