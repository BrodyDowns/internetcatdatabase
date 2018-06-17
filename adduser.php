<?php
/*Adds user to database*/
	session_start();

	require_once 'classes/Dao.php';
	$dao = new Dao();
	echo $_SESSION['user']['username'];
	$dao->addcatxuser($_SESSION['user']['username']);

?>
