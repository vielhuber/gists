let timeout = window.setTimeout(function() {
  console.log('FOO');
},1000);
if(timeout) { clearTimeout(timeout); }

let interval = window.setInterval(function() {
  console.log('FOO');
},1000);
if(interval) { clearInterval(interval); }


/* important: setTimeout happens async (non blocking) */
setTimeout(() => { 
  console.log('a');
},0); // this gets put onto the async stack
console.log('b');
console.log('c');
// output: b, c, a