<?php
    class Profile extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
        }

        public function Profile(){
            $data['functions_js'] = "./Assets/js/functions_profile.js";
            $this->views->getViews($this,"profile", $data);
        }

        public function getDataUser() {
            $this->id_session = intval($_SESSION['dataUser']['id_usuario']);
            if ($this->id_session > 0) {
                $arrayData = $this->model->SelectDataUser($this->id_session);
                if (!empty($arrayData)) {
                    $arrayData['url_photo'] = MEDIA().'images/image-profiles/'.$arrayData['photo'];
                    $arrayData = array('status' => true, 'data' => $arrayData);
                } else {
                    $arrayData = array('status' => false, 'msg' => 'Datos no encontrados!');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die(); 
        }

        public function getPhotoProfile($id_session) {
            if ($_GET) {
                $this->id_session = intval($id_session);
                if ($this->id_session > 0) {
                    $arrayData = $this->model->SelectPhotoProfile($this->id_session);
                    if (!empty($arrayData)) {
                        $arrayData['url_photo'] = MEDIA().'images/image-profiles/'.$arrayData['photo'];
                        $arrayData = array('status' => true, 'data' => $arrayData);
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'Datos no encontrados!');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
                die();
            }
        }

        public function setProfilePhoto() {
            if ($_POST) {
                $this->id_userSession = intval($_POST['id_userSession']);
                $dataImage = $_FILES['image'];
                $this->nameImage = $dataImage['name'];
                $this->type = $dataImage['type'];
				$this->url_temp = $dataImage['tmp_name'];
				$photo = 'profile-default.ico';
                if($this->nameImage != ''){
                    $photo = 'img_profile'.md5(date('d-m-Y H:m:s')).'.jpg';
                }

                if ($this->id_userSession > 0) {
                    if($this->nameImage == ''){
                        if($_POST['photo_actual'] != 'profile-default.ico' && $_POST['photo_remove'] == 0 ){
                            $photo = $_POST['photo_actual'];
                        }
                    }
                    $arrayData = $this->model->UpdateProfilePhoto($this->id_userSession, $photo);
                }

                if ($arrayData > 0) {
                    $arrayData = array('status' => true, 'msg' => 'Actualización Exitosa.');
                    if($this->nameImage != ''){ 
                        uploadProfilePhotoServer($dataImage, $photo); 
                    }
                    if(($this->nameImage == '' && $_POST['photo_remove'] == 1 && $_POST['photo_actual'] != 'profile-default.ico')
						|| ($this->nameImage != '' && $_POST['photo_actual'] != 'profile-default.ico')){
                        deleteProfilePhotoServer($_POST['photo_actual']);
					}
                } else {
                    $arrayData = array('status' => false, 'msg' => 'Filed Register!');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function updateDataUser() {
            if ($_POST) {
                $this->id_user = intval($_SESSION['dataUser']['id_usuario']);
                $this->InputApellidoM = $_POST['InputApellidoM'];
                $this->InputEmail = $_POST['InputEmail'];
                $this->InputTelefono = $_POST['InputTelefono'];
                $this->InputSexo = $_POST['InputSexo'];
                $this->InputFechaNaci = $_POST['InputFechaNaci'];

                if ($this->id_user > 0) {
                    $arrayData = $this->model->UpdateDataUser($this->id_user, $this->InputApellidoM, $this->InputEmail, $this->InputTelefono, $this->InputSexo, $this->InputFechaNaci);
                }

                if ($arrayData > 0) {
                    $arrayData = array('status' => true, 'msg' => 'Actualización Exitosa.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'Filed Register!');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function updatePassword() {
            if ($_POST) {
                $this->id_user = intval($_SESSION['dataUser']['id_usuario']);
                $this->InputCurrentPass =  hash("SHA256", $_POST['InputCurrentPass']);
                $this->InputNewPass = hash("SHA256", $_POST['InputNewPass']);

                if ($this->id_user > 0) {
                    $arrayData = $this->model->UpdatePassword($this->id_user, $this->InputCurrentPass, $this->InputNewPass);
                }

                if ($arrayData > 0) {
                    $arrayData = array('status' => true, 'msg' => 'Su contraseña se actualizó exitosmente.');
                } else if ($arrayData == 'noPass') {
                    $arrayData = array('status' => false, 'msg' => 'La contraseña actual que ingresastes no coiside con la de la base de datos!');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'Filed Register!');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
    }
    
?>