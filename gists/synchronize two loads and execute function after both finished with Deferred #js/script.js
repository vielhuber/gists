var d1 = new $.Deferred();
var d2 = new $.Deferred();
$.when(d1, d2).then(function(r1, r2) {
	console.log(r1);
	console.log(r2);
    alert('done');
});
$.get(href1, function(data) { d1.resolve( data ); })
$.get(href2, function(data) { d2.resolve( data ); })