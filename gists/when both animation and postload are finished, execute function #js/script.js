$.when(
	$('.box').animate({ opacity: 0 }, 1000, 'linear'),
	$.post( $(this).closest('form').attr('action'), $(this).closest('form').serialize() )
).then(function () {
	alert('both finished');
});