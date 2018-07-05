<?php
  include("../header.php");
  require_once('../classes/Dao.php');

  $dao = new Dao();
 ?>
<div class="content">
  <h1>Reset Password</h1>

<?php
  if($_GET["reset"] == success)
  {

?>

  <h1 class="errorValid" > Password successfully changed. Redirecting...</div>

<?php
  header("Refresh: 2; URL=../signin");

  } else if(isset($_GET["key"]) && $dao->isValidHash($_GET["key"])) {
    $_SESSION['resetid'] = $dao->getUserIDHash($_GET['key']);
    $_SESSION['key'] = $_GET['key'];
    echo $_SESSION['resetid'];
?>
    <script src="../js/validate.js" type="text/javascript"></script>
    <form id="signup"  method="post" action="resetPasswordHandler.php">
      <label> Password: </label>
    	<input id="password" type="password" name="password"><br>
    	<div class="error" id="passwordError">
    		&nbsp;
    	</div>


    	<label> Password again: </label>
    	<input id="passwordVal" type="password" name="passcheck"<br>
    	<div class="error" id="passwordValError">
    		<?php
    		if(isset($_SESSION['badpassword']))
    			echo $_SESSION['badpassword'];
    		else
    			echo "&nbsp";
    		unset($_SESSION['badpassword']); ?>
    	</div>

    	<input id="resetSubmit" type="submit" disabled>
    </form>
<?php
  }
  else {
?>
  <form id="signup"  method="post" action="sendEmailHandler.php">
    <label> Email: </label>
    <input id="email" type="text" name="email"><br>
    <input id="submit" type="submit">

    <div class="error">
      <?php
      if(isset($_GET['key']))
        echo "The link used has expired or is no longer valid";
      echo $_SESSION['errorMessage'];
      unset($_SESSION['errorMessage']);
      ?>
    </div>
    <div class="errorValid">
      <?php
      echo $_SESSION['successMessage'];
      unset($_SESSION['successMessage']);
      ?>
    </div>



  </form>


<?php } ?>

</div>
<?php include("../footer.php"); ?>
