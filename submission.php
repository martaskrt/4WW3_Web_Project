<?php
session_start();
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
$lib_name = "";
$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
if (isset($_POST['library_given'])){
	$lib_name = $_POST['library_given'];
}
	$totalErrors = array();
	if (!isset($_SESSION['log_in']) || $_SESSION['log_in'] == False){
		header('Location: https://skretam.cs4ww3.ca/login/');
	}
	if (!empty($_POST)){
		if(!isset($_POST['library'])){
			$error = "Library was not set properly!";
			array_push($totalErrors, $error);
		}
		if(!isset($_POST['latitude'])){
			$error = "Latitude was not set properly!";
			array_push($totalErrors, $error);
		}
		if(!isset($_POST['longitude'])){
			$error = "Longitude was not set properly!";
			array_push($totalErrors, $error);
		}
		if(!isset($_FILES['file']['name'])){
			$error = "No image was uploaded!";
			array_push($totalErrors, $error);
		}
		echo $totalErrors[0];
		if(empty($totalErrors)){
			$library_query = $pdo->prepare("SELECT libraryID,libraryName FROM Library WHERE libraryName=?");
			$library_query->execute([$_POST['library']]);
			$library_Result = $library_query->fetch();
			if (empty($library_Result)){
				$create_library = $pdo->prepare("INSERT INTO Library (libraryID, libraryName, rating, images, latitude, longitude) VALUES (?,?,?,?,?,?)");
				$last_library = $pdo->prepare("SELECT max(libraryID) FROM Library");
				$last_library->execute();
				$last_library_result = $last_library->fetch();
				$last_libraryID = 1 + (int) $last_library_result[0];
				$rating = "?/5";
				$create_library->execute([$last_libraryID, $_POST['library'], $rating, $_FILES['file']['name'], $_POST['latitude'], $_POST['longitude']]);

				$S3_API = new S3Client([
					'region' => 'us-east-2',
					'version' => '2006-03-01',
					'credentials' => array(
						'key' => '',
						'secret' => '')
				]);
				try {
					$S3_API->putObject([
						'Bucket' => 'marta-skreta-image-bucket',
						'Key' => $_FILES['file']['name'],
						'SourceFile' => $_FILES['file']['tmp_name']]);
				}
				catch (S3Exception $error){
				// I have to do something with this error!
				}
			}
			else {
				$submit_review = $pdo->prepare("INSERT INTO Review (libraryID, userID, rating, comments) VALUES (?,?,?,?)");
				$submit_review->execute([$library_Result['libraryID'], $_SESSION['userID'], $_POST['rating'],$_POST['comments']]);
			}
		}
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
				<form enctype="multipart/form-data" name="review_container" action="/submission/" method="post" onsubmit="return validateForm()" method="post">
					<h2>Rate &amp; Review </h2>
					<!-- Each review category contains Prompt & answer box with sample input text -->
					<div class="review_category">
						<label>Library:<abbr title="This field is required">*</abbr></label> <!-- Field is required -->
						<!-- User must type in at least 1 character to classify as a library name-->
						<input type="text" placeholder="e.g. Thode Library" name="library" required minlength="1" title="Please enter a valid library" value="<?php echo $lib_name; ?>">
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
						<input type="text" placeholder="" name="comments">
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
