<?php
    class Payment_controlModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        //*
        public function SelectAllActive() {
            $Query_Select_All = "SELECT pc.id_payment_control, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS student,
                                    DATE_ADD(pc.date_control_LP, INTERVAL 1 MONTH ) AS date_NP,
                                    us.DNI, pc.date_control_LP
                                    FROM payment_control pc INNER JOIN student st ON (st.id_student)
                                    INNER JOIN usuario us ON(st.estudiante=us.DNI)
                                    WHERE pc.status = 1";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllStudents_NoControl() {
            $Query_Select_All = "SELECT st.id_student, st.estudiante AS DNI,
                                    CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS student
                                 FROM student st INNER JOIN usuario us ON (st.estudiante=us.DNI) 
                                 WHERE us.estado != 0 AND payment_control = 0";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllStudents_YesControl() {
            $Query_Select_All = "SELECT st.id_student, pc.id_payment_control, st.estudiante AS DNI,
                                    CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS student, 
                                    DATE_ADD(MAX(pc.date_control_LP), INTERVAL 1 MONTH) AS date_NP,
                                    us.DNI, MAX(pc.date_control_LP) AS date_control_LP
                                 FROM student st INNER JOIN usuario us ON (st.estudiante=us.DNI) 
                                 INNER JOIN payment_control pc ON (st.id_student=pc.student)
                                 WHERE st.payment_control = 1 GROUP BY pc.student";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function InsertPaymentControl ($id_student, $InputDate_LP, $InputDescripcion) {
            $Query_Insert = "INSERT INTO payment_control (student, date_control_LP, description, status) VALUES (?, ?, ?, ?)";
            $Array_Query = array($id_student, $InputDate_LP, $InputDescripcion, 1);
            $result_insert = $this->InsertMySQL($Query_Insert, $Array_Query);
            
            $Query_Update = "UPDATE student SET payment_control=? WHERE id_student=$id_student";
            $Array_Query = array(1);
            $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

            if ($result_insert && $result_update) {
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
        }

        public function InsertPaymentControlFinish ($id_student, $InputDate_LP, $InputDescripcion) {
            $Query_Insert = "INSERT INTO payment_control (student, date_control_LP, description, status) VALUES (?, ?, ?, ?)";
            $Array_Query = array($id_student, $InputDate_LP, $InputDescripcion, 1);
            $result_insert = $this->InsertMySQL($Query_Insert, $Array_Query);
            
            $Query_Update = "UPDATE student SET payment_control=? WHERE id_student=$id_student";
            $Array_Query = array(0);
            $result_update = $this->UpdateMySQL($Query_Update, $Array_Query);

            if ($result_insert && $result_update) {
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
        }

    }
?>