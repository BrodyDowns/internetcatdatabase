<?php
	/*handler for signing out*/
	session_start();
	unset($_SESSION['user']);
	header("Location:index.php");
	exit;

?>
