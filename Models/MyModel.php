<?php
    class MyModel extends MySQL {
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

        public function SelectPaymentDay() {
            $Query_Select = "SELECT * FROM paymentday WHERE id_paymentday = 1";                   
            $result = $this->SelectMySQL($Query_Select);
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

        public function InsertMyContent(String $InputNombre, String $InputDescripcion, String $InputLink, String $user_session, int $InputEstado){
            $this->InputNombre = $InputNombre;
            $this->InputDescripcion = $InputDescripcion;
            $this->InputLink = $InputLink;
            $this->user_session = $user_session;
            $this->InputEstado = $InputEstado;

            $Query_Select_All_MC = "SELECT * FROM my_content WHERE (name_content = '$this->InputNombre' OR link = '$this->InputLink') AND status != 0 ";
            $result_Select_All_MC = $this->SelectAllMySQL($Query_Select_All_MC);

            $Query_Select_All_TC = "SELECT * FROM teacher WHERE teacher = '$this->user_session'";
            $result_Select_All_TC = $this->SelectAllMySQL($Query_Select_All_TC);

            if (empty($result_Select_All_MC)) {
                if (!empty($result_Select_All_TC)) {
                    $Query_Insert_MC = "INSERT INTO my_content (name_content, description, link, status) VALUES (?, ?, ?, ?)";
                    $Array_Query_MC = array($this->InputNombre, $this->InputDescripcion, $this->InputLink, $this->InputEstado);
                    $result_MC = $this->InsertMySQL($Query_Insert_MC, $Array_Query_MC);
    
                    $Query_Insert_DMCT = "INSERT INTO detail_my_content_teacher (content, teacher) VALUES (?, ?)";
                    $Array_Query_DMCT = array($result_MC, $this->user_session);
                    $result_DMCT = $this->InsertMySQL($Query_Insert_DMCT, $Array_Query_DMCT);
    
                    if ($result_MC > 0 && $result_DMCT > 0) {
                        $result = 1;
                    } else {
                        $result = 0;
                    }
                } else {
                    $result = "Notexists";
                }
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateMyContent(int $id_my_content, String $InputNombre, String $InputDescripcion, String $InputLink, String $user_session, int $InputEstado){
            $this->id_my_content = $id_my_content;
            $this->InputNombre = $InputNombre;
            $this->InputDescripcion = $InputDescripcion;
            $this->InputLink = $InputLink;
            $this->user_session = $user_session;
            $this->InputEstado = $InputEstado;

            $Query_Select_All = "SELECT * FROM my_content WHERE (name_content = '$this->InputNombre' OR link = '$this->InputLink') AND id_my_content != $this->id_my_content AND status != 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            $Query_Select = "SELECT * FROM my_content mc INNER JOIN detail_my_content_teacher dct ON(dct.content = mc.id_my_content)
                                WHERE mc.id_my_content = $this->id_my_content AND dct.teacher = '$this->user_session'";
            $result_Select = $this->SelectMySQL($Query_Select);

            if (empty($result_Select_All)) {
                if (!empty($result_Select)) {
                    $Query_Update = "UPDATE my_content SET name_content=?, description=?, link=?, status=? WHERE id_my_content = $this->id_my_content";
                    $Array_Query = array($this->InputNombre, $this->InputDescripcion, $this->InputLink, $this->InputEstado);
                    $result = $this->UpdateMySQL($Query_Update, $Array_Query);
                } else {
                    $result = "ani";
                } 
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function SelectAllMyContentTeacher(String $user_session){
            $this->user_session = $user_session;
            $Query_Select_All = "SELECT * FROM detail_my_content_teacher dct INNER JOIN 
                                 my_content nc ON(nc.id_my_content=dct.content) INNER JOIN 
                                 teacher tc ON(tc.teacher=dct.teacher) INNER JOIN 
                                 usuario us ON(us.DNI=tc.teacher)
                                 WHERE nc.status != 0 AND tc.teacher = '$this->user_session' ORDER BY nc.id_my_content DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllMyContentStudent(String $user_session){
            $this->user_session = $user_session;
            $Query_Select_All = "SELECT * FROM detail_my_content_student dcs INNER JOIN 
                                 my_content nc ON(nc.id_my_content=dcs.content) INNER JOIN 
                                 student st ON(st.estudiante=dcs.student) INNER JOIN 
                                 usuario us ON(us.DNI=st.estudiante)
                                 WHERE nc.status != 0 AND st.estudiante = '$this->user_session' ORDER BY nc.id_my_content DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectMyTeacherContentStudent(int $id_my_content) {
            $this->id_my_content = $id_my_content;
            $Query_Select = "SELECT concat(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS teacher 
                                FROM detail_my_content_teacher dct INNER JOIN 
                                    my_content nc ON(nc.id_my_content=dct.content) INNER JOIN 
                                    teacher tc ON(tc.teacher=dct.teacher) INNER JOIN 
                                    usuario us ON(us.DNI=tc.teacher)
                                WHERE nc.status != 0 AND dct.content = $this->id_my_content";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectMyContent(int $id_my_content) {
            $this->id_my_content = $id_my_content;
            $Query_Select = "SELECT * FROM my_content WHERE id_my_content = $this->id_my_content";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectAllAccounting(String $dni, String $current_date) {
            $this->dni = $dni;
            $this->current_date = $current_date;
            $Query_Select = "SELECT * FROM accounting 
                             WHERE estudiante = '$this->dni' AND cuota = 'Compra Total' 
                                AND (fecha_IC <= '$this->current_date' AND fecha_FC >= '$this->current_date')";
            $result = $this->SelectMySQL($Query_Select);
            
            if (!empty($result)) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        }

        public function SelectAllStudentNotMyContent(int $id_my_content) {
            $this->id_my_content = $id_my_content;
            $Query_Select_All = "SELECT st.id_student, st.estudiante AS DNI, st.proceso_contable,
                                        CONCAT(us.nombres, ' ', us.apellidoP) AS nombres,
                                        us.telefono, us.email
                                    FROM student st INNER JOIN usuario us ON (st.estudiante=us.DNI) 
                                    WHERE NOT EXISTS (SELECT NULL
                                                        FROM detail_my_content_student dcs
                                                        WHERE dcs.student = st.estudiante AND dcs.content = $this->id_my_content
                                                      ) 
                                        AND us.estado != 0";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllStudentYesMyContent(int $id_my_content) {
            $this->id_my_content = $id_my_content;
            $Query_Select_All = "SELECT dcs.id_detail_my_content_student, st.proceso_contable, 
                                        estudiante AS DNI, CONCAT(us.nombres, ' ', us.apellidoP) AS nombres,
                                        us.telefono, us.email
                                 FROM detail_my_content_student dcs INNER JOIN student st ON(st.estudiante=dcs.student)
                                 INNER JOIN usuario us ON (st.estudiante=us.DNI) 
                                 WHERE us.estado != 0 AND dcs.content = $this->id_my_content";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllCountStudent(int $id_my_content) {
            $this->id_my_content = $id_my_content;
            $Query_Select = "SELECT count(id_detail_my_content_student) AS countStudents
                                 FROM detail_my_content_student
                                 WHERE content = $this->id_my_content";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertStudentContent(String $student, int $content){
            $this->student = $student;
            $this->content = $content;

            $Query_Select_All_dcs = "SELECT * FROM detail_my_content_student WHERE student = '$this->student' AND content = $this->content";
            $result_Select_All_dcs = $this->SelectAllMySQL($Query_Select_All_dcs);

            if (empty($result_Select_All_dcs)) {
                $Query_Insert = "INSERT INTO detail_my_content_student (content, student) VALUES (?, ?)";
                $Array_Query = array($this->content, $this->student);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function DeleteStudentContent(String $student, int $content){
            $this->student = $student;
            $this->content = $content;

            $Query_Delete = "DELETE FROM detail_my_content_student WHERE student = '$this->student' AND content = $this->content";
            $result = $this->DeleteMySQL($Query_Delete);

            if ($result) {
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
        }

        public function DeleteCourse(int $content){
            $this->content = $content;

            $Query_Delete_DCT = "DELETE FROM detail_my_content_teacher WHERE content = $this->content";
            $result_Delete_DCT = $this->DeleteMySQL($Query_Delete_DCT);

            $Query_Delete_DCS = "DELETE FROM detail_my_content_student WHERE content = $this->content";
            $result_Delete_DCS = $this->DeleteMySQL($Query_Delete_DCS);

            $Query_Delete_MC = "DELETE FROM my_content WHERE id_my_content = $this->content";
            $result_Delete_MC = $this->DeleteMySQL($Query_Delete_MC);

            if ($result_Delete_MC && $result_Delete_DCS && $result_Delete_DCT) {
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
        }
    } 
?>