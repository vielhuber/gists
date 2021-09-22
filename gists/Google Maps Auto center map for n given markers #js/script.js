// variant 2
var markers = []; // array with markers inside
var bounds = new google.maps.LatLngBounds();
for (var i = 0; i < markers.length; i++) {
 bounds.extend(markers[i].getPosition());
}
map.fitBounds(bounds);
// min/max zoom
if(map.getZoom() > 15) { map.setZoom(15); }
if(map.getZoom() < 3) { map.setZoom(3); }


// variant 1 
var lat_min = lng_min = 999999999;
var lat_max = lng_max = 0;
$('ul.locations li').each(function() {
	if( $(this).attr('data-lat') > lat_max ) { lat_max = parseFloat( $(this).attr('data-lat') ); }
	if( $(this).attr('data-lat') < lat_min ) { lat_min = parseFloat( $(this).attr('data-lat') ); }
	if( $(this).attr('data-lng') > lng_max ) { lng_max = parseFloat( $(this).attr('data-lng') ); }
	if( $(this).attr('data-lng') < lng_min ) { lng_min = parseFloat( $(this).attr('data-lng') ); }
});
map.setCenter(new google.maps.LatLng(
  ((lat_max + lat_min) / 2.0),
  ((lng_max + lng_min) / 2.0)
));
map.fitBounds(new google.maps.LatLngBounds(
  new google.maps.LatLng(lat_min, lng_min),
  new google.maps.LatLng(lat_max, lng_max)
));