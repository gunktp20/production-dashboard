<?php

session_start();

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
$no = 1
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

  <aside class="relative bg-white h-screen w-[350px] hidden sm:block shadow-xl">
    <div class="p-6">
      <a href="#" class="text-[#4195fc] text-3xl font-semibold uppercase hover:text-[#4195fc]">Admin</a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
      <!-- <a href="./view_overview.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">

        ภาพรวม
      </a> -->
      <a href="#" class="flex items-center py-4 pl-4 nav-item text-[#4195fc] text-sm bg-[#e9f3ff]">
        <!-- <i class="fa-solid fa-chart-column mr-3"></i> -->
        <i class="fa-solid fa-chart-pie mr-3"></i>
        ภาพรวม & วิเคราะห์ยอดการผลิต
      </a>
      <!-- <a href="./view_compare_data.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fa-solid fa-chart-line mr-3"></i>
        เปรียบเทียบ
      </a> -->
      <a href="./view_employees.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
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
        <a href="#" class="flex items-center py-4 pl-4 nav-item text-[#4195fc] text-sm bg-[#e9f3ff]">
          <i class="fa-solid fa-chart-column mr-3"></i>
          วิเคราะห์ยอดการผลิต
        </a>
        <a href="./view_compare_data.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-line mr-3"></i>
          เปรียบเทียบ
        </a>
        <a href="./view_employees.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
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


    <div class="w-full overflow-x-hidden border-t flex flex-col">
      <main class="w-full flex-grow p-6 ">
        <h1 class="text-3xl text-black pb-6">ภาพรวม & วิเคราะห์ยอดการผลิต</h1>

        <div class="flex flex-wrap mt-6">

          <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
            <div class="p-6 py-2 bg-white border-[1px] border-gray-200">
              <p class="text-[16px] pb-3 flex items-center">
                จำนวน ตัด
              </p>
              <p class="text-[22px] flex items-center text-blue-600">
                <?=
                $total_quantity_prod1
                ?>
              </p>
            </div>
          </div>

          <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-2 lg:mt-0 mb-4">
            <div class="p-6 py-2 bg-white border-[1px] border-gray-200">
              <p class="text-[16px] pb-3 flex items-center">
                จำนวน CNC
              </p>
              <p class="text-[22px] flex items-center text-blue-600">
                <?=
                $total_quantity_prod2
                ?>
              </p>
            </div>
          </div>

          <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
            <div class="p-6 py-2 bg-white border-[1px] border-gray-200">
              <p class="text-[16px] pb-3 flex items-center">
                จำนวน ข้อเสือ
              </p>
              <p class="text-[22px] flex items-center text-blue-600">
                <?=
                $total_quantity_prod3
                ?>
              </p>
            </div>
          </div>

          <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-2 lg:mt-0 mb-4">
            <div class="p-6 py-2 bg-white border-[1px] border-gray-200">
              <p class="text-[16px] pb-3 flex items-center">
                จำนวน พับ
              </p>
              <p class="text-[22px] flex items-center text-blue-600">
                <?=
                $total_quantity_prod4
                ?>
              </p>

            </div>
          </div>
        </div>

        <div class="flex flex-wrap mt-6">
          <div class="w-full bg-white p-6">
            <div class="flex flex-col gap-3 mb-2">
              <div class="text-sm">วิเคราะห์ยอดการผลิตยอดการผลิตของชิ้นส่วน ตาม เดือน/ปี</div>
              <!-- <div class="flex gap-3 h-[35px] mb-2 items-center justify-between"> -->
              <div class="gap-3 h-[100px] justify-between flex flex-col lg:flex-row lg:h-[35px]">
                <!-- Left -->
                <div class="flex  h-[35px] items-center gap-3">
                  <div class="text-[15.5px]">เดือน</div>
                  <select class="border-[1px] w-[100px] border-gray-300 pl-1 h-[100%]" id="month">
                  </select>
                  <div class="text-[15.5px]">ปี</div>
                  <select class="border-[1px] w-[100px] border-gray-300 pl-1 h-[100%]" id="year">
                  </select>

                  <button id="analysis_button_1" type="button" class="bg-blue-500 text-white px-4 hover:bg-blue-600 transition-all text-[15px] h-[100%]">วิเคราะห์ยอดการผลิต</button>
                </div>
                <!-- Right -->
                <div class="flex  h-[35px] items-center gap-3">
                  <div class="text-[15.5px]">รูปแบบการแสดงผล</div>
                  <select class="border-[1px] w-[170px] border-gray-300 pl-1 h-[100%]" id="chart-type">
                    <option value="bar">Bar Chart</option>
                    <!-- <option value="line">Line Chart</option> -->
                  </select>

                </div>
              </div>
            </div>

            <div id="note-select-compare-production" class="w-[100%] h-[300px] flex items-center text-[17px] justify-center text-gray-500">
              กรุณาเลือกปีที่จะทำการเปรียบเทียบ
            </div>


            <div class="p-6">
              <canvas id="bar_chart" width="400" height="150" style="display:none"></canvas>
            </div>
          </div>
        </div>
      </main>


    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

  <script>
    var chartOne = document.getElementById('chartOne');
    var myChart = new Chart(chartOne, {
      type: 'bar',
      data: {
        labels: ['ยอดขาย', 'ยอดการผลิต', 'ยอดการสั่งซื้อ', 'ยอดการสั่ง', 'จำนวนสินค้า', 'จำนวนผู้ร่วมซื้อ'],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    var chartTwo = document.getElementById('chartTwo');
    var myLineChart = new Chart(chartTwo, {
      type: 'line',
      data: {
        labels: ['ยอดขาย', 'ยอดการผลิต', 'ยอดการสั่งซื้อ', 'ยอดการสั่ง', 'จำนวนสินค้า', 'จำนวนผู้ร่วมซื้อ'],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>
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
          select.appendChild(opt);
        });
      }

      populateSelect("month", months);

      // const yearOptions = Array.from({
      //   length: endYear - startYear + 1
      // }, (_, i) => (startYear + i).toString());
      const yearOptions = [2021, 2022, 2023, 2024, 2025]
      populateSelect("year", yearOptions);

    });

    var month
    document.getElementById('analysis_button_1').addEventListener('click', async (event) => {

      event.preventDefault(); // 👈 ป้องกันการ scroll หรือ submit

      month = document.getElementById('month').value;
      const year = document.getElementById('year').value;
      const chartType = document.getElementById('chart-type').value;
      switch (month) {
        case "ม.ค.":
          month = 1;
          break;
        case "ก.พ.":
          month = 2;
          break;
        case "มี.ค.":
          month = 3
          break;
        case "เม.ย.":
          month = 4
          break;
        case "พ.ค.":
          month = 5
          break;
        case "มิ.ย.":
          month = 6
          break;
        case "ก.ค.":
          month = 7
          break;
        case "ส.ค.":
          month = 8
          break;
        case "ก.ย.":
          month = 9
          break;
        case "ต.ค.":
          month = 10
          break;
        case "พ.ย.":
          month = 11
          break;
        case "ธ.ค.":
          month = 12
          break;
      }

      data = []
      await fetch(`../../provider/getQuantityProduction.php?month=${month}&year=${year}&table=production01`)
        .then(response => response.json())
        .then(response => {
          console.log("response 1 : ", response)
          data.push(response)
        }).catch(error => console.error('Error fetching data:', error));

      await fetch(`../../provider/getQuantityProduction.php?month=${month}&year=${year}&table=production02`)
        .then(response => response.json())
        .then(response => {
          console.log("response 2 : ", response)
          data.push(response)
        }).catch(error => console.error('Error fetching data:', error));

      await fetch(`../../provider/getQuantityProduction.php?month=${month}&year=${year}&table=production03`)
        .then(response => response.json())
        .then(response => {
          console.log("response 3 : ", response)
          data.push(response)
        }).catch(error => console.error('Error fetching data:', error));

      await fetch(`../../provider/getQuantityProduction.php?month=${month}&year=${year}&table=production04`)
        .then(response => response.json())
        .then(response => {
          console.log("response 4 : ", response)
          data.push(response)
        }).catch(error => console.error('Error fetching data:', error));

      const canvas = document.getElementById('bar_chart');
      if (!canvas) {
        console.error("❌ Canvas not found!");
        return; // ป้องกันไปต่อ
      }
      const ctx = canvas.getContext('2d');

      if (canvas.barChart) {
        canvas.barChart.destroy();
      }

      document.getElementById('note-select-compare-production').style.display = 'none';

      canvas.style.display = 'block';
      // document.getElementById('bar-chart-wrapper').style.display = 'flex';

      canvas.barChart = new Chart(ctx, {
        type: chartType,
        data: {
          labels: ['ตัด', 'CNC', 'ข้อเสือ', 'พับ'],
          datasets: [{
            label: '# of Votes',
            data: data,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              // 'rgba(153, 102, 255, 0.2)',
              // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              // 'rgba(153, 102, 255, 1)',
              // 'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

      canvas.scrollIntoView({
        // behavior: 'smooth',
        block: 'start' // หรือ 'center' / 'end' แล้วแต่ที่ต้องการ
      });

      // End
    });

    window.scrollTo({
      top: document.body.scrollHeight,
      behavior: 'smooth'
    });
  </script>

</body>

</html>