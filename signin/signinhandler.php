<?php
/*handler for signing in*/

session_start();
require_once '../classes/Dao.php';
$dao = new Dao();

$userInfo = $dao->getUserUsername($_POST['username']);

if(isset($userInfo['password']) && password_verify($_POST['password'], $userInfo['password'])){
	$_SESSION['user'] = $userInfo;
	header("Location:../manageaccount");
	exit;
} else {
	$_SESSION['badlogin'] = "Username or password incorrect.";
	$_SESSION['inputs'] = $_POST;

	print_r($_SESSION);


	header("Location:../signin/");
	exit;

}







?>
