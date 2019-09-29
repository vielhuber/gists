$(document).ready(function() {
    if( $('.accordion').length > 0 ) {
        $('.accordion').each(function() {
            var self = this;
            $.each(['h1','h2','h3','h4','h4','h5','h6'], function(index, selector) {
                $(self).find(selector).each(function() {
                    $(this).nextUntil(selector).wrapAll('<div class="accordion__content"></div>');
                    $(this).next('.accordion__content').addBack().wrapAll('<div class="accordion__item"></div>');
                    $(this).replaceWith('<a class="accordion__link" href="#">'+$(this).html()+'</a>');
                });
            });
            $('.accordion .accordion__link').click(function() {
            	if( !$(this).parent('.accordion__item').hasClass('accordion__item--active') ) {
            		$(this).parent('.accordion__item').siblings('.accordion__item--active').each(function() {
            			accordionItemClose( $(this) );
            		});
            		accordionItemOpen( $(this) );
            	}
            	else {
            		accordionItemClose($(this).parent('.accordion__item'));
            	}
            	return false;
            });
            function accordionItemClose(item) {
        		$(item).siblings('.accordion__item--active').addBack().find('.accordion__content').slideUp();                		
        		$(item).siblings('.accordion__item--active').addBack().find('.accordion__item--active').removeClass('accordion__item--active');
            	$(item).removeClass('accordion__item--active');
            	$(item).children('.accordion__content').slideUp();
            }
            function accordionItemOpen(item) {
        		$(item).parent('.accordion__item').addClass('accordion__item--active');
        		$(item).next('.accordion__content').slideDown();
            }
        });
    }
});