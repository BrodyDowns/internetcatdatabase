<?php
$thisPage = "home";
include('header.php');
require_once('classes/Dao.php');
$dao = new Dao();
?>

<div class="content">
	<h1 id="title">The Internet Cat Database</h1>
	<h1>TOP 5</h1>
	<?php
	$cats = $dao->topFive();
	foreach($cats as $row) {
	 ?>

	<div class="frontdisplay">

		<?php /* <a href="/vote.php?cat=<?php echo $row['cat']; ?>"> </a> */ ?>
		<img class="vote"  data-action="<?php echo $row['cat']; ?>" src="images/vote.png" alt="Vote!">

		<a href="allcats/<?php echo $row['cat']; ?>">

		<img class="profilepic"  src="allcats/images/<?php echo $row['cat']; ?>/profile.jpg" alt="<?php echo $row['name']; ?>">

		<h2><?php echo $row['name']; ?></h2>

		</a>

		<h3>Votes: <span id="<?php echo $row['cat']; ?>votes"><?php echo $row['votecount']; ?></span></h3>
	</div>
	<?php }?>

</div>

<?php
    include('footer.php');
?>
