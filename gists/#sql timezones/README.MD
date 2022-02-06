### notes

- the date type does not have an associated timezone, the time / datetime has
- all timezone aware dates/times are stored internally in UTC
- they are converted (both when saving and reading) in the specified timezone in the configuration
- recommendation:
  - always use datetime fields when using times  
  - for regional applications:
    - php `date('Y-m-d H:i:s')` uses the local timezone of it's configuration (e.g. 'Europe/Berlin'); so when an user outside of this timezone changes data, this time is correct!

### convert datetime field from UTC to Europe/Berlin

  - `SELECT col AT TIME ZONE 'UTC' AT TIME ZONE 'Europe/Berlin'`

### show current timezone

- `SHOW TIMEZONE;`
  - `Europe/Berlin`
  - `localtime`: The timezone of the OS is used (show with `cat /etc/timezone`)

### show available timezones

- `SELECT * FROM pg_timezone_names ORDER BY name;`

### change timezone

- postgres:
  - permanently
    - `SHOW config_file;`
    - `sudo nano /**/**/postgresql.conf`
    - `timezone = 'Europe/Berlin'`
    - `sudo service postgresql start`
    - `SHOW TIMEZONE;`
  - temporarily
    - `SET TIME ZONE 'UTC'`;
    - `SHOW TIMEZONE;`
- linux (does not work in WSL):
  - `timedatectl list-timezones`
  - `sudo timedatectl set-timezone Europe/Berlin`

### check current time

- `SELECT NOW();`: must show the correct time (only if the user is in the same timezone as the server's configuration)

