$('form').submit(function(e){
    $('input:checkbox:not(:checked)').not("input:checkbox[name$='[]']").each(function() {
        if( $(this).prev('input[type="hidden"][value="0"]').length === 0 ) {
            $(this).before('<input type="hidden" value="0" name="'+$(this).attr('name')+'" />');
        }
    });
    $("input:checkbox[name$='[]']").each(function() {
        if( $(document).find('input:checkbox[name="'+$(this).attr('name')+'"]:checked').length === 0 ) {
            if( $(document).find("input[type='hidden'][name='"+$(this).attr('name')+"']").length === 0 ) {
                $(this).before('<input type="hidden" value="" name="'+$(this).attr('name')+'" />');
            }
        }
    });
});