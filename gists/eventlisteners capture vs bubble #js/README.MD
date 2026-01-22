### notes

- capturing and bubbling has something todo with the **order, when an event is fired**
- capture will dispatch **before** bubble
- event propagation order is...
  - ...
  - grandparent capture
  - parent capture
  - children capture
  - target capture and target bubble (in the order they were registered; when the element is the target of the event, useCapture parameter doesn't matter)
  - children bubble
  - parent bubble
  - grandparent bubble
  - ...
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

### example 3

- mouseenter/mouseleave does not bubble (this is how it's built)
- if we want to build a hover event listener that acts on dynamic elements, we need to use capture (in order to register the event at all!)

```html
<div class="_1" style="padding:20px;background-color:red;">
  <div class="_2" style="padding:20px;background-color:blue;">
  </div>
</div>
```
```js
// only fires when entering _1
document.querySelector('._1').addEventListener('mouseenter', e => {
   console.log(e.target);
}, false);
// fires when entering _1, _2 and _3 (since the parent of _2 is _1 which can be captured)
document.querySelector('._1').addEventListener('mouseenter', e => {
   console.log(e.target);
}, true);
```