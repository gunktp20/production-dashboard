<!DOCTYPE html>
<?php
session_start();

if (empty($_SESSION['logged_in'])) {
  return header("location: ./view_employee_login.php");
}

if (isset($_SESSION['logged_in']) && isset($_SESSION['is_manager'])) {
  return header("location: ../manager/view_employees.php");
}

include_once "../../model/connect.php";
include_once "../../model/method_stmt.php";

$obj = new method_stmt();
$employee_id = $_SESSION["is_employee"];
$employee = $obj->getEmployeeById($employee_id);
$announces = $obj->getAllAnnounces();
?>

<html lang="th">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../index.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ข้อมูลพนักงาน</title>
</head>

<body class="bg-gray-100 font-sans">
  <!-- Modal -->
  <div id="myModal" class="fixed inset-0 bg-black bg-opacity-30 hidden items-center justify-center z-50">
    <div class="bg-white m-auto w-full max-w-lg p-6 rounded-lg shadow-xl relative top-20">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">📢 ข่าวสารทั้งหมด</h2>
      <button id="closeModalBtn" class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-lg font-bold">X</button>
      <div class="space-y-2 max-h-60 overflow-y-auto">
        <?php foreach ($announces as $row): ?>
          <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-md border border-blue-200 shadow-sm">
            <?= $row["announce"] ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- ปุ่มเปิด Modal -->
  <div class="fixed top-4 right-4 z-10">
    <button id="openModalBtn" class="bg-white text-white p-3 rounded-full shadow-lg transition">
      <img src="../../images/marketing.png" class="w-6 h-6" alt="ประกาศ">
    </button>
  </div>

  <!-- ข้อมูลพนักงาน -->
  <div class="max-w-4xl mx-auto mt-16 bg-white rounded-xl shadow-lg p-8">
    <h1 class="text-2xl font-semibold text-blue-700 mb-6">👤 ข้อมูลพนักงาน</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <p class="text-gray-500 text-sm">รหัสพนักงาน</p>
        <p class="text-lg font-medium"><?= $employee['id']; ?></p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">ชื่อ-นามสกุล</p>
        <p class="text-lg font-medium"><?= $employee['fname']; ?> - <?= $employee['lname']; ?></p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">ชื่อเล่น</p>
        <p class="text-lg font-medium"><?= $employee['nick_name']; ?></p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">ค่าแรงต่อวัน</p>
        <p class="text-lg font-medium"><?= $employee['wage_per_date']; ?> บาท</p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">จำนวนวันทำงาน</p>
        <p class="text-lg font-medium"><?= $employee['num_of_work_date']; ?> วัน</p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">ค่ากะ</p>
        <p class="text-lg font-medium"><?= $employee['shift_fee']; ?> บาท</p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">OT ต่อชั่วโมง</p>
        <p class="text-lg font-medium"><?= $employee['ot_per_hour']; ?> บาท</p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">จำนวน OT</p>
        <p class="text-lg font-medium"><?= $employee['num_of_ot_hours']; ?> ชั่วโมง</p>
      </div>
      <div>
        <p class="text-gray-500 text-sm">ยอด OT</p>
        <p class="text-lg font-medium"><?= $employee['ot_summary']; ?> บาท</p>
      </div>
      <div class="md:col-span-2">
        <p class="text-gray-500 text-sm">ยอดรวมทั้งหมด</p>
        <p class="text-xl font-bold text-green-600"><?= $employee['total_salary']; ?> บาท</p>
      </div>
    </div>

    <div class="mt-6 text-center">
      <a href="../../controller/logout_controller.php" class="inline-block bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-md transition shadow">
        🚪 ออกจากระบบ
      </a>
    </div>
  </div>

  <script>
    const modal = document.getElementById("myModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");

    openModalBtn.onclick = () => modal.classList.remove("hidden");
    closeModalBtn.onclick = () => modal.classList.add("hidden");

    window.onclick = function(event) {
      if (event.target === modal) {
        modal.classList.add("hidden");
      }
    };
  </script>
</body>

</html>