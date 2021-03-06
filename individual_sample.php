<?php
session_start();
if (!($_SERVER['REQUEST_METHOD'] === 'POST')){
	header('Location: https://skretam.cs4ww3.ca/');
}
$library_info;
	if (!empty($_POST)){
		if(isset($_POST['review'])){
			$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
			$finalID = $pdo->prepare("SELECT max(reviewID) from Review");
			$finalID->execute();
			$LAST = $finalID->fetch();
			$LPO = 1 + (int) $LAST[0];
			$post_review = $pdo->prepare("INSERT INTO Review (reviewID, comments, rating, userID, libraryID) VALUES (?,?,?,?,?)");
			$get_libraryID = $pdo->prepare("SELECT libraryID FROM Library WHERE libraryName=?");
			$get_libraryID->execute([$_POST['search']]);
			$library_info = $get_libraryID->fetch();
			echo $_SESSION['id'];
			$post_review->execute([$LPO, $_POST['review'],$_POST['rating'],$_SESSION['userID'],$library_info['libraryID']]);
			sleep(1);
		}
		$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
		$get_library = $pdo->prepare("SELECT libraryID, libraryName,latitude,longitude, rating FROM Library WHERE libraryName=?");
		$get_library->execute([$_POST['search']]);
		$library_info = $get_library->fetch();
		$get_reviews = $pdo->prepare("SELECT libraryID, Review.userID, rating, comments, userNAME FROM Review  INNER JOIN User ON Review.userID = User.userID WHERE libraryID=?");
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
		<?php
		include 'header.php';
		?>
		<main>
			<div itemscope itemtype="http://schema.org/Product">  <!-- below data is related to product (in this case, product is library) -->
				<div class="results_library_container">
					<!-- Banner at the top of the page summarizing the information about the library -->
					<div class="summary_library_query">
						<div class="library_details">
							<!-- Information about the library -->
							<?php
							echo '<div id="library_name"> <span itemprop="name">'. $library_info['libraryName'] .'</span> </div>';
							?>
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
							<div class="button2">
								<?php
								echo '<form action="/results/" method="post" style="width: 100%;border-radius: 10px;height: 100%;">';
								echo '	<input type="hidden" value="' . $_POST['search'] .'" name="search">';
								echo '	<input type="submit" value="Go Back!" style="    width: 100%;border-radius: 10px;height: 100%;">';
								echo '</form>';
								?>
							</div>
						</div>
						<!-- Image of map containing location of library -->
						<div itemscope itemtype="http://schema.org/Place"> <!-- data relating to location of product (library) -->
							<!-- Live map containing location of HSL -->
							<div id="hslMap"></div>
							<script type="text/javascript"> var sql_global = '<?php echo json_encode($library_info); ?>'; </script>
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
										<span itemprop="ratingValue">' . $content['rating'] . '/5</span></div>';
							echo '</td>';
							echo '<td>';
							echo '<div class="comments" itemprop="description">' . $content['comments'] . '</div>';
							echo '</td>';
							echo '</tr>';
						}
						}
						?>
						</table>
						<?php
						if (isset($_SESSION['log_in']) && $_SESSION['log_in'] == True){
						echo '<div id="th2" style="color: black; opacity: 100">';
  							echo '<form action="/results/sample/" method="post" style="width: 100%;">';
    							echo '<input required name="review" style="width: 80%;height: 150px;border: 1px solid grey;" type="text">';
    							echo '<input name="search" type="hidden" value="' . $_POST['search']. '">';
    							echo '<select name="rating" style="display: inline;color: black;background: #e4e4e4;border: 0px;margin: 10px;width: 20%;height: 30px;">';
  									echo '<option value="0">Rate Library</option>';
  									echo '<option value="1">1</option>';
  									echo '<option value="2">2</option>';
  									echo '<option value="3">3</option>';
  									echo '<option value="4">4</option>';
  									echo '<option value="5">5</option>';
								echo '</select><input value="Add Review!" style="border: 0px;width: 20%;height: 30px;margin-bottom: 30px;" type="submit">';
  								echo '</form>';
							echo '</div>';
						}
						?>
					</div>
				</div>
			</main>
			<?php
			include 'footer.php';
			?>
		</div>
	</body>
	</html>
