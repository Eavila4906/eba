<?php
    class Payment_recordModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        //*
        public function SelectAllAccounting() {
            $Query_Select_All = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.date_LP, ac.date_NP, da.share, da.full_value, da.estudiante AS DNI
                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE da.status = 1 AND st.proceso_contable = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        //*
        public function SelectDataUserAccounting(String $DNI, int $id_accounting) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;

            $Query_Select = "SELECT us.DNI, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres, 
                                    ac.date_LP, us.email
                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE ac.id_accounting = '$this->id_accounting' AND da.estudiante = '$this->DNI'";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        //*
        public function SelectPeriodo(String $DNI, String $id_accounting) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;
            $Query_Select = "SELECT ac.date_SA, ac.date_FA, ac.date_LP
                             FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                             WHERE ac.id_accounting = '$this->id_accounting' AND da.estudiante = '$this->DNI'";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        //*
        public function InsertPaymentRecord(String $DNI, int $id_accounting, String $date_LP, String $InputTypePayment, String $InputDescripcion) {
            $this->DNI = $DNI;
            $this->id_accounting = $id_accounting;
            $this->date_LP = $date_LP;
            $this->InputTypePayment = $InputTypePayment;
            $this->InputDescripcion = $InputDescripcion;

            //Validate rango date
            $Query_Select = "SELECT da.share_value, ac.date_SA, ac.date_FA, ac.date_LP 
                             FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                             WHERE ac.id_accounting = $this->id_accounting AND da.estudiante = '$this->DNI'";
            $result_select = $this->SelectMySQL($Query_Select);
            $date_FA = $result_select['date_FA'];
            $date_LP = $result_select['date_LP'];
            $periodo = $result_select['date_SA']." - ".$date_FA;
            $valor = $result_select['share_value'];

            $Query_Select_PD = "SELECT * FROM paymentday WHERE id_paymentday = 1";                   
            $PD = $this->SelectMySQL($Query_Select_PD);

            $paymentDay = $PD['day'];
            if ($paymentDay <= 9) {
                $paymentDay = '0'.$paymentDay;
            }
            $day = $paymentDay;
            $date_FA_format = paymentDay($date_FA).$day;

            if ($date_FA_format > $this->date_LP) {
                //Insert payment table
                $Query_Insert_payment = "INSERT INTO payment (tipo_pago, fecha_pago, valor, periodo, estado, descripcion) 
                                         VALUES (?, ?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->InputTypePayment, 
                                             $this->date_LP, $valor, $periodo, 1, $this->InputDescripcion);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

                //Inser detail paymet table
                $Query_Insert_d_payment = "INSERT INTO detail_payment (estudiante, payment) VALUES (?, ?)";
                $Array_Query_d_payment = array($this->DNI, $result_insert_payment);
                $result_insert_d_payment = $this->InsertMySQL($Query_Insert_d_payment, $Array_Query_d_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->date_LP', INTERVAL 1 MONTH ) AS date_NP";
                $result_select = $this->SelectMySQL($Query_Select);
                $date_NP = $result_select['date_NP'];

                //update date payment accounting
                $Query_Update = "UPDATE detail_accounting da INNER JOIN accounting ac ON (ac.id_accounting=da.accounting)
                                 SET ac.date_LP=?, ac.date_NP=? 
                                 WHERE ac.id_accounting = $this->id_accounting AND da.estudiante = '$this->DNI'";
                $Array_Query = array($this->date_LP, $date_NP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

                //Insert notifications table
                $tipo = "Pago";
                $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, ?, ?)";
                $Array_Query_notifications = array($tipo, $this->date_LP, 0);
                $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
                
                //Insert detail notifications table
                $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
                $Array_Query_d_notifications = array($this->DNI, $result_insert_notifications);
                $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);

                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0
                    && $result_insert_d_payment > 0 && $result_insert_d_notifications > 0) {
                    $result = 1; 
                } else {
                    $result = 0; 
                }
            } else {
                //Insert payment table  
                $Query_Insert_payment = "INSERT INTO payment (tipo_pago, fecha_pago, valor, periodo, estado, descripcion) 
                                         VALUES (?, ?, ?, ?, ?, ?)";
                $Array_Query_payment = array($this->InputTypePayment, 
                                             $this->date_LP, $valor, $periodo, 0, $this->InputDescripcion);
                $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);
                //Insert detail payment table  
                $Query_Insert_d_payment = "INSERT INTO detail_payment (estudiante, payment) VALUES (?, ?)";
                $Array_Query_d_payment = array($this->DNI, $result_insert_payment);
                $result_insert_d_payment = $this->InsertMySQL($Query_Insert_d_payment, $Array_Query_d_payment);

                //Generate range 1 month 
                $Query_Select = "SELECT DATE_ADD('$this->date_LP', INTERVAL 1 MONTH ) AS date_NP";
                $result_select = $this->SelectMySQL($Query_Select);
                $date_NP = $result_select['date_NP'];

                //update date payment accounting
                $Query_Update = "UPDATE detail_accounting da INNER JOIN accounting ac ON (ac.id_accounting=da.accounting)
                                 SET ac.date_LP=?, ac.date_NP=? 
                                 WHERE ac.id_accounting = $this->id_accounting AND da.estudiante = '$this->DNI'";
                $Array_Query = array($this->date_LP, $date_NP);
                $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

                //Insert notifications table
                $tipo = "Pago Final";
                $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, ?, ?)";
                $Array_Query_notifications = array($tipo, $this->date_LP, 0);
                $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
                
                //Insert detail notifications table
                $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
                $Array_Query_d_notifications = array($this->DNI, $result_insert_notifications);
                $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);

                //Finish accounting
                $Query_Update_C1 = "UPDATE detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    SET ac.date_NP='0000-00-00 00:00:00', da.status=? 
                                    WHERE ac.id_accounting = $this->id_accounting AND da.estudiante = '$this->DNI'";
                $Array_Query_C1 = array(0);
                $result_update_C1 = $this->UpdateMySQL($Query_Update_C1, $Array_Query_C1);

                $Query_Update_C2 = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->DNI'";
                $Array_Query_C2 = array(0);
                $result_update_C2 = $this->UpdateMySQL($Query_Update_C2, $Array_Query_C2);

                //Cancel payment
                $Query_Update_C3 = "UPDATE payment pa INNER JOIN detail_payment dp ON (pa.id_payment=dp.payment)
                                    SET pa.estado=? 
                                    WHERE dp.estudiante = '$this->DNI' AND pa.periodo = '$periodo' ";
                $Array_Query_C3 = array(0);
                $result_update_C3 = $this->UpdateMySQL($Query_Update_C3, $Array_Query_C3);

                if ($result_insert_payment > 0 && $result_update > 0 && $result_insert_notifications > 0
                    && $result_update_C1 > 0 && $result_update_C2 > 0 && $result_update_C3 > 0
                    && $result_insert_d_payment > 0 && $result_insert_d_notifications > 0) {
                    $result = "rango completo"; 
                } else {
                    $result = 0; 
                }
            }
            return $result;
        }

        //*
        public function SelectPaymentDay() {
            $Query_Select = "SELECT * FROM paymentday WHERE id_paymentday = 1";                   
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        //*
        public function UpdatePaymentDay(int $day) {
            $this->day = $day;

            $Query_Update_PD = "UPDATE paymentday SET day=? WHERE id_paymentday = 1";
            $Array_Query_PD = array($this->day);
            $result_PD = $this->UpdateMySQL($Query_Update_PD, $Array_Query_PD);

            $Query_Select_All_AC = "SELECT ac.id_accounting, ac.date_NP 
                                    FROM detail_accounting da INNER JOIN accounting ac ON(da.accounting=ac.id_accounting)
                                    WHERE da.status = 1";
            $result_AC = $this->SelectAllMySQL($Query_Select_All_AC);

            $Query_Select_PD = "SELECT * FROM paymentday WHERE id_paymentday = 1";                   
            $PD = $this->SelectMySQL($Query_Select_PD);

            $paymentDay = $PD['day'];
            if ($paymentDay <= 9) {
                $paymentDay = '0'.$paymentDay;
            }

            for ($i=0; $i < count($result_AC); $i++) { 
                $date = paymentDay($result_AC[$i]['date_NP']).$day;
                $id_accounting = $result_AC[$i]['id_accounting'];
                $Query_Update_AC = "UPDATE detail_accounting da INNER JOIN accounting ac ON(da.accounting=ac.id_accounting)
                                    SET ac.date_NP=? 
                                    WHERE ac.id_accounting = $id_accounting AND da.status = 1";
                $Array_Query_AC = array($date);
                $result_U_AC = $this->UpdateMySQL($Query_Update_AC, $Array_Query_AC);
            }

            if ($result_PD > 0 || $result_AC > 0 || $PD > 0 || $result_U_AC > 0) {
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
        }

        //Deprecated function
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
        //Deprecated function
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