var column_max = 4;
var margin = 0.05;
var mode = 'one'; // one col per scroll
$(window).resize(function() { sliderSize(); });
$(document).ready(function() { sliderSize(); });
function sliderSize() {
    if( $('.slider').length > 0 ) {
        $('.slider').each(function() {

            // reset styles
            $(this).find('.item ul').attr('style','');
            $(this).find('.item ul li').css({'width': 'auto','margin-right': '0px'});

            var col;
            if( $(window).width() > 1200 ) { col = column_max; }
            else if( $(window).width() > 1000 && column_max > 3 ) { col = 3; }
            else if( $(window).width() > 800 && column_max > 2 ) { col = 2; }
            else if( column_max > 1) { col = 1; }
            $(this).attr('data-col',col);

            var width = (1-((col-1)*margin))/col; // margin in sum on one slide

            $(this).find('.item ul').width(
                Math.ceil(
                    $(this).width() * margin * ($(this).find('.item ul li').length-1) +
                    $(this).width() * width * $(this).find('.item ul li').length
                )
            );

            $(this).find('.item ul li').css({
	                'width': (Math.floor(($(this).width() * width)*100)/100).toFixed(2)+'px',
	                'margin-right': (Math.floor(($(this).width() * banner_slider_margin)*100)/100).toFixed(2)+'px'
            });
            $(this).find('.item ul li:last-child').css('margin-right','0');

            // arrows
            if($(this).children('.arrow').length == 0) {
                $(this).prepend('<div class="arrow"><ul><li class="left"><a href="#">links</a></li><li class="right"><a href="#">rechts</a></li></ul></div>');
            }
            // disable active state
            $(this).find('.arrow .left').addClass('disabled');
            if( col >= $(this).find('.item ul li').length ) {
                $(this).find('.arrow .right').addClass('disabled');
            }
            else {
                $(this).find('.arrow .right').removeClass('disabled');
            }

            // bubbles 
            if($(this).find('.nav').length == 0) {
                $(this).prepend('<div class="nav"><ul></ul></div>');
            }
            else {
                $(this).find('.nav ul li').remove();
            }
            var bubbles_max;
            if( mode == 'all' ) {
              bubbles_max = Math.ceil($(this).find('.item ul li').length/col);
            }
            if( mode == 'one' ) {
              bubbles_max = ($(this).find('.item ul li').length-col+1);
            }
            for(var i = 1; i <= bubbles_max; i++) {
                $('<li class="'+((i==1)?("active"):(""))+'"><a href="#">'+i+'</a></li>').appendTo($(this).find('.nav ul'));
            }

        });
    }
}
function sliderScrollTo(slider, index) {

    // if bad index
    var cur = slider.find('.nav li.active').prevAll('li').length;
    if(cur == index) { return false; }
    if(index > slider.find('.nav ul li').length-1 ) { return false; }
    if(index < 0) { return false; }

    // state of nav
    slider.find('.nav li.active').removeClass('active');
    slider.find('.nav li:nth-child('+(index+1)+')').addClass('active');

    // state of arrow
    if( index <= 0 && !slider.find('.arrow .left').hasClass('disabled') ) { slider.find('.arrow .left').addClass('disabled'); }
    if( index > 0 && slider.find('.arrow .left').hasClass('disabled') ) { slider.find('.arrow .left').removeClass('disabled'); }
    if( index >= (slider.find('.nav ul li').length-1) && !slider.find('.arrow .right').hasClass('disabled') ) { slider.find('.arrow .right').addClass('disabled'); }
    if( index < (slider.find('.nav ul li').length-1) && slider.find('.arrow .right').hasClass('disabled') ) { slider.find('.arrow .right').removeClass('disabled'); }

    // animate
    var left;
    if( mode == 'all' ) {
      left = (-1)*slider.find('.item ul li').outerWidth(true)*slider.attr('data-col')*index+'px';
    }
    if( mode == 'one' ) {
      left = (-1)*slider.find('.item ul li').outerWidth(true)*index+'px';
    }
    slider.find('.item ul').animate({
        'left': left
    }, 250, 'swing', function (){
    });

}
$(document).ready(function() {
    $('.slider').on('click','.nav li a',function() {
        var index = $(this).closest('li').prevAll('li').length;
        sliderScrollTo($(this).closest('.slider'), index);
        return false;
    });
    $('.slider').on('click','.arrow li a',function() {
        var index = $(this).closest('.slider').find('.nav li.active').prevAll('li').length;
        if( $(this).parent('li').hasClass('right') ) { index++; }
        if( $(this).parent('li').hasClass('left') ) { index--; }
        sliderScrollTo($(this).closest('.slider'), index);
        return false;
    });
});