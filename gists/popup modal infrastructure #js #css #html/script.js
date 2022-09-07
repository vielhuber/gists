$(document).ready(function() {
    // on change hash (also when pressing back button)
    $(window).on('hashchange', function() {
        if( window.location.hash ) {
            loadPopup( window.location.hash );
        }
        else {
            unloadPopup();
        }
    });
    // init
    if( window.location.hash ) {
        loadPopup( window.location.hash );
    }
    // open
    $('a[data-popup]').click(function() {
        window.location.hash = $(this).attr('href').replace('#','');
        return false;
    });     
    // close
    $('html').on('click','body.popup_active, .popup_container .close', function(event) {
    if(!$(event.target).closest('.popup_container .vcenter').length || $(event.target).hasClass('close')) {
        if (history.pushState) { window.history.replaceState({}, '', (window.location.protocol+"//"+window.location.hostname+window.location.pathname) ); }
        unloadPopup();
        return false;
    } 
    });
 });
 function unloadPopup() {
     $('.popup_container').fadeOut(100, function() {
         $('body').removeClass('popup_active');
         $('body .popup_container').remove();
     });
     return false;
 }
 function loadPopup(hash) {
    if( $('a[data-popup][href="'+hash+'"]').length === 0 ) { return false; }
    var type = $('a[data-popup][href="'+hash+'"]').attr('data-popup');
    $('body').addClass('popup_active');
    if( $('body > .popup_container').length == 0 ) { $('body').append('<div class="popup_container"><div class="vcenter"><a href="#" class="close">X</a><div class="content '+type+' '+hash.replace("#","")+'"></div></div></div>'); }

    if( type == 'inline' ) {
        $('.popup_container .vcenter .content').append( $('.popup-inline.'+hash.replace("#","")).html() );
    }
    if( type == 'iframe' ) {
        $('.popup_container .vcenter .content').append('<iframe src="'+$('a[data-popup][href="'+hash+'"]').attr('data-target')+'"></iframe>');
    }
    if( type == 'ajax' ) {
        $.ajax({
            method: "GET",
            dataType: "html",
            url: $('a[data-popup][href="'+hash+'"]').attr('data-target')
        }).done(function(result) {
            $('.popup_container .vcenter .content').append( result );
        });
    }

    $('.popup_container').fadeIn(100);
 }