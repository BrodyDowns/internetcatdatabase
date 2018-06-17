<?php
$thisPage="allcats";
include('../header.php');
require_once '../classes/Dao.php';
require_once '../classes/Render.php';

$dao = new Dao();
?>

<div class="content">
	<h1>All Cats</h1>
	<?php
		Render::renderTable($dao->getAllCats());
	?>
</div>

<?php include("../footer.php"); ?>
