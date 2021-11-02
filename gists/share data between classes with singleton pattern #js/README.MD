### option 1

#### singleton-class.js
```js
let instance = null;
export default class Example {
    constructor() {
      	/* this is called "the singleton pattern" */
        if (!instance) {
            instance = this;
        }
        return instance;
    }

    set(val) {
      	this.val = val;
    }
  
  	get() {
      	return this.val;
    }
}
```

#### singleton-usage.js
```js
import Example from './example';
let e1 = new Example();
e1.set(42);
let e2 = new Example();
e2.get() // 42
```

### option 2
#### singleton-class.js
```js
class Example {}
let e = new Example();
export default e;
```

#### singleton-usage-1.js
```js
import Example from './example';
Example.foo = 42;
```

#### singleton-usage-2.js
```js
import Example from './example';
console.log(Example.foo); // 42
```