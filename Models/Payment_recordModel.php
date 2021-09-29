<?php
    class Payment_recordModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllAccounting() {
            $Query_Select_All = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.fecha_UP, ac.fecha_PP, ac.cuota, ac.valor, ac.estudiante AS DNI
                                    FROM accounting ac INNER JOIN student st ON (ac.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE ac.estado = 1 AND st.proceso_contable = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectDataUserAccounting(String $DNI, int $id_accounting) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;

            $Query_Select = "SELECT us.DNI, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres, 
                                    ac.fecha_UP, us.email
                                    FROM accounting ac INNER JOIN student st ON (ac.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE ac.id_accounting = '$this->id_accounting' AND ac.estudiante = '$this->DNI'";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectPeriodo(String $DNI, String $id_accounting) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;
            $Query_Select = "SELECT fecha_IC, fecha_FC, fecha_UP
                             FROM accounting 
                             WHERE id_accounting = '$this->id_accounting' AND estudiante = '$this->DNI'";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertPaymentRecord(String $DNI, int $id_accounting, String $fecha_UP, String $InputTypePayment, String $InputDescripcion) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;
            $this->fecha_UP = $fecha_UP;
            $this->InputTypePayment = $InputTypePayment;
            $this->InputDescripcion = $InputDescripcion;

            //Validate rango date
            $Query_Select = "SELECT valor, fecha_IC, fecha_FC, fecha_UP FROM accounting WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
            $result_select = $this->SelectMySQL($Query_Select);
            $fecha_FC = $result_select['fecha_FC'];
            $fecha_UP = $result_select['fecha_UP'];
            $periodo = $result_select['fecha_IC']." - ".$fecha_FC;
            $valor = $result_select['valor'];

            if ($fecha_FC > $this->fecha_UP) {
                //Insert payment
                $Query_Insert_payment = "INSERT INTO payment (estudiante, tipo_pago, fecha_pago, valor, periodo, estado, descripcion) 
                                         VALUES (?, ?, ?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->DNI, $this->InputTypePayment, 
                                             $this->fecha_UP, $valor, $periodo, 1, $this->InputDescripcion);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->fecha_UP', INTERVAL 1 MONTH ) AS fecha_pp";
                $result_select = $this->SelectMySQL($Query_Select);
                $fecha_PP = $result_select['fecha_pp'];

                //update date payment accounting
                $Query_Update = "UPDATE accounting SET fecha_UP=?, fecha_PP=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query = array($this->fecha_UP, $fecha_PP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

                //Insert notifications
                $tipo = "Pago";
                $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, ?, ?)";
                $Array_Query_notifications = array($this->DNI, $tipo, $this->fecha_UP, 0);
                $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
                
                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0) {
                    $result = 1; 
                } else {
                    $result = 0; 
                }
            } else {
                //Insert payment  
                $Query_Insert_payment = "INSERT INTO payment (estudiante, tipo_pago, fecha_pago, valor, periodo, estado, descripcion) 
                                         VALUES (?, ?, ?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->DNI, $this->InputTypePayment, 
                                             $this->fecha_UP, $valor, $periodo, 0, $this->InputDescripcion);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->fecha_UP', INTERVAL 1 MONTH ) AS fecha_pp";
                $result_select = $this->SelectMySQL($Query_Select);
                $fecha_PP = $result_select['fecha_pp'];

                //update date payment accounting
                $Query_Update = "UPDATE accounting SET fecha_UP=?, fecha_PP=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query = array($this->fecha_UP, $fecha_PP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

                //Insert notifications
                $tipo = "Pago Final";
                $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, ?, ?)";
                $Array_Query_notifications = array($this->DNI, $tipo, $this->fecha_UP, 0);
                $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
                
                //Finish accounting
                $Query_Update_C1 = "UPDATE accounting SET fecha_PP='0000-00-00 00:00:00', estado=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query_C1 = array(0);
                $result_update_C1 = $this->UpdateMySQL($Query_Update_C1, $Array_Query_C1);

                $Query_Update_C2 = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->DNI'";
                $Array_Query_C2 = array(0);
                $result_update_C2 = $this->UpdateMySQL($Query_Update_C2, $Array_Query_C2);

                //Cancel payment
                $Query_Update_C3 = "UPDATE payment SET estado=? WHERE estudiante = '$this->DNI' AND periodo = '$periodo'";
                $Array_Query_C3 = array(0);
                $result_update_C3 = $this->UpdateMySQL($Query_Update_C3, $Array_Query_C3);

                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0
                    && $result_update_C1 > 0 && $result_update_C2 > 0 && $result_update_C3 > 0) {
                    $result = "rango completo"; 
                } else {
                    $result = 0; 
                }
            }
            return $result;
        }

        public function InsertPaymentRecordTotal(String $DNI, int $id_accounting, String $fecha_UP) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;
            $this->fecha_UP = $fecha_UP;

            //Validate rango date
            $Query_Select = "SELECT valor, fecha_IC, fecha_FC, fecha_UP FROM accounting WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
            $result_select = $this->SelectMySQL($Query_Select);
            $fecha_FC = $result_select['fecha_FC'];
            $fecha_UP = $result_select['fecha_UP'];
            $periodo = $result_select['fecha_IC']." - ".$fecha_FC;
            $valor = $result_select['valor'];

            if ($fecha_FC > $this->fecha_UP) {
                //Insert payment
                $Query_Insert_payment = "INSERT INTO payment (estudiante, fecha_pago, valor, periodo, estado) VALUES (?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->DNI, $this->fecha_UP, $valor, $periodo, 1);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->fecha_UP', INTERVAL 1 MONTH ) AS fecha_pp";
                $result_select = $this->SelectMySQL($Query_Select);
                $fecha_PP = $result_select['fecha_pp'];

                //update date payment accounting
                $Query_Update = "UPDATE accounting SET fecha_UP=?, fecha_PP=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query = array($this->fecha_UP, $fecha_PP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);
                
                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0) {
                    $result = 1; 
                } else {
                    $result = 0; 
                }
            } else {
                //Insert payment  
                $Query_Insert_payment = "INSERT INTO payment (estudiante, fecha_pago, valor, periodo, estado) VALUES (?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->DNI, $this->fecha_UP, $valor, $periodo, 0);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->fecha_UP', INTERVAL 1 MONTH ) AS fecha_pp";
                $result_select = $this->SelectMySQL($Query_Select);
                $fecha_PP = $result_select['fecha_pp'];

                //update date payment accounting
                $Query_Update = "UPDATE accounting SET fecha_UP=?, fecha_PP=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query = array($this->fecha_UP, $fecha_PP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

                //Insert notifications
                $tipo = "Pago total";
                $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, ?, ?)";
                $Array_Query_notifications = array($this->DNI, $tipo, $this->fecha_UP, 0);
                $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
                
                //Finish accounting
                $Query_Update_C1 = "UPDATE accounting SET fecha_PP='0000-00-00 00:00:00', estado=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query_C1 = array(0);
                $result_update_C1 = $this->UpdateMySQL($Query_Update_C1, $Array_Query_C1);

                $Query_Update_C2 = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->DNI'";
                $Array_Query_C2 = array(0);
                $result_update_C2 = $this->UpdateMySQL($Query_Update_C2, $Array_Query_C2);

                //Cancel payment
                $Query_Update_C3 = "UPDATE payment SET estado=? WHERE estudiante = '$this->DNI' AND periodo = '$periodo'";
                $Array_Query_C3 = array(0);
                $result_update_C3 = $this->UpdateMySQL($Query_Update_C3, $Array_Query_C3);

                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0
                    && $result_update_C1 > 0 && $result_update_C2 > 0 && $result_update_C3 > 0) {
                    $result = "rango completo"; 
                } else {
                    $result = 0; 
                }
            }
            return $result;
        }

        public function InsertPaymentRecordNotAccounting(String $DNI, int $id_accounting, String $fecha_UP, String $InputDescripcion) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;
            $this->fecha_UP = $fecha_UP;
            $this->InputDescripcion = $InputDescripcion;

            //Validate rango date
            $Query_Select = "SELECT valor, fecha_IC, fecha_FC, fecha_UP FROM accounting WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
            $result_select = $this->SelectMySQL($Query_Select);
            $fecha_FC = $result_select['fecha_FC'];
            $fecha_UP = $result_select['fecha_UP'];
            $periodo = $result_select['fecha_IC']." - ".$fecha_FC;
            $valor = $result_select['valor'];

            if ($fecha_FC > $this->fecha_UP) {
                //Insert payment
                $Query_Insert_payment = "INSERT INTO payment (estudiante, fecha_pago, valor, periodo, estado, observacion, descripcion) 
                                         VALUES (?, ?, ?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->DNI, $this->fecha_UP, $valor, $periodo, 1, 1, $this->InputDescripcion);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->fecha_UP', INTERVAL 1 MONTH ) AS fecha_pp";
                $result_select = $this->SelectMySQL($Query_Select);
                $fecha_PP = $result_select['fecha_pp'];

                //update date payment accounting
                $Query_Update = "UPDATE accounting SET fecha_UP=?, fecha_PP=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query = array($this->fecha_UP, $fecha_PP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

                //Insert notifications
                $tipo = "Pago (No contable)";
                $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, ?, ?)";
                $Array_Query_notifications = array($this->DNI, $tipo, $this->fecha_UP, 0);
                $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
                
                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0) {
                    $result = 1; 
                } else {
                    $result = 0; 
                }
            } else {
                //Insert payment  
                $Query_Insert_payment = "INSERT INTO payment (estudiante, fecha_pago, valor, periodo, estado, observacion, descripcion) 
                                         VALUES (?, ?, ?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->DNI, $this->fecha_UP, $valor, $periodo, 0, 1, $this->InputDescripcion);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->fecha_UP', INTERVAL 1 MONTH ) AS fecha_pp";
                $result_select = $this->SelectMySQL($Query_Select);
                $fecha_PP = $result_select['fecha_pp'];

                //update date payment accounting
                $Query_Update = "UPDATE accounting SET fecha_UP=?, fecha_PP=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query = array($this->fecha_UP, $fecha_PP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

                //Insert notifications
                $tipo = "Pago Final (No contable)";
                $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, ?, ?)";
                $Array_Query_notifications = array($this->DNI, $tipo, $this->fecha_UP, 0);
                $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
                
                //Finish accounting
                $Query_Update_C1 = "UPDATE accounting SET fecha_PP='0000-00-00 00:00:00', estado=? WHERE id_accounting = $this->id_accounting AND estudiante = '$this->DNI'";
                $Array_Query_C1 = array(0);
                $result_update_C1 = $this->UpdateMySQL($Query_Update_C1, $Array_Query_C1);

                $Query_Update_C2 = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->DNI'";
                $Array_Query_C2 = array(0);
                $result_update_C2 = $this->UpdateMySQL($Query_Update_C2, $Array_Query_C2);

                //Cancel payment
                $Query_Update_C3 = "UPDATE payment SET estado=? WHERE estudiante = '$this->DNI' AND periodo = '$periodo'";
                $Array_Query_C3 = array(0);
                $result_update_C3 = $this->UpdateMySQL($Query_Update_C3, $Array_Query_C3);

                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0
                    && $result_update_C1 > 0 && $result_update_C2 > 0 && $result_update_C3 > 0) {
                    $result = "rango completo - no contable"; 
                } else {
                    $result = 0; 
                }
            }
            return $result;
        }

    }
?>