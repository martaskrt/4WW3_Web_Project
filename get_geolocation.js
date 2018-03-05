var lat = document.getElementById('latitude');
var lng = document.getElementById('longitude');

function getLocation() {
	navigator.geolocation.getCurrentPosition(success,error);
}

function success(position){
	var userPosition = position.coords;
	lat.innerHTML = userPosition.latitude;
	lng.innerHTML = userPosition.longitude;
}

function error(error) {
  	console.warn(`ERROR(${error.code}): ${error.message}`);
}
