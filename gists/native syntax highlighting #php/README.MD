```css
.code-container code {
  display: block;
  overflow-x: auto;
  white-space: nowrap;
}
```

```php
echo '<div class="code-container">';
$code = <<<'EOD'
<?php
if(function_exists('foo')) {
    echo '<ul>';
    foreach(bar() as $val) {
        echo '<li>';
            echo '<a href="'.$val['url'].'"'.($val['active']?' class="active"':'').'>';
                echo $val['label'];
            echo '</a>';
        echo '</li>';
    }
    echo '</ul>';
}
EOD;
echo highlight_string($code, true);
echo '</div>';
```