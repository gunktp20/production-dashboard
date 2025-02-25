<?php
// function ในการสุ่มเลข 9 ตัว
function generateEmployeeId()
{
    $firstDigit = rand(1, 9);
    $remainingDigits = '';
    for ($i = 0; $i < 8; $i++) {
        $remainingDigits .= rand(0, 9);
    }
    $numberString = $firstDigit . $remainingDigits;
    return $numberString;
}

class method_stmt
{
    private $ConDB;

    public function __construct()
    {
        $con = new ConDB();
        $con->connect();
        $this->ConDB = $con->conn;
    }
    // การ Login สำหรับ Manager
    public function loginManager($username, $password)
    {
        $sql = "SELECT `username` FROM `managers` WHERE `username` = :username AND `password` = :password";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
            return true;
        } else {
            return false;
        }
    }
    // เข้าสู่ระบบสำหรับพนักงาน
    public function loginEmployee($id, $password)
    {
        $sql = "SELECT `id` FROM `employees` WHERE `id` = :id AND `password` = :password";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id);
        $query->bindParam(":password", $password);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
            return true;
        } else {
            return false;
        }
    }
    // แก้ไขข้อมูลพนักงาน โดยรับข้อมูลใหม่มา และ id เพื่อบอกว่าจะอัพเดทข้อมูลไหน
    public function editEmployee($id, $fname, $lname, $nick_name, $wage_per_date, $num_of_work_date, $num_of_ot_hours, $ot_per_hour, $shift_fee)
    {
        $sql = "UPDATE `employees` 
            SET `fname` = :fname, `lname` = :lname, `nick_name` = :nick_name, 
                `wage_per_date` = :wage_per_date, `num_of_work_date` = :num_of_work_date, 
                `num_of_ot_hours` = :num_of_ot_hours, `ot_per_hour` = :ot_per_hour, 
                `shift_fee` = :shift_fee , `ot_summary` = :ot_summary , `total_salary` = :total_salary
            WHERE `id` = :id";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id);
        $query->bindParam(":fname", $fname);
        $query->bindParam(":lname", $lname);
        $query->bindParam(":nick_name", $nick_name);
        $wage_per_date = floatval($wage_per_date);
        $num_of_work_date = floatval($num_of_work_date);
        $num_of_ot_hours = floatval($num_of_ot_hours);
        $ot_per_hour = floatval($ot_per_hour);
        $shift_fee = floatval($shift_fee);

        $query->bindParam(":wage_per_date", $wage_per_date);
        $query->bindParam(":num_of_work_date", $num_of_work_date);
        $query->bindParam(":num_of_ot_hours", $num_of_ot_hours);
        $query->bindParam(":ot_per_hour", $ot_per_hour);
        $query->bindParam(":shift_fee", $shift_fee);
        $ot_summary = $ot_per_hour * $num_of_ot_hours;
        $total_salary =  $wage_per_date * $num_of_work_date + $ot_per_hour * $num_of_ot_hours + $shift_fee;
        $query->bindParam(":ot_summary", $ot_summary);
        $query->bindParam(":total_salary", $total_salary);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // อัพเดทข้อมูลช่องทางติดต่อของพนักงาน
    public function editEmployeeContact($id, $fname, $lname, $nick_name, $phone_number, $line, $email)
    {
        $sql = "UPDATE `employees` 
            SET `fname` = :fname, `lname` = :lname, `nick_name` = :nick_name, 
                `phone_number` = :phone_number, `line` = :line, 
                `email` = :email WHERE `id` = :id";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id);
        $query->bindParam(":fname", $fname);
        $query->bindParam(":lname", $lname);
        $query->bindParam(":nick_name", $nick_name);
        $query->bindParam(":phone_number", $phone_number);
        $query->bindParam(":line", $line);
        $query->bindParam(":email", $email);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // อัพเดทข้อมูลบัญชีธนาคารของพนักงาน
    public function editEmployeeBankAccount($id, $fname, $lname, $nick_name, $bank_account, $bank_account_number)
    {
        $sql = "UPDATE `employees` 
            SET `fname` = :fname, `lname` = :lname, `nick_name` = :nick_name, 
                `bank_account` = :bank_account, 
                `bank_account_number` = :bank_account_number WHERE `id` = :id";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id);
        $query->bindParam(":fname", $fname);
        $query->bindParam(":lname", $lname);
        $query->bindParam(":nick_name", $nick_name);
        $query->bindParam(":bank_account", $bank_account);
        $query->bindParam(":bank_account_number", $bank_account_number);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // เพิ่มข้อมูลพนักงาน
    public function addEmployee($fname, $lname, $nick_name, $password)
    {
        $id = generateEmployeeId();
        $sql = "INSERT INTO `employees` (`id`,`fname`,`lname`,`nick_name`,`password`)
            VALUES (:id,:fname,:lname,:nick_name,:password)";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id);
        $query->bindParam(":fname", $fname);
        $query->bindParam(":lname", $lname);
        $query->bindParam(":nick_name", $nick_name);
        $query->bindParam(":password", $password);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // เรียกดูข้อมูลพนักงาน
    public function getEmployeeById($id)
    {
        $sql = "SELECT * FROM `employees` WHERE `id` = :id";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
            return true;
        } else {
            return false;
        }
    }
    // เรียกดูข้อมูลข่าวสารทั้งหมด
    public function getAllAnnounces()
    {
        $sql = "SELECT * FROM `announces`";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            return true;
        } else {
            return false;
        }
    }
    // เพิ่มข้อมูลข่าวสารใหม่
    public function addAnnounce($announce)
    {
        $sql = "INSERT INTO `announces` (`announce`)
            VALUES (:announce)";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":announce", $announce);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // เรียกดูข้อมูลพนักงานทั้งหมด
    public function getAllEmployees()
    {
        $sql = "SELECT * FROM `employees`";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            return true;
        } else {
            return false;
        }
    }
    // ลบข้อมูลพนักงาน
    public function deleteEmployee($id)
    {
        $sql = "DELETE FROM `employees` WHERE `id` = :id";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // ลบข่าวสารที่ประกาศ
    public function deleteAnnounce($id)
    {
        $sql = "DELETE FROM `announces` WHERE `id` = :id";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(":id", $id);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalProduction1Quantity()
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production01`";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total_quantity'];
        } else {
            return false;
        }
    }
    public function getTotalProduction2Quantity()
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production02`";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total_quantity'];
        } else {
            return false;
        }
    }
    public function getTotalProduction3Quantity()
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production03`";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total_quantity'];
        } else {
            return false;
        }
    }
    public function getTotalProduction4Quantity()
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production04`";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total_quantity'];
        } else {
            return false;
        }
    }
    public function getTotalProduction5Quantity()
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production05`";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total_quantity'];
        } else {
            return false;
        }
    }

    public function getTotalProductionByProNum()
    {
        $sql = "SELECT pro_num, SUM(quantity) AS total_quantity 
                FROM `process00` 
                GROUP BY pro_num";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result; // จะได้ข้อมูลเป็น array ของ pro_num และ total_quantity
        } else {
            return false;
        }
    }

    public function getTotalRecordsByYear()
    {
        $sql = "SELECT YEAR(date_on) AS year, COUNT(*) AS total_records 
                FROM `purchase00` 
                GROUP BY YEAR(date_on)";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result; // ได้ข้อมูล array ของปีและจำนวนเรคคอร์ด
        } else {
            return false;
        }
    }

    public function getAvailableYears()
    {
        $sql = "SELECT DISTINCT YEAR(date_on) AS year FROM purchase00 ORDER BY year ASC";
        $query = $this->ConDB->prepare($sql);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result; // ได้ข้อมูล array ของปีและจำนวนเรคคอร์ด
        } else {
            return false;
        }
    }

    public function getQuantityProduction1WithMonthAndYear($month, $year)
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production01` WHERE YEAR(pro_date) = :year AND MONTH(pro_date) = :month";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(':month', $month, PDO::PARAM_INT);
        $query->bindParam(':year', $year, PDO::PARAM_INT);

        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $total = $result['total_quantity'];
            return $total;
        } else {
            return false;
        }
    }

    public function getQuantityProduction2WithMonthAndYear($month, $year)
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production02` WHERE YEAR(pro_date) = :year AND MONTH(pro_date) = :month";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(':month', $month, PDO::PARAM_INT);
        $query->bindParam(':year', $year, PDO::PARAM_INT);

        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $total = $result['total_quantity'];
            return $total;
        } else {
            return false;
        }
    }

    public function getQuantityProduction3WithMonthAndYear($month, $year)
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production03` WHERE YEAR(pro_date) = :year AND MONTH(pro_date) = :month";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(':month', $month, PDO::PARAM_INT);
        $query->bindParam(':year', $year, PDO::PARAM_INT);

        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $total = $result['total_quantity'];
            return $total;
        } else {
            return false;
        }
    }

    public function getQuantityProduction4WithMonthAndYear($month, $year)
    {
        $sql = "SELECT SUM(quantity) AS total_quantity FROM `production04` WHERE YEAR(pro_date) = :year AND MONTH(pro_date) = :month";
        $query = $this->ConDB->prepare($sql);
        $query->bindParam(':month', $month, PDO::PARAM_INT);
        $query->bindParam(':year', $year, PDO::PARAM_INT);

        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $total = $result['total_quantity'];
            return $total;
        } else {
            return false;
        }
    }
}
