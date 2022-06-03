/* basic for */
for(let i = 0; i < 10; i++) {}

/* arrays and objects */
Object.keys(item).forEach(item__key => { console.log([item__key,item[item__key]]); }); // every array is an object
for(const [item__key, item__value] of Object.entries(item)) { console.log([item__key,item[item__key]]); }

/* arrays */

// alternative with arrow functions
["a", "b", "c"].forEach((value) => { });
["a", "b", "c"].forEach((value, key) => { });

// foreach (es6)
["a", "b", "c"].forEach(function(value, key) {
    if( value === 'b' )
    {
        return; // continue
      	// break does NOT exist in forEach
    }
});

// new browsers
for(let item of ["a", "b", "c"]) {
    console.log(item);
  	if( item === 'b' )
    {
     	continue; // continue works here! 
      	break; // break works here!
    }
  	await foo(); // async await works here
}
for(var item of ["a", "b", "c"]) {
    console.log(item);
}

let arr = ["a", "b", "c"];
for(let key in arr) {
  console.log(arr[key]);
}

// cool alternative way
for(let i=0, item; item = ["a", "b", "c"][i]; i++) {
  console.log(item);
}

// old browsers (jquery)
$.each(["a", "b", "c"], function(key, value) {
  console.log(key, value);
});

// standard
var arr = ["a", "b", "c"];
for(let i = 0; i < arr.length; i++) { console.log(arr[i]); }
for(var i = 0; i < arr.length; i++) { console.log(arr[i]); }


/* objects */

var obj = { a: 'foo', b: 'bar' };

// new
for(const [key, value] of Object.entries(obj)) {
	// you can't break out easily from forEach but from for of!
  	break;
  	// another advantage: you can use await here (inside forEach this is impossible)
  	await someAsyncFunc();
}

// new
for(let obj__value of Object.values(obj)) {
    console.log(obj__value);
}

// new
Object.values(obj).forEach((value) => { });
Object.entries(obj).forEach(([key, value]) => { });
Object.keys(obj).forEach(key => { console.log([key,obj[key]]); }); // alternative

// old
for(var key in obj) {
    if (!obj.hasOwnProperty(key)) { continue; } // filter out prototype things; NOT needed, if this is only a plain object
    console.log(key, obj[key])
}

// jquery
$.each({ a: 'foo', b: 'bar' }, function(key, value)
{
  console.log(key, value);
});

// dom elements
document.querySelectorAll('.foo').forEach($el => { });
for (let $el of document.querySelectorAll('.foo')) { /* use break, continue, async await here! */ }