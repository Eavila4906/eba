<?php
    class Admin extends Controllers {
        public function __construct(){
            ValidarSesionYesExists();
            parent::__construct();
        }

        public function Admin(){
            $data['functions_js'] = "./Assets/js/functions_login-admin.js";
            $this->views->getViews($this,"admin", $data);
        }

        public function LogearSuperAdmin() {
            if ($_POST) {
                if (empty($_POST['textUsername-email']) || empty($_POST['textPassword'])) {
                    $arrayResponse = array('status' => false, 'msg' => 'Error, Campos vacios!');
                } else {
                    $this->strUsernameEmail = strtolower(strClean($_POST['textUsername-email']));
                    $this->strPassword = hash("SHA256", $_POST['textPassword']);
                    $request = $this->model->SelectSuperAdmin($this->strUsernameEmail, $this->strPassword);

                    if (empty($request)) {
                        $arrayResponse = array('status' => false, 'msg' => 'Username / Email o contraseña incorrecta!');
                    } else {
                        $arrayData = $request;
                        if ($arrayData['estado'] == 1) {
                            if ($arrayData['nombreRol'] == "Super Administrador") {
                                $_SESSION['id_usuario'] = $arrayData['id_usuario'];
                                $_SESSION['Login'] = true; 

                                $arrayData = $this->model->SessionLogin($_SESSION['id_usuario']);
                                $_SESSION['dataUser'] = $arrayData;

                                $arrayResponse = array('status' => true, 'msg' => 'ok');
                            } else {
                                $arrayResponse = array('status' => false, 'msg' => 'Acceso denegado!, Usted no es administrador.');
                            }
                        } else {
                            $arrayResponse = array('status' => false, 'msg' => 'Acceso denegado!, Usuario inactivo.');
                        }  
                    } 
                }
                echo json_encode($arrayResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
    
?>