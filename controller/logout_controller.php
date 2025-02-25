<?php
    // ลบ SESSION ออกทั้งหมดเพื่อเป็นการออกจากระบบ และ กลับไปหน้า Login
    session_start();
    session_unset();
    header("location: ../index.php");
    
?>