### working solution (2021-01-21)

- chrome does ignore autocomplete="off" and other things
- this behaviour can be very nasty when honeypot values are populated
- the following solution works (chrome does not autofill it) and has the benefit that "impp" is an obscure valid value, for which chrome does not have any stored data to prefill

```html
<input type="text" name="foo" id="foo" autocomplete="impp" />
```