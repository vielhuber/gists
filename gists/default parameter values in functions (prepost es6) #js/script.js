// es6
function foo(a,b = 2) {
  alert(a+b);
}

// pre es6
function foo(a,b) {
  b = b || 2;
  alert(a+b);
}
function foo(a,b) {
  b = typeof b !== 'undefined' ? b : 2;
  alert(a+b);
}

foo(1); // 3
