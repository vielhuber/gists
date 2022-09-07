// without
$('.el').each(function() {
  	$(this).remove();
});

// with
$('.el').each((el__key, el__value) =>
{
	$(el__value).remove();  
});