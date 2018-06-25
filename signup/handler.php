<?php
/*validates information on account creation. Will validate info if javascript is disabled*/

session_start();
require_once '../classes/Dao.php';
require '../vendor/autoload.php';
$dao = new Dao();
$ready = true;



echo $_POST['name'];




//check username
if(!preg_match('/^[A-Za-z0-9-_\.]{3,40}$/', $_POST['name'])) {
	$_SESSION['badname'] = "Can only contain alphanumeric characters, -, _, or .";
	$ready = false;
} else {
	$userInfo = $dao->getUserUsername($_POST['name']);
	if(isset($userInfo['username'])) {
		$_SESSION['badname'] = "Username already taken";
		$ready = false;
	}
}

//check email
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$_SESSION['bademail'] = "E-mail entered is not valid";
	$ready = false;
} else {
	$userInfo = $dao->getUserEmail($_POST['email']);
	if(isset($userInfo['username'])) {
		$_SESSION['bademail'] = "This e-mail already has an associated account";
		$ready = false;
	}
}

//checkpassword
if(!preg_match('/^.{5,50}$/', $_POST['password'])) {
	$_SESSION['badpassword'] = "Password must be between 5 and 50 characters.";
	$ready = false;
} else {
	if(!($_POST['password'] == $_POST['passcheck'])) {
		$_SESSION['badpassword'] = "Passwords do not match";
		$ready = false;
	}
}


if($ready) {

	//hash password with bcrypt
	$_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

	//save user
	$dao->saveUser($_POST);

	//send email
	$from = new SendGrid\Email(null, "icatsdb@gmail.com");
	$subject = "ICDB Email Confirmation";
	$to = new SendGrid\Email(null, $_POST['email']);
	$content = new SendGrid\Content("text/plain", "Thank you for signing up to the #1 source on popular internet cats!

	 internetcatdatabase.herokuapp.com");
	$mail = new SendGrid\Mail($from, $subject, $to, $content);

	$apiKey = getenv('SENDGRID_API_KEY');
	$sg = new \SendGrid($apiKey);

	$response = $sg->client->mail()->send()->post($mail);
	echo $response->statusCode();
	echo "<br > <br >";
	echo $response->headers();
	echo "<br > <br >";
	echo $response->body();

} else {
	$_SESSION['inputs'] = $_POST;
	header("Location:../signup");
	exit;
}

header("Location:../manageaccount");
exit;

?>
