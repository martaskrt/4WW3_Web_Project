	var myLatLng = {lat: 43.2635, lng: -79.9180};

	var locations = [
	['Health Sciences Library', 43.2602, -79.9183],
	['Thode Library', 43.2611, -79.9225],
	['Mills Library', 43.2627, -79.9177],
	];
	var markers = [];

	var content = [

	`<h2 class="library_name"><a href="./individual_sample.html">Health Sciences Library</a></h2>
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

	var map = new google.maps.Map(document.getElementById('map'), {
		center: myLatLng,
		zoom: 15
	});

	setMarkers(map);

}

function setMarkers(map){

	for(i = 0; i < locations.length; i++){


		var infoWindow = new google.maps.InfoWindow({
			content: content[i],
			maxWidth: 200
		});

		var marker = new google.maps.Marker({
			position: {lat: locations[i][1], lng: locations[i][2]},
			map: map,
			title: locations[i][0],
			infowindow: infoWindow
		});
	

	markers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
      hideAllInfoWindows(map);
      this.infowindow.open(map, this);
    });
}
}

function hideAllInfoWindows(map) {
   markers.forEach(function(marker) {
     marker.infowindow.close(map, marker);
  }); 

}


