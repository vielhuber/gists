$(document).ready(function() {
    $('.ripple').each(function() {
        var self = $(this);
        if(self.find(".ripple_txt").length == 0) {
            self.html("<sub class='ripple_txt'>"+$(self).html()+"</sub>");
                if( self.css('background-image').indexOf('url') > -1 ) {
                  $.each(["background-color","background-image","background-repeat","background-position","background-size"], function(index, item) {
                    if( self.css(item) !== undefined ) {
                      self.find('.ripple_txt').css(item,self.css(item));
                    }
                  });
                	self.find('.ripple_txt').css({
                		'width':'100%',
                		'height':'100%',
                		'background-color':'transparent',
                		'display':'block'
                	});
                	self.css('background-image','none');
                }
        }
        if(self.find(".ripple_bubble").length == 0) {
            self.prepend("<sub class='ripple_bubble'></sub>");
        }
    });
    $('.ripple').click(function(e) {
        var self = $(this);
        var ripple_bubble = self.find('.ripple_bubble');
        // double click: stop prev animation
        ripple_bubble.removeClass("animate");
        // size
        if(!ripple_bubble.height() && !ripple_bubble.width()) {
            var d = Math.max(self.outerWidth(), self.outerHeight());
            ripple_bubble.css({height: d, width: d});
        }
        // position
        var x = e.pageX - self.offset().left - (ripple_bubble.width()/2);
        var y = e.pageY - self.offset().top - (ripple_bubble.height()/2);
        ripple_bubble.css({top: y+'px', left: x+'px'}).addClass("animate");
        // reset (set time to css transition time)
        window.setTimeout(function() { ripple_bubble.removeClass('animate'); }, 650);
    });
}); 