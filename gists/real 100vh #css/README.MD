### notes

- browsers intentionally calculate 100vh by no means as the value of the current viewport height
- they don't want repaints all the time, when the address bar is shown or hidden
- but there are tricks to achieve that behaviour (which can be useful in some situations)

### problem

```css
div {
 	height:100vh; /* doesn't always have to be the overall viewport size */
}
```

### solution with css variables and js
```js
let fn = () => {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
}
fn();
window.addEventListener('resize', () => { fn(); });
```

```css
div {
	height: 100vh; /* fallback */
	height: calc(100 * var(--vh, 1vh));
}
```

### solution with hlp
```js
hlp.real100vh('div')
hlp.real100vh('div', 60)
hlp.real100vh() // sets up the css variable
```