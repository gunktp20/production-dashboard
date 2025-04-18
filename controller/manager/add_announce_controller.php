<?php

    session_start();
    include_once '../../model/connect.php';
    include_once '../../model/method_stmt.php';

    // เช็คว่าผู้ใช้เข้าสู่ระบบ และ เป็น manager หรือไม่หากไม่จะกลับไปหน้า login
    if(empty($_SESSION['logged_in']) || empty($_SESSION['is_manager'])){
        header("location: ../../view/manager/view_manager_login.php");
    }
    
    $obj = new method_stmt();

    if(isset($_POST['add_announce'])){
        $announce = $_POST['announce'];
        // เช็คว่าข้อมูล ข่าวสาร ที่ส่งมาเป็นค่าว่างหรือไม่
        if(empty($announce)){
            $_SESSION['error'] = "กรุณากรอก ข่าวสาร";
            header("location: ../../view/manager/view_add_announce.php"); 
            return;
        }
        // หากข้อมูลถูกส่งมาจะนำไปเพิ่มประกาศ
        $result = $obj->addAnnounce($announce);
        if($result === true){
            // และกลับไปหน้าข่าวสารประกาศทั้งหมด
            header("location: ../../view/manager/view_announces.php"); 
        }
    
    }else{
        header("location: ../../index.php");
    }
?>