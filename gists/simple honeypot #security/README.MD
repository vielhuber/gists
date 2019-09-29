## frontend
```html
<!-- honeypot! -->
<style>
  input[name="salutation"], input[name="timing"] { opacity:0.0001;position:absolute;top:0;left:-999999px; }  
</style>
<input type="text" name="salutation" value="" tabindex="-1" autocomplete="off" />
<input type="text" name="timing" value="" tabindex="-1" autocomplete="off" />
```

## backend
```php
if( @$_POST['salutation'] != '' || @$_POST['timing'] != '' )
{
    die('success');
}
```