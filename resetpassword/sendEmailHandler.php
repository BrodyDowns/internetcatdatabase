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
$from = new SendGrid\Email(null, "icatsdb@gmail.com");
$subject = "ICDB Reset Password Link";
$to = new SendGrid\Email(null, $_POST['email']);
$content = new SendGrid\Content("text/html", "Hello " . $userInfo['username'] . ",
<br >
Click the following link to reset password, it will only be available for a limited amount of time:
<br >
internetcatdatabase.herokuapp.com/resetpassword?key=" . $hash);
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
echo "<br > <br >";
echo $response->headers();
echo "<br > <br >";
echo $response->body();



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
