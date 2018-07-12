<?php
//Deletes select comment
session_start();
require_once '../classes/Dao.php';
$dao = new Dao();


if(!isset($_SERVER['HTTP_REFERER'])) {
  $url = "../index.php";
  header("Location:$url");
  exit;
}


//get ID of commenter
$userID = $dao->getUserIDfromCommentID($_GET['commentID']);

 //double check that user is an admin or owner of comment
if($_SESSION['user']['admin'] || $_SESSION['user']['id'] == $userID)
{
  //run DAO delete comment function
  try {
    $commentID = $_GET['commentID'];
    $dao->deleteComment($commentID);
    $err['success'] = true;
    echo json_encode($err);
  } catch (Exception $e) {
    $err['error'] = $e;
    echo json_encode($err);
  }

  //return to page
  /*
  $url = $_SERVER['HTTP_REFERER'];
  header("Location:$url");
  exit;
  */

}
else
{
  $url = "/index.php";
  header("Location:$url");
  exit;
}


 ?>
