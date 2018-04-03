<?php
	if (!empty($_POST)){
		$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
		$get_library = $pdo->prepare("SELECT libraryID, libraryName, rating FROM Library WHERE libraryName=?");
		$get_library->execute($_POST['search']);
		$library_info = $get_library->fetch();
		$get_reviews = $pdo->prepare("SELECT libraryID, userID, rating, comments, userNAME FROM Review WHERE libraryID=? INNER JOIN User ON Review.userID = User.userID");
		$get_reviews->execute([$library_info['libraryID']]);
		$reviews = $get_reviews->fetchAll();
}
?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
	
	<meta charset="UTF-8">
	<!-- FACEBOOK OPEN GRAPH META DATA -->
	<meta property="og:title" content="Health Sciences Library" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="./individual_sample.html" />
	<meta property="og:image" content="./assets/tempImage.svg" />
	<meta property="og:site_name" content="The Librarian"/>
	<meta property="og:description" content="Reviews for libraries around the world"/>
	<!-- TWITTER OPEN GRAPH META DATA -->
	<meta name="twitter:card" content="Review" />
	<meta name="twitter:site" content="@thelibrarian" />
	<meta name="twitter:creator" content="@skretam" />
	<!-- Configuring web site for iOS home screen -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon-precomposed" href="/assets/tempImage.svg"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="default" />
	<!-- Configuring web site for android home screen -->
	<meta name="mobile-web-app-capable" content="yes">
	<title>TL: Individual Sample</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>

<body>
	<div class="content_page_background"> 	<!-- create wrapper for individual sample page to structure background -->
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
			<div itemscope itemtype="http://schema.org/Product">  <!-- below data is related to product (in this case, product is library) -->
				<div class="results_library_container">
					<!-- Banner at the top of the page summarizing the information about the library -->
					<div class="summary_library_query">
						<div class="library_details">
							<!-- Information about the library -->
							<div id="library_name"> <span itemprop="name"> Health Sciences Library </span> </div>
							<div id="library_address">1280 Main St. W.</div>
							<div class="library_time">Hours of operation:</div>
							<div class="library_time">Mon-Thurs 8:45am-10:45pm</div>
							<div class="library_time">Fri 8:45am-9:45pm</div>
							<div class="library_time">Sat 10am-5:45pm</div>
							<div class="library_time">Sun 8:45am-10:45pm</div>
							<div class="overall_rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"> <!-- forward overall rating about product (library) -->
								<!-- Rating of the library represented in stars and numerically -->
								<img src="/assets/4.5stars.svg" alt="5stars">
								<div class="rating"> <span itemprop="ratingValue"> 4.5</span>/5 </div>
							</div>
						</div>

						<!-- Buttons in banner that quickly allow user to return to search results or write review -->
						<div class="buttons">
							<div class="button2"><a href="/results/">Go back</a></div>
							<div class="button2"><a href="/submission/">Write review</a></div>
						</div>
						<!-- Image of map containing location of library -->
						<div itemscope itemtype="http://schema.org/Place"> <!-- data relating to location of product (library) -->
							<!-- Live map containing location of HSL -->
							<div id="hslMap"></div>
							<!-- Initialize js file contiang library map -->
	   						<script src="/javascript/hslMap.js"></script>
	   						<!-- Google Maps key -->
					    	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh7w4XEe9aVCbSMDBMGBWTEI7hGIqFfHA&callback=initMap"
					    	async defer></script>
							<div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">  <!-- forward geolocation (coordinates) of product (library) -->
								<meta itemprop="latitude" content="28.93" />
								<meta itemprop="longitude" content="-47.25" />
							</div>
						</div>

					</div>
					<div id="th2">Reviews</div>
					<!-- Table containing user information, user rating, and user comments for library -->
					<table style="width:100%">
						<!-- Setting column widths -->
						<!-- Row #1 -->
						<tr>
							<!-- Setting column headers-->
							<th class="twentyfive">User</th>
							<th class="twentyfive">Rating</th> 
							<th class="fifty">Comments</th>
						</tr>
						<!-- Row #2 -->
						<?php
						if(!empty($reviews)){
							foreach($reviews as $content){
							echo '<tr itemprop="review" itemscope itemtype="http://schema.org/Review">';
							echo '<td>';
							echo '<img class="userPic" src="/assets/userPic.svg" alt="userPic">';
							echo '<div class="username" itemprop="name">' . $content['userName'] . '</div>';
							echo '</td>';
							echo '<td>';
							echo '<img src="/assets/5stars.svg" alt="5stars">';
							echo '<div class="rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"> 
										<span itemprop="ratingValue">' . $content['rating'] . '</span></div>';
							echo '</td>';
							echo '<td>';
							echo '<div class="comments" itemprop="description">' . $content['comments'] . '</div>';
							echo '</td>';
							echo '</tr>';
						}
						}
							?>
							<!-- Row #3 -->
							<tr>
								<td> <!-- First column containg user name & picture-->
									<img class="userPic" src="/assets/userPic.svg" alt="userPic">
									<div class="username">skretam</div>
								</td>
								<td> <!-- Second column containg user rating of library -->
									<img class="rating_stars" src="/assets/5stars.svg" alt="5stars">
									<div class="rating">5/5</div>
								</td>
								<td> <!-- Third column containg user comments about -->
									<div class="comments">It's often hard to get a seat because so many people come here, but if I manage to get one, the atmosphere here is pretty cool. </div>
								</td>
							</tr>
							<!-- Row #4 -->
							<tr>
								<td> <!-- First column containg user name & picture-->
									<img class="userPic" src="/assets/userPic.svg" alt="userPic">
									<div class="username">skretam</div>
								</td>
								<td> <!-- Second column containg user rating of library -->
									<img src="/assets/5stars.svg" alt="5stars">
									<div class="rating">5/5</div>
								</td>
								<td> <!-- Third column containg user comments about -->
									<div class="comments">The layout of the library is pretty weird...why you have to walk up a flight of stairs and then down a flight of stairs to get to the main floor of the library? </div>
								</td>
							</tr>
						</table>
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
