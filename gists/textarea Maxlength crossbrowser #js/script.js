$('textarea').bind('input propertychange', function() {  
	var limit = $(this).attr('data-maxlength');
	var chars = $(this).val().length;
	if(chars > limit){  
		$(this).val($(this).val().substring(0,limit)); 
		chars = limit;
	}
	$('.counter').text(limit - chars);
});