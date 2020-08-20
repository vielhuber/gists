requestAnimationFrame takes a function and tells the browser
to execute that function AFTER the next repaint.

there are two use cases for using requestAnimationFrame:

### needing repaint for further code usage

#### before

```js
document.querySelector('.foo').style.width = '200px';

document.querySelector('.foo').offsetTop  // does perhaps not return the correct value
```

#### after

```js
document.querySelector('.foo').style.paddingTop = '200px';

requestAnimationFrame(() =>
{
    document.querySelector('.foo').offsetTop // returns the correct value, because is executed after the next repaint
});
```

### do something constantly (animations etc.)

#### before

```js
setInterval(() =>
{
    /* ... */
}, 1000/60); // 60 fps
```

#### after

```js
function repeatOften(() =>
{
    /* ... */
    requestAnimationFrame(repeatOften);
});
requestAnimationFrame(repeatOften);
```

#### order: the following statements are equivalent (because raf is asynchronous)
```js
function repeatOften(() =>
{
    /* ... */
    requestAnimationFrame(repeatOften);
});
requestAnimationFrame(repeatOften);
```
```js
function repeatOften(() =>
{
    requestAnimationFrame(repeatOften);
    /* ... */
});
requestAnimationFrame(repeatOften);
```

#### example: scrolling

```js
// slow scroll event
$(window).scroll(()
{
    console.log(window.scrollY);
    /* ... */
});

// this is also not bad, but try RAF for speed comparison
window.addEventListener('scroll', (e)
{
    console.log(window.scrollY);
    /* ... */ 
});

// fast scroll event (including vendor prefixes and polyfill)
var rAF = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || window.oRequestAnimationFrame || function(callback){ window.setTimeout(callback, 1000/60) };
var rAFPosLast = -1;
function rAFLoop()
{
  if( rAFPosLast == window.pageYOffset ) { rAF(rAFLoop); return false; }
  rAFPosLast = window.pageYOffset;
  
  // work
  console.log('foo');
  
  rAF(rAFLoop);
}
rAFLoop();

// clean final form with self invoking function
let rAFPosLast = -1; (function rAFLoop() { if( rAFPosLast == window.pageYOffset ) { requestAnimationFrame(rAFLoop); return; } rAFPosLast = window.pageYOffset;
{            
    // work
    // ...             
}
requestAnimationFrame(rAFLoop); })();

// fast scroll to
(function scroll() {
    var value = by * (Math.pow(currentIteration / animIterations - 1, 3) + 1) + from;
    document.documentElement.scrollTop = document.body.scrollTop = value;
    currentIteration++;
    if (currentIteration < animIterations) {
        requestAnimationFrame(scroll);
    }    
})();
```