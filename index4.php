<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogXD-AHrsmnWinZIyhRORJ84bgLwDPpg&callback"></script>
<style>
html {
  height: 100%;
}
body {
  height: 100%;
  margin: 0, padding: 0;
}
#map-container {
  border: 2px solid red;
  height: 95%;
  width: 95%;
}
</style>
<div id='map-container'></div>

<script>
function initialize() {
  var infoWindow = null,
    rectangle = null,
    bounds, map,
    mapOptions = {
      center: new google.maps.LatLng(38.822270, -77.061024),
      mapTypeId: google.maps.MapTypeId.TERRAIN,
      zoom: 13
    };
  map = new google.maps.Map(document.getElementById('map-container'), mapOptions);

  google.maps.event.addListener(map, 'click', function(event) {
    var ne_lat = event.latLng.lat() + 0.005,
      ne_lng = event.latLng.lng() + 0.01,
      sw_lat = event.latLng.lat() - 0.005,
      sw_lng = event.latLng.lng() - 0.01;
    bounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(sw_lat, sw_lng),
      new google.maps.LatLng(ne_lat, ne_lng)
    );
    rectangle = new google.maps.Rectangle({
      bounds: bounds,
      editable: true,
      draggable: true
    });
    rectangle.setMap(map);
    infoWindow = new google.maps.InfoWindow();
    createClickablePoly(rectangle, "hello world", map);

  });
}

function createClickablePoly(poly, html, map) {
  var contentString = html;
  var infoWindow = new google.maps.InfoWindow();
  google.maps.event.addListener(poly, 'click', function(event) {
    infoWindow.setContent(contentString);
    infoWindow.setPosition(event.latLng);
    infoWindow.open(map);
  });
}
$(document).ready(function() {
  initialize();
});
</script>