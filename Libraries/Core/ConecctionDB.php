<?php
    class ConecctionDB {
        private $connec;
        public function __construct(){
            $str_Conecction = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
            try {
                $this->connec =new PDO($str_Conecction, DB_USER, DB_PASSWORD);
                $this->connec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $this->connec = "FILED CONNECTION!";
                echo "ERROR: ".$e->getMessage();
            }
        }
        public function Connec(){
            return $this->connec;
        }
    }
?>