<?php

session_start();

// ถ้ายังไม่ได้ Login ให้กลับไปหน้า Login
if (empty($_SESSION['logged_in'])) {
  return header("location: ../manager/view_manager_login.php");
}

include_once "../../model/connect.php";
include_once "../../model/method_stmt.php";

$obj = new method_stmt();
// เรียกดูข้อมูลพนักงานทั้งหมด
$total_quantity_prod1 = $obj->getTotalProduction1Quantity();
$total_quantity_prod2 = $obj->getTotalProduction2Quantity();
$total_quantity_prod3 = $obj->getTotalProduction3Quantity();
$total_quantity_prod4 = $obj->getTotalProduction4Quantity();
$total_quantity_prod5 = $obj->getTotalProduction5Quantity();
// $no = 1

$pronum_quantity_sums = $obj->getTotalProductionByProNum();

$obj = new method_stmt();
// เรียกดูข้อมูลพนักงานทั้งหมด
$result2 = $obj->getAllEmployees();
$no = 1
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Employee-system</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-family-karla flex">

  <aside class="relative bg-white h-screen w-[350px] hidden sm:block shadow-xl">
    <div class="p-6">
      <a href="#" class="text-[#4195fc] text-3xl font-semibold uppercase hover:text-[#4195fc]">Admin</a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
      <a href="./view_analysis.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fa-solid fa-chart-pie mr-3"></i>
        ภาพรวม & วิเคราะห์ยอดการผลิต
      </a>
      <!-- <a href="./view_compare_data.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fa-solid fa-chart-line mr-3"></i>
        เปรียบเทียบ
      </a> -->
      <a href="#" class="flex items-center py-4 pl-4 nav-item text-[#4195fc] text-sm bg-[#e9f3ff]">
        <i class="far fa-address-book mr-3"></i>
        รายชื่อพนักงาน
      </a>
      <a href="./view_add_employee.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="far fa-address-card mr-3"></i>
        เพิ่มข้อมูลพนักงาน
      </a>
      <a href="./view_employees_contact.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fas fa-phone mr-3"></i>
        ช่องทางการติดต่อพนักงาน
      </a>
      <a href="./view_employees_bank.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fas fa-piggy-bank mr-3"></i>
        บัญชีธนาคารพนักงาน
      </a>
      <a href="./view_announces.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fas fa-bullhorn mr-3"></i>
        ประชาสัมพันธ์ข่าวสาร
      </a>
      <a href="./view_add_announce.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fas fa-edit mr-3"></i>
        เพิ่ม ประชาสัมพันธ์ข่าวสาร
      </a>
    </nav>
  </aside>


  <div class="w-full flex flex-col h-screen overflow-y-hidden">
    <!-- Desktop Header -->
    <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
      <div class="w-1/2"></div>
      <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
        <i @click="isOpen = !isOpen" class="fa-solid fa-circle-user text-[35px] text-blue-600"></i>
        <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
        <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-12">
          <a href="#" class="block px-4 py-3 account-link hover:text-blue-500 transition-all text-sm">บัญชีของคุณ</a>
          <a href="#" class="block px-4 py-3 account-link hover:text-blue-500 transition-all text-sm">ช่วยเหลือ</a>
          <a class="block px-4 py-3 account-link hover:text-blue-500 transition-all text-sm" href="../../controller/logout_controller.php">ออกจากระบบ</a>
        </div>
      </div>
    </header>

    <!-- Mobile Header & Nav -->
    <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden bg-white">
      <div class="flex items-center justify-between">
        <a href="index.html" class="text-[#4195fc] text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        <button @click="isOpen = !isOpen" class="text-[#4195fc] text-3xl focus:outline-none">
          <i x-show="!isOpen" class="fas fa-bars"></i>
          <i x-show="isOpen" class="fas fa-times"></i>
        </button>
      </div>

      <!-- Dropdown Nav -->
      <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4 bg-white">
        <a href="./view_overview.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-pie mr-3"></i>
          ภาพรวม
        </a>
        <a href="./view_analysis.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-column mr-3"></i>
          วิเคราะห์ยอดการผลิต
        </a>
        <a href="./view_compare_data.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-line mr-3"></i>
          เปรียบเทียบ
        </a>
        <a href="#" class="flex items-center py-4 pl-4 nav-item text-[#4195fc] text-sm bg-[#e9f3ff]">
          <i class="far fa-address-book mr-3"></i>
          รายชื่อพนักงาน
        </a>
        <a href="./view_add_employee.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="far fa-address-card mr-3"></i>
          เพิ่มข้อมูลพนักงาน
        </a>
        <a href="./view_employees_contact.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-phone mr-3"></i>
          ช่องทางการติดต่อพนักงาน
        </a>
        <a href="./view_employees_bank.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-piggy-bank mr-3"></i>
          บัญชีธนาคารพนักงาน
        </a>
        <a href="#" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-cogs mr-3"></i>
          ช่วยเหลือ
        </a>
        <a href="#" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-user mr-3"></i>
          บัญชีของฉัน
        </a>
        <a href="../../controller/logout_controller.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-sign-out-alt mr-3"></i>
          ออกจากระบบ
        </a>
      </nav>
    </header>


    <?php if (empty($result2)) : ?>
      <div class="w-full flex justify-center items-center p-10 bg-gray-100 rounded-md">
        <div class="text-center text-gray-600">
          <p class="text-2xl font-semibold mb-2">🔍 ยังไม่มีข้อมูลพนักงานในระบบ</p>
          <p class="text-base">กรุณาเพิ่มข้อมูลพนักงานเพื่อเริ่มต้นใช้งานระบบได้อย่างสมบูรณ์</p>
          <a href="./view_add_employee.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            + เพิ่มข้อมูลพนักงาน
          </a>
        </div>
      </div>
    <?php else : ?>

      <div class="w-full overflow-x-hidden border-t flex flex-col">
        <main class="w-full flex-grow p-6">
          <h1 class="text-3xl text-black pb-6">รายชื่อพนักงาน</h1>

          <div class="flex flex-wrap">
            <table id="employee" class="bg-white shadow rounded w-full text-sm">
              <tr class="bg-blue-400 text-white">
                <th>รหัส</th>
                <th>ชื่อ-นามสกุล</th>
                <th>ชื่อเล่น</th>
                <th>จำนวนวันลา</th>
                <th>ค่าแรง / วัน</th>
                <th>จำนวนวัน</th>
                <th>บวกค่ากะ</th>
                <th>OT / ชั่วโมง</th>
                <th>จำนวน OT</th>
                <th>ยอดเงิน OT</th>
                <th>ยอดรวม</th>
                <th>ตัวเลือก</th>
              </tr>
              <?php foreach ($result2 as $row) : ?>
                <tr>
                  <td><?= $row["id"] ?></td>
                  <td><?= $row["fname"] ?>-<?= $row["lname"] ?></td>
                  <td><?= $row["nick_name"] ?></td>
                  <td><?= $row["leave_days"] ?></td>
                  <td><?= $row["wage_per_date"] ?></td>
                  <td><?= $row["num_of_work_date"] ?></td>
                  <td><?= $row["shift_fee"] ?></td>
                  <td><?= $row["ot_per_hour"] ?></td>
                  <td><?= $row["num_of_ot_hours"] ?></td>
                  <td><?= $row["ot_summary"] ?></td>
                  <td><?= $row["total_salary"] ?></td>
                  <td class="option-col">
                    <a class="edit-btn" href="./view_edit_employee.php?id=<?= $row['id'] ?>">แก้ไข</a>
                    <button class="delete-btn" data-id="<?= $row["id"] ?>">ลบ</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </main>
      </div>




    <?php endif; ?>


  </div>

  <!-- AlpineJS -->
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function() {
        const itemId = this.getAttribute('data-id');

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
          text: "คุณต้องการลบพนักงานคนนี้หรือไม่",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ลบเลย!',
          cancelButtonText: 'ยกเลิก'
        }).then((result) => {
          if (result.isConfirmed) {
            // Send delete request to server
            window.location.href = `../../controller/manager/delete_employee_controller.php?id=${itemId}`;
          }
        });
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>