- Links to cross origin destinations should always marked with rel="noopener noreferrer" (web.dev)
- Vulnerability: https://www.jitbit.com/alexblog/256-targetblank---the-most-underestimated-vulnerability-ever/, https://mathiasbynens.github.io/rel-noopener/

#### before
```html
<a href="https://tld.com" target="_blank">External link</a>
```

#### after
```html
<a href="https://tld.com" target="_blank" rel="noopener noreferrer">External link</a>
```

#### auto replace via js
```js
document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('a[target="_blank"]:not([rel*="noopener"])') !== null ) {
        document.querySelectorAll('a[target="_blank"]:not([rel*="noopener"])').forEach((el) => {
            let rel = el.getAttribute('rel');
            if( rel === null ) { rel = ''; }
            rel += ' noopener noreferrer';
            rel = rel.trim();
            el.setAttribute('rel', rel);
        }); 
    }
});
```