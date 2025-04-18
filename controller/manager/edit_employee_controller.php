<?php

session_start();
include_once '../../model/connect.php';
include_once '../../model/method_stmt.php';
// เช็คว่าผู้ใช้เข้าสู่ระบบ และ เป็น manager หรือไม่หากไม่จะกลับไปหน้า login
if(empty($_SESSION['logged_in']) || empty($_SESSION['is_manager'])){
    header("location: ../../view/manager/view_manager_login.php");
}

$obj = new method_stmt();

if (isset($_POST['edit_employee'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nick_name = $_POST['nick_name'];
    $wage_per_date = isset($_POST['wage_per_date']) ? $_POST['wage_per_date'] : 0;
    $num_of_work_date = isset($_POST['num_of_work_date']) ? $_POST['num_of_work_date'] : 0;
    $num_of_ot_hours = isset($_POST['num_of_ot_hours']) ? $_POST['num_of_ot_hours'] : 0;
    $ot_per_hour = isset($_POST['ot_per_hour']) ? $_POST['ot_per_hour'] : 0;
    $shift_fee = isset($_POST['shift_fee']) ? $_POST['shift_fee'] : 0;
    // เช็คว่าข้อมูล ชื่อ นามสกุล ชื่อเล่น เป็นค่าว่างหรือไม่
    if (empty($fname)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อจริง";
        header("location: ../../view/manager/view_edit_employee.php?id=". $id);
        return;
    } else if (empty($lname)) {
        $_SESSION['error'] = "กรุณากรอก นามสกุล";
        header("location: ../../view/manager/view_edit_employee.php?id=". $id);
        return;
    } else if (empty($nick_name)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อเล่น";
        header("location: ../../view/manager/view_edit_employee.php?id=". $id);
        return;
    } 

    $result = $obj->editEmployee($id,$fname, $lname, $nick_name, $wage_per_date, $num_of_work_date, $num_of_ot_hours, $ot_per_hour, $shift_fee);
    if ($result === true) {
        header("location: ../../view/manager/view_employees.php");
    }

} else {
    header("location: ../../index.php");
}
?>