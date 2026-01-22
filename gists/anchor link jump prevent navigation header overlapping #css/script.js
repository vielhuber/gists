/* if you need edge support, use this instead */
    $(window).on('hashchange load', function()
    {
        var $anchor = $(':target'),
            fixedElementHeight = $('.site-navigation').height()+20;
        if ($anchor.length > 0)
        {
            $('html, body')
                .stop()
                .animate({
                    scrollTop: $anchor.offset().top - fixedElementHeight
                }, 200);
        }    
    });
