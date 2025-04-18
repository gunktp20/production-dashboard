<?php 

    session_start();
    include_once '../../model/connect.php';
    include_once '../../model/method_stmt.php';
     // เช็คว่าผู้ใช้เข้าสู่ระบบ และ เป็น manager หรือไม่หากไม่จะกลับไปหน้า login
    if(empty($_SESSION['logged_in']) || empty($_SESSION['is_manager'])){
        header("location: ../../view/manager/view_manager_login.php");
    }

    $id = $_GET['id'];

    $obj = new method_stmt();
    // ส่ง id เพื่อนำไปใช้ในการบอกว่าจะลบข่าวสารตัวไหน
    $result = $obj->deleteAnnounce($id);
    if($result == true){
        // กลับไปยังหน้าดูข่าวสารทั้งหมด
        header("location: ../../view/manager/view_announces.php");
    }
?>