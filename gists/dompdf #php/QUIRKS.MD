#1 svg fill

SVGs without a base fill color are not shown
Simply fix this with php before viewing:
```php
$svg_filename = 'test.svg';
$svg_content = file_get_contents( $svg_filename );
if(strpos($svg_content, '<svg xmlns') === 0)
{
  $svg_content = str_replace('<svg xmlns', '<svg fill="#000000" xmlns', $svg_content);
  file_put_contents($svg_filename, $svg_content);
}
```