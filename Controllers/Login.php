<?php
    class Login extends Controllers {
        public function __construct(){
            ValidarSesionYesExists();
            parent::__construct();
        }
        
        public function LoginUser() {
            if($_POST){
                $this->InputUsernameEmail = strtolower(strClean($_POST['InputUsername-email']));
                $this->InputPassword = hash("SHA256", $_POST['InputPassword']);
                $request = $this->model->SelectUserLogin($this->InputUsernameEmail, $this->InputPassword);

                if (empty($request)) {
                    $arrayResponse = array('status' => false, 'msg' => 'Username / Email o contraseña incorrecta!');
                } else {
                    $arrayData = $request;
                    if ($arrayData['estado'] == 1) {
                        $_SESSION['id_usuario'] = $arrayData['id_usuario'];
                        $_SESSION['Login'] = true; 

                        $arrayData = $this->model->SessionLogin($_SESSION['id_usuario']);
                        $_SESSION['dataUser'] = $arrayData;
                        $rol = $arrayData['nombreRol'];
                        $arrayResponse = array('status' => true, 'msg' => 'ok', 'rol' => $rol);
                            
                    } else {
                        $arrayResponse = array('status' => false, 'msg' => 'Acceso denegado!, Usuario inactivo.');
                    }  
                } 
                echo json_encode($arrayResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }  
    }  
?>