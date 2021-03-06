<?php
/* Validates email and generates key to be sent */
session_start();
require_once('../classes/Dao.php');
require '../vendor/autoload.php';

$dao = new Dao();

$userInfo = $dao->getUserEmail($_POST['email']);

//if account exists send email with hash
if(isset($userInfo['email'])) {
  $key = $_POST['email'] . time() . rand();
  $hash = password_hash($key, PASSWORD_BCRYPT);
  $hash = substr($hash, 7, strlen($hash));
  $link = "http://internetcatdatabase.herokuapp.com/resetpassword?key=" . $hash;

  //echo "internetcatdatabase.herokuapp.com/resetpassword?key=" . $hash;

  //check if user was already has existing hash reset
  if(isset($dao->userExistPasswordReset($userInfo['id'])['user_id']))
  {
    $_SESSION['errorMessage'] = "A reset link has already been sent to this email. Please check your inbox or try resetting later.";
    header("Location:../resetpassword");
    exit;
  }

  $dao->insertResetPasswordHash($userInfo['id'], $hash);

//send email
$message = "Hello " . $userInfo['username'] . ",
<br > <br >
Click the following link to reset password, it will only be available for a limited amount of time:
<br > <br >
<a href='" . $link . "'>" . $link . "</a>";

$from = new SendGrid\Email(null, "icatsdb@gmail.com");
$subject = "ICDB Reset Password Link";
$to = new SendGrid\Email(null, $_POST['email']);
$content = new SendGrid\Content("text/html", $message);
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);

/*
echo $response->statusCode();
echo "<br > <br >";
echo $response->headers();
echo "<br > <br >";
echo $response->body();
echo "<br > <br >";
echo $message;
*/

$_SESSION['successMessage'] = "An email has been sent to " . $_POST[email];
header("Location:../resetpassword");
exit;


}
else {
  $_SESSION['errorMessage'] = "No account associated with this email.";
  header("Location:../resetpassword");
  exit;
}


 ?>
