<?php
require_once('../classes/Dao.php');
$dao = new Dao();

if($dao->checkLastDate())
  print_r("NOT BEEN AT LEAST A WEEK");
else {
  print_r("INSERTING CATS");
  $cats = $dao->topThreeCats();

  $cat1 = $cats->fetch();
  $cat2 = $cats->fetch();
  $cat3 = $cats->fetch();


  $dao->submitWeeklyLeaders($cat1, $cat2, $cat3);
}

?>
