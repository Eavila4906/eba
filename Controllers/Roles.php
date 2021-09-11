<?php
    class Roles extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(5);
        }

        public function Roles(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['page_name'] = "Roles de usuarios";
            $data['functions_js'] = "./Assets/js/functions_roles.js";
            $this->views->getViews($this,"roles", $data);
        }

        public function getRoles() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllRoles();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnPermisosRol = "";    
                    $btnEditarRol = "";
                    $btnEliminarRol = "";
                    $btnPermisosRolSA = "";    
                    $btnEditarRolSA = "";
                    $btnEliminarRolSA = "";
                    if ($arrayData[$i]['estadoRol'] == 1) {
                        $arrayData[$i]['estadoRol'] = '<spam class="badge badge-success">Activo</spam>';
                    } else {
                        $arrayData[$i]['estadoRol'] = '<spam class="badge badge-danger">Inactivo</spam>';
                    }
    
                    if ($_SESSION['permisosModulo']['u']){
                        $btnPermisosRol = '<button class="btn btn-primary btn-sm btnPermisosRol" onclick="FctBtnPermisosRol('.$arrayData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>';
                        $btnEditarRol = '<button class="btn btn-info btn-sm btnEditarRol" onclick="FctBtnEditarRol('.$arrayData[$i]['id_rol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                        $btnPermisosRolSA = '<button class="btn btn-primary btn-sm btnPermisosRol" onclick="FctBtnPermisosRol('.$arrayData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>';
                        $btnEditarRolSA = '<button class="btn btn-info btn-sm noneBtn disabled" rl="'.$arrayData[$i]['id_rol'].'" title="No disponible"><i class="fas fa-pencil-alt"></i></button>';
                    }
    
                    if ($_SESSION['permisosModulo']['d']){
                        $btnEliminarRol = '<button class="btn btn-danger btn-sm btnEliminarRol" onclick="FctBtnEliminarRol('.$arrayData[$i]['id_rol'].')" title="Eliminar"><i class="fas fa-trash"></i></button>';
                        $btnEliminarRolSA = '<button class="btn btn-danger btn-sm noneBtn disabled" rl="'.$arrayData[$i]['id_rol'].'" title="No disponible"><i class="fas fa-trash"></i></button>';
                    }
                    
                    $accionesRoles = '<div class="text-center">'.$btnPermisosRol.' '.$btnEditarRol.' '.$btnEliminarRol.'</div>';
                    $accionesSA = '<div class="text-center">'.$btnPermisosRolSA.' '.$btnEditarRolSA.' '.$btnEliminarRolSA.'</div>';
                    if ($arrayData[$i]['nombreRol'] == 'Super Administrador') {
                        $arrayData[$i]['Acciones'] = $accionesSA;
                    } else {
                        $arrayData[$i]['Acciones'] = $accionesRoles;
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

        public function setRoles() {
            if ($_POST) {
                $this->id_rol = intval($_POST['id_rol']);
                $this->TextNombreRol = $_POST['TextNombreRol'];
                $this->TextDescripcionRol = $_POST['TextDescripcionRol'];
                $this->ListaEstadoRol = $_POST['ListaEstadoRol'];
                $arrayData = "";

                if ($this->id_rol == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertRol($this->TextNombreRol, $this->TextDescripcionRol, $this->ListaEstadoRol);
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        $arrayData = $this->model->UpdateRol($this->id_rol, $this->TextNombreRol, $this->TextDescripcionRol, $this->ListaEstadoRol);
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente.'); 
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualización Exitosa.');
                    }  
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'El rol ya esta registrado en el sistema.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);   
            }
            die();
        }

        public function getRol($id_rol) {
            if ($_SESSION['permisosModulo']['r']) {
                $this->id_rol = intval($id_rol);
                if ($this->id_rol > 0) {
                    $arrayData = $this->model->SelectRol($this->id_rol);
                    if (!empty($arrayData)) {
                        $arrayData = array('status' => true, 'data' => $arrayData);
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'Datos no encontrados!');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
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

        public function DeleteRol() {
            if ($_POST) {
                $this->id_rol = intval($_POST['id_rol']);
                if ($this->id_rol > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteRol($this->id_rol);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                    } else if ($arrayData == "Exists") {
                        $arrayData = array('status' => false, 'msg' => 'No es posible eliminar un rol asociado a un usuario.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
    
?>