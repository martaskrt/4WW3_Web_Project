	//Initializing HSL location
	var myLatLng = {lat: 43.2602, lng: -79.9183};

	function initMap() {
		//Instance new map object using Google Maps API; map is centered at myLatLng
		var map = new google.maps.Map(document.getElementById('hslMap'), {
			center: myLatLng,
			zoom: 15
		});

		//Instance marker object that is positioned at myLatLng on the Google Maps object
		var hslMarker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			title: 'Health Science Library'
		});

	}

