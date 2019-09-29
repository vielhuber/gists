/* let: defines a variable only available in current scope (function scope, for loop scope, if scope) */
let i = 1337;
for(let i = 0; i < 10; i++) {
  console.log(i); // 0 ...10
}
console.log(i); // 1337

/* {} is also a block */
let i = 42;
{
	let i = 1337;
}
console.log(i); // 42

/* rule: always use let instead of var in the future! var is not needed anymore */