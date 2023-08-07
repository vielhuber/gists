### installation

```bash
npm install --save @ckeditor/ckeditor5-build-classic
```

### js

```js
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import '@ckeditor/ckeditor5-build-classic/build/translations/de.js';

document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.wysiwyg') !== null) {
    document.querySelectorAll('.wysiwyg').forEach(el => {
      ClassicEditor.create(el, {
        language: 'de',
        toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList'],
        width: '100%',
        height: 400,
        forcePasteAsPlainText: true
      }).then(editor => {
        // always update textarea on changes (not only on submit)
        editor.model.document.on('change:data', () => {
          editor.updateSourceElement();
          editor.sourceElement.dispatchEvent(new Event('change', { bubbles: true }));
        });
      });;
    });
  }
});
```

### html

```html
<textarea class="wysiwyg">Initial <strong>value</strong></textarea>
```

### a note on adapters

- some adapters like base64 image upload are only available as es6 modules
- transforming with babel/babelify does not work (https://ckeditor.com/docs/ckeditor5/latest/framework/guides/support/error-codes.html#error-ckeditor-duplicated-modules)
- with the following methods you don't have to manually include plugins
- one way to get this working is to do a custom build (locally)
  - run the generator on https://ckeditor.com/ckeditor-5/online-builder/
  - download and import in js via `import ClassicEditor from './../_libs/ckeditor/build/ckeditor.js';`
- a faster way is to find an existing build
  - e.g.
    - https://www.npmjs.com/package/ckeditor5-build-classic-base64-upload-adapter
    - https://www.npmjs.com/package/@aavenel/ckeditor5-build-classic-source-editing
    - https://www.npmjs.com/package/@jackhuynh1995/ckeditor5-build-classic-plus
  - install and import with `import ClassicEditor from 'ckeditor5-build-classic-base64-upload-adapter';`
