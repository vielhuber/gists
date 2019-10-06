/* html5 required="required" does not work here */
/* instead we use this jquery solution */
$('.container').find('input[type="checkbox"]').change(function()
{
  if( $('input[type="checkbox"][name="'+$(this).attr('name')+'"]:checked').length === 0 )
  {
    $('input[type="checkbox"][name="'+$(this).attr('name')+'"]').first().attr('required','required');
  }
  else
  {
    $('input[type="checkbox"][name="'+$(this).attr('name')+'"]').removeAttr('required');
  }
});