<?php 

session_start();
// ถ้ายังไม่ได้ Login ให้กลับไปหน้า Login
if (empty($_SESSION['logged_in'])) {
    return header("location: ../view/manager/view_manager_login.php");
  }
  
include_once "../model/connect.php";
include_once "../model/method_stmt.php";

$obj = new method_stmt();

    $data = $obj->getAvailableYears();
    // ส่งข้อมูลกลับเป็น JSON
    header('Content-Type: application/json');
    echo json_encode($data);

?>