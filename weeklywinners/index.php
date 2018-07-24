<?php
  $thisPage="weeklywinners";
  include("../header.php");
  require_once '../classes/Dao.php';
  $dao = new Dao();
?>
<div class="content">


  <h1> Weekly Winners </h1>
  <?php
    $weeklyleaders = $dao->getWeeklyLeaders();
    foreach($weeklyleaders as $row) {
  ?>
    <div class='weektitle'> Week <?php echo $row['week'] ?> </div>
  <div class='week'>

  <?php
      for($i = 1; $i <= 3; $i++)
      {
  ?>
    <div class='weeklycatwindow'>

      <a href="/allcats/<?php echo $row['cat' . $i]; ?>">
      <img class="weeklycatprofilepic" src="../allcats/images/<?php echo $row['cat' . $i]; ?>/profile.jpg" alt="<?php echo $row['cat' . $i]; ?>">
      <div class="weeklycatwindowname"> <?php echo $i .". " . $dao->getCatName($row['cat' . $i]);  ?> </div>
      </a>

      <div class="weeklycatwindowvotes">Votes: <?php echo $row['cat' . $i . 'votes'] ?> </div>
    </div>
  <?php
      }
  ?>
</div>
  <?php
    }
  ?>



  </div>
</div>

</div>
<?php include("../footer.php"); ?>
