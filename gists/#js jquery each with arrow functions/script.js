// without
$('.el').each(function() {
  	$(this).remove();
});

// with
$('.el').each((index,el) =>
{
	$(el).remove();  
});