let arr = [];
console.log(arr); // shows ['foo'] when expanded because it is done on runtime
console.log(JSON.parse(JSON.stringify(arr))); // shows correctly []
console.log(JSON.stringify(arr)); // this is also sometimes needed (for nested objects)
arr.push('foo');