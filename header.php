<?php
session_start();
?>

<html>
    <head>
	<title>Internet Cat Database</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/js/myjs.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="/style.css">
	<link rel="icon" type="image/png" href="/images/favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    </head>
    <body>

	<div id="header">
		<a href="/">
		<img id="cornerlogo" src="/images/cornerlogo.png" alt="logo">
		</a>
	</div>
	<div id="nav">


	<div id="userinfo">
		<?php
			if(isset($_SESSION['user'])){
				echo $_SESSION['user']['username'] . " | <span id='uservotes'>" . $_SESSION['user']['votecount'] . "</span>";
		?>
			<a href="/signout.php">(sign out)</a>
		<?php
			} else {
		?>
			<a href="/signin">sign in</a> | <a href="/signup">sign up</a>
		<?php } ?>
	</div>

		<div id="novotes">
		</div>

	    <ul id="navlist">
		<li<?php if ($thisPage=="allcats") echo " id =\"currentpage\""; ?>><a href="/allcats">Cats</a></li><li<?php if ($thisPage=="manageaccount") echo " id =\"currentpage\""; ?>><a href="/manageaccount">Account</a></li><li<?php if ($thisPage=="about") echo " id =\"currentpage\""; ?>><a href="/about">About</a></li><li<?php if ($thisPage=="weeklywinners") echo " id =\"currentpage\""; ?>><a href="/weeklywinners">Weekly Winners</a></li>
             </ul>
        </div>
