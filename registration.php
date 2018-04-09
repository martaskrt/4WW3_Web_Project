<?php
session_start();
// define variables and set to empty values
$totalErrors = array();
$nameError = $bdayError = $emailError = $unameError = $passError = $pass2Error = $checkboxError= "";
$name = $bday = $email = $uname = $pass = $pass2 = $checkbox= "";

if (!empty($_POST)) {
  $name = checkInput($_POST["name"]);
  if (!preg_match("/^\w+\s\w+$/",$name)) {
    $nameError = "Please enter name in the format: First Last"; 
    array_push($totalErrors, $nameError);
  }
  
  $bday = checkInput($_POST["bday"]);
  if (!preg_match("/[0-9]{4}[-][0-9]{1,2}[-][0-9]{1,2}/",$bday)) {
    $bdayError = "Please enter birthday in the format: Year-Month-Date";
    array_push($totalErrors, $bdayError);
  } 
    
  $email = checkInput($_POST["email"]);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $emailError = "Please enter a valid email";
    array_push($totalErrors, $emailError);
  } 

  $uname = checkInput($_POST["uname"]);
  if (!preg_match("/\S{6,}/", $uname)) {
    $unameError = "Please enter a valid username (must contain at least 6 characters)";
    array_push($totalErrors, $unameError);
  } 
  else {
	$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
	$checkUN = $pdo->prepare("SELECT userName FROM User WHERE userName=?");
	$checkUN->execute([$_POST["uname"]]);
	$UNAME = $checkUN->fetch();
	if (!empty($UNAME)){		
    		$unameError = "Username has already been taken!";
    		array_push($totalErrors, $unameError);
	}
}

  $pass = checkInput($_POST["pass"]);
  if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $pass)) {
    $passError = "Please enter a valid password (must contain at least 1 uppercase and lowercase letter, at least 1 digit, and at least 8 characters)";
    array_push($totalErrors, $passError);
  } 

  if ($_POST["pass2"] != $_POST["pass"]) {
    $pass2Error = "Passwords do not match!";
    array_push($totalErrors, $pass2Error);
  } 

  if (empty($_POST["checkbox"])) {
    $checkboxError = "You must agree to our terms and conditions!";
    array_push($totalErrors, $checkboxError);
  } 
}
function checkInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}
if (empty($totalErrors)){
	$pdo = new PDO('mysql:host=localhost; dbname=marts_database', 'skretam','Philedelthia12!?');
	$passwordSalt = bin2hex($_POST['pass']);
	$hashed_pw = hash('sha256', $_POST['pass'] . $passwordSalt);
	$getLastUserID = $pdo->prepare("SELECT max(userID) FROM User");
	$getLastUserID->execute();
	$lastUserID = $getLastUserID->fetch();
	$fullUID = 1 + (int) $lastUserID[0];
	$register_query = $pdo->prepare("INSERT INTO User (userID, userName, userPass, userSalt, userEmail, userBirthday)
		VALUES (?,?,?,?,?,?)");
	$register_query->execute([$fullUID,$_POST['uname'],$hashed_pw,$passwordSalt, $_POST['email'],$_POST['bday']]);
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>TL: Sign Up</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>

<body>
	<div class="content_page_background"> 	<!-- create wrapper for sign in page to structure background -->
		<?php
		include 'header.php';
		?>
		<main>
			<!-- Page is divided into two columns: column 1 contains decorative images, column 2 contains sign up form-->
			<div class="account_content">
				<!-- Column containing decorative image -->
				<img id="secondaryImage" src="/assets/personReading.jpeg" alt="personReading">
				<!-- Column containg sign up form, which is divded into rows of prompts-->
				<!-- function is located in js file called registration_validator -->
				<script src="/javascript/registration_validator.js"></script>
				<?php
				$name = $birthdate = $email = $username = "";
				if (!empty($_POST)){
					$name = $_POST['name'];
					$birthdate = $_POST['bday'];
					$email = $_POST['email'];
					$username = $_POST['uname'];
				}
				echo '<form name="registrationForm" action="/registration/" method="post" onsubmit="formValidate(event)" novalidate>';
				echo '	<input id="name" type="text" placeholder="NAME" name="name" value="' .$name.'">';
				echo '	<p id="errorName">Please enter name in the format: First Last</p>';
				echo '	<span class="errorPHP">'.  $nameError . '</span>';
				echo '	<div id="birthday">BIRTHDAY</div> <input type="date" name="bday" value="' .$birthdate.'">';
				echo '	<p id="errorBirthday">Please enter birthday in the format: Year-Month-Date</p>';
				echo '	<span class="errorPHP">'.  $bdayError . '</span>';
				echo '	<input type="email" placeholder="E-MAIL" id="email" name="email" value="' .$email. '">';
				echo '	<p id="errorEmail">Please enter a valid email</p>';
				echo '	<span class="errorPHP">' . $emailError . '</span>';
				echo '	<input type="text" placeholder="USERNAME" id="uname" name="uname" value="' .$username.'">';
				echo '	<p id="errorUserName">Please enter a valid username (must contain at least 6 characters)</p>';
				echo '	<span class="errorPHP">' . $unameError . '</span>';
				echo '	<input type="password" placeholder="PASSWORD" id="pass" name="pass">';
				echo '	<p id="errorPassword">Please enter a valid password (must contain at least 1 uppercase and lowercase letter, at least 1 digit, and at least 8 characters)</p>';
				echo '	<span class="errorPHP">' . $passError . '</span>';
				echo '	<input type="password" placeholder="RE-ENTER PASSWORD" id="pass2" name="pass2">';
				echo '	<p id="errorReenteredPassword">Passwords do not match!</p>';
				echo '	<span class="errorPHP">' . $pass2Error . '</span>';
				echo '	<div id="text">I agree to a long list of terms and conditions that I won\'t read.</div><input type="checkbox" name="checkbox" value="yes">';
				echo '	<p id="errorUncheckedBox">You must agree to our terms and conditions!</p>';
				echo '	<span class="errorPHP">' . $checkboxError . '</span>';
				echo '	<button class="button button2">Submit</button> ';
				echo '</form>';
				?>
			</div>
		</main>
		<?php
		include 'footer.php';
		?>
	</div>
</body>
</html>
