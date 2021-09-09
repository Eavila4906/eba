<?php
    //url project
    const BASE_URL = "http://localhost/eba/";
    //data of connection database
    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_NAME = "cursosingles_db";
    const DB_CHARSET = "utf8";
    
    //data of seend email
    const SENDER_NAME = "English Bootcamp Academy";
	const SENDER_EMAIL = "eavila4906@gmail.com";
	const COMPANY_NAME = "English Bootcamp Academy";
	const WEB_COMPANY = "www.eba.com.ec";

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

        public function SelectAllMySQL(String $Query) {
            $this->strQuery = $Query;
            $result = $this->conexion->prepare($this->strQuery);
            $result->execute();
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
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

        public function DeleteMySQL(String $Query) {
            $this->Query = $Query;
            $result = $this->conexion->prepare($this->Query);
            $result->execute();
            if ($result) {
                $lastEliminar = 1;
            } else {
                $lastEliminar = 0;
            }
            return $lastEliminar;
        }
    }

    class Model extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllAccountingUsers(String $current_date) {
            $this->current_date = $current_date;
            $Query_Select_All = "SELECT CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres,
                                 ac.estudiante AS DNI, ac.fecha_pp, DATEDIFF(ac.fecha_PP, '$this->current_date') AS plazo,
                                 us.email 
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

        public function SelectAllNotifications(String $current_date) {
            $this->current_date = $current_date;
            $Query_Select_All = "SELECT id_notifications, DATEDIFF('$this->current_date',fecha) AS plazo
                                 FROM notifications 
                                 WHERE (tipo = 'Recordatorio de pago' OR tipo = 'Pago atrasado' OR
                                       tipo = 'Contabilidad pausada' OR tipo = 'Contabilidad reanudada') AND leida = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function  DeleteNotifications(int $id_notifications) {
            $this->id_notifications = $id_notifications;
            $Query_Delete = "DELETE FROM notifications WHERE id_notifications = $this->id_notifications";
            $result = $this->DeleteMySQL($Query_Delete);
            return $result;
        }
        
    }

    class AutomaticSystemProcesses extends Model {
        public function __construct() {
            parent::__construct();
        }

        function sendEmail($data,$template) {
            $asunto = $data['asunto'];
            $emailDestino = $data['email'];
            $empresa = SENDER_NAME;
            $remitente = SENDER_EMAIL;
            //ENVIO DE CORREO
            $de = "MIME-Version: 1.0\r\n";
            $de .= "Content-type: text/html; charset=UTF-8\r\n";
            $de .= "From: {$empresa} <{$remitente}>\r\n";
            ob_start();
            require_once("Templates/Emails/".$template.".php");
            $mensaje = ob_get_clean();
            $send = mail($emailDestino, $asunto, $mensaje, $de);
            return $send;
        }

        public function paymentReminder() {
            setlocale(LC_ALL,"es-ES");
            $this->current_date = date("Y-m-d");
            //$this->current_date = date("2021-12-04");
            $arrayData = $this->SelectAllAccountingUsers($this->current_date);
            //echo json_encode($arrayData, JSON_UNESCAPED_UNICODE)."<br>";
            for ($i=0; $i < count($arrayData); $i++) { 
                if ($arrayData[$i]['plazo'] < 4 && $arrayData[$i]['plazo'] > 0) {
                    #Insert Notifications payment reminder
                    $user = $arrayData[$i]['DNI'];
                    $type = "Recordatorio de pago";
                    $description = "Hola ".$arrayData[$i]['nombres'].", con número de cedula ".$arrayData[$i]['DNI'].". te recordamos que te quedan ".$arrayData[$i]['plazo']." días para realizar el pago de tu mensualidad correspondiente al mes de ".ucwords(strftime("%B", strtotime($arrayData[$i]['fecha_pp']))).".";
                    $date = $arrayData[$i]['fecha_pp'];
                    $this->InsertNotifications($user, $type, $description, $date);
                    #Seend email payment reminder
                    $mes = ucwords(strftime("%B", strtotime($arrayData[$i]['fecha_pp'])));
                    $dataUser = array(
                        'usuario' => $arrayData[$i]['nombres'],
                        'DNI' => $arrayData[$i]['DNI'],
                        'email' => $arrayData[$i]['email'],
                        'asunto' => 'Recordatorio de pago '.$mes.' - '.SENDER_NAME,
                        'url' => BASE_URL,
                        'mes' => $mes,
                        'plazo' => $arrayData[$i]['plazo']
                    );
                    $this->sendEmail($dataUser, 'email_payment_reminder');
                }
                if ($arrayData[$i]['plazo'] <= 0) {
                    #Insert Notifications late payment
                    $user = $arrayData[$i]['DNI'];
                    $type = "Pago atrasado";
                    $description = "Hola ".$arrayData[$i]['nombres'].", con número de cedula ".$arrayData[$i]['DNI'].". te informamos que el plazo para realizar el pago de tu mensualidad correspondiente al mes de ".ucwords(strftime("%B", strtotime($arrayData[$i]['fecha_pp'])))." a caducado. Por favor hacer el pago de tu mensualidad";
                    $date = $arrayData[$i]['fecha_pp'];
                    $this->InsertNotifications($user, $type, $description, $date);
                    #Seend email late payment
                    $mes = ucwords(strftime("%B", strtotime($arrayData[$i]['fecha_pp'])));
                    $dataUser = array(
                        'usuario' => $arrayData[$i]['nombres'],
                        'DNI' => $arrayData[$i]['DNI'],
                        'email' => $arrayData[$i]['email'],
                        'asunto' => 'Recordatorio de pago atrasado '.$mes.' - '.SENDER_NAME,
                        'url' => BASE_URL,
                        'mes' => $mes
                    );
                    $this->sendEmail($dataUser, 'email_payment_later');
                }
            }
        }

        public function checkNotifications() {
            $this->current_date = date("Y-m-d");
            //$this->current_date = date("2021-12-15");
            $arrayData = $this->SelectAllNotifications($this->current_date);
            //echo json_encode($arrayData, JSON_UNESCAPED_UNICODE)."<br>";
            for ($i=0; $i < count($arrayData); $i++) { 
                if ($arrayData[$i]['plazo'] >= 1) {
                    $this->DeleteNotifications($arrayData[$i]['id_notifications']); 
                }
            } 
        }

        public function run() {
            //echo "run payment reminder <br>";
            $this->paymentReminder();
            sleep(3);
            //echo "run check notifications <br>";
            $this->checkNotifications();
            sleep(3);
            //echo "finish run";
            die();
        }
    }

    $ASP =new AutomaticSystemProcesses();
    $ASP->run();

?>