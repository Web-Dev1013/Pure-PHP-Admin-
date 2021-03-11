<?php
session_start();

include("../admin/common/env.php");
$db_host = getenv("DB_HOST");
$db_username = getenv("DB_USERNAME");
$db_password = getenv("DB_PASSWORD");
$db_name = getenv("DB_NAME");

$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($_POST['type'] == "login") {
  $entry_code = $_POST['entry_code'];
  $password = $_POST['password'];
  $access_code = $_POST['access_code'];
  try {
    $stmt = $conn->prepare("SELECT id FROM surveylogin WHERE username_hash='$entry_code' AND password_hash = '$password'");
    $stmt->execute();
    $result_data = array();
    if ($stmt->rowCount() > 0) {
      $date = date_create();
      $time = date_timestamp_get($date);
      $date_time = date("Y:m:d h:i:sa");
      $user_query = $conn->prepare("SELECT a.id,a.level_id, c.first_name, c.last_name FROM surveylogin AS a
      LEFT JOIN surveycode AS b ON a.id = b.survey_login_id 
      LEFT JOIN `user` AS c ON a.user_id = c.id
      WHERE a.username_hash='$entry_code' AND a.password_hash = '$password' AND b.survey_code_hash = '$access_code'");
      $user_query->execute();
      if ($user_query->rowCount() > 0) {
        $available = $conn->prepare("SELECT created_at, max_responses, expire_date FROM surveycode WHERE survey_code_hash = '$access_code'");
        $available->execute();
        if ($available->rowCount() > 0) {
          $available_temp = $available->fetchAll();
          foreach ($available_temp as $temp) {
            $created_at = $temp["created_at"];
            $max_responses = $temp["max_responses"];
            $expire_date = $temp["expire_date"];
          }
          $responses_temp = ($time - $created_at) / 86400;
          $expire_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $expire_date);
          if ($expire_timestamp === false) {
            die("Incorrect date string");
          } else {
            $expire_timestamp = $expire_timestamp->getTimestamp();
          }
          if (($responses_temp <= $max_responses || $max_responses == 0) && ($expire_timestamp < 0 || $time <= $expire_timestamp)) {
            $result = $user_query->fetchAll();
            foreach ($result as $temp) {
              $result_data["first_name"] = $temp["first_name"];
              $result_data["last_name"] = $temp["last_name"];
              $result_data["level_id"] = $temp["level_id"];
            }
            $_SESSION["access_code"] = $access_code;
            $_SESSION["user_name"] = $result_data["first_name"] . " " . $result_data["last_name"];
            $_SESSION["level_id"] = $result_data["level_id"];
            echo json_encode($result_data);
          }else{
            echo "expired";
          }
        }
      } else {
        echo "failed_access_code";
      }
    } else {
      echo "failed_user";
    }
  } catch (PDOException $e) {
    echo "failed" . $e->getMessage();
  }
}
if ($_POST['type'] == "logout") {
  session_destroy();
  echo "success";
}

$conn = null;
