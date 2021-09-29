<?php
    class Site extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionYesExists(); 
        }

        public function Site(){
            $data['page'] = "";
            $this -> views -> getViews($this,"site", $data);
        }

        /* Start get home */
        public function getAllContentsHome() {
			$arrayData = $this->model->SelectAllContentsHome();
            return $arrayData;
			die();
        }
        /* Finish get home */

        /* Start get about */
        public function getAllContentsAbout() {
			$arrayData = $this->model->SelectAllContentsAbout();
            return $arrayData;
			die();
        }
        /* Finish get about */

        /* Start get headquarter */
        public function getAllContentsHeadquarter() {
			$arrayData = $this->model->SelectAllContentsHeadquarter();
            return $arrayData;
			die();
        }
        /* Finish get headquarter */

        /* Start get contacts */
        public function getAllContentsContacts() {
			$arrayData = $this->model->SelectAllContentsContacts();
            return $arrayData;
			die();
        }
        /* Finish get contacts */

        /* Start get social media */
        public function getAllContentsSocialMedia() {
			$arrayData = $this->model->SelectAllContentsSocialMedia();
            return $arrayData;
			die();
        }
        /* Finish get social media */

        /* Start get teachers */
        public function getAllTeachers() {
            $arrayData = $this->model->SelectAllTeachers();
            return $arrayData;
            die();
        }
        /* Finish get teachers */

        /* sendEmail */
        public function sendEmailInformation() {
            if ($_POST) {
                if ($_POST['InputFullNameC'] == "" || $_POST['InputEmailC'] == "" 
                || $_POST['InputTelefonoC'] == "" || $_POST['InputMessageC'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso, por favor intente mas tarde.');
                } else {
                    $this->InputFullNameC = $_POST['InputFullNameC'];
                    $this->InputEmailC = $_POST['InputEmailC'];
                    $this->InputTelefonoC = $_POST['InputTelefonoC'];
                    $this->InputMessageC = $_POST['InputMessageC'];
                    $data = array(
                        'fullName' => $this->InputFullNameC,
                        'emailUser' => $this->InputEmailC,
                        'cell' => $this->InputTelefonoC,
                        'email' => SENDER_EMAIL,
                        'asunto' => 'Mensaje de parte de '.$this->InputEmailC,
                        'message' => $this->InputMessageC
                    );
                    $sendEmail = sendEmail($data,'email_contact');
                    if ($sendEmail) {
                        $arrayData = array('status' => true, 'msg' => 'Tu mensaje ha sido enviado exitosamente.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso, por favor intente mas tarde.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>