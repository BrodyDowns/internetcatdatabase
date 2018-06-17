<?php
$thisPage="manageaccount";
include("../header.php");
require_once '../classes/Dao.php';

if(!isset($_SESSION['user'])) {
	header("Location:../signin");
	exit;
}

	$dao = new Dao();
?>
<div class="content">
	<h1>Account Profile</h1>
	<div id="accountinfo">
	<img id="accountpic" src="<?php if(isset($_SESSION['user']['profilepic']))
						echo "../" . $_SESSION['user']['profilepic'];
						else echo "../images/default.png"?>" alt="profile pic">
					<div id="accountname"> <?php echo $_SESSION['user']['username']; ?> </div>
			<div id="uservotes">Available Votes: <?php echo $_SESSION['user']['votecount']; ?> </div>

		<form id="upload" action="../upload.php" method="post" enctype="multipart/form-data">
			<label for="file" id="filelabel"></label>
			<input id="file" class="inputfile" value="Change Pic" type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload Image" name="submit">
		</form>
		<div id='failedProfileImageUpload'>
		<?php
		if(isset($_SESSION['badUpload'])) echo $_SESSION['badUpload'];
		unset($_SESSION['badUpload']);
		?>
		</div>
	</div>
		<div id="faves">
		<div id="favestitle"> Your Favorites </div>
		<?php
			$faves = $dao->getFaves($_SESSION['user']['id']);
			$i = 1;
			foreach($faves as $row) {
			?>
				<div class="catwindow">

				<a href="/allcats/<?php echo $row['cat']; ?>">
				<img class="catprofilepic" src="../allcats/images/<?php echo $row['cat']; ?>/profile.jpg" alt="<?php echo $row['name']; ?>">
				<div class="catwindowname"> <?php echo $i .". " . $row['name']; $i++; ?> </div>
				</a>

				<div class="catwindowvotes"> Your Votes: <?php $id = $_SESSION['user']['id']; echo $row["u$id"]; ?> </div>
				</div>
		<?php }
		?>
	</div>

</div>


<?php include("../footer.php"); ?>
