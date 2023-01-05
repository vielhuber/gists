$(document).ready(function()
{
  /* example #1 */
  if( $('.example-1').length > 0 )
  {
    if( window.location.search !== null && window.location.search.indexOf('ab_test=b') > -1 )
    {
      // move around stuff etc.
      $('.example-1').appendTo( $('.container') );
    }
  }
});