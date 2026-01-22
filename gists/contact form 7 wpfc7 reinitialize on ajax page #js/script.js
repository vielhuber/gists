if( $('div.wpcf7 > form').length > 0 )
{
	$('div.wpcf7 > form').each(function()
	{
		var $form = $(this);
		wpcf7.initForm($form);
		if(wpcf7.cached)
		{
			wpcf7.refill($form);
		}
	});
}