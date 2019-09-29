#### method 1: function declaration
```js
function foo() {
   return 42;
}
foo() // 42
foo // function
```

#### method 2: function expression (anonymous)
```js
var foo = function() {
   return 42;
}
```

#### method 3: function expression (named)
```js
var foo = function bar() {
   return 42;
}
```

#### method 4: self invoking (named)
```js
(function foo() {
    alert("42"); // starts immediately without calling!
})(); 
```

#### method 5: self invoking (anonymous)
```js
(function() {
    alert("42"); // starts immediately without calling!
})(); 
```

#### difference: function declarations get hoisted but function expressions not
```js
console.log(foo()); // 42
console.log(bar()); // error
function foo() { return 42; }
let bar = function() { return 43; }
```