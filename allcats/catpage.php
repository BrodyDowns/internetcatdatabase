<?php
	include('header.php');
	require_once 'classes/Dao.php';
	require_once 'classes/Render.php';
	$dao = new Dao();
	$cat = $_SESSION['currentcat'];
	$catInfo = $dao->getCatInfo($cat);
?>

<div class="content">

	<h1><?php echo $catInfo['name'] ?></h1>
	<img id="mainpic"   src="images/<?php echo $catInfo['cat']; ?>/main.jpg" alt="<?php echo $catInfo['name']; ?>">
	<div id="votesection">
		<img id="votebut" data-action="<?php echo $catInfo['cat']; ?>"  src="/images/vote.png" alt="VOTE!">
		<span id="votecount"><span id="<?php echo $catInfo['cat']; ?>votes"><?php echo $catInfo['votecount'] ?></span> Votes</span>

	</div>

	<div class="socialmedia">
		<?php
		$first = true;
		if(isset($catInfo['youtube'])) { ?>
			<a href="<?php echo $catInfo['youtube'] ?>" >
			<img class="<?php if($first) echo "firsticon"; else echo "icon"; $first=false; ?>" src="/icon/youtube.png" alt="YouTube">
			</a>
		<?php } ?>


		<?php
		if(isset($catInfo['facebook'])) { ?>
			<a href="<?php echo $catInfo['facebook'] ?>">
				<img class="<?php if($first) echo "firsticon"; else echo "icon"; $first=false; ?>" src="/icon/facebook.png" alt="Facebook">
			</a>
		<?php } ?>

		<?php
		if(isset($catInfo['ig'])) { ?>
			<a href="<?php echo $catInfo['ig'] ?>">
				<img class="<?php if($first) echo "firsticon"; else echo "icon"; $first=false; ?>" src="/icon/ig.png" alt="Instagram">
			</a>
		<?php } ?>


		<?php
		if(isset($catInfo['twitter'])) { ?>
			<a href="<?php echo $catInfo['twitter'] ?>">
				<img class="<?php if($first) echo "firsticon"; else echo "icon"; $first=false; ?>" src="/icon/twitter.png" alt="twitter">
			</a>
		<?php } ?>




	</div>


	<div class="bio">
		<p id="biography"><span class="biotitle">Biography:</span> <?php echo $catInfo['bio']; ?> </p>
		<p id="breed"><span class="biotitle">Breed: </span><?php echo $catInfo['breed']; ?></p>
	</div>

	<div class="comments">
		<form id="commentsform" method="POST" action='commenthandler.php' enctype="multipart/form-data">
			<label for="comment" id="commentLabel">Comment: </label>
			<textarea id="commentinput" name="comment"></textarea>
			<?php $_SESSION['lastcat'] = $catInfo['cat']; ?>
			<input type="submit">

			<span id="commenterror"> <?php echo $_SESSION['commenterror']; unset($_SESSION['commenterror']); ?></span>
		</form>

		<?php
			$comments = $dao->getComments($catInfo['cat']);
		 	Render::renderComments($comments);

		?>
	</div>

</div>

<?php
    include('footer.php');
?>
