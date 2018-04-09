	//Initializing HSL location
	function initMap() {
		//Instance new map object using Google Maps API; map is centered at myLatLng
		let library = JSON.parse(sql_global);
		let myLatLng = {lat: parseFloat(library.latitude), lng: parseFloat(library.longitude)};
		var map = new google.maps.Map(document.getElementById('hslMap'), {
			center: myLatLng,
			zoom: 15
		});
		//Instance marker object that is positioned at myLatLng on the Google Maps object
		var hslMarker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			title: library.libraryName
		});

	}

