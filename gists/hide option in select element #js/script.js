/* hiding option elements with $('option').hide() does not work with IE, instead use this strategy */
var og = $('select').html();
$('select').change(function() {
    $('select').html(og);
    $('select option[myfilter=1]').remove();
});