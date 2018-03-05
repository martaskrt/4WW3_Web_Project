
function getLocation() {
	//returns a Geolocation object that gives Web content access to the location of the device; parameters are the functions success, 
	//which takes the Position object as its sole input parameter, and error, which takes a PositionError object as its sole input 
	//parameter.
	navigator.geolocation.getCurrentPosition(success,error);
}

function success(position){
	var userPosition = position.coords;
	var lat = document.getElementById('latitude'); //gets element latitude, which is box in doc where I will store my latitude in 
	var lng = document.getElementById('longitude'); //gets element longitude, which is box in doc where I will store my longitude in 
	lat.value = userPosition.latitude; //change value of lat to user's latitude
	lng.value = userPosition.longitude; //change value of lng to user's longitude
}

function error(error) {
  	console.warn(`ERROR(${error.code}): ${error.message}`); //print error in console that position could not be obtained
  }
