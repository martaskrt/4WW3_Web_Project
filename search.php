<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>The Librarian</title>
	<link rel="stylesheet" type="text/css" href="/style.css" />
	<!-- Function to get user's geolocation -->
	<script>
		function getLocation() {
			//returns a Geolocation object that gives Web content access to the location of the device; parameters are the functions success, 
			//which takes the Position object as its sole input parameter, and error, which takes a PositionError object as its sole input 
			//parameter.
		    navigator.geolocation.getCurrentPosition(success,error);
		}
		function success(position){
			var userPosition = position.coords;
			console.log(`Your current latitude is: ${userPosition.latitude}`); //print user latitude to console
			console.log(`Your current longitude is: ${userPosition.longitude}`); //print user longitude to console
		}

		function error(error) {
  			console.warn(`ERROR(${error.code}): ${error.message}`);  //print error in console that position could not be obtained
		}
	</script>
</head>

<body>
	<div class="main-page-background"> <!-- create wrapper to set background image for main page -->
		<?php
		include 'header.php';
		?>
		<main>
			<div class="container-content"> <!-- Class containing content for main page -->
				<div class="headlines"> <!-- Headlines -->
					<h2>The</h2>
					<h1>Librarian</h1>
				</div>
				<h3>Find a library</h3> 
				<!--  Search bar on main page -->
				<div class="search-container">
					<form name="searchForm" action="results/" method="post">
						<span class="input-prompt">Enter library:</span>
						<!-- Box containing sample input text so user knows what to search for -->
						<input type="text" placeholder="e.g. Thode Library" name="search">
						<span class="input-prompt">Rating:</span>
						<!--  Dropdown menu to select star rating -->
						<div class="dropdown">
							<button>Any &#x25BC;</button> <!-- Prompt for dropdown menu -->
							<div class="dropdown_content">
								<div class="item">&#x2605;</div> <!--  Symbol for star  -->
								<div class="item">&#x2605;&#x2605;</div>
								<div class="item">&#x2605;&#x2605;&#x2605;</div>
								<div class="item">&#x2605;&#x2605;&#x2605;&#x2605;</div>
								<div class="item">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;</div>
							</div>
						</div> 
						<span class="input-prompt">Proximity:</span>
						<!--  Dropdown menu to select distance of query from user -->
						<div class="dropdown">
							<button>Any &#x25BC;</button> <!-- Prompt for dropdown menu -->
							<div class="dropdown_content"> <!--  Dropdown menu containing different distances  -->
								<!--  Get user's geolocation using getLocation() function in header  -->
								<button class="item" onclick="getLocation()">Current Location</button>
							</div>
						</div> 
						<!-- Image of search icon which user can click to submit results -->
						<a href="results/"><img id="searchIcon" src="/assets/searchIcon.svg" alt="Search Icon"></a>
					</form>
				</div>
			</div>
		</main>

		<?php
		include 'footer.php';
		?>
	</div>
</body>
</html>
