<!DOCTYPE html>
<?php
session_start();

if (isset($_SESSION['logged_in'])) {
    return header("location: ./view_employee_home.php"); // เปลี่ยนเส้นทางเมื่อ Login แล้ว
}
?>

<html lang="th">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>เข้าสู่ระบบพนักงาน</title>
</head>

<body>
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex fle-col items-center justify-center py-6 px-4">
            <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
                <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">

                    <form class="space-y-4" action="../../controller/employee/login_employee_controller.php" method="POST">
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-semibold">เข้าสู่ระบบพนักงาน</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">
                                เข้าสู่ระบบเพื่อดูข่าวสาร ยอดเงินเดือน และข้อมูลของคุณในระบบ
                            </p>
                        </div>

                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="bg-red-50 border-red-200 border-[1px] rounded text-sm py-3 text-red-700 text-center px-5" role="alert">
                                <p>
                                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">รหัสพนักงาน</label>
                            <div class="relative flex items-center">
                                <input name="id" type="text" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="กรอกรหัสพนักงานของคุณ" required />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                    <circle cx="10" cy="7" r="6"></circle>
                                    <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5z"></path>
                                </svg>
                            </div>
                        </div>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">รหัสผ่าน</label>
                            <div class="relative flex items-center">
                                <input name="password" type="password" id="password" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="กรอกรหัสผ่าน" required />
                                <svg xmlns="http://www.w3.org/2000/svg" id="togglePassword" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="!mt-8">
                            <button type="submit" name="login_employee" class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                ยืนยันการเข้าสู่ระบบ
                            </button>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">คุณคือผู้จัดการ?</p>
                            <a href="../manager/view_manager_login.php"
                                class="inline-block mt-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                                👉 คลิกที่นี่เพื่อเข้าสู่ระบบของผู้จัดการ
                            </a>
                        </div>
                    </form>
                </div>

                <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
                    <img src="../../images/dashboard-v.png" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Employee Login" />
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });
    });
</script>

</html>
