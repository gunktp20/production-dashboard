<?php
    class ConDB{
        private $dsn = "mysql:host=localhost;dbname=sci00";
        private $username = "root";
        private $password = "";

        public $conn;

        public function connect(){
            try{
                $this->conn = new PDO($this->dsn,$this->username,$this->password);
                 //echo "connected to database successfully!<br>";
            }catch(PDOException $err){
                 echo "Have an Error : " . $err->getMessage();
                 echo "<br>Error on line : " . $err->getLine();
            } 
        }

    }

?>