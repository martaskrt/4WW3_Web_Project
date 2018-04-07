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
				<form name="registrationForm" action="/registration/" method="post" onsubmit="formValidate(event)" novalidate>
					<!-- Each row consists of line with sample input text -->
					<input id="name" type="text" placeholder="NAME" name="name">
					<p id="errorName">Please enter name in the format: First Last</p>
					<span class="errorPHP"><?php echo $nameError;?></span>
					<div id="birthday">BIRTHDAY</div> <input type="date" name="bday">
					<p id="errorBirthday">Please enter birthday in the format: Year-Month-Date</p>
					<span class="errorPHP"><?php echo $bdayError;?></span>
					<input type="email" placeholder="E-MAIL" id="email" name="email">
					<p id="errorEmail">Please enter a valid email</p>
					<span class="errorPHP"><?php echo $emailError;?></span>
					<input type="text" placeholder="USERNAME" id="uname" name="uname">
					<p id="errorUserName">Please enter a valid username (must contain at least 6 characters)</p>
					<span class="errorPHP"><?php echo $unameError;?></span>
					<input type="password" placeholder="PASSWORD" id="pass" name="pass">
					<p id="errorPassword">Please enter a valid password (must contain at least 1 uppercase and lowercase letter, at least 1 digit, and at least 8 characters)</p>
					<span class="errorPHP"><?php echo $passError;?></span>
					<input type="password" placeholder="RE-ENTER PASSWORD" id="pass2" name="pass2">
					<p id="errorReenteredPassword">Passwords do not match!</p>
					<span class="errorPHP"><?php echo $pass2Error;?></span>
					<div id="text">I agree to a long list of terms and conditions that I won't read.</div><input type="checkbox" name="checkbox" value="yes">
					<p id="errorUncheckedBox">You must agree to our terms and conditions!</p>
					<span class="errorPHP"><?php echo $checkboxError;?></span>
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
