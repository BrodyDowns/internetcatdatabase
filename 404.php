<?php
session_start();
require_once './classes/Dao.php';
$dao = new Dao();

$urlinfo = pathinfo($_SERVER['REQUEST_URI']);
if($urlinfo[dirname] == '/allcats' && isset($dao->getCatInfo($urlinfo[filename])['cat'])) {
  //echo $urlinfo[filename];
  $_SESSION['currentcat']=$urlinfo[filename];
  include('./allcats/catpage.php');
}
else {
  include('./header.php');
  echo "<div class='content'><h1 id='title'> 404 error </h1></div>";
  include('./footer.php');
}
?>


<?php

?>
