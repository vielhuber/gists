/* vanilla */
var event = new Event('css-loaded');
elem.addEventListener('css-loaded', function (e) { }, false);
elem.dispatchEvent(event);
  
/* jquery */
$(document).on( "myCustomEvent", {
    foo: "bar"
}, function(event, arg1, arg2) {
    console.log(event.data.foo); // bar
    console.log(arg1);           // data1
    console.log(arg2);           // data2
});

$(document).trigger('myCustomEvent', ['data1','data2']);