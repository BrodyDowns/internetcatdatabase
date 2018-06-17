<?php
/*validates information on account creation. Will validate info if javascript is disabled*/

session_start();
require_once '../classes/Dao.php';
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
	$_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$dao->saveUser($_POST);
} else {
	$_SESSION['inputs'] = $_POST;
	header("Location:../signup");
	exit;
}

header("Location:../manageaccount");
exit;

?>
