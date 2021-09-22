var column_max = 4;
var margin = 0.05;
var timeout = {};
var speed = 1000;
var speed_manual = 100;
var delay = 1000; 
var delay_manual = 5000;
$(document).ready(function() { sliderInit(); });
var windowWidth = $(window).width(); $(window).resize(function(){ if ($(window).width() != windowWidth) { windowWidth = $(window).width(); sliderSize(); } });
function sliderInit() {
	if( $('.slider').length > 0 ) {
		$('.slider').each(function() {
			var self = this;
			if( $(self).find('.item ul li').length <= column_max ) { return true; }
			// create timeouts
			var timeout_name = 'timeout_'+(~~(Math.random()*9999)+1000);
			$(self).attr('data-timeout',timeout_name);
			timeout[timeout_name] = null;
			// duplicate boxes for endless scrolling
			var clone_before = $(self).find('.item ul li').clone();
			var clone_after = $(self).find('.item ul li').clone();
			$(self).find('.item ul').append( clone_before );
			$(self).find('.item ul').prepend( clone_after );
			// arrows
			if($(self).children('.arrow').length == 0) {
				$(self).prepend('<div class="arrow"><ul><li class="left"><a href="#">links</a></li><li class="right"><a href="#">rechts</a></li></ul></div>');
			}
			// initial size
			sliderSize();
			// auto nav
			window.setTimeout(function(){
				sliderScroll( $(self), 'right', false );
			},delay);
			// manual nav
			$(self).find('.arrow li a').click(function() {
				if($(self).hasClass('disabled')) { return false; }
        var dir;
				if( $(this).parent('li').hasClass('right') ) { dir = 'right'; }
				if( $(this).parent('li').hasClass('left') ) { dir = 'left'; }
				sliderScroll($(self), dir, true);
				return false;
			});
			// pause on hover
			$(self).hover(function() {
				$(self).addClass('hover');
			}, function() {
				$(self).removeClass('hover');				
				var timeout_name = $(self).attr('data-timeout');
				if(typeof timeout[timeout_name] !== "undefined"){ clearTimeout(timeout[timeout_name]); }	
				timeout[timeout_name] = window.setTimeout(function(){
					sliderScroll( $(self), 'right', false );
				},delay);
			});
		});
	}
}
function sliderSize() {
	if( $('.slider').length > 0 ) {
		$('.slider').each(function() {
			var self = this;
			// reset styles
			$(self).find('.item ul').attr('style','');
			$(self).find('.item ul li').css({'width': 'auto','margin-right': '0px'});
			// if slider is not active
			if( $(self).find('.item ul li').length <= column_max ) {
				$(self).find('.item ul li').width(Math.floor($(self).width()/column_max));
				$(self).find('.item ul li').css({'float':'none','display':'inline-block'});
				return true;
			}
			// determine margins
			var col;
			if( $(window).width() > 1200 ) { col = column_max; }
			else if( $(window).width() > 1000 && column_max > 3 ) { col = 3; }
			else if( $(window).width() > 800 && column_max > 2 ) { col = 2; }
			else if( column_max > 1) { col = 1; }
			$(self).attr('data-col',col);
			$(self).attr('data-count',($(self).find('.item ul li').length/3));
			var width = (1-((col-1)*margin))/col; // margin in sum on one slide
			// set sizes
			$(self).find('.item ul').width(
				Math.ceil(
					$(self).width() * margin * $(self).find('.item ul li').length +
					$(self).width() * width * $(self).find('.item ul li').length
				)
			);
			$(self).find('.item ul li').each(function(i) {
				$(this).css({
					'width': ($(self).width() * width).toFixed(2)+'px',
					'margin-right': ($(self).width() * margin).toFixed(2)+'px'
				});
			});
			// reset slider to initial position
			resetSlider(self);
		});
	}
}
function resetSlider(slider) {
	// x position
	$(slider).find('.item ul').css({
		'left':((-1)*($(slider).attr('data-count')/$(slider).attr('data-col'))*( $(slider).width() + ($(slider).width() * margin)) )
	});
	// tag first/last item
	$(slider).find('.item ul li').removeAttr('class');
	$(slider).find('.item ul li:nth-child('+(parseInt($(slider).attr('data-count'))+1)+')').addClass('first');
	$(slider).find('.item ul li:nth-child('+(parseInt($(slider).attr('data-count'))+2+parseInt($(slider).attr('data-col')))+')').addClass('last');
}
function sliderScroll(slider, direction, manual) {
	// return on hover
	if( $(slider).hasClass('hover') && manual === false ) {
		return false;
	}
	// disable state
	$(slider).addClass('disabled');
	// reset position
	var index = $(slider).find('.item ul li.first').prevAll().length;
	if( index <= 0 || index >= $(slider).attr('data-count')*2) {
		resetSlider(slider);
	}
	// animate
	slider.find('.item ul').animate({
		'left': '+='+((direction == 'right')?(-1):(1))*slider.find('.item ul li').outerWidth(true)+'px'
	}, ((manual===true)?(speed_manual):(speed)), 'swing', function (){
		$(slider).removeClass('disabled');
		var timeout_name = $(slider).attr('data-timeout');
		if(typeof timeout[timeout_name] !== "undefined"){ clearTimeout(timeout[timeout_name]); }
		timeout[timeout_name] = window.setTimeout(function(){
			sliderScroll(slider, 'right',false);
		},((manual===false)?(delay):(delay_manual)));
	});
	// update tag
	if( direction == 'right' ) {
		$(slider).find('.item ul li.first').removeClass('first').next('li').addClass('first');
		$(slider).find('.item ul li.last').removeClass('last').next('li').addClass('last');
	}
	if( direction == 'left' ) {
		$(slider).find('.item ul li.first').removeClass('first').prev('li').addClass('first');
		$(slider).find('.item ul li.last').removeClass('last').prev('li').addClass('last');
	}
}