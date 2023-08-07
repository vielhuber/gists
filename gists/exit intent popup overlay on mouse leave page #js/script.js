$(document).ready(function()
{
        if( __cookie_get('popup_hide') == 'true' )
        {
            return;
        }

        $('body').prepend('\
            <div class="popup">\
                <div class="popup__inner">\
                    ...\
                    <a href="#" class="popup__close">Schließen</a>\
                </div>\
            </div>\
        ');

        $('body').mouseleave(function()
        {
            if( $('.popup--opened').length > 0 )
            {
                return;
            }
            $('.popup').addClass('popup--opened');
            $('.popup').fadeIn(100);
        });

        $('.popup__close').click(function()
        {
            $(this).closest('.popup').fadeOut(100, function()
            {
                $(this).remove();
            });
            __cookie_set('popup_hide','true',7);
            return false;
        });

});