```html
<form>
	<!-- prevent implicit submission of the form -->
	<button type="submit" disabled style="display: none" aria-hidden="true"></button>
	<input type="submit" value="Absenden" />
</form>
```

```js
// leave this as it was
if (document.querySelector('form') !== null) {
  document.querySelector('form').addEventListener('submit', e => {
    console.log('submit');
    e.preventDefault();
  });
}
```