$("input[type='radio']:checked").attr('prev','checked');
$("input[type='radio']").click(function() {
    if ($(this).attr('prev') == 'checked') {
        $(this).removeAttr('checked');
        $(this).attr('prev', false);
    }
    else {
        $("input[name="+$(this).attr('name')+"]:radio").attr('prev', false);
        $(this).attr('prev', 'checked');
    }
});