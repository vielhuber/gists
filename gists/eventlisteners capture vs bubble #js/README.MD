### notes

- capturing and bubbling has something todo with the **order, when an event is fired**
- capture will dispatch **before** bubble
- event propagation order is...
  - parent capture
  - children capture
  - target capture and target bubble (in the order they were registered; when the element is the target of the event, useCapture parameter doesn't matter)
  - children bubble
  - parent bubble
- ```stopPropagation()``` will stop the flow

### syntax
```js
el.addEventListener('click', () { }); // bubble
el.addEventListener('click', () { }, false); // bubble
el.addEventListener('click', () { }, true); // capture
```

### example 1
```js
window.addEventListener('click', () => { console.log(1); }, false);
window.addEventListener('click', () => { console.log(2); }, true);
window.addEventListener('click', () => { console.log(3); }, false);
window.addEventListener('click', () => { console.log(4); }, true);
// 2, 4, 1, 3
```

### example 2
```html
<div id="d1">
  <p id="p1">bubble</p>
</div>
<div id="d2">
  <p id="p2">capture</p>
</div>
```
```js
document.getElementById('p1').addEventListener('click', () => { alert('p1'); }, false);
document.getElementById('d1').addEventListener('click', () => { alert('d1'); }, false);
document.getElementById('p2').addEventListener('click', () => { alert('p2'); }, true);
document.getElementById('d2').addEventListener('click', () => { alert('d2'); }, true);
```