```html
<ul>
  <li>foo</li>
  <li><a href="#" class="bar">bar</a></li>
  <li>baz</li>
</ul>
```

```js
document.addEventListener('DOMContentLoaded', () => {
	document.querySelector('.bar').addEventListener('click', (e) => { alert('OK'); });

    // does not work
    document.querySelector('ul').innerHTML = '<ul><li>foo</li><li><a href="#" class="bar" data-attribute="barrr">barrr</a></li></li><li>baz</li></ul>';

    // works (https://github.com/fiduswriter/diffDOM)
    dd = new diffDOM.DiffDOM(); 
    let diff = dd.diff(document.querySelector('ul'), '<ul><li>foo</li><li><a href="#" class="bar" data-attribute="barrr">barrr</a></li></li><li>baz</li></ul>');
    dd.apply(document.querySelector('ul'),diff);
});
```