## setup
npm install clipboard --save

## js
```js
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('[data-clipboard]') !== null) {
    let clipboard = new ClipboardJS(document.querySelectorAll('[data-clipboard]'), {
      text: (trigger) => {
        return trigger.getAttribute('data-clipboard');
      }
    });
    clipboard.on('success', (e) => {
      alert(e.text+' in die Zwischenablage kopiert');
    });
    clipboard.on('error', (e) => {
      alert('Es ist ein Fehler beim kopieren aufgetreten');
    });
  }
});
```

## html
```html
<a href="#" data-clipboard="foo" title="foo">X</a>
```