<?php
/*checks if email exists in database*/
  require_once 'classes/Dao.php';
  $dao = new Dao();

  $userInfo = $dao->getUserEmail($_GET['email']);
  if (isset($userInfo['email'])) {
    echo true;
  } else {
    echo false;
  }
?>
