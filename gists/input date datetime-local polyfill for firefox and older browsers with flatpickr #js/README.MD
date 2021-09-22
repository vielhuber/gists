### installation
```sh
npm install flatpickr --save-dev
```

### usage
```scss
@import '../../node_modules/flatpickr/dist/flatpickr.css';
```

```js
import flatpickr from 'flatpickr';
import { fr } from 'flatpickr/dist/l10n/fr.js';
import { de } from 'flatpickr/dist/l10n/de.js';
flatpickr('input[type="date', {
  locale: 'fr',
  /* ... */
});
```