<?php
/*handler for uploading image*/
session_start();


require_once 'classes/Dao.php';
require('vendor/autoload.php');
$dao = new Dao();

$target_dir = "userProfilePictures/";
$target_file = $target_dir . $_SESSION['user']['id'];

$uploadOk = 1;
$imageFileType = pathinfo($_FILES["fileToUpload"]["name"] , PATHINFO_EXTENSION);

$target_file = $target_file . "." . $imageFileType;
echo $_FILES["fileToUpload"]["name"];

echo $target_file . "<br />";
echo $_FILES["fileToUpload"]["tmp_name"] . "<br />";

if(isset($_POST["submit"])){
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . "<br />";
		$imagesize = filesize($_FILES["fileToUpload"]["tmp_name"]);
		if($imagesize > 1048576) {
			echo "File is too large";
			$_SESSION['badUpload'] = "FILE TOO LARGE";
			$uploadOk = 0;
		}
		else
			$uploadOk = 1;
	} else {
		echo "File is not an image.<br />";
		$_SESSION['badUpload'] = "Error uploading - Limit images to 1MB";
		$uploadOk = 0;
	}

}



if ($uploadOk == 0) {
	echo "Sorry, your file was no uploaded.<br />";
} else {
	/*
	try {
		// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
		$s3 = Aws\S3\S3Client::factory(array('key'=>'', 'secret'=>'', 'signature' => 'v4', 'region'=>'us-east-2'));
		$bucket = 'icdbuploads';
		$upload = $s3->upload($bucket, $target_file, fopen($_FILES['fileToUpload']['tmp_name'], 'rb'), 'public-read');
		echo "File uploaded: " . htmlspecialchars($upload->get('ObjectURL'));
		$dao->adduserpic($_SESSION['user']['id'], htmlspecialchars($upload->get('ObjectURL')));
		$_SESSION['user']['profilepic'] = htmlspecialchars($upload->get('ObjectURL'));

	}
	catch(Exception $e) {
		echo "Upload error";
		$_SESSION['badUpload'] = "ERROR UPLOADING. MAX FILE SIZE 1MB";
	}
*/
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

		$dao->adduserpic($_SESSION['user']['id'], $target_file);

		echo "<br />" . $target_file . "<br />";

		$_SESSION['user']['profilepic'] = $target_file;
		echo "The file " . basename($_FILES["fileToUpload"]["name"]) . "has been uploaded.<br />";
	}
}



/*
	header("Location:/manageaccount");
	exit;
*/

?>
