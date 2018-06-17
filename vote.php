<?php
/*handler for submitting a vote*/
	session_start();
	require_once 'classes/Dao.php';
	$dao = new Dao();


	if(isset($_SERVER['HTTP_REFERER'])) {
		if(!isset($_SESSION['user'])) {
			$err['error'] = true;
			$err['message'] = "You must sign in to vote!";
			echo json_encode($err);
		} else if( $dao->getUserVotecount($_SESSION['user']['username'])> 0) {
			$dao->decUser($_SESSION['user']['username']);
			$dao->incCat($_GET['cat']);
			$dao->inccatxuser($_GET['cat'], $_SESSION['user']['id']);
			$_SESSION['user']['votecount'] = $dao->getUserVotecount($_SESSION['user']['username']);
			$err['error'] = false;
			$err['votes'] = $_SESSION['user']['votecount'];
			echo json_encode($err);
		}
		else {
			$err['error'] = true;
			$err['message'] = "You have no votes left!";
			$err['votes'] = 0;
			echo json_encode($err);
		}

		$url = $_SERVER['HTTP_REFERER'];
	} else {
		$url = "/index.php";
		header("Location:$url");
		exit;
	}


		/*
	header("Location:$url");
	exit;
		 */


?>
