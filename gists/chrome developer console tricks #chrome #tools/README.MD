### network: filter external requests
```
-domain:*tld.com
```
+ More filters > Hide extension URLs

### freeze page (for inspecting hover etc.)

```js
setTimeout(function(){debugger;}, 5000)
```

### current / last nth active dom element
```js
$0
$1
$2
$3
$3
```

### selectors
```js
$('.foo') // document.querySelector('.foo')
$('.foo', document.querySelector('.bar')) // document.querySelector('.bar').querySelector('.foo')

$$('.foo') // document.querySelectorAll('.foo')
$$('.foo', document.querySelector('.bar')) // document.querySelector('.bar').querySelectorAll('.foo')
```

### last evaluated result
```js
$_
```

### xpath
```js
$x('//p')
$x('//p', document.querySelector('.bar'))
```

### console
```js
console.log('msg')
console.error('msg')
console.info('msg')
console.warn('msg')
console.table({ 0: { foo: "bar" }, 1: { bar: "baz" } }) // same as table() 
console.dir({ 0: { foo: "bar" }, 1: { bar: "baz" } }) // same as dir(obj)
console.dir('very long string that should NOT be truncated!')
console.clear() // same as clear()
inspect($('.foo'))
getEventListeners($('.foo'))
function fn(x, y) { return x + y; } monitor(fn); fn(1,2)
monitorEvents(window, 'resize')
console.log('%ccool stuff', 'background: red; color: blue')
```   