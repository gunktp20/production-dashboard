<?php

session_start();
include_once '../../model/connect.php';
include_once '../../model/method_stmt.php';

$obj = new method_stmt();

if (isset($_POST['login_manager'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // เช็คค่าว่า ชื่อผู้ใช้และรหัสผ่านถูกกรอกมาหรือไม่
    if (empty($username)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อผู้ใช้ และ รหัสผ่านให้ครบถ้วน";
        header("location: ../../view/manager/view_manager_login.php");
        return;
    } else if (empty($password)) {
        $_SESSION['error'] = "กรุณากรอก ชื่อผู้ใช้ และ รหัสผ่านให้ครบถ้วน";
        header("location: ../../view/manager/view_manager_login.php");
        return;
    } else {
        // หากข้อมูลครบทำการ Login
        // $result = $obj->loginManager($username, $password);
        if ($username == "manager" && $password == "password123") {
            $result = true;
        } else {
            $result = false;
        }
        if ($result == true) {
            // ทำการเก็บ SESSION ไว้เพื่อบอกว่าผู้ใช้ เข้าสู่ระบบแล้ว และ เป็น manager
            $_SESSION['logged_in'] = true;
            header("location: ../../view/manager/view_overview.php");
        } else {
            // หากไม่ถูกต้องแสดงข้อความว่ารหัสไม่ถูกต้อง
            $_SESSION['error'] = "ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง";
            header("location: ../../view/manager/view_manager_login.php");
        }
    }
} else {
    header("location: ../../index.php");
}
