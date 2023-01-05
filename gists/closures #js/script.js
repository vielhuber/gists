// When a function returns another function, the returning function holds its environment (in a closure)

// example #1
// here the function "inner" uses the variable var1 from outside its scope in its closure
var outer = function(var1) {
  var inner = function(var2) {
    return var1 + var2;
  }
  return inner;
}
var newFunction = new outer(7);
newFunction(42); // 49

// example #2
let object = function() {
  let i = 0;
  return {
    setI(k) { i = k; },
    getI() { return i; }
  }
}
let x = new object();
x.setI(2);
console.log(x.getI()); // x has i in its closure

