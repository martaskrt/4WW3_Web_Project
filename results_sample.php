<?php
if (!empty($_POST)){
$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
$template = "%" . $_POST["search"] . "%";
$get_the_posts = $pdo->prepare("SELECT libraryName, rating FROM Library WHERE libraryName LIKE ?");
$get_the_posts->execute([$template]);
$posts = $get_the_posts->fetchAll();
}
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<title>TL: View Results</title>
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
	</head>

	<body>
		<div class="content_page_background"> 	<!-- create wrapper for search results page to structure background -->
			<header> 	<!-- header for page when screen size is 1024 px-->
			<img id="theLibLogo" src="/assets/theLibSmallLogo.svg" alt="theLibLogo"> 	<!-- logo image -->
			<ul class="menu-left"> 	<!-- unordered list for left half of header; navigates to search or review pages -->
				<li><a href="/">Search</a></li>
				<li><a href="/submission/">Write a Review</a></li>
			</ul>
			<ul class="menu-right"> <!-- unordered list for right half of header; navigates to log in or sign up pages -->
				<li><div class="button1"><a href="/login/">Log In</a></div></li>
				<li><div class="button1"><a href="/registration/">Sign Up</a></div></li>
			</ul>
			<div class="dropdown"> <!-- header for page when screen size < 1024 px-->
				<button class="button1">Menu &#x25BC;</button> <!-- Menu button that drops down to list of all pages-->
				<div class="dropdown_content">
					<div class="item"><a href="/">Search</a></div>
					<div class="item"><a href="/submission/">Write a Review</a></div>
					<div class="item"><a href="/login/">Log In</a></div>
					<div class="item"><a href="/registration/">Sign Up</a></div>
				</div>
			</div> 
		</header>

			<main>
				<div class="results_library_container">
					<!-- Banner at the top of the page reiterating user's query -->
					<div class="summary_library_query">
						<div class="guest_query_summary">
							<div id="title">Returning your search results for: </div>
							<!-- Key words user searched for on main page -->
							<div id="search">Libraries near McMaster University</div>
						</div>
						<!-- Live map containing location of all library McMaster -->
	    				<div id="map"></div>
	    				<!-- Initialize js file contiang library map -->
	   					<script src="/javascript/liveMap.js"></script>
	   					<!-- Google key for map -->
					    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh7w4XEe9aVCbSMDBMGBWTEI7hGIqFfHA&callback=initMap"
					    async defer></script>
					</div>

					<!-- Table containing libraries relating to search, their rating & images -->
					<table style="width:100%">
						<tr> <!-- Row #1 -->
							<!-- Setting column headers-->
							<th class="twentyfive">Library name</th>
							<th class="twentyfive">Rating</th> 
							<th class="fifty"></th>
						</tr>
						<?php
						if (isset($posts)){
						foreach ($posts as $number=>$content){
							$key_plus = $number + 1;
							echo '<tr>'; //<!-- Row #2 -->
							echo '<td><a href="sample/">'. $key_plus . '. ' . $content['libraryName'] . '</a></td>'; //<!-- First column containing library name-->
							echo '<td>'; //<!-- Second column containg average rating of library -->
								echo '<img id="4.5stars" src="/assets/4.5stars.svg" alt="5stars">';
								echo '<div id="rating_number">' . $content['rating'] . '</div></td>'; 
								echo '<td>'; //<!-- Third column containg images of library -->
									echo '<img class="item" src="/assets/tempImage.svg" alt="hthsci1">';
									echo '<img class="item" src="/assets/tempImage.svg" alt="hthsci2">';
									echo '<img class="item" src="/assets/tempImage.svg" alt="hthsci3">';
								echo '</td>';
							echo '</tr>';
						}
						}
						?>
						</table>
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
