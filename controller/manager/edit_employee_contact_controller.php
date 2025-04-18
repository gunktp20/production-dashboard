<?php

session_start();
include_once '../../model/connect.php';
include_once '../../model/method_stmt.php';

// เช็คว่าผู้ใช้เข้าสู่ระบบ และ เป็น manager หรือไม่หากไม่จะกลับไปหน้า login
if (empty($_SESSION['logged_in']) || empty($_SESSION['is_manager'])) {
    header("location: ../../view/manager/view_manager_login.php");
}


$obj = new method_stmt();

if (isset($_POST['edit_employee'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nick_name = $_POST['nick_name'];
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : 0;
    $line = isset($_POST['line']) ? $_POST['line'] : 0;
    $email = isset($_POST['email']) ? $_POST['email'] : 0;

   // เช็คว่าข้อมูล ชื่อ นามสกุล ชื่อเล่น เป็นค่าว่างหรือไม่
    if (empty($fname)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อจริง";
        header("location: ../../view/manager/view_edit_employee_contact.php?id=" . $id);
        return;
    } else if (empty($lname)) {
        $_SESSION['error'] = "กรุณากรอก นามสกุล";
        header("location: ../../view/manager/view_edit_employee_contact.php?id=" . $id);
        return;
    } else if (empty($nick_name)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อเล่น";
        header("location: ../../view/manager/view_edit_employee_contact.php?id=" . $id);
        return;
    }

    $result = $obj->editEmployeeContact($id, $fname, $lname, $nick_name, $phone_number, $line, $email);
    if ($result === true) {
        header("location: ../../view/manager/view_employees_contact.php");
    }
} else {
    header("location: ../../index.php");
}
