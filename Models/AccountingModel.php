<?php
    class AccountingModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }
        /* Starts starts accounting */
        public function SelectAllStudents() {
            $Query_Select_All = "SELECT st.id_student, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    us.DNI
                                    FROM student st INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE st.proceso_contable = 0 AND us.estado = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectDataUserAccounting(String $DNI) {
            $this->DNI = $DNI;
            $Query_Select = "SELECT us.DNI, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres, 
                                    ac.fecha_UP, us.email
                                    FROM accounting ac INNER JOIN student st ON (ac.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE ac.estudiante = '$this->DNI' AND ac.estado = 1";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectDataUserPT(String $DNI) {
            $this->DNI = $DNI;
            $Query_Select = "SELECT CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres, us.email
                                    FROM student st INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE us.DNI = '$this->DNI' AND estado = 1";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertAccounting(String $id_student, String $InputTypePayment_sa, String $InputCuota, $InputValor, String $InputFechaIC, String $InputFechaFC) {
            $this->id_student = $id_student;
            $this->InputTypePayment_sa = $InputTypePayment_sa;
            $this->InputCuota = $InputCuota;
            $this->InputValor = $InputValor;
            $this->InputFechaIC = $InputFechaIC;
            $this->InputFechaFC = $InputFechaFC;
            //$fecha_actual = date("Y-m-d");
            if ($this->InputFechaFC <= $this->InputFechaIC) {
                return "invalid date";
                die();
            }
            //Student Starts accounting process
            $Query_Select = "SELECT DATE_ADD('$this->InputFechaIC', INTERVAL 1 MONTH ) AS fecha_pp";
            $result_select = $this->SelectMySQL($Query_Select);
            $fecha_pp = $result_select['fecha_pp'];

            $Query_Insert = "INSERT INTO accounting (estudiante, fecha_IC, fecha_FC, fecha_UP, fecha_PP, cuota, valor, estado) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $Array_Query = array($this->id_student, $this->InputFechaIC, $this->InputFechaFC, $this->InputFechaIC, $fecha_pp, $this->InputCuota, $this->InputValor, 1);
            $result_insert = $this->InsertMySQL($Query_Insert, $Array_Query);
            
            //Insert payment
            $Query_Insert_payment = "INSERT INTO payment (estudiante, tipo_pago, fecha_pago, valor, periodo, estado) 
                                     VALUES (?, ?, ?, ?, CONCAT('$this->InputFechaIC',' - ', '$this->InputFechaFC'), ?)";
            $Array_Query_payment = array($this->id_student, $this->InputTypePayment_sa, $this->InputFechaIC, $this->InputValor, 1);
            $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

            //Insert notifications
            $tipo = "Pago Inicial";
            $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, ?, ?)";
            $Array_Query_notifications = array($this->id_student, $tipo, $this->InputFechaIC, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
            
            //Student Starts accounting process
            $Query_Update = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->id_student'";
            $Array_Query = array(1);
            $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

            if ($result_insert > 0 && $result_update > 0) {
               $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        public function InsertTotalPurchaseAccounting(String $id_studentTP, String $InputTypePayment, $InputValorTP, $valor, String $InputFechaInicio, String $InputFechaFinal, String $InputDescripcion) {
            $this->id_studentTP = $id_studentTP;
            $this->InputTypePayment = $InputTypePayment;
            $this->InputValorTP = $InputValorTP;
            $this->valor = $valor;
            $this->InputFechaInicio = $InputFechaInicio;
            $this->InputFechaFinal = $InputFechaFinal;
            $this->InputDescripcion = $InputDescripcion;
            //$fecha_actual = date("Y-m-d");
            if ($this->InputFechaFinal <= $this->InputFechaInicio) {
                return "invalid date";
                die();
            }

            $Query_Insert = "INSERT INTO accounting (estudiante, fecha_IC, fecha_FC, fecha_UP, fecha_PP, cuota, valor, estado) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $Array_Query = array($this->id_studentTP, 
                                 $this->InputFechaInicio, 
                                 $this->InputFechaFinal, 
                                 $this->InputFechaFinal, 
                                 '0000-00-00', 
                                 'Compra Total', 
                                 $this->InputValorTP, 0);
            $result_insert = $this->InsertMySQL($Query_Insert, $Array_Query);
            
            //Insert payment
            $Query_Insert_payment = "INSERT INTO payment (estudiante, tipo_pago, fecha_pago, valor, periodo, estado, descripcion) 
                                     VALUES (?, ?, ?, ?, CONCAT('$this->InputFechaInicio',' - ', '$this->InputFechaFinal'), ?, ?)";
            $Array_Query_payment = array($this->id_studentTP, $this->InputTypePayment, $this->InputFechaInicio, $this->valor, 5, $this->InputDescripcion);
            $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

            //Insert notifications
            $tipo = "Pago Total";
            $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, ?, ?)";
            $Array_Query_notifications = array($this->id_studentTP, $tipo, $this->InputFechaInicio, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            if ($result_insert > 0 && $result_insert_payment > 0 && $result_insert_notifications > 0) {
               $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }
        /* Finish starts accounting */

        /* Starts stopt accounting */
        public function SelectAllAccounting() {
            $Query_Select_All = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.fecha_IC, ac.fecha_FC, ac.fecha_UP, ac.fecha_PP, ac.cuota, ac.valor, ac.estudiante AS DNI, ac.estado
                                    FROM accounting ac INNER JOIN student st ON (ac.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE (ac.estado = 1 OR ac.estado = 2) AND st.proceso_contable = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function stopAccounting(String $id_student, String $periodo) {
            $this->id_student = $id_student;
            $this->periodo = $periodo;
            $Query_Update_TS = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->id_student'";
            $Array_Query_TS = array(0);
            $result_update_TS = $this->UpdateMySQL($Query_Update_TS, $Array_Query_TS);

            $Query_Update_TA = "UPDATE accounting SET estado=? WHERE estudiante = '$this->id_student'";
            $Array_Query_TA = array(0);
            $result_update_TA = $this->UpdateMySQL($Query_Update_TA, $Array_Query_TA);

            $Query_Update_TP = "UPDATE payment SET estado=? WHERE estudiante = '$this->id_student' AND periodo = '$this->periodo'";
            $Array_Query_TP = array(4);
            $result_update_TP = $this->UpdateMySQL($Query_Update_TP, $Array_Query_TP);

            //Insert notifications
            $tipo = "Contabilidad detenida";
            $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, CURRENT_DATE(), ?)";
            $Array_Query_notifications = array($this->id_student, $tipo, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            if ($result_update_TS > 0 && $result_update_TA > 0 && $result_update_TP > 0 
                && $result_insert_notifications > 0) {
                $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        public function pauseAccounting(String $id_student, String $periodo) {
            $this->id_student = $id_student;
            $this->periodo = $periodo;

            $Query_Update_TA = "UPDATE accounting SET estado=? WHERE estudiante = '$this->id_student' AND 
                                       CONCAT(fecha_IC, ' - ', fecha_FC) = '$this->periodo' AND 
                                       estado = 1";
            $Array_Query_TA = array(2);
            $result_update_TA = $this->UpdateMySQL($Query_Update_TA, $Array_Query_TA);

            $Query_Update_TP = "UPDATE payment SET estado=? WHERE estudiante = '$this->id_student' AND periodo = '$this->periodo'";
            $Array_Query_TP = array(3);
            $result_update_TP = $this->UpdateMySQL($Query_Update_TP, $Array_Query_TP);

            //Insert notifications
            $tipo = "Contabilidad pausada";
            $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, CURRENT_DATE(), ?)";
            $Array_Query_notifications = array($this->id_student, $tipo, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            if ($result_update_TA > 0 && $result_update_TP > 0 && $result_insert_notifications > 0) {
                $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        public function playAccounting(String $id_student, String $periodo) {
            $this->id_student = $id_student;
            $this->periodo = $periodo;
            
            $Query_Update_TA = "UPDATE accounting SET estado=? WHERE estudiante = '$this->id_student' AND 
                                       CONCAT(fecha_IC, ' - ', fecha_FC) = '$this->periodo' AND 
                                       estado = 2";
            $Array_Query_TA = array(1);
            $result_update_TA = $this->UpdateMySQL($Query_Update_TA, $Array_Query_TA);

            $Query_Update_TP = "UPDATE payment SET estado=? WHERE estudiante = '$this->id_student' AND periodo = '$this->periodo'";
            $Array_Query_TP = array(1);
            $result_update_TP = $this->UpdateMySQL($Query_Update_TP, $Array_Query_TP);

            //Insert notifications
            $tipo = "Contabilidad reanudada";
            $Query_Insert_notifications = "INSERT INTO notifications (usuario, tipo, fecha, leida) VALUES (?, ?, CURRENT_DATE(), ?)";
            $Array_Query_notifications = array($this->id_student, $tipo, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            if ($result_update_TA > 0 && $result_update_TP > 0 && $result_insert_notifications > 0) {
                $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        /* Finish stopt accounting */
    }
?>