// wrong
var obj1 = { foo: 'bar', bar: 'baz' };
var obj2 = obj1;
obj2.foo = 'baz';
obj1.foo // 'baz';

// variant 1 (does NOT work with objects inside object)
var obj1 = { foo: 'bar', bar: 'baz', ign: { az: 42 } };
var obj2 = Object.assign({}, obj1); // alternative: { ...obj1 }
obj2.foo = 'baz';
obj2.ign.az = 43;
obj1.foo // 'bar';
obj1.ign.az // 43;

// variant 2 (does NOT work with functions inside object)
var obj1 = { foo: 'bar', bar: 'baz' };
var obj2 = JSON.parse(JSON.stringify(obj1));
obj2.foo = 'baz';
obj1.foo // 'bar';