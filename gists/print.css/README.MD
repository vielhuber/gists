### possibility #1
```html
<link rel="stylesheet" type="text/css" media="print" href="print.css" />
```

```css
@page {
	size: A4 portrait;
	margin: 1cm 1cm;
}
html,
body {
	padding: 0;
	margin: 0;
}
```

### possibility #2
```html
<link rel="stylesheet" type="text/css" href="style.css" /> <!-- don't use media="screen" here! -->
```

```css
@media print {
    @page {
        size: A4 portrait;
        margin: 1cm 1cm;
    }
    html,
    body {
        padding: 0;
        margin: 0;
    }
}
```

### conditional @page statements (put this only on pages you need)
```html
<style>
	@media print {
      @page {
          size: A4 portrait;
          margin: 1cm 1cm;
      }
  }  
</style>
```
