## tl;dr

- if you are encoding a path segment, use `rawurlencode()`
- if you are encoding a query component, use `urlencode()`
- `&` is not part of both groups => manually encode it to `&amp;`

## example

```php
echo '<a href="https://tld.com/'.rawurlencode('You and Me').'/search?foo='.urlencode('First string').'&amp;bar='.urlencode('Second string').'">Hier klicken</a>';
```

## encoding

- in html, query arguments are separated with an encoded `&`, that is `&amp;`
- this is part of the html encapsulation, NOT of the url specification
- therefore manually encode it to `&amp;`, otherwise it is invalid html
- if you grab such an encoded link, you then may wish to substitute `&amp;` by `&` before parsing and validating urls

## parse query args

#### array to string
```php
http_build_query(['foo' => 'bar', 'bar' => 'baz'], '', '&') // foo=bar&bar=baz
http_build_query(['foo' => 'bar äöl älööälläälö', 'bar' => 'baz'], '', '&amp;') // foo=bar&amp;bar=baz (use this when you want to output it inside a html link)
```

#### string to array
```php
$link = '?foo=bar&bar=baz';
$parts = parse_url($link);
parse_str(html_entity_decode($parts['query']), $query);
print_r($query); // ['foo' => 'bar', 'bar' => 'baz']
```