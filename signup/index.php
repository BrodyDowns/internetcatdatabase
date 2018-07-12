<?php include("../header.php");

?>
<script src="../js/validate.js" type="text/javascript"></script>
<div class="content">

	<h1>Create An Account</h1>
	<form id="signup"  method="post" action="handler.php">

	<label> Username: </label>
	<input id="username" type="text" name="name" value ="<?php echo $_SESSION['inputs']['name']; ?>"><br>
	<div class="error" id="usernameError">
	<?php
	if(isset($_SESSION['badname']))
		echo $_SESSION['badname'];
	else
		echo "&nbsp";
	unset($_SESSION['badname']); ?>
	</div>

	<label> Email: </label>
	<input id="email" type="text" name="email" value ="<?php echo $_SESSION['inputs']['email']; ?>"><br>
	<div class="error" id="emailError">
		<?php
		if(isset($_SESSION['bademail']))
			echo $_SESSION['bademail'];
		else
			echo "&nbsp";
		unset($_SESSION['bademail']); ?>
	</div>

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

	<input id="submit" type="submit" disabled>

	<div class="signInRedir"><a href="../signin">Already have an account?</a></div>
	</form>
</div>

<?php unset($_SESSION['inputs']); ?>


<?php include("../footer.php"); ?>
