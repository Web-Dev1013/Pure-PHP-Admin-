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

if ($_POST["type"] == "get_survey_page_data") {
  $data = array();
  if (!empty($_SESSION["access_code"])) {
    $access_code = $_SESSION["access_code"];
    $level_id = $_SESSION["level_id"];
    $surveypage_table = "level" . $level_id . "surveypages";
    $customcategories_table = "level" . $level_id . "customcategories";
    $customtemplate_id = "level" . $level_id . "customcategories_template_id";
    try {
      $data = array();
      $stmt = $conn->prepare("SELECT a.surveypage_id FROM surveypageorder AS a
    LEFT JOIN surveycode AS b ON b.id = a.surveycode_id
    WHERE b.survey_code_hash = '$access_code'");
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        $sc_id_result = $stmt->fetchAll();
        foreach ($sc_id_result as $key => $temp) {
          $sp_id = $temp["surveypage_id"];
          $sp_id_query = $conn->prepare("SELECT a.*,b.id AS page_id, b.survey_page_tagline_user AS tagline, b.survey_page_header_user AS page_name, b.survey_page_currency AS currency, b.survey_page_separator AS `separator`, b.survey_page_decimals AS `decimal`, b.survey_page_unit AS unit FROM $customcategories_table AS a
        LEFT JOIN $surveypage_table AS b ON b.$customtemplate_id=a.base_template_id 
        LEFT JOIN surveycode AS c ON c.id = a.survey_code_id
        WHERE b.id = '$sp_id' AND c.survey_code_hash = '$access_code' AND a.is_hidden = '0'");
          $sp_id_query->execute();
          $sp_data = array();
          $i = 0;
          if ($sp_id_query->rowCount() > 0) {
            $sp_id_query_result = $sp_id_query->fetchAll();
            foreach ($sp_id_query_result as $temp) {
              $sp_data[$i]["id"] = $temp["id"];
              $sp_data[$i]["tagline"] = $temp["tagline"];
              $sp_data[$i]["page_name"] = $temp["page_name"];
              $sp_data[$i]["page_id"] = $temp["page_id"];
              $sp_data[$i]["category_code"] = $temp["category_code"];
              $sp_data[$i]["flag_id"] = $temp["flag_id"];
              $sp_data[$i]["icon_url"] = $temp["icon_url"];
              $sp_data[$i]["name"] = $temp["name"];
              $sp_data[$i]["value_load"] = $temp["value_load"];
              $sp_data[$i]["currency"] = $temp["currency"];
              $sp_data[$i]["separator"] = $temp["separator"];
              $sp_data[$i]["decimal"] = $temp["decimal"];
              $sp_data[$i]["unit"] = $temp["unit"];
              $i++;
            }
          }
          $data[$key] = $sp_data;
        }
        echo json_encode($data);
      }
    } catch (PDOException $e) {
      echo "failed" . $e->getMessage();
    }
  }
}

if ($_POST["type"] == "add_category") {
  $recommend = $_POST["recommend"];
  $level_id = $_SESSION["level_id"];
  $access_code = $_SESSION["access_code"];
  $page_id = $_POST["page_id"];
  $recommend_table = "level" . $level_id . "recommend";
  $recommend_id = "level" . $level_id . "customcategories_id";
  $surveypage_table = "level" . $level_id . "surveypages";
  $customtemplate_id = "level" . $level_id . "customcategories_template_id";
  $date = date_create();
  $created_at = date_timestamp_get($date);
  try {
    $exist_query = $conn->prepare("SELECT a.id, a.survey_login_id, b.$customtemplate_id AS customcategories_id FROM surveycode AS a
    LEFT JOIN $surveypage_table AS b ON b.survey_code_id = a.id
    WHERE a.survey_code_hash='$access_code' AND b.id='$page_id'");
    $exist_query->execute();
    if ($exist_query->rowCount() > 0) {
      $query_result = $exist_query->fetchAll();
      foreach ($query_result as $temp) {
        $sl_id = $temp["survey_login_id"];
        $sc_id = $temp["id"];
        $template_id = $temp["customcategories_id"];
      }
    }
    $stmt = $conn->prepare("INSERT INTO $recommend_table SET created_at='$created_at', survey_code_id='$sc_id', survey_login_id='$sl_id', template_id='$template_id', $recommend_id='$template_id', recommend='$recommend'");
    $stmt->execute();
    echo "success";
  } catch (PDOException $e) {
    echo "failed" . $e->getMessage();
  }
}

if($_POST["type"] == "feedback-submit"){
  $feedback = $_POST["feedback"];
  $level_id = $_SESSION["level_id"];
  $access_code = $_SESSION["access_code"];
  $page_id = $_POST["page_id"];
  $feedback_table = "level" . $level_id . "feedback";
  $feedback_id = "level" . $level_id . "customcategories_id";
  $surveypage_table = "level" . $level_id . "surveypages";
  $customtemplate_id = "level" . $level_id . "customcategories_template_id";
  $date = date_create();
  $created_at = date_timestamp_get($date);
  try {
    $exist_query = $conn->prepare("SELECT a.id, a.survey_login_id, b.$customtemplate_id AS customcategories_id FROM surveycode AS a
    LEFT JOIN $surveypage_table AS b ON b.survey_code_id = a.id
    WHERE a.survey_code_hash='$access_code' AND b.id = '$page_id'");
    $exist_query->execute();
    if ($exist_query->rowCount() > 0) {
      $query_result = $exist_query->fetchAll();
      foreach ($query_result as $temp) {
        $sl_id = $temp["survey_login_id"];
        $sc_id = $temp["id"];
        $template_id = $temp["customcategories_id"];
      }
    }
    $stmt = $conn->prepare("INSERT INTO $feedback_table SET created_at='$created_at', survey_code_id='$sc_id', survey_login_id='$sl_id', template_id='$template_id', $feedback_id='$template_id', feedback='$feedback'");
    $stmt->execute();
    echo "success";
  } catch (PDOException $e) {
    echo "failed" . $e->getMessage();
  }
}


// Change value
if($_POST["type"] == "change_value"){
  $category_id = $_POST["category_id"];
  $value = $_POST["value"];
  $level_id = $_SESSION["level_id"];
  $customcategories = "level".$level_id."customcategories";
  try{
    $query = $conn->prepare("UPDATE $customcategories SET value_load='$value' WHERE id='$category_id'");
    $query->execute();
  }catch(PDOException $e){
    echo "failed".$e->getMessage();
  }
}