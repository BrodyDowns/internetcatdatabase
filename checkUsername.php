<?php
/*checks if username already exists*/
  require_once 'classes/Dao.php';
  $dao = new Dao();

  $userInfo = $dao->getUserUsername($_GET['username']);
  if (isset($userInfo['username'])) {
    echo true;
  } else {
    echo false;
  }
?>
