$('.slideshow').swipe({
  swipeLeft:function(event, direction, distance, duration, fingerCount) { scrollSlideshow('right'); },
  swipeRight:function(event, direction, distance, duration, fingerCount) { scrollSlideshow('left'); },
  threshold:75
});