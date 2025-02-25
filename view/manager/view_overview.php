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
      <a href="#" class="flex items-center text-white py-4 pl-4 nav-item text-white text-md">
        <i class="fa-solid fa-chart-pie mr-3"></i>
        ภาพรวม
      </a>
      <a href="./view_analysis.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
        <i class="fa-solid fa-chart-column mr-3"></i>
        วิเคราะห์
      </a>
      <a href="./view_compare_data.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
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
        <a href="#" class="flex items-center text-white py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-pie mr-3"></i>
          ภาพรวม
        </a>
        <a href="./view_analysis.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
          <i class="fa-solid fa-chart-column mr-3"></i>
          วิเคราะห์
        </a>
        <a href="./view_compare_data.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
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
        <h1 class="text-3xl text-black pb-6">ภาพรวม</h1>

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


                <?php
                if ($total_quantity_prod5 <= 0 ||  $total_quantity_prod5 == null) {
                  echo 0;
                }
                ?>

        </div>

    




        <div class="w-full mt-12">
          <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Latest Reports
          </p>
          <div class="bg-white overflow-auto">
            <table class="min-w-full bg-white">
              <thead class="bg-gray-800 text-white">
                <tr>
                  <th class="w-[5%] text-left py-3 px-4 uppercase font-semibold text-sm">ยอดผลิตแต่ละปี</th>
                  <th class="w-[95%] text-left py-3 px-4 uppercase font-semibold text-sm">จำนวนทั้งหมด</th>

                </tr>
              </thead>
              <tbody class="text-gray-700">

                <?php
                // เรียกใช้ฟังก์ชัน
                $totalRecordsByYear = $obj->getTotalRecordsByYear();

                if ($totalRecordsByYear) {
                  foreach ($totalRecordsByYear as $row) {
                    echo "<tr>";
                    echo " <td class='w-1/3 text-left py-3 px-4 font-bold'>" . htmlspecialchars($row['year']) . "</td>";
                    echo " <td class='text-left py-3 px-4 text-blue-600'>" . htmlspecialchars($row['total_records']) . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "Error querying data.";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

      </main>

      <footer class="w-full bg-white text-right p-4">
        Built by <a target="_blank" href="#" class="underline">Kuttapat Somwang</a>.
      </footer>
    </div>

  </div>

  <!-- AlpineJS -->
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // ฟังก์ชันโหลดปีจาก API
    function loadAvailableYears() {
      fetch('../../provider/getAvailableYears.php') 
        .then(response => response.json())
        .then(data => {
          const year1Select = document.getElementById('year1');
          const year2Select = document.getElementById('year2');

          year1Select.innerHTML = '';
          year2Select.innerHTML = '';

          data.forEach(yearObj => {
            const option1 = document.createElement('option');
            option1.value = yearObj.year;
            option1.textContent = yearObj.year;

            const option2 = option1.cloneNode(true); 

            year1Select.appendChild(option1);
            year2Select.appendChild(option2);
          });
        })
        .catch(error => console.error('Error loading years:', error));
    }

    document.addEventListener('DOMContentLoaded', loadAvailableYears);
  </script>

  <script>
    document.getElementById('compareButton').addEventListener('click', () => {
      const year1 = document.getElementById('year1').value;
      const year2 = document.getElementById('year2').value;

      fetch(`../../provider/getTotalRecordsByYear.php?year1=${year1}&year2=${year2}`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error('Error:', data.error);
          } else {
            const labels = data.map(item => item.year);
            const quantities = data.map(item => item.total_quantity);

            const ctx = document.getElementById('doughnutChart').getContext('2d');

            if (window.myDoughnutChart) {
              window.myDoughnutChart.destroy(); 
            }

            window.myDoughnutChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: labels,
                datasets: [{
                  data: quantities,
                  backgroundColor: ['#FF6384', '#36A2EB']
                }]
              },
              options: {
                rotation: -90,
                circumference: 180,
              }

            });
          }
        })
        .catch(error => console.error('Error fetching data:', error));
    });
  </script>

  <script>
    var chartOne = document.getElementById('chartOne');
    var myChart = new Chart(chartOne, {
      type: 'bar',
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
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
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
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


</body>

</html>