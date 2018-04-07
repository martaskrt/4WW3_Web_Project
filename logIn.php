<?php
session_start();
if (!empty($_POST)){
	if(isset($_POST['logMeOut']) && $_POST['logMeOut'] == 'true'){
		$_SESSION['log_in'] = False;
		$_SESSION['user'] = "";
		$_SESSION['userID'] = "";
	}
	else {
		if (!empty($_POST['user']) && !empty($_POST['pass'])){
			$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
			$get_credentials = $pdo->prepare("SELECT userSalt, userPass, userName, userID FROM User WHERE userName=?");
			$get_credentials->execute([$_POST['user']]);
			$user_details = $get_credentials->fetch();
			$hashed_pw = hash('sha256', $_POST['pass'] . $user_details['userSalt']);
			if ($hashed_pw == $user_details['userPass']){
				$_SESSION['log_in'] = True;
				$_SESSION['user'] = $user_details['userName'];
				$_SESSION['userID'] = $user_details['userID'];
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>TL: Log In</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>
	<div class="content_page_background"> 	<!-- create wrapper for log in to structure background -->
		<?php 
		include 'header.php'
		?>
		<main>
			<!-- Page is divided into two columns: column 1 contains decorative images, column 2 contains log in form-->
			<div class="account_content">
				<!-- Column containing decorative image -->
				<img id="secondaryImage" src="/assets/booksStacked.jpeg" alt="booksStacked">
				<!-- Column containg log in form, which is divded into rows of prompts-->
				<?php
				if(!isset($_SESSION['log_in']) || $_SESSION['log_in'] == False) {
				echo '<form action="/login/" method="post">';
				echo '<input type="text" placeholder="USERNAME" name="user">';
				echo '<input type="text" placeholder="PASSWORD" name="pass">';
				echo '<input type="submit" class="button button2" value="Log In">';
				echo '</form>';
				}
				else {
					echo '<form action="/login/" method="post">';
					echo '<input type="hidden" value="true" name="logMeOut">';
					echo '<input type="submit" class="button button2" value="Log Out">';
					echo '</form>';
				}
				
				?>
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
