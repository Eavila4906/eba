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

        //Reset your password
        public function reset_password() {
            $data['functions_js'] = MEDIA()."js/functions_resetPass.js";
            $this->views->getViews($this,"reset_password", $data);
        }

        public function resetPassword() {
            if($_POST){
				$token = token();
				$this->InputEmailRP  =  strtolower($_POST['InputEmailRP']);
				$arrayData = $this->model->getUserEmail($this->InputEmailRP);

				if(empty($arrayData)){
					$arrayResponse = array('status' => false, 'msg' => 'El usuario no existente, o esta inactivo.'); 
				}else{
					$id_usuario = $arrayData['id_usuario'];
					$nombreUsuario = $arrayData['nombres'].' '.$arrayData['apellidoP'].' '.$arrayData['apellidoM'];

					$url_recovery = BASE_URL().'login/confirmPasswordReset/'.$this->InputEmailRP.'/'.$token;
					$requestUpdate = $this->model->setTokenUser($id_usuario,$token);

                    $dataUsuario = array(
                        'usuario' => $nombreUsuario,
						'email' => $this->InputEmailRP,
						'asunto' => 'Recuperar cuenta - '.SENDER_NAME,
					    'url_recovery' => $url_recovery
                    );

                    
					if($requestUpdate){
                        $sendEmail = sendEmail($dataUsuario,'email_resetPassword');
                        if($sendEmail){
                            $arrayResponse = array('status' => true, 'msg' => 'Se ha enviado un email a tu cuenta de correo para restablecer tu contraseña.');
                        }else{
                            $arrayResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.' );
                        }
					}else{
						$arrayResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.' );
					}
				}
				
				echo json_encode($arrayResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
        }

        public function confirmPasswordReset(String $params) {
            if (empty($params)) {
                header('Location: '.BASE_URL());
            } else {
                $arrayParams = explode(',',$params);
                $email = $arrayParams[0];
                $token = $arrayParams[1];
                $arrayData = $this->model->getUser($email, $token);
                if (empty($arrayData)) {
                    header('Location: '.BASE_URL());
                } else {
                    $data['functions_js'] = MEDIA()."js/functions_confirmPasswordReset.js";
                    $data['id_usuario'] = $arrayData['id_usuario'];
                    $data['email'] = $email;
                    $data['token'] = $token;
                    $this->views->getViews($this,"confirmPasswordReset", $data);
                }
            }
            die();
        }

        public function updatePassword() {
            if(empty($_POST['id_usuario']) || empty($_POST['email']) || empty($_POST['token']) || empty($_POST['InputPassword']) || empty($_POST['InputConfirmPass'])){
                $arrayResponse = array('status' => false, 'msg' => 'Error de datos' );
            }else{
                $id_usuario = intval($_POST['id_usuario']);
                $InputPassword = $_POST['InputPassword'];
                $InputConfirmPass = $_POST['InputConfirmPass'];
                $email = $_POST['email'];
                $token = $_POST['token'];
                if($InputPassword != $InputConfirmPass){
                    $arrayResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales.' );
                }else{
                    $arrayDataUser = $this->model->getUser($email, $token);
                    if(empty($arrayDataUser)){
                        $arrayResponse = array('status' => false, 'msg' => 'Erro de datos.' );
                    }else{
                        $Password = hash("SHA256",$InputPassword);
                        $requestPass = $this->model->updatePassword($id_usuario, $Password);
                        if($requestPass){
                            $arrayResponse = array('status' => true, 'msg' => 'Contraseña actualizada con éxito.');
                        }else{
                            $arrayResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intente más tarde.');
                        }
                    }
                }
            }
            echo json_encode($arrayResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function requestRegistration() {
            //if ($_POST) {
                if (empty($_POST['InputCedulaPasaporte']) || empty($_POST['InputNombres']) || empty($_POST['InputApellidoP'])
                    || empty($_POST['InputApellidoM']) || empty($_POST['InputEmail']) || empty($_POST['InputTelefono'])
                    || empty($_POST['InputfechaNaci']) || empty($_POST['InputSexo'])) 
                {
                    $arrayData = array('status' => false, 'msg' => 'Todos los campos son obligatorios');
                } else {
                    $this->InputCedula = $_POST['InputCedulaPasaporte'];
                    $this->InputNombres = $_POST['InputNombres'];
                    $this->InputApellidoP = strClean2($_POST['InputApellidoP']);
                    $this->InputApellidoM = strClean2($_POST['InputApellidoM']);
                    $this->InputEmail = $_POST['InputEmail'];
                    $this->InputTelefono = $_POST['InputTelefono'];
                    $this->InputfechaNaci = $_POST['InputfechaNaci'];
                    $this->InputSexo = $_POST['InputSexo'];

                    $arrayData = $this->model->ValidarRegistro($this->InputCedula, $this->InputEmail);

                    if ($arrayData == 1) {
                        $arrayData = array('status' => false, 'msg' => 'La cedula ya existe en nuestros registros');
                    } elseif ($arrayData == 2) {
                        $arrayData = array('status' => false, 'msg' => 'El email ya existe en nuestros registros');
                    } else {
                        $dataSolRegistro = array(
                            'cedula' => $this->InputCedula,
                            'nombres' => $this->InputNombres,
                            'apellidoP' => $this->InputApellidoP,
                            'apellidoM' => $this->InputApellidoM,
                            'emailInfo' => $this->InputEmail,
                            'email' => SENDER_EMAIL,
                            'telefono' => $this->InputTelefono,
                            'fechNaci' => $this->InputfechaNaci,
                            'sexo' => $this->InputSexo,
                            'asunto' => 'Solicitud de registro - '.SENDER_NAME,
                            'url' => BASE_URL()
                        );
                        $sendEmail = sendEmail($dataSolRegistro,'email_SolicitarRegistro');
                        if ($sendEmail) {
                            $arrayData = array('status' => true, 'msg' => 'Su solicitud a sido enviada, por favor estar pendiente a su correo electronico');
                        } else {
                            $arrayData = array('status' => false, 'msg' => 'Error al solicitar registro, por favor intentalo mas tarde'); 
                        }
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            //}
            die();
        }
    }  
?>