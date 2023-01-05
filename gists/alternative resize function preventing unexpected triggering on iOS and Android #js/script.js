// this function has problems with android and iphone/ipad scrolling (because address bar hiding leads to change of height and unexpected triggering of function
$(window).resize(function() { yourFunction(); });

// better resize function (does only recognize change of width)
var windowWidth = $(window).width(); $(window).resize(function(){ if ($(window).width() != windowWidth) { windowWidth = $(window).width(); yourFunction(); } });

// helper function
function onResizeHorizontal(fun)
{
  var windowWidth = window.innerWidth;
  window.addEventListener('resize', () =>
                          {
    var windowWidthNew = window.innerWidth;
    if(windowWidthNew != windowWidth)
    {
      windowWidth = windowWidthNew;
      fun();
    }
  });
}