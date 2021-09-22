## frontend

- very important: the chrome autofill behaviour fills in some scenarios hidden fields and leads to unsuccessful legal attempts. solution: use ```autocomplete="impp"```
- we apply 3 different fields (you should intersperse them between other valid fields)

```html
<style>input[name^="topfhonig"] { opacity:0.0001;position:absolute;top:0;left:-999999px; }</style>
<input type="text" name="topfhonig1" value="" tabindex="-1" autocomplete="impp" />
<input type="text" name="topfhonig2" value="" tabindex="-1" autocomplete="impp" />
<input type="text" name="topfhonig3" value="" tabindex="-1" autocomplete="impp" />
```

## backend

- note that we give the user the feedback that it worked but left out the actual logic
- also the form values need to be present but empty

```php
if(
  	isset($_POST['topfhonig1']) && $_POST['topfhonig1'] == '' &&
  	isset($_POST['topfhonig2']) && $_POST['topfhonig2'] == '' &&
  	isset($_POST['topfhonig3']) && $_POST['topfhonig3'] == ''
)
{
    mail(/*...'*/);
}
die('success');
```