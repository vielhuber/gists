$(document).ready(function() {
  $('#scrolldown').click(function() {
    $("html").velocity("scroll", { mobileHA: false, duration: 500, easing: "easeInOutQuart", offset: $(window).height() });
    return false;
  });
});