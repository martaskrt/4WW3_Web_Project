	var myLatLng = {lat: 43.2602, lng: -79.9183};

	var markers = [];

function initMap() {

	var map = new google.maps.Map(document.getElementById('hslMap'), {
		center: myLatLng,
		zoom: 15
	});

	var hslMarker = new google.maps.Marker({
		position: myLatLng,
		map: map,
		title: 'Health Science Library'
	});

	hslMarker.addListener('click', function() {
		hslInfoWindow.open(map, hslMarker);
	});

	markers.push(hslMarker);

}

