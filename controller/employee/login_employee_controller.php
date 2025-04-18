<?php

    session_start();
    include_once '../../model/connect.php';
    include_once '../../model/method_stmt.php';
    
    $obj = new method_stmt();

    if(isset($_POST['login_employee'])){
        $id = $_POST['id'];
        $password = $_POST['password'];
        // เช็คว่าผู้ใช้ได้่ส่งข้อมูลมาครบหรือไม่ ได้แก่ รหัสพนักงาน กับ รหัสผ่าน
        if(empty($id)){
            $_SESSION['error'] = "กรุณากรอก รหัสพนักงาน";
            header("location: ../../view/employee/view_employee_login.php"); 
            return;
        }else if(empty($password)){
            $_SESSION['error'] = "กรุณากรอก รหัสผ่าน";
            header("location: ../../view/employee/view_employee_login.php"); 
            return;
        }else{ 
            // หากกรอกข้อมูลครบให้ทำการเข้าสู่ระบบ
            $result = $obj->loginEmployee($id,$password);
            if($result == true){
                // เก็บ SESSION ไว้เพื่อเอาไว้เช็คว่าผู้ใช้เข้าสู่ระบบแล้วหรือยัง และ เก็บรหัสพนักงานไว้ด้วย
                $_SESSION['logged_in'] = true;
                $_SESSION['is_employee'] = $id;
                header("location: ../../view/employee/view_employee_info.php"); 
            }else{
                // หากรหัสผ่านไม่ถูกต้องจะแจ้ง error กลบไป
                $_SESSION['error'] = "หมายเลขพนักงาน หรือ รหัสผ่านไม่ถูกต้อง";
                header("location: ../../view/employee/view_employee_login.php"); 
            }
        }

       
    }else{
        header("location: ../../index.php");
    }
?>