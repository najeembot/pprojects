<!DOCTYPE html>
<html lang="en">
<head>
<title>NajeemB &mdash; Contact Process</title>
<link rel="icon" type="image/x-icon" href="images/icon.ico" />
</head>
<body>
<?php 
// text filtering for bad words function
function filter_text($text) {
	$bad_words = array("fuck", "sex", "xxx", "pussy", "dick", "ass", "hole", "cock", "prick", "phallus", "vagina", "porn", "shit", "piss", "pee", "boob", "boobs");
	$replacements = array("bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word", "bad-word");
	    $filtered_text = str_ireplace($bad_words, $replacements, $text);
	    return $filtered_text;
}
// checking post variables
if (@isset($_POST['fname']) and @isset($_POST['lname']) and @isset($_POST['email']) and @isset($_POST['subject']) and @isset($_POST['message'])) {
	// defining important variables
	$fname = @htmlentities($_POST['fname']);
	$lname = @htmlentities($_POST['lname']);
	$email = @htmlentities($_POST['email']);
	$subject = @htmlentities($_POST['subject']);
	$message = @htmlentities($_POST['message']);

	if (@!empty($fname) and @!empty($lname) and @!empty($email) and @!empty($subject) and @!empty($message)) {
		// creating actual email
		$to = "najeemb18@gmail.com";
		$from = @trim($email);
		$subject = @trim($subject);
		$headers = 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();
		$body = @trim(filter_text($message));
		if (@mail($to, $subject, $body, $headers)) {
?>
<br />
<br />
<center><h2 style="color:lightgreen;"><b>Your email was sent successfully!</b></h2><br /><a href="contact.html" style="text-decoration: none; cursor: pointer; color:#4685B8;">Go Back</a></center>
<br />
<br />
<?php
		} else {
?>
<br />
<br />
<center><h2 style="color:red"><b>Failed to send email!</b></h2><br /><a href="contact.html" style="text-decoration: none; cursor: pointer; color:#4685B8;">Go Back</a></center>
<br />
<br />
<?php
		}
	} else {
?>
<br />
<br />
<center><h2 style="color:#42A0DE"><b>Please fill all of your information</b></h2><br /><a href="contact.html" style="text-decoration: none; cursor: pointer; color:#4685B8;">Go Back</a></center>
<br />
<br />
<?php
	}
}
?>
</body>
</html>
