### installation
```sh
npm install flatpickr --save-dev
```

### usage
```js
import flatpickr from 'flatpickr';
import { fr } from 'flatpickr/dist/l10n/fr.js';
import { de } from 'flatpickr/dist/l10n/de.js';
flatpickr('input[type="date"]', {
  locale: fr,
  /* ... */
});
```

```scss
@import '../../node_modules/flatpickr/dist/flatpickr.css';

/* override colors */
.flatpickr-months .flatpickr-prev-month:hover svg,
.flatpickr-months .flatpickr-next-month:hover svg {
    fill: red;
}
.flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
	background: blue;
    border-color: blue;
}
.flatpickr-day.selected.startRange + .endRange:not(:nth-child(7n + 1)), .flatpickr-day.startRange.startRange + .endRange:not(:nth-child(7n + 1)),
.flatpickr-day.endRange.startRange + .endRange:not(:nth-child(7n + 1)) {
    box-shadow: -10px 0 0 blue;
}
.flatpickr-day.week.selected {
    box-shadow: -5px 0 0 blue, 5px 0 0 blue;
}
```