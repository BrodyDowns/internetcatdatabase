<?php
/*RESETS THE USER's PASSWORD*/
session_start();
require_once('../classes/Dao.php');

$dao = new Dao();

$key = $_SESSION["key"];
unset($_SESSION["key"]);

$id = $_SESSION['resetid'];
unset($_SESSION['resetid']);

//check if key still valid
if($dao->isValidHash($key)) {

  //check if password valid
  $ready = true;
  if(!preg_match('/^.{5,50}$/', $_POST['password'])) {
  	$_SESSION['badpassword'] = "Password must be between 5 and 50 characters.";
  	$ready = false;
  } else {
  	if(!($_POST['password'] == $_POST['passcheck'])) {
  		$_SESSION['badpassword'] = "Passwords do not match";
  		$ready = false;
  	}
  }

  if(!$ready) {
    header("Location:../resetpassword?key=" . $key);
    exit;
  }



  $password = $_POST['password'];

  $password = password_hash($password, PASSWORD_BCRYPT);

  $dao->updatePassword($id,$password);
  $dao->removeResetPasswordHash($id);

  header("Location:../resetpassword?reset=success");
  exit;
}
else {

  header("Location:../resetpassword?key=invalid");
  exit;
}





 ?>
