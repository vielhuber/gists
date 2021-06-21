### new
```js
if (document.querySelector('.form') !== null) {
  document.querySelectorAll('.form').forEach(el => {
    el.addEventListener('submit', e => {
      /* todo */
      e.preventDefault();
    });
  });
}
if (document.querySelector('.form__submit') !== null) {
  document.querySelectorAll('.form__submit').forEach(el => {
    el.addEventListener('click', e => {
      if (el.closest('form').checkValidity()) {
        el.closest('form').dispatchEvent(new Event('submit', { bubbles: true }));
      } else {
        el.closest('form').reportValidity();
      }
      e.preventDefault();
    });
  });
}
```


### old

```html
<form>
   <input type="text" required="required" name="foo" value="" />
   <input style="display:none;" type="submit" />
   <a href="#" onclick="this.previousElementSibling.click();return false;">Absenden</a>
</form>
```