<!-- use here a client side api key --> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=***REMOVED***"></script>
<script type="text/javascript">
<!--
$(document).ready(function() {
    var geocoder;
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': 'Baumannstraße 23, 94036 Passau' }, function(results, status) {                               
        var lat = lng = null;
        if (status == google.maps.GeocoderStatus.OK) {
            lat = results[0].geometry.location.lat();
            lng = results[0].geometry.location.lng();
        }
        console.log(lat+" "+lng);
    });   
});
-->
</script>