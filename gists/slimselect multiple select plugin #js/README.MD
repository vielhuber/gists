```sh
npm install --save-dev slim-select
```

```html
<select multiple="multiple" data-placeholder="Jetzt wählen!">
  <option value="">--</option>
  <option selected="selected" value="foo">Foo</option>
  <option value="bar">Bar</option>
</select>
```

```js
import SlimSelect from 'slim-select';

document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('select[multiple]') !== null ) {
        document.querySelectorAll('select[multiple]').forEach($el => {
            if (!$el.hasAttribute('multiple')) {
                if ($el.querySelector('option[value=""]') !== null) {
                    $el.querySelector('option[value=""]').innerText = '';
                    $el.querySelector('option[value=""]').setAttribute('data-placeholder', 'true');
                }
            }
            new SlimSelect({
                select: $el,
                showSearch: false,
                placeholder: $el.hasAttribute('data-placeholder') ? $el.getAttribute('data-placeholder') : ' ',
                allowDeselect: true,
                allowDeselectOption: true,
                closeOnSelect: !$el.hasAttribute('multiple')
            })
        });
    }
});
```