

function getLocation() {

	navigator.geolocation.getCurrentPosition(success,error);
}

function success(position){
	var userPosition = position.coords;
	var lat = document.getElementById('latitude');
	var lng = document.getElementById('longitude');
	lat.value = userPosition.latitude;
	lng.value = userPosition.longitude;
}

function error(error) {
  	console.warn(`ERROR(${error.code}): ${error.message}`);
}
