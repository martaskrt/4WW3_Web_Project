

function getLocation() {
	var lat = document.getElementById('latitude');
	var lng = document.getElementById('longitude');
	navigator.geolocation.getCurrentPosition(success,error);
}

function success(position){
	var userPosition = position.coords;
	lat.value = userPosition.latitude;
	lng.value = userPosition.longitude;
}

function error(error) {
  	console.warn(`ERROR(${error.code}): ${error.message}`);
}
