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
		<header> 	<!-- header for page when screen size is 1024 px-->
			<img id="theLibLogo" src="/assets/theLibSmallLogo.svg" alt="theLibLogo"> 	<!-- logo image -->
			<ul class="menu-left"> 	<!-- unordered list for left half of header; navigates to search or review pages -->
				<li><a href="/">Search</a></li>
				<li><a href="submission/">Write a Review</a></li>
			</ul>
			<ul class="menu-right"> <!-- unordered list for right half of header; navigates to log in or sign up pages -->
				<li><div class="button1"><a href="login/">Log In</a></div></li>
				<li><div class="button1"><a href="registration/">Sign Up</a></div></li>
			</ul>
			<div class="dropdown"> <!-- header for page when screen size < 1024 px-->
				<button class="button1">Menu &#x25BC;</button> <!-- Menu button that drops down to list of all pages-->
				<div class="dropdown_content">
					<div class="item"><a href="/">Search</a></div>
					<div class="item"><a href="submission/">Write a Review</a></div>
					<div class="item"><a href="login/">Log In</a></div>
					<div class="item"><a href="registration/">Sign Up</a></div>
				</div>
			</div> 
		</header>

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

		<footer>
			<div class="footer-left"> <!-- Left half of footer contains social media icons -->
				<img class="socialMediaIcon" src="/assets/facebook.svg" alt="facebook">
				<img class="socialMediaIcon" src="/assets/twitter.svg" alt="twitter">
				<img class="socialMediaIcon" src="/assets/instagram.svg" alt="instagram">
			</div>
			<ul class="footer-right"> <!-- Right half of footer contains site information -->
				<li>About</li>
				<li>Contact</li>
				<li>Copyright &#169; Marta Skreta designs</li>
			</ul>
		</footer>
	</div>
</body>
</html>
