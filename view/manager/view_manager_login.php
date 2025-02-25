<!DOCTYPE html>
<?php
session_start();

if (isset($_SESSION['logged_in'])) {
    return header("location: ../manager/view_overview.php");
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Employee-system</title>
</head>

<body>
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex fle-col items-center justify-center py-6 px-4">
            <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
                <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">

                    <form class="space-y-4" action="../../controller/manager/login_manager_controller.php" method="POST">
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-semibold">ลงชื่อเข้าใช้</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">ลงชื่อเข้าใช้บัญชีของคุณและสำรวจโลกแห่งความเป็นไปได้ การเดินทางของคุณเริ่มต้นที่นี่</p>
                        </div>

                        <?php
                        if (isset($_SESSION['error'])) {
                        ?>
                            <div class="bg-red-50 border-red-200 border-[1px] rounded text-sm py-3 text-red-700 text-center px-5" role="alert">
                                <p>
                                    <?php
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error'])
                                    ?>
                                </p>
                            </div>
                        <?php
                        }
                        ?>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">ชื่อผู้ใช้</label>
                            <div class="relative flex items-center">
                                <input name="username" type="text" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="กรอกชื่อผู้ใช้ของคุณ" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                    <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                                    <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">รหัสผ่าน</label>
                            <div class="relative flex items-center">
                                <input name="password" type="password" id="password" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="กรอกรหัสผ่าน" />
                                <svg xmlns="http://www.w3.org/2000/svg" id="togglePassword" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4">
                        </div>

                        <div class="!mt-8">
                            <button type="submit" name="login_manager" class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                ยืนยันการเข้าสู่ระบบ
                            </button>
                        </div>

                    
                    </form>
                </div>
                <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
                    <img src="../../images/dashboard-v.png" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Dining Experience" />
                </div>
            </div>
        </div>
    </div>

</body>


<script>
    // JavaScript
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