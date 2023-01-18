## header
- this gets loaded at first and blocks execution

```html
<html>
  <head>
    <script src="script.js"></script> 
  </head>
  <body>
  </body>
</html>
```

## footer
- this gets loaded at last and blocks execution
```html
<html>
  <head>
  </head>
  <body>
      <script src="script.js"></script> 
  </body>
</html>
```

## defer
- use defer for scripts which have to be executed after html is parsed
```html
<html>
  <head>
  	<script defer src="script.js"></script> 
  </head>
  <body>
  </body>
</html>
```

## async
- use async for scripts which can be executed in any order
```html
<html>
  <head>
  	<script async src="script.js"></script> 
  </head>
  <body>
  </body>
</html>
```

## async defer
- if you specify both, async takes precedence on modern browsers, while older browsers that support defer but not async will fallback to defer
- async/defer make only sense when using the script in the head portion of the page, and they are useless if you put the script in the body footer
- document ready does not trigger in async scripts, so use window load
- for google page speed insights it is best to use async
- be careful: document ready and window load do not get triggered reliably. instead use the promise below
```html
<html>
  <head>
  	<script async defer src="script.js"></script> 
  </head>
  <body>
  </body>
</html>
```

```js
const ready = new Promise((resolve) =>
{
    if (document.readyState !== 'loading') { return resolve(); }
    else { document.addEventListener('DOMContentLoaded', () => { return resolve(); }); }
});
ready.then(() => {
    /* ... */
});
```