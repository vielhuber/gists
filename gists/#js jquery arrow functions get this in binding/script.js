// without arrow functions
$('.el').click(function() {
  	console.log(this);
});

// with arrow functions
$('.el').click((e) =>
{
	console.log(e.currentTarget);  
});