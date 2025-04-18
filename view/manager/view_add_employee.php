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
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

            <a href="./view_employees.php" class="flex items-center text-gray-800 opacity-75 text-sm hover:opacity-100 py-4 pl-4 nav-item">
                <i class="far fa-address-book mr-3"></i>
                รายชื่อพนักงาน
            </a>
            <a href="#" class="flex items-center py-4 pl-4 nav-item text-[#4195fc] text-sm bg-[#e9f3ff]">
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
                <a href="./view_employees.php" class="flex items-center text-gray-800 opacity-75 hover:opacity-100 py-4 pl-4 nav-item">
                    <i class="far fa-address-book mr-3"></i>
                    รายชื่อพนักงาน
                </a>
                <a href="#" class="flex items-center py-4 pl-4 nav-item text-[#4195fc] text-sm bg-[#e9f3ff]">
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
            <main class="w-full flex-grow p-6">
                <!-- <h1 class="text-3xl text-black pb-2">เพิ่มข้อมูลพนักงาน</h1>
                <p class="text-gray-600 mb-4">กรอกข้อมูลเพื่อเพิ่ม ข้อมูลพนักงาน</p> -->

                <form action="../../controller/manager/add_employee_controller.php" method="POST"
                    class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md space-y-6">

                    <h2 class="text-2xl font-semibold text-gray-800">เพิ่มข้อมูลพนักงาน</h2>
                    <p class="text-gray-500">กรุณากรอกข้อมูลพนักงานให้ครบถ้วน</p>

                    <?php if (isset($_SESSION['error'])) : ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                            <strong class="font-bold">เกิดข้อผิดพลาด:</strong>
                            <span class="block sm:inline"><?= $_SESSION['error'];
                                                            unset($_SESSION['error']); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-1 text-gray-700">ชื่อ</label>
                            <input name="fname" type="text" placeholder="ชื่อ" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">นามสกุล</label>
                            <input name="lname" type="text" placeholder="นามสกุล" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">ชื่อเล่น</label>
                            <input name="nick_name" type="text" placeholder="ชื่อเล่น"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">**รหัสผ่าน สำหรับพนักงาน</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" placeholder="รหัสผ่าน" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 pr-10">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-blue-600 focus:outline-none"
                                    onclick="togglePasswordVisibility()">
                                    <i id="eyeIcon" class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-wrap gap-4 justify-start pt-4">
                        <button type="submit" name="add_employee"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-md transition">
                            💾 บันทึก
                        </button>
                        <a type="reset"
                            href="./view_employees.php"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-md transition">
                            ❌ ยกเลิก
                        </a>
                    </div>
                </form>

            </main>


        </div>

    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>