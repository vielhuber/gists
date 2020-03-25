### installation

```bash
npm install --save @ckeditor/ckeditor5-build-classic
```

### js

```js
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.wysiwyg') !== null) {
    document.querySelectorAll('.wysiwyg').forEach(el => {
      ClassicEditor.create(el, {
        toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList'],
        width: '100%',
        height: 400,
        forcePasteAsPlainText: true
      });
    });
  }
});
```

### html

```html
<textarea class="wysiwyg">Initial <strong>value</strong></textarea>
```