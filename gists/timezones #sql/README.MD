### notes

- all timezone aware dates/times are stored internally in UTC; they are converted (both when saving and reading) in the specified timezone in the configuration
- so e.g. the function `NOW()` is time zone aware; notice the difference between:
  - `SET TIME ZONE 'UTC'; SELECT NOW();`
  - `SET TIME ZONE 'Europe/Berlin'; SELECT NOW();`
- when storing datetime data, there are two datatypes in postgresql:
  - `timestamp`: a timestamp (date+time) without a timezone
  - `timestamptz`: timestamp (date+time) with a timezone
- that means: when you change the timezone in the pgsql configuration, the `timestamp` value *will not* change, the `timestamptz` *will* change

### recommendation

- when dealing with timezones, there are different levels to consider (sql, php, js)
- note that you don't always want to convert visible columns into the users timezone (e.g. if the time given indicates when an event is happening at the event locations timezone!)
- if you want to store all your timezones as UTC (which is generally recommended for international applications), the following recommendations are the same
- as an easy approach set the timezones in sql and php both to `Europe/Berlin`
- in the backend: for columns invisible like `created_at` or `updated_at` that are set automatically via php, don't worry (since php uses the correct datetime for an user outside of `Europe/Berlin`!)
- in the frontend: for columns visible + editable you want to read in your application, convert from `Europe/Berlin` to the users timezone
- in the frontend: for columns editable, convert the data back from the users timezone to `Europe/Berlin` before posting form data

```html
<p>Simple client side conversion of time given by PHP date('d.m.Y H:i:s') which timezone is in Europe/Berlin:</p>
<span class="local-timezone">07.02.2022 00:37:00</span>

<p>Unfortunately, input datetime was removed from WHATWG. Use datetime-local instead and take care of the conversion yourself:
<form method="POST" action="test.php">
    <input class="local-timezone" type="datetime-local" name="test" value="2022-02-07T00:37:00" />
    <button type="submit">Absenden</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('.local-timezone') !== null ) {
        document.querySelectorAll('.local-timezone').forEach($el => {
            let isInput = $el.matches('input[type="datetime-local"]');
            let val = isInput ? $el.value : $el.innerText;
            if( val.match(/\d\d\.\d\d\.\d\d\d\d\ \d\d\:\d\d\:\d\d/) ) {
                let d = new Date(val.substring(6,10)+'-'+val.substring(3,5)+'-'+val.substring(0,2)+'T'+val.substring(11,13)+':'+val.substring(14,16)+':'+val.substring(17,19)+'+01:00');
                val = ('0'+d.getDate()).slice(-2)+'.'+('0'+(d.getMonth()+1)).slice(-2)+'.'+d.getFullYear()+' '+('0'+d.getHours()).slice(-2)+':'+('0'+d.getMinutes()).slice(-2)+':'+('0'+d.getSeconds()).slice(-2);
            }
            if( val.match(/\d\d\d\d-\d\d-\d\dT\d\d:\d\d:\d\d/) ) {
                let d = new Date(val+'+01:00');
                val = d.getFullYear()+'-'+('0'+(d.getMonth()+1)).slice(-2)+'-'+('0'+d.getDate()).slice(-2)+'T'+('0'+d.getHours()).slice(-2)+':'+('0'+d.getMinutes()).slice(-2)+':'+('0'+d.getSeconds()).slice(-2);
            }
            if( isInput ) {
                $el.value = val;
                $el.insertAdjacentHTML('afterend','<input type="hidden" name="'+$el.getAttribute('name')+'" value="" />');
                let updateHiddenField = () => {
                    let d = new Date($el.value);
                    d = d.toLocaleString('en-GB', { timeZone: 'Europe/Berlin' }).replace(',','');
                    d = new Date(d.substring(6,10)+'-'+d.substring(3,5)+'-'+d.substring(0,2)+'T'+d.substring(11,13)+':'+d.substring(14,16)+':'+d.substring(17,19));
                    $el.nextElementSibling.value = d.getFullYear()+'-'+('0'+(d.getMonth()+1)).slice(-2)+'-'+('0'+d.getDate()).slice(-2)+'T'+('0'+d.getHours()).slice(-2)+':'+('0'+d.getMinutes()).slice(-2)+':'+('0'+d.getSeconds()).slice(-2);                    
                };
                $el.addEventListener('change', () => { updateHiddenField(); });
                updateHiddenField();
            }
            else {
                $el.innerText = val;
            }
        });
    }
});
</script>
```

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

### links

- https://www.postgresqltutorial.com/postgresql-timestamp/

