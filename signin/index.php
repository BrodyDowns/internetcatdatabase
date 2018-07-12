<?php
$thisPage = "SignIn";
	include("../header.php");
?>
<div class="content">
	<h1> Account Sign-In </h1>

	<form id="signin" method="post"  action="signinhandler.php">
		<label> Username: </label>
		<input type="text" name="username" value="<?php echo $_SESSION['inputs']['username'];?>">

		<label> Password: </label>
		<input type="password" name="password">

		<div class="error">
			<?php
				echo $_SESSION['badlogin'];
				unset($_SESSION['badlogin']);
			?>
		</div>

		<input id="submit" type="submit">

		<div class="signinredir"> <a href="/signup">Don't have an account?</a></div>
		<div class="signInRedir"><a href="/resetpassword">Forgot Password?</a></div>
	</form>
</div>

<?php
	unset($_SESSION['inputs']);
	include("../footer.php");
?>
