### line breaks

- `&#13;&#10;` // better (works in all major browsers)
- `&#13;` // doesn't work in chrome anymore

### php (handles double quotes)
```php
echo '<span title="'.htmlspecialchars('foo " bar').'"></span>';
```

### js (handles double quotes)
```js
document.querySelector('span').setAttribute('title', hlp.htmlEncode('foo " bar'));
```
