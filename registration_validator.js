
function formValidate(event){

	let userForm = document.forms["registrationForm"];
	let name = userForm[0].value;
	let birthday = userForm[1].value;
	let email = userForm[2].value;
	let username = userForm[3].value;
	let password = userForm[4].value;
	let passwordReentered = userForm[5].value;
	let checkBox = userForm[6].checked;

	 // regular expression for entering name (two words separate by a space)
   let regExpName = /^\w+\s\w+$/;
   if(!regExpName.exec(name)) {
      // Highlight incorrect field in red & display error message
      userForm[0].style.border = "1px solid red";
      document.getElementById("errorName").style.display = "block";
      event.preventDefault();
   }
   else {
      document.getElementById("errorName").style.display = "none";
      userForm[0].style.border = "none";
      userForm[0].style.borderBottom = "2px dotted #a9a9a9"; //if entered properly, remove red box
   }

	// regular expression for entering birthday (year (four digits), followed by a dash, followed by month(two digits), followed by dash, followed by date (two digits))
   let regExpDate = /[0-9]{4}[-][0-9]{1,2}[-][0-9]{1,2}/;
   if(!regExpDate.exec(birthday)) {
      // Highlight incorrect field in red & display error message
      userForm[1].style.border = "1px solid red";
      document.getElementById("errorBirthday").style.display = "block";
      event.preventDefault();
   }
   else {
      document.getElementById("errorBirthday").style.display = "none";
      userForm[1].style.border = "none";
      userForm[1].style.borderBottom = "2px dotted #a9a9a9"; //if entered properly, remove red box
   }

	// regular expression for entering email taken from: http://emailregex.com/
   let regExpEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   if(!regExpEmail.exec(email)) {
      // Highlight incorrect field in red & display error message
      userForm[2].style.border = "1px solid red";
      document.getElementById("errorEmail").style.display = "block";
      event.preventDefault();
   }
   else {
      document.getElementById("errorEmail").style.display = "none";
      userForm[2].style.border = "none";
      userForm[2].style.borderBottom = "2px dotted #a9a9a9"; //if entered properly, remove red box
   }

	// regular expression for entering username (anything but newline or whitespace)
   let regExpUName = /\S{6,}/;
   if(!regExpUName.exec(username)) {
      // Highlight incorrect field in red & display error message
      userForm[3].style.border = "1px solid red";
      document.getElementById("errorUserName").style.display = "block";
      event.preventDefault();
   }
   else {
      document.getElementById("errorUserName").style.display = "none";
      userForm[3].style.border = "none";
      userForm[3].style.borderBottom = "2px dotted #a9a9a9"; //if entered properly, remove red box
   }

	// regular expression for entering password (at least 1 digit, at least 1 uppercase letter, at least 1 lowercase letter, at least 8 chars total)
   let regPassword = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
   if(!regPassword.exec(password)) {
      // Highlight incorrect field in red & display error message
      userForm[4].style.border = "1px solid red";
      document.getElementById("errorPassword").style.display = "block";
      event.preventDefault();
   }
   else {
      document.getElementById("errorPassword").style.display = "none";
      userForm[4].style.border = "none";
      userForm[4].style.borderBottom = "2px dotted #a9a9a9"; //if entered properly, remove red box
   }

   if(passwordReentered != password){
      // Highlight incorrect field in red & display error message
      userForm[5].style.border = "1px solid red";
      document.getElementById("errorReenteredPassword").style.display = "block";
      event.preventDefault();
   }
   else {
      document.getElementById("errorReenteredPassword").style.display = "none";
      userForm[5].style.border = "none";
      userForm[5].style.borderBottom = "2px dotted #a9a9a9"; //if entered properly, remove red box
   }

    if(!checkBox){
      userForm[6].style.borderColor = "red";
      document.getElementById("errorUncheckedBox").style.display = "block";
      event.preventDefault();
	}
	else {
      document.getElementById("errorUncheckedBox").style.display = "none";
      userForm[6].style.border = "none"; //if entered properly, remove red box
   }
}