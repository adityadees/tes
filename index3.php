<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<title>Tutorial: Adding points to the map and saving them in a database</title>
	<style type="text/css">
		html { height: 100% }
		body { height: 100%; margin: 0px; padding: 0px }
		#map_canvas { height: 100% }
		/* bootstrap fix */
		#map_canvas img {
			max-width: none;
		}
	</style> 

<!-- Google Maps and Places and Drawing API -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAogXD-AHrsmnWinZIyhRORJ84bgLwDPpg&libraries=places,drawing&sensor=false"></script>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<!-- bootstrap -->
<link rel="stylesheet" type="text/css" href="http://www.yohman.com/students/yoh/bootstrap/css/bootstrap.min.css" />
<script src="http://www.yohman.com/students/yoh/bootstrap/js/bootstrap.min.js"></script>

<!-- ArcGIS -->
<script type="text/javascript" src="http://www.yohman.com/scripts/arcgislink.js"></script>

<script type="text/javascript">
//declare namespace
var up206b = {};

//declare map
var map;

//set the drawing manager
var drawingManager;

function trace(message)
{
	if (typeof console != 'undefined')
	{
		console.log(message);
	}
}

//Function that gets run when the document loads
up206b.initialize = function()
{
	var latlng = new google.maps.LatLng(34.070264, -118.4440562);
	var myOptions = {
		zoom: 12,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false //disable the map type control
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	//add the drawing tool that allows users to draw points on the map
    drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.MARKER,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [google.maps.drawing.OverlayType.MARKER]
        },
        markerOptions: {
            // icon: new google.maps.MarkerImage('bus.png'),
            draggable: true
        }
    });

    //add the tools to the map
    drawingManager.setMap(map);
    
	//event listener that does the following after user draws point on the map
	google.maps.event.addListener(drawingManager, 'overlaycomplete', function (point) 
	{
		//"clone" the save-form to put in the infowindow
		var form =	$(".save-form").clone().show();
		var infowindow_content = form[0];
		var infowindow = new google.maps.InfoWindow({
			content: infowindow_content
		});
	
		//make each marker clickable
		google.maps.event.addListener(point.overlay, 'click', function() {
			infowindow.open(map,point.overlay);
		});
		
		//open infowindow by default
		infowindow.open(map,point.overlay);
		
		//when user clicks on the "submit" button
		form.submit({point: point}, function (event) {
			//prevent the default form behavior (which would refresh the page)
			event.preventDefault();
			
			//put all form elements in a "data" object
			var data = {
				name: $("input[name=name]", this).val(),
				description: $("textarea[name=description]", this).val(),
				category: $("select[name=category]",this).val(),
				lat: event.data.point.overlay.getPosition().lat(),
				lon: event.data.point.overlay.getPosition().lng()
			};
			trace(data)
			
			//send the results to the PHP script that adds the point to the database
			$.post("adddata.php", data, up206b.saveStopResponse, "json");

			//Erase the form and replace with new message
			infowindow.setContent('done')
			return false;
		});
	});
up206b.saveStopResponse = function (data) {
	if (typeof data.error != "undefined")
	{
		alert(data.error);
	}
	else 
	{
		alert(data.message);
	}
}
}

</script>
</head>
<body onload="up206b.initialize()">
	<!-- side panel div container -->
	<div style="position:absolute; width:380px; height: 100%; overflow:auto; float:left; padding-left:10px; padding-right:10px;"> 

		<div class="hero-unit">
			<h1>UP206B</h1>
			<p>Adding points to the map and saving them in a database</p>
		</div>

<!--
            This is the form that will show up in the infowindow for
            each marker created.  The display is set to "none" by default
        -->
        <form class="form-horizontal save-form" style="display: none">
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
        </form>


	</div>
	<!-- map div container -->
	<div id="map_canvas" style="height:100%; margin-left:400px;"></div>
</body>
</html>