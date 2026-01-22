$(document).ready(function() {	
	$('.navigation-main .navigation--entry').off();
	$('.navigation-main .navigation--entry').click(function() {
		if( $(this).hasClass('is--hovered') ) {
			$(this).removeClass('is--hovered');
			$('.advanced-menu .menu--is-active').removeClass('menu--is-active');
			return false;
		}
		else {
			$(this).siblings('.is--hovered').removeClass('is--hovered');
			$(this).addClass('is--hovered');
			$('.advanced-menu .menu--is-active').removeClass('menu--is-active');
			if( $('.advanced-menu .menu--container:nth-child('+$(this).prevAll('li').length+') .has--content').length > 0 ) {			
				$('.advanced-menu .menu--container:nth-child('+$(this).prevAll('li').length+')').addClass('menu--is-active');
				$('.advanced-menu').show();
				return false;
			}
		}
	});
	$('.navigation-main').on('mouseleave',function() {
		$('.advanced-menu .menu--is-active').removeClass('menu--is-active');
	});
});