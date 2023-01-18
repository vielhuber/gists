- if you apply one of the following css properties to an element, a new "stacking" context is created
  - `filter`
  - `transform`
  - `backdrop-filter`
  - `perspective`
  - `contain`
  - `transform-style`
  - `will-change`
- all child elements, that are positioned absolute/fixed, are not working anymore as expected!
- workaround: just use `backdrop-filter` instead of `filter`!

```html
<div class="foo">
  <div class="bar">I am fixed on scroll</div>
</div>

<div class="foo" style="filter:grayscale(1);">
  <div class="bar">I move with the scroll</div>
</div>
```

```css
.foo {
  display: inline-block;
  width: 200px;
  height: 200vh;
  border: 1px solid;
}

.bar {
  position: fixed;
  width: 100px;
  height: 100px;
  background: red;
  color: #fff;
}
```