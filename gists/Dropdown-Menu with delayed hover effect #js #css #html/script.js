$(document).ready(function() {
	$( ".menu > ul > li" ).hover(function() { 
		var self = this;
		window.setTimeout(function() {
			if( $(self).hasClass('hover-init') ) {
				$('.menu .hover').removeClass('hover');
				$(self).addClass('hover');
			}
		},1000);
		$(this).addClass('hover-init');
	}, function() {
		var self = this;
		window.setTimeout(function() {
			if( $(self).hasClass('hover') && !$(self).hasClass('hover-init') ) { $(self).removeClass('hover'); }
		},1000);			
		$(this).removeClass('hover-init');
	});

});	