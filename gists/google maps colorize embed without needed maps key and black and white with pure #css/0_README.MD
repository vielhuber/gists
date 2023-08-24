### #1

- recommended current example (extracted from the official embed function)

```php
<?php
$zoom = 5000;
$address = 'Auenstraße 6, 80469 München';
//$address = '48.127660,11.575380'; // lat/lng is also possible but without an address card
$lng = 'de';

$src = 'https://www.google.com/maps/embed?pb='.
'!1m18'.
    '!1m12'.
        '!1m3'.
            '!1d'.$zoom.
            '!2d0'.
            '!3d0'.
        '!2m3'.
            '!1f0'.
            '!2f0'.
            '!3f0'.
        '!3m2'.
            '!1i1024'.
            '!2i768'.
        '!4f13.1'.
        '!3m3'.
            '!1m2'.
            '!1s0'.
            '!2s'.rawurlencode($address).
        '!5e0'.
        '!3m2'.
            '!1s'.$lng.
            '!2s'.$lng.
        '!4v'.time().'000'.
        '!5m2'.
            '!1s'.$lng.
            '!2s'.$lng;

echo '<iframe src="'.$src.'" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
```

### #2

- solution with api key (important: restrict the api key to domain referrers)

```html
<iframe
	src="https://www.google.com/maps/embed/v1/place?key=xxxxxxxxxxxxxxxxxxxxxxxxxxx&q=Auenstraße 6, 80469 München, Deutschland&zoom=9"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
></iframe>
```

```html
<iframe
	src="https://www.google.com/maps/embed/v1/place?key=xxxxxxxxxxxxxxxxxxxxxxxxxxx&q=48.127660,11.575380&zoom=9"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
></iframe>
```

### #3

- this solution doesn't work anymore (google stopped supporting `output=embed` and no use of an api key)

```html
<iframe
	src="https://www.google.com/maps?q=Auenstraße 6, 80469 München, Deutschland&z=9&output=embed"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
></iframe>
```

```html
<iframe
	src="https://www.google.com/maps?q=48.127660,11.575380&z=9&output=embed"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
></iframe>
```

### #4

- apply fancy styles

```css
iframe {
   filter: grayscale(50%) invert(5%) sepia(10%) saturate(70%) brightness(100%) contrast(110%) hue-rotate(-130deg);
}
iframe {
   filter: grayscale(0%) invert(0%) sepia(70%) saturate(40%) brightness(100%) contrast(100%) hue-rotate(0deg); 
}
```