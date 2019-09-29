let arr = [];
console.log(arr); //shows ['foo'] when expanded because it is done on runtime
console.log(JSON.stringify(arr)); //shows correctly []
arr.push('foo');