## new way

```css
iframe {
  	width: 100%;
    aspect-ratio: 16 / 9;
}
```

## old way

### functions.php
```php
// WordPress: Wrap div around automatically oembedded youtube videos
add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;
function custom_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="video-container"><div>'.$html.'</div></div>';
    return $return;
}
```

### index.html
```html
<div class="video-container"><div>
<iframe width="960" height="720" src="https://www.youtube.com/embed/mpotcitv0ps?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
</div></div>
```

### style.css
```css
.video-container {
  width:100%;
  max-width:780px;
  margin:0px auto;
}
.video-container > div {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 */
  height: 0;
}
.video-container > div > iframe {
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:100%;
}
```