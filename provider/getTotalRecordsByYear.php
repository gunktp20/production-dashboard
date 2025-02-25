<?php

session_start();

if (empty($_SESSION['logged_in'])) {
    return header("location: ../view/manager/view_manager_login.php");;
}

include_once "../model/connect.php";
include_once "../model/method_stmt.php";

$obj = new method_stmt();

$table = isset($_GET['table']) ? (string)$_GET['table'] : null;
$month1 = isset($_GET['month1']) ? (int)$_GET['month1'] : null;
$month2 = isset($_GET['month2']) ? (int)$_GET['month2'] : null;
$year1 = isset($_GET['year1']) ? (int)$_GET['year1'] : null;
$year2 = isset($_GET['year2']) ? (int)$_GET['year2'] : null;

try {
    switch ($table) {
        case "production01":
            $data = $obj->getQuantityProduction1WithMonthAndYear($month1, $year1);
            $data2 = $obj->getQuantityProduction1WithMonthAndYear($month2, $year2);
            break;
        case "production02":
            $data = $obj->getQuantityProduction2WithMonthAndYear($month1, $year1);
            $data2 = $obj->getQuantityProduction1WithMonthAndYear($month2, $year2);
            break;
        case "production03":
            $data = $obj->getQuantityProduction3WithMonthAndYear($month1, $year1);
            $data2 = $obj->getQuantityProduction1WithMonthAndYear($month2, $year2);
            break;
        case "production04":
            $data = $obj->getQuantityProduction4WithMonthAndYear($month1, $year1);
            $data2 = $obj->getQuantityProduction1WithMonthAndYear($month2, $year2);
            break;
        default:
            echo json_encode(["error" => "Invalid table"]);
            exit;
    }

    echo json_encode(["data" => $data, "data2" => $data2]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

// if ($month1 && $year1 && $month2 && $year2) {
//     $data = $obj->getRecordsBySelectedYears($month1, $month2 , $year1, $year2);

//     header('Content-Type: application/json');
//     echo json_encode($data);
// } else {
//     header('Content-Type: application/json');
//     echo json_encode(['error' => 'Invalid years provided.']);
// }
