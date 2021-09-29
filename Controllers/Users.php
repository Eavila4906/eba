<?php
    class Users extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(4);
        }

        public function Users(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['page_name'] = "Usuarios";
            $data['functions_js'] = "./Assets/js/functions_users.js";
            $this->views->getViews($this,"users", $data);
        }

        public function getUsers() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllUsers();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnVerInfoUser = "";    
                    $btnEditarUser = "";
                    $btnEliminarUser = "";
                    if ($arrayData[$i]['estado'] == 1) {
                        $arrayData[$i]['estado'] = '<spam class="badge badge-success">Activo</spam>';
                    } else {
                        $arrayData[$i]['estado'] = '<spam class="badge badge-danger">Inactivo</spam>';
                    }
    
                    if ($_SESSION['permisosModulo']['r']) {
                        $btnVerInfoUser = '<button class="btn btn-primary btn-sm btnVerInfoUser" onclick="FctBtnVerInfoUser('.$arrayData[$i]['id_usuario'].')" title="Ver info"><i class="fa fa-eye"></i></button>';
                    }
    
                    if ($_SESSION['permisosModulo']['u']){
                        if ($_SESSION['id_usuario'] == 1) {
                            if ($_SESSION['dataUser']['id_usuario'] != $arrayData[$i]['id_usuario']) {
                                $btnEditarUser = '<button class="btn btn-info btn-sm btnEditarUser" onclick="FctBtnEditarUser('.$arrayData[$i]['id_usuario'].')" title="Editar"><i class="fa fa-pencil"></i></button>';
                            } else {
                                $btnEditarUser = '<button class="btn btn-info btn-sm btnEditarUser" title="No disponible" disabled><i class="fa fa-pencil"></i></button>';
                            }    
                        } else if ($_SESSION['id_usuario'] != 1) {
                            if ($_SESSION['dataUser']['nombreRol'] == "Administrador" && $arrayData[$i]['nombreRol'] == "Administrador") {
                                $btnEditarUser = '<button class="btn btn-info btn-sm btnEditarUser" title="No disponible" disabled><i class="fa fa-pencil"></i></button>';
                            } else {
                                $btnEditarUser = '<button class="btn btn-info btn-sm btnEditarUser" onclick="FctBtnEditarUser('.$arrayData[$i]['id_usuario'].')" title="Editar"><i class="fa fa-pencil"></i></button>';
                            }
                        }
                    }
    
                    if ($_SESSION['permisosModulo']['d']){
                        if ($_SESSION['id_usuario'] == 1) {
                            if ($_SESSION['dataUser']['id_usuario'] != $arrayData[$i]['id_usuario']) {
                                $btnEliminarUser = '<button class="btn btn-danger btn-sm btnEliminarUser" onclick="FctBtnEliminarUser('.$arrayData[$i]['id_usuario'].')" title="Eliminar"><i class="fa fa-trash"></i></button>';
                            } else {
                                $btnEliminarUser = '<button class="btn btn-danger btn-sm btnEliminarUser" title="No disponible" disabled><i class="fa fa-trash"></i></button>';
                            }    
                        } else if ($_SESSION['id_usuario'] != 1) {
                            if ($_SESSION['dataUser']['nombreRol'] == "Administrador" && $arrayData[$i]['nombreRol'] == "Administrador") {
                                $btnEliminarUser = '<button class="btn btn-danger btn-sm btnEliminarUser" title="No disponible" disabled><i class="fa fa-trash"></i></button>';
                            } else {
                                $btnEliminarUser = '<button class="btn btn-danger btn-sm btnEliminarUser" onclick="FctBtnEliminarUser('.$arrayData[$i]['id_usuario'].')" title="Eliminar"><i class="fa fa-trash"></i></button>';
                            }
                        }
                    }
                    
                    $accionesUsers = '<div class="text-center">'.$btnVerInfoUser.' '.$btnEditarUser.' '.$btnEliminarUser.'</div>';
                    $arrayData[$i]['Acciones'] = $accionesUsers;
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo '<div class="alert alert-danger" role="alert" 
                        style="position: relative;padding: 0.75rem 1.25rem;margin-bottom: 1rem;border: 
                        1px solid transparent;border-radius: 0.25rem;color: #721c24;background-color: #f8d7da;
                        border-color: #f5c6cb;border-top-color: #f1b0b7;">
                        <b>¡Restricted access!</b> you do not have permission to manipulate this module.
                      </div>';
            }
            die();
        }

        public function getListTypeRoles() {
            $arrayData = $this->model->SelectAllRoles();
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getVerInfoUser($id_user) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                $this->id_user = intval($id_user);
                $arrayData = $this->model->SelectInfoUser($this->id_user);
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo '<div class="alert alert-danger" role="alert" 
                            style="position: relative;padding: 0.75rem 1.25rem;margin-bottom: 1rem;border: 
                            1px solid transparent;border-radius: 0.25rem;color: #721c24;background-color: #f8d7da;
                            border-color: #f5c6cb;border-top-color: #f1b0b7;">
                            <b>¡Restricted access!</b> you do not have permission to manipulate this module.
                        </div>';
                }
            }
            die();
        }

        public function getDataUser($id_user) {
            if ($_SESSION['permisosModulo']['r']) {
                $this->id_user = intval($id_user);
                if ($this->id_user > 0) {
                    $arrayData = $this->model->SelectInfoUser($this->id_user);
                    if (!empty($arrayData)) {
                        $arrayData = array('status' => true, 'data' => $arrayData);
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'Datos no encontrados!');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo '<div class="alert alert-danger" role="alert" 
                        style="position: relative;padding: 0.75rem 1.25rem;margin-bottom: 1rem;border: 
                        1px solid transparent;border-radius: 0.25rem;color: #721c24;background-color: #f8d7da;
                        border-color: #f5c6cb;border-top-color: #f1b0b7;">
                        <b>¡Restricted access!</b> you do not have permission to manipulate this module.
                    </div>';
            }
            die(); 
        }

        public function setUsers() {
            if ($_POST) {
                $this->id_usuario = intval($_POST['id_usuario']);
                $this->InputCedulaPasaporte = $_POST['InputCedulaPasaporte'];
                $this->InputNombres = $_POST['InputNombres'];
                $this->InputApellidoP = $_POST['InputApellidoP'];
                $this->InputApellidoM = $_POST['InputApellidoM'];
                $this->InputEmail = $_POST['InputEmail'];
                $this->InputTelefono = $_POST['InputTelefono'];
                $this->InputfechaNaci = $_POST['InputfechaNaci'];
                $this->InputSexo = $_POST['InputSexo'];
                $this->InputTipoRol = $_POST['InputTipoRol'];
                $this->InputEstado = $_POST['InputEstado'];
                $this->InputPassword = $_POST['InputPassword'];
                $arrayData = "";
                if ($this->id_usuario == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        //Generate credenciales de acceso
                        $username = usernameGenerator($this->InputNombres, $this->InputApellidoP, $this->InputCedulaPasaporte);
                        $password = hash("SHA256", $this->InputCedulaPasaporte);
                        $Photo = "profile-default.ico";
                        $arrayData = $this->model->InsertUser($this->InputCedulaPasaporte, $username, $password, $this->InputNombres, $this->InputApellidoP, $this->InputApellidoM, $this->InputEmail, $this->InputTelefono, $this->InputfechaNaci, $this->InputSexo, $this->InputTipoRol, $this->InputEstado, $Photo);
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        $arrayData = $this->model->UpdateUser($this->id_usuario, $this->InputPassword, $this->InputTelefono, $this->InputfechaNaci, $this->InputSexo, $this->InputTipoRol, $this->InputEstado);
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $dataNewUser = array(
                            'usuario' => $this->InputNombres." ".$this->InputApellidoP." ".$this->InputApellidoM,
                            'username' => $username,
                            'password' => $this->InputCedulaPasaporte,
                            'email' => $this->InputEmail,
                            'asunto' => 'Bienvenida - Datos de accesso - '.SENDER_NAME,
                            'url' => BASE_URL()
                        );
                        $sendEmail = sendEmail($dataNewUser,'email_accessData');
                        if ($sendEmail) {
                            $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente.');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente, pero hubo un error al enviar el email.');
                        }  
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualizado exitosamente.');
                    }  
                } else if ($arrayData == "ExistsCed") {
                    $arrayData = array('status' => false, 'msg' => 'El usuario ya esta registrado en el sistema.');
                } else if ($arrayData == "ExistsEmail") {
                        $arrayData = array('status' => false, 'msg' => 'El email ya se encuentra registrado con otro usuario.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function DeleteUser() {
            if ($_POST) {
                $this->id_usuario = intval($_POST['id_usuario']);
                $arrayData = "";
                if ($this->id_usuario > 0) {
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteUser($this->id_usuario);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                    } else if ($arrayData == "Exists") {
                        $arrayData = array('status' => false, 'msg' => 'No es posible eliminar un rol asociado a un usuario.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No es posible ejecutar este proceso.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE); 
            }
            die();
        }
    }
    
?>