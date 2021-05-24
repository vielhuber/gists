// https://hammerjs.github.io/
new Hammer(document.querySelector('.foo')).on('swipeleft swiperight', (ev) => {
  console.log(ev.type);
});

// https://github.com/mattbryson/TouchSwipe-Jquery-Plugin
$('.foo').swipe({
  swipeLeft:function(event, direction, distance, duration, fingerCount) { scrollSlideshow('right'); },
  swipeRight:function(event, direction, distance, duration, fingerCount) { scrollSlideshow('left'); },
  threshold:75
});