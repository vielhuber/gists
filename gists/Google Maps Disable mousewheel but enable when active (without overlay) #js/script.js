var map = new google.maps.Map(document.getElementById('gmaps'), {
    //...
    scrollwheel: false
});

map.addListener('click', function() { map.setOptions({ scrollwheel: true }); });
map.addListener('drag', function() { map.setOptions({ scrollwheel: true }); });
map.addListener('mouseout', function() { map.setOptions({ scrollwheel: false }); });