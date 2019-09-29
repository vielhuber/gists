$('#toggle_menu').click(function() {
	if( $(this).hasClass('active') ) {
		$(this).removeClass('active');
		$('#menu').slideUp(500);
	}
	else {
		$(this).addClass('active');
		$('#menu').slideDown(500);			
	}
	return false;
});