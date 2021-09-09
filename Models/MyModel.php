<?php
    class MyModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllNotifications(String $user) {
            $this->user = $user;
            $Query_Select_All = "SELECT * FROM notifications WHERE usuario = '$this->user' ORDER BY fecha DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectInfoNotificationsPayment(String $user, String $date) {
            $this->user = $user;
            $this->date = $date;
            $Query_Select = "SELECT * FROM payment WHERE estudiante = '$this->user' AND fecha_pago = '$this->date'";
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
            $Query_Select = "SELECT * FROM payment WHERE estudiante = '$this->user' ORDER BY id_payment DESC LIMIT 1";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectMesesActualesPagados(String $user, String $periodo, String $fecha) {
            $this->user = $user;
            $this->periodo = $periodo;
            $this->fecha = $fecha;
            $Query_Select = "SELECT count(id_payment) AS valor FROM payment 
                             WHERE estudiante = '$this->user' AND periodo = '$this->periodo' AND fecha_pago <= '$this->fecha'";
            $result = $this->SelectMySQL($Query_Select);
            $valor = $result['valor'];
            return $valor;
        }

        public function UpdateMarkReadNotifications(int $id_notification, String $user) {
            $this->id_notification = $id_notification;
            $this->user = $user;
            $this->leida = 1;
            $Query_Update = "UPDATE notifications SET leida=? WHERE id_notifications = $this->id_notification AND usuario = '$this->user'";
            $Array_Query = array($this->leida);
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $result;
        }
    }
?>