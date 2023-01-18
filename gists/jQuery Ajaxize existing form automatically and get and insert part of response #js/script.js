let $form = $('#form'),
    attr = {};
attr.type = $form.attr('method');
if($form.is('[action]')) { attr.url = $form.attr('action'); }

// without multipart data
attr.data = $form.serialize();

// with multipart data
attr.data = new FormData($form.get(0));
attr.cache = false;
attr.contentType = false;
attr.processData = false;

$.ajax(attr).done(function(data)
{
   $('.outer').html( $(data).filter('.inner') ); 
   $('.content').html( $('.content',data).html() );
   $('.content').html( $('.content',data)[0].outerHTML );
   // $('body',data) and $('body',data) are undefined, use this instead to get e.g. the class
   new DOMParser().parseFromString(data, 'text/html').documentElement.getAttribute('class');
   new DOMParser().parseFromString(data, 'text/html').body.getAttribute('class');
});