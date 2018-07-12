<?php
/*adds comment to database*/
	session_start();
	require_once 'classes/Dao.php';
	$dao = new Dao();

	$cat = $_SESSION['lastcat'];
	if(isset($_SESSION['user'])){
		$comment = nl2br(htmlentities($_POST['comment']));
		$user = $_SESSION['user']['username'];
		$commentID = $dao->saveComment($comment, $cat, $user);



		$data['comment'] = $comment;
		$data['name'] = $user;
		$data['id'] = $commentID;
		echo json_encode($data);

	} else {
		/*$_SESSION['commenterror'] = "You must be logged in to comment!";*/
		$data['error'] = true;
		$data['message'] = "You must be logged in to comment!";
		echo json_encode($data);
	}

	/*
	header("Location:allcats/$cat.php");
	exit;
	*/
?>
