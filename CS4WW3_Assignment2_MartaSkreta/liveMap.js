	//Initializing location of center of map
	var myLatLng = {lat: 43.2635, lng: -79.9180};

	//Initializing library locations array
	var locations = [
	['Health Sciences Library', 43.2602, -79.9183],
	['Thode Library', 43.2611, -79.9225],
	['Mills Library', 43.2627, -79.9177],
	];
	var markers = []; //initialize array which will be used for closing windows

	//Initializing array of content to go in marker info boxes
	var content = [

	`<h2 class="library_name"><a href="sample/">Health Sciences Library</a></h2>
	<div id="bodyContent">
	<p><b>1280 Main St. W.</b></p>
	<p>Mon-Thurs 8:45am-10:45pm
	<br>Fri 8:45am-9:45pm
	<br>Sat 10am-5:45pm
	<br>Sun 8:45am-10:45pm</p>
	</div>`,


	`<h2 class="library_name">Thode Library</h2>
	<div id="bodyContent">
	<p><b>1280 Main St. W.</b></p>
	<p>Mon-Thurs 8:45am-10:45pm
	<br>Fri 8:45am-9:45pm
	<br>Sat 10am-5:45pm
	<br>Sun 8:45am-10:45pm</p>
	</div>`,

	`<h2 class="library_name">Mills Library</h2>
	<div id="bodyContent">
	<p><b>1280 Main St. W.</b></p>
	<p>Mon-Thurs 8:45am-10:45pm
	<br>Fri 8:45am-9:45pm
	<br>Sat 10am-5:45pm
	<br>Sun 8:45am-10:45pm</p>
	</div>`

	]

	function initMap() {
		//Instance new map object using Google Maps API; map is centered at myLatLng
		var map = new google.maps.Map(document.getElementById('map'), {
			center: myLatLng,
			zoom: 15
		});
		//Call setMarkers() function with map as input
		setMarkers(map);

	}

	function setMarkers(map){
		//for each item in locations array
		for(i = 0; i < locations.length; i++){
			//create new info window with contect from content array
			var infoWindow = new google.maps.InfoWindow({
				content: content[i],
				maxWidth: 200
			});
			//create new marker on map objext with locations from locations aray
			var marker = new google.maps.Marker({
				position: {lat: locations[i][1], lng: locations[i][2]},
				map: map,
				title: locations[i][0],
				infowindow: infoWindow
			});

			//add markers to array, which will be used for closing windows
			markers.push(marker);

			//when marker is clicked, hide all other windows and open that marker's window
			google.maps.event.addListener(marker, 'click', function() {
				hideAllInfoWindows(map);
				this.infowindow.open(map, this);
			});
		}
	}

	function hideAllInfoWindows(map) {
		//for each marker in markers array, close window
		markers.forEach(function(marker) {
			marker.infowindow.close(map, marker);
		}); 

	}


