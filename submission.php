<?php
session_start();
if (!isset($_SESSION['log_in']) || $_SESSION['log_in'] == False){
	header('Location: https://skretam.cs4ww3.ca/login/');
}
if (!empty($_POST)){
		
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>TL: Write a Review</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
	<!-- Initializing js file -->
	<script src="/javascript/get_geolocation.js"></script>
</head>

<body>
	<div class="content_page_background"> 	<!-- create wrapper for write review page to structure background -->
		<?php
		include 'header.php';
		?>
		<main>
			<!-- Page is divided into two columns: column 1 contains decorative images, column 2 contains review form-->
			<div class="review_page_layout">
				<!-- Column containing decorative image -->
				<img id="bookStack" src="/assets/bookStack.jpg" alt="bookStack.jpg">
				<!-- Column containg review form, which is divded into rows of prompts & answer boxes-->
				<!-- When form is submitted, form will be validated based on patterns in HTML tags -->
				<form name="review_container" action="/submission/" method="post" onsubmit="return validateForm()" method="post">
					<h2>Rate &amp; Review </h2>
					<!-- Each review category contains Prompt & answer box with sample input text -->
					<div class="review_category">
						<label>Library:<abbr title="This field is required">*</abbr></label> <!-- Field is required -->
						<!-- User must type in at least 1 character to classify as a library name-->
						<input type="text" placeholder="e.g. Thode Library" name="library" required minlength="1" title="Please enter a valid library">
					</div>
					<!-- New field where user can select button & lat and lng will be updated with user's current location-->
					<div class="review_category">
						<label>To get library location, either press button or enter it manually below:<abbr title="This field is required">*</abbr></label> <!-- Field is required -->
						<!-- calls function getLocation() in js file -->
						<button id="getLibLoc" onclick="getLocation()">Get library location</button>
					</div>
					<div class="review_category">
						<label>Latitude:<abbr title="This field is required">*</abbr></label> <!-- Field is required -->
						<!-- Regex pattern outlining what user must enter to constitute a latitude; adapted from https://stackoverflow.com/questions/3518504/regular-expression-for-matching-latitude-longitude-coordinates-->
						<input type="text" id="latitude" placeholder="e.g. 43.261059" name="latitude" required pattern="^(\+|-)?(?:90(?:(?:\.0{1,20})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,20})?))$" title="Please enter a valid latitude"> 
					</div>
					<div class="review_category">
						<label>Longitude:<abbr title="This field is required">*</abbr></label> <!-- Field is required -->
						<!-- Regex pattern outlining what user must enter to constitute a Longitudee; adapted from https://stackoverflow.com/questions/3518504/regular-expression-for-matching-latitude-longitude-coordinates-->
						<input type="text" id="longitude" placeholder="e.g. -79.922565" name="longitude" required pattern="^(\+|-)?(?:180(?:(?:\.0{1,20})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,20})?))$" title="Please enter a valid longitude">
					</div>
					<div class="review_category">
						<label>Rate library:<abbr title="This field is required">*</abbr></label> <!-- Field is required -->
						<!-- User selects radio of number from 1 to 5 -->
						<div class="rating">
							<span class="label radio"><input type="radio" name="rating" value="1" required name="title">1</span>
							<span class="label radio"><input type="radio" name="rating" value="2" required name="title">2</span>
							<span class="label radio"><input type="radio" name="rating" value="3" required name="title">3</span>
							<span class="label radio"><input type="radio" name="rating" value="4" required name="title">4</span>
							<span class="label radio"><input type="radio" name="rating" value="5" required name="title">5</span>
						</div>
					</div>
					<!-- User can add image -->
					<div class="review_category">
						<label>Add images:</label>
						<input type="file" name="file" id="file" class="inputfile"> <!-- Field is not required -->
						<label for="file"><img id="camera" src="/assets/addImage.svg" alt="camera"></label>
					</div>
					<div class="review_category">
						<label>Comments?</label> <!-- Field is not required -->
						<input type="text" placeholder="" name="search">
					</div>
					<!-- Submit button -->
					<button class="button button2">Submit</button>
				</form>
			</div>
		</main>
		<?php
		include 'footer.php';
		?>
	</div>
</body>
</html>
