<?php include("header.php"); ?>

<div class="content">
	<h1>Suggestions</h1>

	<form id="suggestions" action="mailto:internetcatdatabase@gmail.com" method="post" enctype="text/plain">
	Name: <br>
	<input type="text" name="name"><br>
	Email: <br>
	<input type="text" name="email"><br>
	Suggestion: <br>
	<textarea  name="suggestion"></textarea><br>
	<input id="submit" type="submit" value="Send">
	</form>

</div>





<?php include("footer.php"); ?>
