### step 1: modify viewport-property

before:
```html
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" />
```

after:
```html
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0" />
```

### step 2: add css

```css
body {
	touch-action: manipulation;
}
```

### caveat: certain elements with display flex still allow the user to zoom on double tap!

```html
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0" />
    <title>.</title>
    <style>
    body {
        touch-action: manipulation;
    }
    h1 {
        display: flex;
    }
    </style>
</head>
<body>
    <h1>Test</h1>
</body>
</html>
```