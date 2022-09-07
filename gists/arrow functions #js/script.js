/* old way to do it (es5) */
function foo(x,y) {
   return x*y;
}
var foo = function(x,y) {
   return x*y;
}

/* new syntax */
const fun = () => 2*3;
const fun = (x,y) => x*y;
const fun = (x,y) => { return x*y; }
setTimeout(()=>{ });

/* differences */
// arrow functions do not have an own scope
window.firstName = 'foo';
const object = {
  firstName: 'bar',
  fun1: function() { console.log(this.firstName); },
  fun2: () => { console.log(this.firstName); }
};
object.fun1(); // 'foo' because this referrs to window object
object.fun2(); // 'bar' because this referrs to object