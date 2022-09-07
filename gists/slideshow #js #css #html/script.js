// build up config for each slider
var slideshow_config = {};
$(document).ready(function() {
	if( $('.slideshow').length > 0 ) {
		$('.slideshow').each(function(i) {
			var id = i+1;
			$(this).attr('data-id',id);
	    		slideshow_config[id] = {
				    timeout: null,
				    speed: parseInt($(this).attr('data-speed')),
				    speed_manual: parseInt($(this).attr('data-speed-manual')),
				    delay: parseInt($(this).attr('data-delay')),
				    delay_init: parseInt($(this).attr('data-delay-init')),
				    animation: $(this).attr('data-animation'),
				    easing: $(this).attr('data-easing')
	    		}
    		});
	}
});

// set size
var windowWidth = $(window).width(); $(window).resize(function(){ if ($(window).width() != windowWidth) { windowWidth = $(window).width(); sliderSize(); } });
$(document).ready(function() { sliderSize(); });
function sliderSize() {
	if( $('.slideshow').length > 0 ) {
		$('.slideshow').each(function() {
			$(this).width( $(window).width()/2 );
			$(this).height( $(window).height()/2 );
		});
	}
}

// init slider
$(document).ready(function() {
if( $('.slideshow').length > 0 ) {
	$('.slideshow').each(function() {
		initSlideshow(this);
	}); 
}
});

function initSlideshow(self) {

    // cancel if only 1 image is there
    if($(self).find('ul li').length <= 1 ) { return false; }

	// nav
	$(self).append('<div class="nav"></div>');
	$(self).find('ul li').each(function(i) {
	    $(self).find('.nav').append('<a href="#">'+(i+1)+'</a>');
	});
	$(self).find('.nav').addClass('count_'+$(self).find('.nav a').length); // for css positioning
	$(self).find('.nav a:first-child').addClass('active');
	// next/prev
	$(self).prepend('<div class="arrow"><a class="left" href="#">links</a><a class="right" href="#">rechts</a></div>');
	$(self).find('.arrow .left').addClass('disabled');
	// revert items
	$(self).find('ul').append($(self).find('ul li').get().reverse());
	// enumerate
	var num = $(self).find('ul li').length;
	$(self).find('ul li').each(function() {
	    $(this).addClass('num_'+num);
	    if(num == 1) { $(this).addClass('active'); }
	    num--;
	});
	// start
	window.setTimeout(function(){
	    startSlideshow(self,2,false);
	},slideshow_config[$(self).attr('data-id')].delay_init);
	// bubble nav
	$(self).find('.nav a').click(function() {           
	    if($(this).hasClass('disabled')) { return false; }
	    $(self).addClass('manual');
	    startSlideshow( self, $(this).prevAll('a').length+1, 'bubble' );
	    return false;
	});
	// arrow nav
	$(self).find('.arrow a').click(function() {           
	    if($(this).hasClass('disabled')) { return false; }
	    $(self).addClass('manual');
	    var i = $(self).find('.nav a.active').prevAll('a').length+1;
	    if( $(this).hasClass('right') ) { i++; }
	    if( $(this).hasClass('left') ) { i--; }
	    startSlideshow(self, i, ($(this).hasClass('right')?('right'):('left')) );
	    return false;
	});
}

function startSlideshow(s,n,m) {  

    var self = s;
    if(typeof slideshow_config[$(self).attr('data-id')].timeout !== "undefined"){ clearTimeout(slideshow_config[$(self).attr('data-id')].timeout); }

	var cur = $(self).find('.nav a.active').prevAll('a').length+1;  
	if( cur == n ) { return false; }
	
	$(self).find('.nav a').addClass('disabled');
	$(self).find('.nav a.active').removeClass('active');
	$(self).find('.nav a:nth-child('+n+')').addClass('active');
	
	if( $(self).find('.nav a:last-child').hasClass('active') ) { $(self).find('.arrow .right').addClass('disabled'); }
	else { $(self).find('.arrow .right').removeClass('disabled'); }
	if( $(self).find('.nav a:first-child').hasClass('active') ) { $(self).find('.arrow .left').addClass('disabled'); }
	else { $(self).find('.arrow .left').removeClass('disabled'); }
	
	$(self).find('ul li.num_'+n).insertBefore( $(self).find('ul li.num_'+cur) );
	$(self).find('ul li.num_'+n).show();

	// after a manual call, stop automatic call (for 1x)
	if( $(self).hasClass('manual') && m === false ) { $(self).removeClass('manual'); return false; }

	$(self).find('ul li.num_'+cur).fadeOut(((m===false)?(slideshow_config[$(self).attr('data-id')].speed):(slideshow_config[$(self).attr('data-id')].speed_manual)), function() {
	    $(self).find('ul li.num_'+cur).prependTo($(self).find('ul')).hide();
	    $(self).find('.nav a').removeClass('disabled');
	    slideshow_config[$(self).attr('data-id')].timeout = window.setTimeout(function(){
				if( $(self).hasClass('manual') && m === false ) { $(self).removeClass('manual'); return false; }
				else { $(self).removeClass('manual'); }
	        n = $(self).find('.nav a.active').prevAll('a').length+2;
	        n = ((n-1) % $(self).find('ul li').length)+1;
	        startSlideshow(s,n,false);
	    },slideshow_config[$(self).attr('data-id')].delay);
	});         
}
