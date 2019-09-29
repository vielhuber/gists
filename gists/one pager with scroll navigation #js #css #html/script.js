/* navigation */
function jumpToHash(hash, speed) {
    if( hash == 'top' ) {
        $("html").velocity("scroll", { mobileHA: false, duration: 500, easing: "easeInOutQuart", offset: 0 });
    }
    else if ( $('#content .box[data-section="'+hash+'"]').length > 0 ) {         
        var scrollTop = $('.box[data-section="'+hash+'"]').offset().top - $('#menu').outerHeight(true);         
        if( scrollTop > $(document).height()-$(window).height() ) { scrollTop = $(document).height()-$(window).height(); }
        
        // if elem is less height than window
	if( $('#content .box[data-section="'+hash+'"]').outerHeight(true) < ($(window).height() - $('#menu').outerHeight(true)) ) {
		scrollTop -= (($(window).height() - $('#menu').outerHeight(true) - $('#container .box[data-section="'+hash+'"]').outerHeight(true) ) / 2);
	}
        
        $("html").velocity("scroll", { mobileHA: false, duration: speed, easing: "easeInOutQuart", offset: scrollTop });
    }
}
$(document).ready(function() {
    $('#menu ul li a:not([target="_blank"])').bind("click", function(event) {
        var hash = $(this).attr("href").split("#")[1]; 
        if( hash == 'top' || $('#content .box[data-section="'+hash+'"]').length > 0 ) {
	        jumpToHash(hash, 1500);
	        return false;
	    }
    });
});

// initial jump to correct hash
var init_jump = false;
$(window).load(function() {
	if(window.location.hash) {
		jumpToHash(window.location.hash.replace("#",""),0);
	}
	init_jump = true;
});  

// refresh hash and state
$(window).scroll(nav_update);
$(window).load(nav_update);
var current = 0;
function nav_update() {
    if( init_jump === false ) { return false; }
    current = null;
    $('#content .box').each(function(i) {
        // top of item
        var v1 = $(this).offset().top;
        // mid scroll position
        var v2 = $(window).scrollTop()+($(window).height()/2);
        if( $(this).next('.box').length > 0 ) {
            // top of next item
            var v3 = $(this).next('.box').offset().top;
            if( v2 < v1 ) {
                current = 0;
                return false;
            }
            else if( v2-v1 > 0 && v3-v2 > 0 ) {
                current = parseInt(i)+1;
                return false;
            }
        }
        else {
            current = parseInt(i)+1;
        }
    });
    $('#menu ul li a.active').removeClass('active');
    // if first module, reset url (remove hash)
    if( current === 1 ) {
        if (history.pushState) { window.history.replaceState({}, '', (window.location.protocol+"//"+window.location.hostname+window.location.pathname) ); }
        $('#menu ul li a[href$="#top"]').addClass('active');
    }
    else if( current !== null ) {
        var hash = $('#content .box:nth-child('+current+')').attr('data-section');
        location.hash = hash;
        $('#menu ul li a[href$="#'+hash+'"]').addClass('active');
    }
}