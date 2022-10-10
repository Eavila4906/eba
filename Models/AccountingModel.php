<?php
    class AccountingModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

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
                                    ac.date_LP, us.email
                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE da.estudiante = '$this->DNI' AND da.status = 1";
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

        public function periodValidation(String $id_student, String $InputFechaIC, String $InputFechaFC) {
            $this->id_student = $id_student;
            $this->InputFechaIC = $InputFechaIC;
            $this->InputFechaFC = $InputFechaFC;
            $period = $this->InputFechaIC." - ".$this->InputFechaFC;

            $Query_Select_All = "SELECT *
                                 FROM detail_payment dp INNER JOIN payment pt ON(dp.payment=pt.id_payment)
                                 WHERE dp.estudiante = '$this->id_student' AND pt.periodo = '$period'";
            $result = $this->SelectAllMySQL($Query_Select_All);
            if ($result) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        }

        public function SelectPaymentDay() {
            $Query_Select = "SELECT * FROM paymentday WHERE id_paymentday = 1";                   
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertAccounting(String $id_student, String $InputTypePayment_sa, String $InputCuota, $InputValor, $valor_ordinario, String $InputFechaIC, String $InputFechaFC, String $fecha_UP, $descuento, $valor_descuento, $valor_total_descuento, $descripcion) {
            $this->id_student = $id_student;
            $this->InputTypePayment_sa = $InputTypePayment_sa;
            $this->InputCuota = $InputCuota;
            $this->InputValor = $InputValor;
            $this->valor_ordinario = $valor_ordinario;
            $this->InputFechaIC = $InputFechaIC;
            $this->InputFechaFC = $InputFechaFC;
            $this->fecha_UP = $fecha_UP;
            $this->descuento = $descuento;
            $this->valor_descuento = $valor_descuento;
            $this->valor_total_descuento = $valor_total_descuento;
            $this->descripcion = $descripcion;
            //$fecha_actual = date("Y-m-d");
            if ($this->InputFechaFC <= $this->InputFechaIC) {
                return "invalid date";
                die();
            }
            //Student Starts accounting process
            $Query_Select = "SELECT DATE_ADD('$this->fecha_UP', INTERVAL 1 MONTH ) AS fecha_pp";
            $result_select = $this->SelectMySQL($Query_Select);
            $fecha_pp = $result_select['fecha_pp'];

            $Query_Insert = "INSERT INTO accounting (estudiante, fecha_IC, fecha_FC, fecha_UP, fecha_PP, cuota, valor, valor_total, descuento, valor_descuento, valor_total_descuento, descripcion, estado) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $Array_Query = array($this->id_student, $this->InputFechaIC, 
                                 $this->InputFechaFC, $this->fecha_UP, 
                                 $fecha_pp, $this->InputCuota, 
                                 $this->InputValor, $this->valor_ordinario,
                                 $this->descuento, $this->valor_descuento, 
                                 $this->valor_total_descuento, $this->descripcion, 1);
            $result_insert = $this->InsertMySQL($Query_Insert, $Array_Query);
            
            //Insert payment
            $Query_Insert_payment = "INSERT INTO payment (tipo_pago, fecha_pago, valor, periodo, estado) 
                                     VALUES (?, ?, ?, CONCAT('$this->InputFechaIC',' - ', '$this->InputFechaFC'), ?)";
            $Array_Query_payment = array($this->InputTypePayment_sa, $this->fecha_UP, $this->InputValor, 1);
            $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

            $Query_Insert_d_payment = "INSERT INTO detail_payment (estudiante, payment) VALUES (?, ?)";
            $Array_Query_d_payment = array($this->id_student, $result_insert_payment);
            $result_insert_d_payment = $this->InsertMySQL($Query_Insert_d_payment, $Array_Query_d_payment);


            //Insert notifications
            $tipo = "Pago Inicial";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, ?, ?)";
            $Array_Query_notifications = array($tipo, $this->fecha_UP, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
            
            $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_d_notifications = array($this->id_student, $result_insert_notifications);
            $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);

            //Student Starts accounting process
            $Query_Update = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->id_student'";
            $Array_Query = array(1);
            $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

            if ($result_insert > 0 && $result_insert_payment > 0 && $result_insert_d_payment > 0 
            && $result_insert_notifications > 0 && $result_insert_d_notifications > 0 && $result_update > 0) {
               $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        public function InsertTotalPurchaseAccounting(String $id_studentTP, String $InputTypePayment, $InputValorTP, $InputValorO, String $InputFechaInicio, String $InputFechaFinal, $descuento, $valor_descuento, $valor_total_descuento, String $InputDescripcion) {
            $this->id_studentTP = $id_studentTP;
            $this->InputTypePayment = $InputTypePayment;
            $this->InputValorTP = $InputValorTP;
            $this->InputValorO = $InputValorO;
            $this->InputFechaInicio = $InputFechaInicio;
            $this->InputFechaFinal = $InputFechaFinal;
            $this->descuento = $descuento;
            $this->valor_descuento = $valor_descuento;
            $this->valor_total_descuento = $valor_total_descuento;
            $this->InputDescripcion = $InputDescripcion;
            //$fecha_actual = date("Y-m-d");
            if ($this->InputFechaFinal <= $this->InputFechaInicio) {
                return "invalid date";
                die();
            }

            $Query_Insert = "INSERT INTO accounting (estudiante, fecha_IC, fecha_FC, fecha_UP, fecha_PP, cuota, valor, valor_total, descuento, valor_descuento, valor_total_descuento, descripcion, estado) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $Array_Query = array($this->id_studentTP, 
                                 $this->InputFechaInicio, 
                                 $this->InputFechaFinal, 
                                 $this->InputFechaFinal, 
                                 '0000-00-00', 
                                 'Compra Total', 
                                 $this->InputValorTP, $this->InputValorO, 
                                 $this->descuento, $this->valor_descuento, 
                                 $this->valor_total_descuento, $this->InputDescripcion, 0);
            $result_insert = $this->InsertMySQL($Query_Insert, $Array_Query);
            
            //Insert payment
            $Query_Insert_payment = "INSERT INTO payment (tipo_pago, fecha_pago, valor, periodo, estado, descripcion) 
                                     VALUES (?, ?, ?, CONCAT('$this->InputFechaInicio',' - ', '$this->InputFechaFinal'), ?, ?)";
            $Array_Query_payment = array($this->InputTypePayment, $this->InputFechaInicio, $this->InputValorTP, 5, $this->InputDescripcion);
            $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

            $Query_Insert_d_payment = "INSERT INTO detail_payment (estudiante, payment) VALUES (?, ?)";
            $Array_Query_d_payment = array($this->id_studentTP, $result_insert_payment);
            $result_insert_d_payment = $this->InsertMySQL($Query_Insert_d_payment, $Array_Query_d_payment);

            //Insert notifications
            $tipo = "Pago Total";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, ?, ?)";
            $Array_Query_notifications = array($tipo, $this->InputFechaInicio, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_d_notifications = array($this->id_studentTP, $result_insert_notifications);
            $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);

            if ($result_insert > 0 && $result_insert_payment > 0 && $result_insert_d_payment > 0 
                && $result_insert_notifications > 0 && $result_insert_d_notifications > 0) {
               $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }
        
        public function SelectAllAccounting() {
            $Query_Select_All = "SELECT ac.id_accounting, us.fechaNaci, 
                                    CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.date_SA, ac.date_FA, ac.date_LP, ac.date_NP, da.share, da.full_value, da.estudiante AS DNI, da.status
                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE (da.status = 1 OR da.status = 2) AND st.proceso_contable = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllInactiveAccounting() {
            $Query_Select_All = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    CONCAT(ac.date_SA, ' - ', ac.date_FA) AS periodo, COUNT(ac.id_accounting) AS periodos, 
                                    da.estudiante AS DNI, da.status
                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting) 
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE da.status = 0 GROUP BY da.estudiante ORDER BY periodos DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function stopAccounting(int $id_accounting, String $id_student, String $periodo, String $InputJustificacion) {
            $this->id_accounting = $id_accounting;
            $this->id_student = $id_student;
            $this->periodo = $periodo;
            $this->InputJustificacion = $InputJustificacion;
            $Query_Update_TS = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->id_student'";
            $Array_Query_TS = array(0);
            $result_update_TS = $this->UpdateMySQL($Query_Update_TS, $Array_Query_TS);

            $Query_Update_TA = "UPDATE accounting SET observacion=?, estado=? 
                                WHERE id_accounting = $this->id_accounting AND estudiante = '$this->id_student'";
            $Array_Query_TA = array($this->InputJustificacion, 0);
            $result_update_TA = $this->UpdateMySQL($Query_Update_TA, $Array_Query_TA);

            $Query_Update_TP = "UPDATE payment pa INNER JOIN detail_payment dp ON (pa.id_payment=dp.payment)
                                SET pa.estado=? 
                                WHERE dp.estudiante = '$this->id_student' AND pa.periodo = '$this->periodo' ";
            $Array_Query_TP = array(4);
            $result_update_TP = $this->UpdateMySQL($Query_Update_TP, $Array_Query_TP);

            //Insert notifications
            $tipo = "Contabilidad detenida";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, CURRENT_DATE(), ?)";
            $Array_Query_notifications = array($tipo, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_d_notifications = array($this->id_student, $result_insert_notifications);
            $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);
            
            if ($result_update_TS > 0 && $result_update_TA > 0 && $result_update_TP > 0 
                && $result_insert_notifications > 0 && $result_insert_d_notifications > 0) {
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

            $Query_Update_TP = "UPDATE payment pa INNER JOIN detail_payment dp ON (pa.id_payment=dp.payment)
                                SET pa.estado=? 
                                WHERE dp.estudiante = '$this->id_student' AND pa.periodo = '$this->periodo' ";
            $Array_Query_TP = array(3);
            $result_update_TP = $this->UpdateMySQL($Query_Update_TP, $Array_Query_TP);

            //Insert notifications
            $tipo = "Contabilidad pausada";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, CURRENT_DATE(), ?)";
            $Array_Query_notifications = array($tipo, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_d_notifications = array($this->id_student, $result_insert_notifications);
            $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);
            
            if ($result_update_TA > 0 && $result_update_TP > 0 && $result_insert_notifications > 0 && $result_insert_d_notifications > 0) {
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

            $Query_Update_TP = "UPDATE payment pa INNER JOIN detail_payment dp ON (pa.id_payment=dp.payment)
                                SET pa.estado=? 
                                WHERE dp.estudiante = '$this->id_student' AND pa.periodo = '$this->periodo' ";
            $Array_Query_TP = array(1);
            $result_update_TP = $this->UpdateMySQL($Query_Update_TP, $Array_Query_TP);

            //Insert notifications
            $tipo = "Contabilidad reanudada";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, CURRENT_DATE(), ?)";
            $Array_Query_notifications = array($tipo, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_d_notifications = array($this->id_student, $result_insert_notifications);
            $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);

            if ($result_update_TA > 0 && $result_update_TP > 0 && $result_insert_notifications > 0 && $result_insert_d_notifications > 0) {
                $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        public function SelectDetailsAccounting(int $id_accounting, String $dni, String $periodo) {
            $this->id_accounting = $id_accounting;
            $this->dni = $dni;
            $this->periodo = $periodo;

            $Query_Select = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.fecha_IC, ac.fecha_FC, ac.fecha_UP, ac.fecha_PP, ac.cuota, ac.valor, ac.valor_total, 
                                    ac.descuento, ac.valor_descuento, ac.valor_total_descuento, descripcion,
                                    ac.estudiante AS DNI, ac.estado
                                    
                                    FROM accounting ac INNER JOIN student st ON (ac.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE ac.estudiante = '$this->dni' AND CONCAT(ac.fecha_IC, ' - ', ac.fecha_FC) = '$this->periodo' AND
                                    ac.estado = 1 AND st.proceso_contable = 1 AND ac.id_accounting = $this->id_accounting";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectSeeIIA(String $dni) {
            $this->dni = $dni;
            $Query_Select = "SELECT ac.id_accounting, us.DNI, ac.fecha_IC, ac.fecha_FC, ac.fecha_UP, ac.fecha_PP
                                    FROM accounting ac INNER JOIN student st ON (ac.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE ac.estudiante = '$this->dni' AND ac.estado = 0";
            $result = $this->SelectAllMySQL($Query_Select);
            return $result;
        }

        public function SelectDIIA(String $dni, String $periodo) {
            $this->dni = $dni;
            $this->periodo = $periodo;

            $Query_Select = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.fecha_IC, ac.fecha_FC, ac.fecha_UP, ac.fecha_PP, ac.cuota, ac.valor, ac.valor_total, 
                                    ac.descuento, ac.valor_descuento, ac.valor_total_descuento, descripcion, observacion,
                                    ac.estudiante AS DNI, ac.estado
                                    
                                    FROM accounting ac INNER JOIN student st ON (ac.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE ac.estudiante = '$this->dni' AND CONCAT(ac.fecha_IC, ' - ', ac.fecha_FC) = '$this->periodo' AND
                                    ac.estado = 0";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function DeleteAccountingInactive(int $id_accounting) {
            $this->id_accounting = $id_accounting;
            $Query_Delete = "DELETE FROM accounting WHERE id_accounting = $this->id_accounting";
            $result = $this->DeleteMySQL($Query_Delete);

            if ($result) {
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
        }
    }
?>