$(document).ready(function() {
	if($('.parallax').length > 0) {
		$('.parallax').each(function(i) {
			var self = this;
			adjustSize(self);
			$(window).resize(function () {
				adjustSize(self);
			});
			adjustParallax(self);
			$(window).scroll(function () {
				adjustParallax(self);				
			});
		});
	}
});
function adjustSize(self) {
  
  // header offset
  var header_offset = 0;
  if( !$('#toggle_menu').is(':visible') ) { header_offset = $('#header').outerHeight(true); }

	// first determine min dimensions of image
	var width_min = $(window).width();
	var height_min = $(self).outerHeight(true) + ($(window).height()-header_offset-$(self).outerHeight(true))*$(self).attr('data-speed');

	// determine ratios
	var ratio_image = $(self).attr('data-ratio');
	var ratio_screen = width_min/height_min;

	// set dimensions
	var width, height, left, top;
	if( ratio_image > ratio_screen ) {
		height = height_min;
		width = height * ratio_image;
		left = ((width_min-width)/2);
		top = 0;
	}
	else {
		width = width_min;
		height = width * (1/ratio_image);
		top = ((height_min-height)/2);
		left = 0;
	}
	$(self).find('.i').css({
		width: width,
		height: height,
		top: top,
		left: left
	});

	// save for usage below
	$(self).attr('data-height', $(self).outerHeight(true));
	$(self).attr('data-img-height', $(self).find('.i').height());


}
function adjustParallax(self) {
	var s_t = $(window).scrollTop();
	var w_h = $(window).height();
	var w_b = s_t+w_h;
	var p_t = $(self).offset().top;
	var p_h = parseFloat($(self).attr('data-height'));
	var i_h = parseFloat($(self).attr('data-img-height'));
	
  // header offset
  var h_h = 0;
  if( !$('#toggle_menu').is(':visible') ) { h_h = $('#header').outerHeight(true); }

	// return if above or below viewport
	if( w_b < p_t || p_t+p_h-h_h < s_t ) { return; }

	var top = (-1)*(p_t-s_t)*$(self).attr('data-speed');

	$(self).find('.i').css({
		'-webkit-transform': 'translate3d(0px, '+top+'px, 0px)',
		'-moz-transform': 'translate3d(0px, '+top+'px, 0px)',
		'-o-transform': 'translate3d(0px, '+top+'px, 0px)',
		'-ms-transform': 'translate3d(0px, '+top+'px, 0px)',
		'transform': 'translate3d(0px, '+top+'px, 0px)'		
	});
}