<?php
session_start();

if (!empty($_POST)){
	if(isset($_POST['logMeOut'])){

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
			<!-- Page is divided into two columns: column 1 contains decorative images, column 2 contains log in form-->
			<div class="account_content">
				<!-- Column containing decorative image -->
				<img id="secondaryImage" src="/assets/booksStacked.jpeg" alt="booksStacked">
				<!-- Column containg log in form, which is divded into rows of prompts-->
				<form action="/login/" method="post">
					<input type="text" placeholder="USERNAME" name="user">
					<input type="text" placeholder="PASSWORD" name="pass">
					<input type="submit" class="button button2" value="Log In">
				</form>
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