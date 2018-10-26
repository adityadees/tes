<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <title>Rectangle Events</title>
  <style>
      /* Always set the map height explicitly to define the size of the div
      * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    
    <form class="form-horizontal save-form" action="aaa.php" method="GET" >
      <h1>Add me!</h1>
      <fieldset>
        <div class="control-group">
          <label class="control-label" for="name">Name</label>
          <div class="controls">
            <input type="text" class="input-xlarge" name="name">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="category">What is this?</label>
          <div class="controls">
            <select name="category">
              <option value="asset">something I like</option>
              <option value="deficit">something I do not like</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="description">Description</label>
          <div class="controls">
            <textarea class="input-xlarge" name="description" rows="3"></textarea>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Save me</button>
        </div>
      </fieldset>
      <script>
      // This example adds a user-editable rectangle to the map.
      // When the user changes the bounds of the rectangle,
      // an info window pops up displaying the new bounds.

      var rectangle;
      var map;
      var infoWindow;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 44.5452, lng: -78.5389},
          zoom: 9
        });

        var bounds = {
          north: 44.599,
          south: 44.490,
          east: -78.443,
          west: -78.649
        };

        // Define the rectangle and set its editable property to true.
        rectangle = new google.maps.Rectangle({
          bounds: bounds,
          editable: true,
          draggable: true
        });

        rectangle.setMap(map);

        // Add an event listener on the rectangle.
        rectangle.addListener('bounds_changed', showNewRect);

        // Define an info window on the map.
        infoWindow = new google.maps.InfoWindow();
      }
      // Show the new coordinates for the rectangle in an info window.

      /** @this {google.maps.Rectangle} */
      function showNewRect(event) {
        var ne = rectangle.getBounds().getNorthEast();
        var sw = rectangle.getBounds().getSouthWest();
        var nelat=ne.lat();
        var nelng=ne.lng();
        var swlat=sw.lat();
        var swlng=sw.lng();
        var contentString = '<b>Simpan Lokasi ini?</b><br>' +
        '<form action=proses.php method=POST>' +
        '<input type=text name=nelat value=' + nelat + '>' +
        '<input type=text name=nelng value=' + nelng + '>' +
        '<input type=text name=swlat value=' + swlat + '>' +
        '<input type=text name=swlng value=' + swlng + '>' +
        '<textarea name=ket></textarea>' +
        '<input type=submit value=Submit>' +
        '</form>';

        // Set the info window's content and position.
        infoWindow.setContent(contentString);
        infoWindow.setPosition(ne);

        infoWindow.open(map);
      }
      
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogXD-AHrsmnWinZIyhRORJ84bgLwDPpg&callback=initMap">
  </script>
</body>
</form>
</html>