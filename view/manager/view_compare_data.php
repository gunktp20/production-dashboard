<?php

session_start();

// ถ้ายังไม่ได้ Login ให้กลับไปหน้า Login
if (empty($_SESSION['logged_in'])) {
  return header("location: ../manager/view_manager_login.php");
}

include_once "../../model/connect.php";
include_once "../../model/method_stmt.php";

$obj = new method_stmt();

$total_quantity_prod1 = $obj->getTotalProduction1Quantity();
$total_quantity_prod2 = $obj->getTotalProduction2Quantity();
$total_quantity_prod3 = $obj->getTotalProduction3Quantity();
$total_quantity_prod4 = $obj->getTotalProduction4Quantity();
$total_quantity_prod5 = $obj->getTotalProduction5Quantity();
// $no = 1

$pronum_quantity_sums = $obj->getTotalProductionByProNum();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Employee-system</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      display: flex;
    }
  </style>
</head>

<body class="bg-gray-100 font-family-karla flex">

  <aside class="relative bg-blue-500 h-screen w-[350px] hidden sm:block shadow-xl">
    <div class="p-6">
      <a href="#" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
      <a href="./view_overview.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fa-solid fa-chart-pie mr-3"></i>
        ภาพรวม
      </a>
      <a href="./view_analysis.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fa-solid fa-chart-column mr-3"></i>
        วิเคราะห์
      </a>
      <a href="./view_compare_data.php" class="flex items-center text-white py-4 pl-4 nav-item text-white text-md">
        <i class="fa-solid fa-chart-line mr-3"></i>
        เปรียบเทียบ
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
    <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden bg-blue-500">
      <div class="flex items-center justify-between">
        <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
          <i x-show="!isOpen" class="fas fa-bars"></i>
          <i x-show="isOpen" class="fas fa-times"></i>
        </button>
      </div>

      <!-- Dropdown Nav -->
      <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4 bg-blue-500">
        <a href="#" class="text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-pie mr-3"></i>
          ภาพรวม
        </a>
        <a href="./view_analysis.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-column mr-3"></i>
          วิเคราะห์
        </a>
        <a href="./view_compare_data.php" class="flex items-center text-white py-4 pl-4 nav-item flex items-center ">
          <i class="fa-solid fa-chart-line mr-3"></i>
          เปรียบเทียบ
        </a>
        <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-cogs mr-3"></i>
          ช่วยเหลือ
        </a>
        <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-user mr-3"></i>
          บัญชีของฉัน
        </a>
        <a href="../../controller/logout_controller.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fas fa-sign-out-alt mr-3"></i>
          ออกจากระบบ
        </a>
      </nav>
    </header>

    <div class="w-full overflow-x-hidden border-t flex flex-col">
      <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">การเปรียบเทียบ</h1>


        <div class="flex flex-col w-[100%] gap-4 lg:flex-row">

          <div class="flex bg-white p-5 flex-col w-[100%] shadow-md">
            <div class="flex flex-col gap-3 mb-2">
              <div class="text-sm">เปรียบเทียบยอดการผลิตแต่ละปี</div>

              <div class="flex flex-col lg:flex-row gap-3 mb-2">

                <!-- Sec1 -->
                <div class="flex gap-3 h-[35px] items-center">
                  <div class="text-[14.5px]">การผลิต</div>
                  <select class="border-[1px] w-[180px] border-gray-300 pl-1 h-[100%]" id="item-type">
                    <option value="" default>เลือกชิ้นส่วน</option>
                    <option value="cut">ตัด</option>
                    <option value="cnc">CNC</option>
                    <option value="kz">ข้อเสือ</option>
                    <option value="pab">พับ</option>
                  </select>
                </div>

                <!-- Sec2 -->
                <div class="flex gap-3 h-[35px] items-center">
                  <div class="text-[15.5px]">ระหว่าง เดือน</div>
                  <select class="border-[1px] w-[100px] border-gray-300 pl-1 h-[100%]" id="month1">
                  </select>
                  <div class="text-[15.5px]">ปี</div>
                  <select class="border-[1px] w-[100px] border-gray-300 pl-1 h-[100%]" id="year1">
                  </select>

                </div>

                <!-- Sec3 -->
                <div class="flex gap-3 h-[35px] flex items-center">
                  <div class="text-[15.5px]">และ เดือน</div>
                  <select class="border-[1px] w-[100px] border-gray-300 pl-1 h-[100%]" id="month2">
                  </select>
                  <div class="text-[15.5px]">ปี</div>
                  <select class="border-[1px] w-[100px] border-gray-300 pl-1 h-[100%]" id="year2">
                  </select>
                </div>

                <button id="compare_button" class="bg-blue-500 h-[35px] text-white px-4 hover:bg-blue-600 transition-all text-[15px] h-[100%]">เปรียบเทียบ</button>
              </div>
            </div>

            <div id="note-select-compare-production" class="w-[100%] h-[300px] flex items-center text-[17px] justify-center text-gray-500">
              กรุณาเลือกปีที่จะทำการเปรียบเทียบ
            </div>

            <div id="doughnut-chart-wrapper" class="flex justify-center items-center h-[400px] w-[100%]" style="display: none;">
              <canvas id="doughnut-chart" style="display: none;">
              </canvas>
            </div>

          </div>


        </div>

      </main>

    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    var data = []

    document.addEventListener("DOMContentLoaded", function() {
      const months = [
        "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
        "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
      ];
      const currentYear = new Date().getFullYear();
      const startYear = currentYear - 10;
      const endYear = currentYear + 10;

      function populateSelect(selectId, options) {
        const select = document.getElementById(selectId);
        options.forEach(option => {
          const opt = document.createElement("option");
          opt.value = option;
          opt.textContent = option.toString();
          select.appendChild(opt)
        });
      }


      populateSelect("month1", months);
      populateSelect("month2", months);

      const yearOptions = Array.from({
        length: endYear - startYear + 1
      }, (_, i) => (startYear + i).toString());
      populateSelect("year1", yearOptions);
      populateSelect("year2", yearOptions);

    });

    var month1
    var month2
    var table

    var data1
    var data2
    document.getElementById('compare_button').addEventListener('click', async () => {

      data1 = null
      data2 = null
      month1 = document.getElementById('month1').value;
      month2 = document.getElementById('month2').value;
      const year1 = document.getElementById('year1').value;
      const year2 = document.getElementById('year2').value;

      const itemType = document.getElementById('item-type').value;

      switch (month1) {
        case "ม.ค.":
          month1 = 1;
          break;
        case "ก.พ.":
          month1 = 2;
          break;
        case "มี.ค.":
          month1 = 3
          break;
        case "เม.ย.":
          month1 = 4
          break;
        case "พ.ค.":
          month1 = 5
          break;
        case "มิ.ย.":
          month1 = 6
          break;
        case "ก.ค.":
          month1 = 7
          break;
        case "ส.ค.":
          month1 = 8
          break;
        case "ก.ย.":
          month1 = 9
          break;
        case "ต.ค.":
          month1 = 10
          break;
        case "พ.ย.":
          month1 = 11
          break;
        case "ธ.ค.":
          month1 = 12
          break;
      }

      switch (month2) {
        case "ม.ค.":
          month2 = 1;
          break;
        case "ก.พ.":
          month2 = 2;
          break;
        case "มี.ค.":
          month2 = 3
          break;
        case "เม.ย.":
          month2 = 4
          break;
        case "พ.ค.":
          month2 = 5
          break;
        case "มิ.ย.":
          month2 = 6
          break;
        case "ก.ค.":
          month2 = 7
          break;
        case "ส.ค.":
          month2 = 8
          break;
        case "ก.ย.":
          month2 = 9
          break;
        case "ต.ค.":
          month2 = 10
          break;
        case "พ.ย.":
          month2 = 11
          break;
        case "ธ.ค.":
          month2 = 12
          break;
      }

      switch (itemType) {
        case "cut":
          table = "production01";
          break;
        case "cnc":
          table = "production02";
          break;
        case "kz":
          table = "production03";
          break;
        case "pab":
          table = "production04";
          break;
      }


      data = []
      await fetch(`../../provider/getTotalRecordsByYear.php?month1=${month1}&year1=${year1}&month2=${month2}&year2=${year2}&table=${table}`)
        .then(response => response.json())
        .then(response => {
          console.log("response : ", response)
          data1 = response.data
          data2 = response.data2
        }).catch(error => console.error('Error fetching data:', error));


      const canvas = document.getElementById('doughnut-chart');
      const ctx = canvas.getContext('2d');

      if (canvas.doughnutChartInstance) {
        canvas.doughnutChartInstance.destroy();
      }

      document.getElementById('note-select-compare-production').style.display = 'none';

      canvas.style.display = 'block';
      document.getElementById('doughnut-chart-wrapper').style.display = 'flex';

      canvas.doughnutChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: [`เดือน ${month1} ปี ${year1}`, `เดือน ${month2} ปี ${year1}`],
          datasets: [{
            data: [data1, data2],
            backgroundColor: ['#FF6384', '#36A2EB'],
            borderWidth: 2
          }]
        },
        options: {
          rotation: -90,
          circumference: 360,
          responsive: false,
          cutoutPercentage: 10,
          maintainAspectRatio: false,
          cutout: 80,
          aspectRatio: 1,
        }
      });
    });
  </script>


</body>

</html>