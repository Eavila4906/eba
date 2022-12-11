<?php
    require_once("../Config/Config.php");
    require_once("../Libraries/Core/ConecctionDB.php");
    require_once("../Libraries/Core/MySQL.php");

    class Model extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        //*
        public function SelectAllAccountingUsers(String $current_date) {
            $this->current_date = $current_date;

            $Query_Select_All = "SELECT CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres, 
                                st.estudiante AS DNI, DATE_ADD(MAX(pc.date_control_LP), INTERVAL 1 MONTH) AS date_NP, DATEDIFF(DATE_ADD(MAX(pc.date_control_LP), INTERVAL 1 MONTH), '$this->current_date') AS plazo,
                                us.email 
                                FROM payment_control pc INNER JOIN student st ON (st.id_student=pc.student)
                                INNER JOIN usuario us ON(st.estudiante=us.DNI) 
                                WHERE pc.status = 1 AND st.payment_control = 1 GROUP BY pc.student";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function InsertNotifications(String $user, String $type, String $description, String $date) {
            $this->user = $user;
            $this->type = $type;
            $this->description = $description;
            $this->date = $date;
            $Query_Insert = "INSERT INTO notifications (tipo, descripcion, fecha, leida) VALUES (?, ?, ?, ?)";
            $Array_Query = array($this->type, $this->description, $this->date, 0);
            $resul_insert = $this->InsertMySQL($Query_Insert, $Array_Query);

            $Query_Insert_DN = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_DN = array($this->user, $resul_insert);
            $this->InsertMySQL($Query_Insert_DN, $Array_Query_DN);
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

        public function DeleteNotifications(int $id_notifications) {
            $this->id_notifications = $id_notifications;
            $Query_DeleteDN = "DELETE FROM detail_notifications WHERE notifications = $this->id_notifications";
            $Query_DeleteN = "DELETE FROM notifications WHERE id_notifications = $this->id_notifications";
            
            $result_DeleteDN = $this->DeleteMySQL($Query_DeleteDN);
            $result_DeleteN = $this->DeleteMySQL($Query_DeleteN);

            if ($result_DeleteDN > 0 && $result_DeleteN > 0) {
                $result = 1;
            } else {
                $result = 0;
            }
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
            $this->current_date = date("Y-m-d");
            //$this->current_date = date("2022-12-23");
            $arrayData = $this->SelectAllAccountingUsers($this->current_date);
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE)."<br>";
            for ($i=0; $i < count($arrayData); $i++) { 
                if ($arrayData[$i]['plazo'] < 4 && $arrayData[$i]['plazo'] > 0) {
                    #Insert Notifications payment reminder
                    $user = $arrayData[$i]['DNI'];
                    $type = "Recordatorio de pago";
                    $description = "Hola ".$arrayData[$i]['nombres'].", con número de cedula ".$arrayData[$i]['DNI'].". te recordamos que te quedan ".$arrayData[$i]['plazo']." días para realizar el pago de tu mensualidad correspondiente al mes de ".ucwords(strftime("%B", strtotime($arrayData[$i]['date_NP']))).".";
                    $date = $arrayData[$i]['date_NP'];
                    $this->InsertNotifications($user, $type, $description, $date);
                    #Seend email payment reminder
                    $mes = ucwords(strftime("%B", strtotime($arrayData[$i]['date_NP'])));
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
                if ($arrayData[$i]['plazo'] == 0) {
                    #Insert Notifications late payment
                    $user = $arrayData[$i]['DNI'];
                    $type = "Pago atrasado";
                    $description = "Hola ".$arrayData[$i]['nombres'].", con número de cedula ".$arrayData[$i]['DNI'].". te informamos que el plazo para realizar el pago de tu mensualidad correspondiente al mes de ".ucwords(strftime("%B", strtotime($arrayData[$i]['date_NP'])))." a caducado.  Por favor, debera de hacer el pago en un plazo menos de 3 días.";
                    $date = $arrayData[$i]['date_NP'];
                    $this->InsertNotifications($user, $type, $description, $date);
                    #Seend email late payment
                    $mes = ucwords(strftime("%B", strtotime($arrayData[$i]['date_NP'])));
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