<?php

session_start();
include_once '../../model/connect.php';
include_once '../../model/method_stmt.php';

// เช็คว่าผู้ใช้เข้าสู่ระบบ และ เป็น manager หรือไม่หากไม่จะกลับไปหน้า login
if (empty($_SESSION['logged_in']) || empty($_SESSION['is_manager'])) {
    header("location: ../../view/manager/view_manager_login.php");
}

$obj = new method_stmt();

if (isset($_POST['add_employee'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nick_name = $_POST['nick_name'];
    $password = $_POST['password'];
    // เช็คว่าชื่อถูกกรอกหรือไม่
    if (empty($fname)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อจริง";
        header("location: ../../view/manager/view_add_employee.php");
        return;
        // เช็คว่านามสกุลถูกกรอกหรือไม่
    } else if (empty($lname)) {
        $_SESSION['error'] = "กรุณากรอก นามสกุล";
        header("location: ../../view/manager/view_add_employee.php");
        return;
        // เช็คว่าชื่อเล่นถูกกรอกหรือไม่
    } else if (empty($nick_name)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อเล่น";
        header("location: ../../view/manager/view_add_employee.php");
        return;
        // เช็คว่ารหัสผ่านถูกกรอกหรือไม่
    } else if (empty($password)) {
        $_SESSION['error'] = "กรุณากรอก รหัสผ่าน";
        header("location: ../../view/manager/view_add_employee.php");
        return;
    }
    // หากข้อมูลครบทำการเพิ่มลงฐานข้อมูล
    $result = $obj->addEmployee($fname, $lname, $nick_name, $password);
    if ($result === true) {
        header("location: ../../view/manager/view_employees.php");
    }
} else {
    header("location: ../../index.php");
}
