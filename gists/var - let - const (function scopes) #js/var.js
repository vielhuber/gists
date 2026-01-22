/* var: defines a variable available in function scope */

// example 1 (for is not a function)
for(var i = 0; i < 10; i++) {
   console.log(i);
}
console.log(i); // 10

// example 2 (var is not available outside function scope)
function counter() {
   for(var i = 0; i < 10; i++) {
      console.log(i);
   }
}
console.log(i); // error: not defined

// example 3 (var is also not available outside invoked function)
(function() {
  for(var i = 0; i < 10; i++) {
      console.log(i);
  } 
})();
console.log(i); // error: not defined

// example 4 (var gets in comparison to let hoisted)
console.log(v); // undefined (because the definition (not the value) of v gets hoisted)
console.log(l); // reference error (because l does not get hoisted)
var v = 1337;
let l = 42;

// example 5 (let is valid in the current block (nearest scope, not necessary function scope!); var is valid in the current function scope)
function varTest() {
  var x = 31;
  if (true) {
    var x = 71;
    console.log(x);  // 71
  }
  console.log(x);  // 71
}
function letTest() {
  let x = 31;
  if (true) {
    let x = 71;
    console.log(x);  // 71
  }
  console.log(x);  // 31
}