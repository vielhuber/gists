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
- wordpress always sets the timezone to "UTC" (regardless what the server timezone is set to), which is the same as "GMT"
- if you have to take care of timezones, save all dates in the database in UTC-time
- if you don't take care of timezones, only work with local times use `wp_date()`/`strtotime(get_gmt_from_date())`
- don't use `date_i18n()`, since it is deprecated
- never overwrite the timezone with `date_default_timezone_set()`, because WordPress assumes UTC everywhere

#### important functions

```php
// equivalent of date() that respects the timezone set in options
wp_date()
// convert europe/berlin to utc
get_gmt_from_date('2021-06-23 12:00:00') // 2021-06-23 10:00:00
// utc to europe/berlin
get_date_from_gmt('2021-06-23 12:00:00') // 2021-06-23 14:00:00
// get timezone from settings
get_option('timezone_string') // Europe/Berlin
```

#### translation

##### output in source language

```php
$date_time = '2021-09-30 17:00:00';
echo wp_date(__('d.m.Y H:i', 'custom'),strtotime(get_gmt_from_date($date_time)));
```

##### translate format via wpml string translations

- `d.m.Y H:i` => `Y-m-d G:i a`