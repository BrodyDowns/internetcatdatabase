<?php
  $host = getenv("DB_HOST");
  $db = getenv("DB_DB");
  $user = getenv("DB_USER");
  $pass = getenv("DB_PASS");

  //error_log("host: " . $host . "db: " . $db . "user: " . $user);

  //create connection
  $conn = new mysqli($host, $user, $pass, $db);

  //check connection
  if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
  }

  $sql = "DELETE FROM pwd_reset WHERE time_stamp < (CURRENT_TIMESTAMP - INTERVAL 5 MINUTE)";
  $result = $conn->query($sql);
  $conn->close();


 ?>
