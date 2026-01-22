// default js arrays (they are objects internally)
var arr = ['foo','bar','baz'];
console.log(arr[0]); // 'foo'
console.log(arr.length); // 3
arr.push('nan'); // ['foo','bar','baz','nan']

// associative arrays in js do NOT exist, they are objects!
var arr = [];
arr["foo"] = "bar";
arr["baz"] = "nan";
console.log(arr.length); // 0, because this is now an object
console.log(Object.keys(arr).length); // use this instead
console.log(arr); // returns a pseudo like object

// "shorthand"
var arr = {
 'foo': 'bar',
 'bar': 'baz'
}; arr['foo'] // 'bar

// use instead the new ES6 feature Maps
const map0 = new Map(); // initialize empty map
const map = new Map([ // initialize map from array
  ['key0','value0'],
  ['key1','value1'],
  ['key2','value2']
]);
map.set('key3','value3');
console.log(map.get('key3')); // value3
console.log(map.has('keyZ')); // false
console.log(map.size); // 4
map.delete('key3');
map.clear(); // clear all
map.set('key0','value0');
const maparr = [...map]; // or Array.from(map);

// loop through Maps
map.forEach((value, key, map) => {
  console.log(key, value);
});
for( let [key, value] of map ) {
  console.log(key, value);
}