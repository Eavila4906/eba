<?php
    class Roles extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
        }

        public function Roles(){
            $data['page_name'] = "Roles de usuarios";
            $data['functions_js'] = "./Assets/js/functions_roles.js";
            $this->views->getViews($this,"roles", $data);
        }

        public function getRoles() {
            $arrayData = $this->model->SelectAllRoles();

            for ($i=0; $i < count($arrayData); $i++) { 
                if ($arrayData[$i]['estadoRol'] == 1) {
                    $arrayData[$i]['estadoRol'] = '<spam class="badge badge-success">Activo</spam>';
                } else {
                    $arrayData[$i]['estadoRol'] = '<spam class="badge badge-danger">Inactivo</spam>';
                }
                
                $accionesRoles = '<div class="text-center">
                                <button class="btn btn-primary btn-sm btnPermisosRol" onclick="FctBtnPermisosRol('.$arrayData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>
                                <button class="btn btn-info btn-sm btnEditarRol" onclick="FctBtnEditarRol('.$arrayData[$i]['id_rol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm btnEliminarRol" onclick="FctBtnEliminarRol('.$arrayData[$i]['id_rol'].')" title="Eliminar"><i class="fas fa-trash"></i></button>
                            </div>';
                $accionesSA = '<div class="text-center">
                                <button class="btn btn-primary btn-sm btnPermisosRol" onclick="FctBtnPermisosRol('.$arrayData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>
                                <button class="btn btn-info btn-sm noneBtn disabled" rl="'.$arrayData[$i]['id_rol'].'" title="No disponible"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm noneBtn disabled" rl="'.$arrayData[$i]['id_rol'].'" title="No disponible"><i class="fas fa-trash"></i></button>
                            </div>';
                if ($arrayData[$i]['nombreRol'] == 'Super Administrador') {
                    $arrayData[$i]['Acciones'] = $accionesSA;
                } else {
                    $arrayData[$i]['Acciones'] = $accionesRoles;
                }
                

                
            }
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setRoles() {
            if ($_POST) {
                $this->id_rol = intval($_POST['id_rol']);
                $this->TextNombreRol = $_POST['TextNombreRol'];
                $this->TextDescripcionRol = $_POST['TextDescripcionRol'];
                $this->ListaEstadoRol = $_POST['ListaEstadoRol'];

                if ($this->id_rol == 0) {
                    $arrayData = $this->model->InsertRol($this->TextNombreRol, $this->TextDescripcionRol, $this->ListaEstadoRol);
                    $opcion = 1;
                } else {
                    $arrayData = $this->model->UpdateRol($this->id_rol, $this->TextNombreRol, $this->TextDescripcionRol, $this->ListaEstadoRol);
                    $opcion = 2;
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
                    $arrayData = array('status' => false, 'msg' => 'Filed Register!');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function getRol(int $id_rol) {
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
            die(); 
        }

        public function DeleteRol() {
            if ($_POST) {
                $this->id_rol = intval($_POST['id_rol']);
                if ($this->id_rol > 0) {
                    $arrayData = $this->model->DeleteRol($this->id_rol);
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                    } else if ($arrayData == "Exists") {
                        $arrayData = array('status' => false, 'msg' => 'No es posible eliminar un rol asociado a un usuario.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'Error!');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
    
?>