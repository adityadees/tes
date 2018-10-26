<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <link type="text/css" rel="stylesheet" href="style.css" />
  <script type="text/javascript" src="../gmap3.js"></script>
<body>
<div id="map2" class="gmap3"></div>
<script>
  $(function () {
    var gmap, infowindow;


    // create an array of markers
    var markers = [];

    $('#maplinks a').each(function () {
      var $this = $(this);
      var htmltxt = $this.html();
      var position = {lat: parseFloat($this.data('lat')), lng: parseFloat($this.data('lon'))};
      var data = {
        position: position,
        id: $this.data('markerid'),
        data: htmltxt
      };

      $this.click(function () {
        if (infowindow && data.marker) {
          infowindow.setContent(htmltxt);
          gmap.setZoom(6);
          gmap.panTo(position);
          infowindow.open(gmap, data.marker);
        }
      });

      markers.push(data);
    });

    // create gmap3:
    $("#map2")
      .gmap3({center: [36.1128,-113.9961], zoom: 4})
      .then(function (_gmap) {
        gmap = _gmap;
      })
      .infowindow({
        content: ''
      })
      .then(function (iw) {
        infowindow = iw;
      })
      .cluster({
        size: 200,
        markers: markers,
        cb: function (markers) {
          if (markers.length > 1) { // 1 marker stay unchanged (because cb returns nothing)
            if (markers.length < 20) {
              return {
                content: "<div class='cluster cluster-1'>" + markers.length + "</div>",
                x: -26,
                y: -26
              };
            }
            if (markers.length < 50) {
              return {
                content: "<div class='cluster cluster-2'>" + markers.length + "</div>",
                x: -26,
                y: -26
              };
            }
            return {
              content: "<div class='cluster cluster-3'>" + markers.length + "</div>",
              x: -33,
              y: -33
            };
          }
        }
      })
    .then(function (cluster) {
      // complete global markers data with google maps marker
      $.each(cluster.markers(), function (_, marker) {
        $.each(markers, function (_, data) {
          if (data.id === marker.id) {
            data.marker = marker;
          }
        });
      })
    })
    .on('click', function (marker, clusterOverlay, cluster, event) {
      if (marker) {
        infowindow.setContent(marker.data);
        infowindow.open(marker.getMap(), marker);
      }
    });

  });
</script>
<div id="maplinks">
  <a href='#' data-lat='36.1128' data-lon='-113.9961' data-markerid="1">Location 1</a>
  <a href='#' data-lat='42.4280' data-lon='-110.5885' data-markerid="2">Location 2</a>
  <a href='#' data-lat='44.4280' data-lon='60.5985' data-markerid="3">Location 3</a>
  <a href='#' data-lat='13.4280' data-lon='44.5895' data-markerid="4">Location 4</a>
  <a href='#' data-lat='44.4280' data-lon='-13.5185' data-markerid="5">Location 5</a>
  <a href='#' data-lat='44.4280' data-lon='-89.5285' data-markerid="6">Location 6</a>
</div>
</body>
</html>