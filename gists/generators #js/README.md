## generators
- for the niche
- generators are functions which can be exited and later re-entered
- they can be suspended and later resumed at any time
- yield returns a value only once, and the next time you call the same function it will move on to the next yield statement
- in generators we always get the output {value: ..., done: true/false}
- useful when you want stop the function, get results out of a function, do some things, pass things back to the function, resume the function and so on

## syntax
```js
// all three are valid
function * generator () {}
function* generator () {}
function *generator () {}
```

## examples
#### simple
```js
function* oneToThree() {
  yield 1;
  yield 2;
  yield 3;
}
var gen = oneToThree();
console.log(gen.next()); // { value: 1, done: false }
console.log(gen.next()); // { value: 2, done: false }
console.log(gen.next()); // { value: 3, done: false }
console.log(gen.next()); // { value: undefined, done: true }
```

#### simple
```js
function* generatorForLoop(num) {
  for(let i = 0; i < num; i += 1) {
    yield console.log(i);
  }
}
const genForLoop = generatorForLoop(5);
genForLoop.next(); // first console.log - 0
genForLoop.next(); // 1
genForLoop.next(); // 2
genForLoop.next(); // 3
genForLoop.next(); // 4
```

#### use as an iterator
```js
function* oneToThree() {
  yield 1
  yield 2
  yield 3
}
var gen = oneToThree();
for (var num of oneToThree()){
    console.log(num)
}
```

#### random number
```js
function * randomFrom(...arr) {
  while (true)
    yield arr[Math.floor(Math.random() * arr.length)];
}
const getRandom = randomFrom(1, 2, 5, 9, 4);
getRandom.next().value; // returns random value
```

#### async await polyfill
```js
function runAsync(generator){
    var it = generator();
    (function iterate(val){
        var ret = it.next( val );
        if (!ret.done) {
            ret.value.then( iterate );
        }
    })();
}
function* printFooBar(){
    var part1 = yield getFoo()
    var part2 = yield getBar()
    console.log(part1+part2)
}
runAsync(printFooBar) // foobar
```