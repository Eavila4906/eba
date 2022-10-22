<?php
    class AccountingModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        //*
        public function SelectAllStudents() {
            $Query_Select_All = "SELECT st.id_student, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    us.DNI
                                    FROM student st INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE st.proceso_contable = 0 AND us.estado = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        //*
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

        //*
        public function SelectDataUserPT(String $DNI) {
            $this->DNI = $DNI;
            $Query_Select = "SELECT CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS nombres, us.email
                                    FROM student st INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE us.DNI = '$this->DNI' AND estado = 1";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        //*
        public function periodValidation(String $id_student, String $InputFechaIC, String $InputFechaFC) {
            $this->id_student = $id_student;
            $this->InputFechaIC = $InputFechaIC;
            $this->InputFechaFC = $InputFechaFC;
            $period = $this->InputFechaIC." - ".$this->InputFechaFC;

            $Query_Select_All = "SELECT *
                                 FROM detail_payment dp INNER JOIN payment pt ON(dp.payment=pt.id_payment)
                                 WHERE dp.estudiante = '$this->id_student' AND pt.periodo = '$period'";
            $result = $this->SelectAllMySQL($Query_Select_All);
            if (!empty($result)) {
                $result = true;
            } else {
                $result = false;
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
        public function InsertAccounting(String $id_student, int $course, String $InputTypePayment_sa, String $InputShare, $InputFullValue, $share_value, String $InputDateSA, String $InputDateFA, String $Date_LP, $discount, $discount_value, $full_discount_value, $description) {
            $this->id_student = $id_student;
            $this->course = $course;
            $this->InputTypePayment_sa = $InputTypePayment_sa;
            $this->InputShare = $InputShare;
            $this->InputFullValue = $InputFullValue;
            $this->share_value = $share_value;
            $this->InputDateSA = $InputDateSA;
            $this->InputDateFA = $InputDateFA;
            $this->Date_LP =$Date_LP;
            $this->discount = $discount;
            $this->discount_value = $discount_value;
            $this->full_discount_value = $full_discount_value;
            $this->description = $description;
            //$fecha_actual = date("Y-m-d");
            if ($this->InputDateFA <= $this->InputDateSA) {
                return "invalid date";
                die();
            }
            //Student Starts accounting process
            $Query_Select = "SELECT DATE_ADD('$this->Date_LP', INTERVAL 1 MONTH ) AS date_np";
            $result_select = $this->SelectMySQL($Query_Select);
            $date_np = $result_select['date_np'];

            //Insert accounting table
            $Query_Insert_accounting = "INSERT INTO accounting (date_SA, date_FA, date_LP, date_NP) 
            VALUES (?, ?, ?, ?)";
            $Array_Query_accounting = array($this->InputDateSA, $this->InputDateFA, $this->Date_LP, $date_np);
            $result_insert_accounting = $this->InsertMySQL($Query_Insert_accounting, $Array_Query_accounting);

            //Insert detail accounting table
            $Query_Insert_da = "INSERT INTO detail_accounting (accounting, estudiante, course, share, full_value, share_value, discount, discount_value, full_discount_value, description, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $Array_Query_da = array($result_insert_accounting, $this->id_student, $this->course, $this->InputShare,
                                    $this->InputFullValue, $this->share_value, $this->discount, $this->discount_value, 
                                    $this->full_discount_value, $this->description, 1);
            $result_insert_da = $this->InsertMySQL($Query_Insert_da, $Array_Query_da);

            /*
            $Query_Insert = "INSERT INTO accounting (estudiante, fecha_IC, fecha_FC, fecha_UP, fecha_PP, cuota, valor, valor_total, descuento, valor_descuento, valor_total_descuento, descripcion, estado) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $Array_Query = array($this->id_student, $this->InputFechaIC, 
                                 $this->InputFechaFC, $this->fecha_UP, 
                                 $date_np, $this->InputCuota, 
                                 $this->InputValor, $this->valor_ordinario,
                                 $this->descuento, $this->valor_descuento, 
                                 $this->valor_total_descuento, $this->descripcion, 1);
            $result_insert = $this->InsertMySQL($Query_Insert, $Array_Query);
            */
            
            //Insert payment table
            $Query_Insert_payment = "INSERT INTO payment (tipo_pago, fecha_pago, valor, periodo, estado) 
                                     VALUES (?, ?, ?, CONCAT('$this->InputDateSA',' - ', '$this->InputDateFA'), ?)";
            $Array_Query_payment = array($this->InputTypePayment_sa, $this->Date_LP, $this->share_value, 1);
            $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

            //Insert detail payment table
            $Query_Insert_d_payment = "INSERT INTO detail_payment (estudiante, payment) VALUES (?, ?)";
            $Array_Query_d_payment = array($this->id_student, $result_insert_payment);
            $result_insert_d_payment = $this->InsertMySQL($Query_Insert_d_payment, $Array_Query_d_payment);


            //Insert notifications table
            $tipo = "Pago Inicial";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, ?, ?)";
            $Array_Query_notifications = array($tipo, $this->Date_LP, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);
            
            //Insert detail notifications table
            $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_d_notifications = array($this->id_student, $result_insert_notifications);
            $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);

            //Student Starts accounting process
            $Query_Update = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->id_student'";
            $Array_Query = array(1);
            $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

            if ($result_insert_accounting > 0 && $result_insert_da > 0 && $result_insert_payment > 0 && $result_insert_d_payment > 0 
            && $result_insert_notifications > 0 && $result_insert_d_notifications > 0 && $result_update > 0) {
                $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        //#
        public function InsertTotalPurchaseAccounting(String $id_studentTP, int $course, String $InputTypePayment, $InputValorTP, $InputValorO, String $InputFechaInicio, String $InputFechaFinal, $descuento, $valor_descuento, $valor_total_descuento, String $InputDescripcion) {
            $this->id_studentTP = $id_studentTP;
            $this->course = $course;
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

            //Insert accounting table
            $Query_Insert_accounting = "INSERT INTO accounting (date_SA, date_FA, date_LP, date_NP) 
            VALUES (?, ?, ?, ?)";
            $Array_Query_accounting = array($this->InputFechaInicio, $this->InputFechaFinal, 
                                            $this->InputFechaFinal, '0000-00-00');
            $result_insert_accounting = $this->InsertMySQL($Query_Insert_accounting, $Array_Query_accounting);

            //Insert detail accounting table
            $Query_Insert_da = "INSERT INTO detail_accounting (accounting, estudiante, course, share, full_value, discount, discount_value, full_discount_value, description, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $Array_Query_da = array($result_insert_accounting, $this->id_studentTP, $this->course, 'Compra Total',
                                    $this->InputValorTP, $this->descuento, $this->valor_descuento, 
                                    $this->valor_total_descuento, $this->InputDescripcion, 0);
            $result_insert_da = $this->InsertMySQL($Query_Insert_da, $Array_Query_da);

            /*
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
            */
            
            //Insert payment table
            $Query_Insert_payment = "INSERT INTO payment (tipo_pago, fecha_pago, valor, periodo, estado, descripcion) 
                                     VALUES (?, ?, ?, CONCAT('$this->InputFechaInicio',' - ', '$this->InputFechaFinal'), ?, ?)";
            $Array_Query_payment = array($this->InputTypePayment, $this->InputFechaInicio, $this->InputValorTP, 5, $this->InputDescripcion);
            $result_insert_payment = $this->InsertMySQL($Query_Insert_payment, $Array_Query_payment);

            //Insert detail payment table
            $Query_Insert_d_payment = "INSERT INTO detail_payment (estudiante, payment) VALUES (?, ?)";
            $Array_Query_d_payment = array($this->id_studentTP, $result_insert_payment);
            $result_insert_d_payment = $this->InsertMySQL($Query_Insert_d_payment, $Array_Query_d_payment);

            //Insert notifications table
            $tipo = "Pago Total";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, ?, ?)";
            $Array_Query_notifications = array($tipo, $this->InputFechaInicio, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            //Insert detail notifications table
            $Query_Insert_d_notifications = "INSERT INTO detail_notifications (usuario, notifications) VALUES (?, ?)";
            $Array_Query_d_notifications = array($this->id_studentTP, $result_insert_notifications);
            $result_insert_d_notifications = $this->InsertMySQL($Query_Insert_d_notifications, $Array_Query_d_notifications);

            if ($result_insert_accounting > 0 && $result_insert_da > 0 && $result_insert_payment > 0 && $result_insert_d_payment > 0 
                && $result_insert_notifications > 0 && $result_insert_d_notifications > 0) {
               $result = 1; 
            } else {
                $result = 0; 
            }
            return $result;
        }

        //*
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

        public function SelectAllCourses() {
            $Query_Select_All = "SELECT co.id_course, co.name, cc.category 
                                 FROM course_category cc INNER JOIN course co ON (cc.id_course_category=co.category) 
                                 WHERE co.status = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectDataCourse(int $id_course) {
            $this->id_course = $id_course;
            $Query_Select = "SELECT co.id_course, co.date_start, co.date_final, co.value 
                             FROM course co INNER JOIN course_category cc 
                             ON (co.category=cc.id_course_category)
                             WHERE id_course = $this->id_course";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        //*
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
        
        //*
        public function stopAccounting(int $id_accounting, String $id_student, String $periodo, String $InputJustificacion) {
            $this->id_accounting = $id_accounting;
            $this->id_student = $id_student;
            $this->periodo = $periodo;
            $this->InputJustificacion = $InputJustificacion;

            //Update student table
            $Query_Update_TS = "UPDATE student SET proceso_contable=? WHERE estudiante = '$this->id_student'";
            $Array_Query_TS = array(0);
            $result_update_TS = $this->UpdateMySQL($Query_Update_TS, $Array_Query_TS);

            //Update detail accounting table
            $Query_Update_TA = "UPDATE detail_accounting SET observation=?, status=? 
                                WHERE accounting = $this->id_accounting AND estudiante = '$this->id_student'";
            $Array_Query_TA = array($this->InputJustificacion, 0);
            $result_update_TA = $this->UpdateMySQL($Query_Update_TA, $Array_Query_TA);

            //Update payment table
            $Query_Update_TP = "UPDATE payment pa INNER JOIN detail_payment dp ON (pa.id_payment=dp.payment)
                                SET pa.estado=? 
                                WHERE dp.estudiante = '$this->id_student' AND pa.periodo = '$this->periodo' ";
            $Array_Query_TP = array(4);
            $result_update_TP = $this->UpdateMySQL($Query_Update_TP, $Array_Query_TP);

            //Insert notifications table
            $tipo = "Contabilidad detenida";
            $Query_Insert_notifications = "INSERT INTO notifications (tipo, fecha, leida) VALUES (?, CURRENT_DATE(), ?)";
            $Array_Query_notifications = array($tipo, 0);
            $result_insert_notifications = $this->InsertMySQL($Query_Insert_notifications, $Array_Query_notifications);

            //Insert detail notifications table
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

        //Deprecated function
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
        //Deprecated function
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

        //*
        public function SelectDetailsAccounting(int $id_accounting, String $dni, String $periodo) {
            $this->id_accounting = $id_accounting;
            $this->dni = $dni;
            $this->periodo = $periodo;

            $Query_Select = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.date_SA, ac.date_FA, ac.date_LP, ac.date_NP, da.share, da.full_value, da.share_value,
                                    da.discount, da.discount_value, da.full_discount_value, da.description,
                                    da.estudiante AS DNI, da.status

                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE da.estudiante = '$this->dni' AND CONCAT(ac.date_SA, ' - ', ac.date_FA) = '$this->periodo' AND
                                    da.status = 1 AND st.proceso_contable = 1 AND ac.id_accounting = $this->id_accounting";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }
        
        //*
        public function SelectSeeIIA(String $dni) {
            $this->dni = $dni;
            $Query_Select = "SELECT ac.id_accounting, us.DNI, ac.date_SA, ac.date_FA, ac.date_LP, ac.date_NP, co.name, cc.category
                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    INNER JOIN course co ON (co.id_course=da.course)
                                    INNER JOIN course_category cc ON (cc.id_course_category=co.category)
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE da.estudiante = '$this->dni' AND da.status = 0";
            $result = $this->SelectAllMySQL($Query_Select);
            return $result;
        }

        //*
        public function SelectDIIA(String $dni, String $periodo) {
            $this->dni = $dni;
            $this->periodo = $periodo;

            $Query_Select = "SELECT ac.id_accounting, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    ac.date_SA, ac.date_FA, ac.date_LP, ac.date_NP, da.share, da.full_value,
                                    da.discount, da.discount_value, da.full_discount_value, da.description, da.observation,
                                    da.estudiante AS DNI, da.status
                                    
                                    FROM detail_accounting da INNER JOIN accounting ac ON (da.accounting=ac.id_accounting)
                                    INNER JOIN student st ON (da.estudiante=st.estudiante)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE da.estudiante = '$this->dni' AND CONCAT(ac.date_SA, ' - ', ac.date_FA) = '$this->periodo' AND
                                    da.status = 0";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        //*
        public function DeleteAccountingInactive(int $id_accounting) {
            $this->id_accounting = $id_accounting;
            //Delete register detail accountig table
            $Query_Delete_da = "DELETE FROM detail_accounting WHERE accounting = $this->id_accounting";
            $result_da = $this->DeleteMySQL($Query_Delete_da);

            //Delete register accounting table
            $Query_Delete_accounting = "DELETE FROM accounting WHERE id_accounting = $this->id_accounting";
            $result_accounting = $this->DeleteMySQL($Query_Delete_accounting);

            if ($result_accounting && $result_da) {
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
        }
    }
?>