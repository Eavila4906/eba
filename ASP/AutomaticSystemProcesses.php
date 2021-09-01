<?php
    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_NAME = "cursosingles_db";
    const DB_CHARSET = "utf8";
    
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

    class MySQL extends ConecctionDB {
        private $conexion;
        private $strQuery;
        private $arrayValues;

        public function __construct() {
            $this->conexion =new ConecctionDB();
            $this->conexion = $this->conexion->Connec();
        }

        public function InsertMySQL(String $Query, array $arrayValues) {
            $this->strQuery = $Query;
            $this->arrayValues = $arrayValues;
            $Insert = $this->conexion->prepare($this->strQuery);
            $resul_insert = $Insert->execute($this->arrayValues);
            if ($resul_insert) {
                $lastinsert = $this->conexion->lastinsertId();
            } else {
                $lastinsert = 0;
            }
            return $lastinsert;
        }

        public function SelectAllMySQL(String $Query) {
            $this->strQuery = $Query;
            $result = $this->conexion->prepare($this->strQuery);
            $result->execute();
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }
    }

    class Model extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllAccountingUsers(String $current_date) {
            $this->current_date = $current_date;
            $Query_Select_All = "SELECT CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres,
                                 ac.estudiante AS DNI, ac.fecha_pp, DATEDIFF(ac.fecha_PP, '$this->current_date') AS plazo 
                                 FROM accounting ac INNER JOIN usuario us ON(ac.estudiante=us.DNI) WHERE ac.estado=1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function InsertNotifications(String $user, String $type, String $description, String $date) {
            $this->user = $user;
            $this->type = $type;
            $this->description = $description;
            $this->date = $date;
            $Query_Insert = "INSERT INTO notifications (usuario, tipo, descripcion, fecha, leida) VALUES (?, ?, ?, ?, ?)";
            $Array_Query = array($this->user, $this->type, $this->description, $this->date, 0);
            $this->InsertMySQL($Query_Insert, $Array_Query);
        }
        
    }

    class AutomaticSystemProcesses extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function paymentReminder() {
            setlocale(LC_ALL,"es-ES");
            $this->current_date = date("Y-m-d");
            //$this->current_date = date("2021-09-30");
            $arrayData = $this->SelectAllAccountingUsers($this->current_date);
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE)."<br>";
            for ($i=0; $i < count($arrayData); $i++) { 
                if ($arrayData[$i]['plazo'] < 4 && $arrayData[$i]['plazo'] > 0) {
                    $user = $arrayData[$i]['DNI'];
                    $type = "Recordatorio de pago";
                    $description = "Hola ".$arrayData[$i]['nombres'].", con número de cedula ".$arrayData[$i]['DNI'].". te recordamos que te quedan ".$arrayData[$i]['plazo']." días para realizar el pago de tu mensualidad correspondiente al mes de ".ucwords(strftime("%B", strtotime($arrayData[$i]['fecha_pp']))).".";
                    $date = $arrayData[$i]['fecha_pp'];
                    echo json_encode($description, JSON_UNESCAPED_UNICODE)."<br>";
                    #Insert Notifications payment reminder
                    $this->InsertNotifications($user, $type, $description, $date);
                    #Seend email payment reminder
                }
                if ($arrayData[$i]['plazo'] <= 0) {
                    $user = $arrayData[$i]['DNI'];
                    $type = "Pago atrasado";
                    $description = "Hola ".$arrayData[$i]['nombres'].", con número de cedula ".$arrayData[$i]['DNI'].". te informamos que el plazo para realizar el pago de tu mensualidad correspondiente al mes de ".ucwords(strftime("%B", strtotime($arrayData[$i]['fecha_pp'])))." a caducado. Por favor hacer el pago de tu mensualidad";
                    $date = $arrayData[$i]['fecha_pp'];
                    echo json_encode($description, JSON_UNESCAPED_UNICODE)."<br>";
                    #Insert Notifications late payment
                    $this->InsertNotifications($user, $type, $description, $date);
                    #Seend email late payment
                }
            }
            die();
        }
    }

    $ASP =new AutomaticSystemProcesses();
    $ASP->paymentReminder();

?>