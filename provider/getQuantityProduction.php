<?php

session_start();
header('Content-Type: application/json');

if (empty($_SESSION['logged_in'])) {
  return header("location: ../view/manager/view_manager_login.php");;
}

include_once "../model/connect.php";
include_once "../model/method_stmt.php";

$obj = new method_stmt();

$table = isset($_GET['table']) ? (string)$_GET['table'] : null;
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;

if (!$month || !$year || !$table) {
  echo json_encode(["error" => "Missing parameters"]);
  exit;
}

try {
  switch ($table) {
    case "production01":
      $data = $obj->getQuantityProduction1WithMonthAndYear($month, $year);
      break;
    case "production02":
      $data = $obj->getQuantityProduction2WithMonthAndYear($month, $year);
      break;
    case "production03":
      $data = $obj->getQuantityProduction3WithMonthAndYear($month, $year);
      break;
    case "production04":
      $data = $obj->getQuantityProduction4WithMonthAndYear($month, $year);
      break;
    default:
      echo json_encode(["error" => "Invalid table"]);
      exit;
  }

  echo json_encode($data);
} catch (Exception $e) {
  echo json_encode(["error" => $e->getMessage()]);
  exit;
}