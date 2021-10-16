<?php
    class MyModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllNotifications(String $user) {
            $this->user = $user;
            $Query_Select_All = "SELECT * FROM detail_notifications dn INNER JOIN notifications nt ON (dn.notifications=nt.id_notifications) 
                                 WHERE dn.usuario = '$this->user' ORDER BY dn.date DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectInfoNotificationsPayment(String $user, String $date) {
            $this->user = $user;
            $this->date = $date;
            $Query_Select = "SELECT * FROM detail_payment dp INNER JOIN payment pa ON (dp.payment=pa.id_payment) 
                             WHERE dp.estudiante = '$this->user' AND pa.fecha_pago = '$this->date'";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectNextDate(String $fecha) {
            $this->fecha = $fecha;
            $Query_Select = "SELECT DATE_ADD('$this->fecha', INTERVAL 1 MONTH ) AS fecha";
            $result = $this->SelectMySQL($Query_Select);
            $date = $result['fecha'];
            return $date;
        }

        public function SelectNotification(String $user) {
            $this->user = $user;
            $Query_Select = "SELECT * FROM detail_payment dp INNER JOIN payment pa ON (dp.payment=pa.id_payment) 
                             WHERE dp.estudiante = '$this->user' ORDER BY pa.id_payment DESC LIMIT 1";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectMesesActualesPagados(String $user, String $periodo, String $fecha) {
            $this->user = $user;
            $this->periodo = $periodo;
            $this->fecha = $fecha;
            $Query_Select = "SELECT count(pa.id_payment) AS valor 
                             FROM detail_payment dp INNER JOIN payment pa ON (dp.payment=pa.id_payment)
                             WHERE dp.estudiante = '$this->user' 
                             AND pa.periodo = '$this->periodo' AND pa.fecha_pago <= '$this->fecha'";
            $result = $this->SelectMySQL($Query_Select);
            $valor = $result['valor'];
            return $valor;
        }

        public function UpdateMarkReadNotifications(int $id_notification, String $user) {
            $this->id_notification = $id_notification;
            $this->user = $user;
            $this->leida = 1;
            $Query_Update = "UPDATE notifications nt INNER JOIN detail_notifications dn ON (nt.id_notifications=dn.notifications) 
                             SET nt.leida=? 
                             WHERE nt.id_notifications = $this->id_notification AND dn.usuario = '$this->user'";
            $Array_Query = array($this->leida);
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $result;
        }
    } 
?>