## general
- output buffering is a method to hold data before it issend to the browser
- you can retrieve the data and put it in a variable, manipulate it, and send it to the browser once you're finished
- php normally also has output buffering (it controls, when php sends/shows the data while parsing it); the limit can be set via output_buffering  (to e.g. 4kb)
- ob_start has it's own limit (which is by default 0)
- if no ob_end_clean() is called at the end, the output buffer is also cleared automatically on php shutdown

## commands

### start output buffering
```php
ob_start();
```

### get content from buffer
```php
ob_get_contents();
```

### delete current output buffer
```php
ob_end_clean();
```

### echo current buffer contents and delete current output buffer
```php
ob_end_flush();
```

## examples
```php
ob_start();
require_once('template.html');
$html = ob_get_contents();
ob_end_clean();
$html = str_replace('foo','bar',$html);
echo $html;
```

```php
ob_start(
  function($html) { echo str_replace('foo','bar',$html); }, // nead alternative to ob_get_contents()
  0 // chunk size, could be se to 4096
);
require_once('template.html');
ob_end_flush(); // this is needed (otherwise weird behaviour occures when using multiple output buffers etc.)
```