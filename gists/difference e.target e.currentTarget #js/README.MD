- target = element that triggered event.
- currentTarget = element that listens to event.

```html
<div class="_1">1<div class="_2">2</div></div>
```

```js
document.querySelector('._1').addEventListener('click', e => {
    e.target // _1 if you click _1, _2 if you click on _2
    e.currentTarget // _1 if you click on _1, _1 if you click on _2
});
```