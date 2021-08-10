### line breaks

- `&#13;&#10;` // better (works in all major browsers)
- `&#13;` // doesn't work in chrome anymore

### double quotes
```php
echo '<span title="'.htmlspecialchars('foo " bar').'"></span>';
```