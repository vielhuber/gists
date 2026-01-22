$(document).ready(function() {
    $('#navigation > li').hover(
        function() {
            if( isTouchDevice() ) { return; }
            $(this).addClass('hover');
        }, function() {
            if( isTouchDevice() ) { return; }
            $(this).removeClass('hover');
        }
    );
    $('#navigation > li').click(function() {
        if( !isTouchDevice() ) { return; }
        $(this).siblings('li').removeClass('hover');
        if( $(this).children('ul').length === 0 ) { return; }
        if( !$(this).hasClass('hover') ) {
            $(this).addClass('hover');
            return false;
        }
    });
});
function isTouchDevice() {
  // if modernizr is available
  return $('html').hasClass('touch');
  // if not use vanilla js
  return 'ontouchstart' in window || navigator.maxTouchPoints;
}