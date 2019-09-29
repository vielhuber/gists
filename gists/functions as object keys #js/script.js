let obj;

obj = {
 	foo: 'bar' 
};

let bar() => { return 'bar'; }

obj = {
 	foo: bar() // this is static and does not get recalled every time
}

obj = {
 	foo: function() { return bar(); } // gets recalled every time 
}

obj = {
 	foo() { return bar(); } //shortcode for the above 
}