document.addEventListener('DOMContentLoaded', () =>
{
  if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD)
  {
    if( window.location.href.indexOf('some-custom-url') > -1 )
    {
    	location.reload(true);
    }
  }
});