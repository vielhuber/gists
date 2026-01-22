/* ___ (no variable decoration) */

// this is possible, because "i" gets hoisted to the top of the program
(function() {
  for(i = 0; i < 10; i++) {
      console.log(i);
  } 
})();
console.log(i); // 10

// you can prevent this when using strict mode
"use strict";
(function() {
  for(i = 0; i < 10; i++) {
      console.log(i);
  } 
})();
console.log(i); // error: not defined