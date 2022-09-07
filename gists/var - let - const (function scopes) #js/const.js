/* const: const guarantees that the variable does not get rebinded */
const x = 1;
x = 2; // error
x++; // error

/* const: this is also not possible */
const c;
c = 1; // does not work

/* const does _not_ guarantee immutability */
const x = {
   y: 5 
}
x.y = 6; // possible

/* also possible */
const x = [1,2];
x.push(3); // possible
x = [1,2,3]; // not possible

/* rule: always use const if you declare a variable that does not change */