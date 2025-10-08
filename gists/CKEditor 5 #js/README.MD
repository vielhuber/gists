### installation

```bash
npm install ckeditor5 --save 
```

### js

```js
import { ClassicEditor, Essentials, Bold, Italic, Underline, Strikethrough, Link, Font, Paragraph, List, SourceEditing, GeneralHtmlSupport, Clipboard, PasteFromOffice } from 'ckeditor5';
import coreTranslations from 'ckeditor5/translations/de.js';
import 'ckeditor5/ckeditor5.css';

document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.wysiwyg') !== null) {
    document.querySelectorAll('.wysiwyg').forEach($el => {
      ClassicEditor.create($el, {
        licenseKey: 'GPL',
        translations: [coreTranslations],
        plugins: [ Essentials, Bold, Italic, Underline, Strikethrough, Link, Font, Paragraph, List, SourceEditing, GeneralHtmlSupport, Clipboard, PasteFromOffice ],
        toolbar: {
          items: [
            'sourceEditing',
            '|',
            'undo',
            'redo',
            '|',
            'bold',
            'italic',
            'underline',
            'strikethrough',
            '|',
            'link',
            '|',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'bulletedList',
            'numberedList'
          ]
        },
        link: {
          addTargetToExternalLinks: true
        },
        htmlSupport: {
          allow: [
            {
              name: /.*/,
              attributes: true,
              classes: true,
              styles: true
            }
          ]
        }
      }).then(editor => {
        // always update textarea on changes (not only on submit)
        editor.model.document.on('change:data', () => {
          editor.updateSourceElement();
          editor.sourceElement.dispatchEvent(new Event('change', { bubbles: true }));
        });
      });
    });
  }
});
```

### html

```html
<textarea class="wysiwyg">Initial <strong>value</strong></textarea>
```

### css

```css
.ck-editor__editable_inline:not(.ck-comment__input *) {
    height: 350px;
    overflow-y: auto;
}
:root {
    --ck-content-font-size: 13px !important;
}
.ck-powered-by-balloon {
    display: none !important;
}
.ck.ck-voice-label {
    display: none !important;
}
```

### note on using old builders

- some adapters like base64 image upload are only available as es6 modules
- transforming with babel/babelify does not work (https://ckeditor.com/docs/ckeditor5/latest/framework/guides/support/error-codes.html#error-ckeditor-duplicated-modules)
- with the following methods you don't have to manually include plugins
- one way to get this working is to do a custom build (locally)
  - run the generator on https://ckeditor.com/ckeditor-5/online-builder/
  - download and import in js via `import ClassicEditor from './../_libs/ckeditor/build/ckeditor.js';` (or sometimes `import { Editor } from './../../_libs/ckeditor/build/ckeditor.js';`)
  - you then don't need to manually import plugins, since they are enabled by default then
- a faster way is to find an existing build
  - use `@ckeditor/ckeditor5-build-classic`
  - other examples:
    - https://www.npmjs.com/package/ckeditor5-build-classic-base64-upload-adapter
    - https://www.npmjs.com/package/@aavenel/ckeditor5-build-classic-source-editing
    - https://www.npmjs.com/package/@jackhuynh1995/ckeditor5-build-classic-plus
  - install and import with `import ClassicEditor from 'ckeditor5-build-classic-base64-upload-adapter';`
