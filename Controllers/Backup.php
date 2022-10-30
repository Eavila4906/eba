<?php
    class Backup extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(11);
        }

        public function Backup(){
            $data['functions_js'] = "./Assets/js/functions_backup.js";
            $data['name_page'] = "Backup";
            $this->views->getViews($this,"backup", $data);
        }

        public function getAllBackup() {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $arrayData = $this->model->SelectAllBackup();
                    for ($i=0; $i < count($arrayData); $i++) { 
                        $btnInfoBackup = "";
                        $btnRemoveBackup = "";
                        $arrayData[$i]['create_by_format'] = $arrayData[$i]['create_by'];
                        $arrayData[$i]['id_backup_format'] = $arrayData[$i]['id_backup'];

                        if ($arrayData[$i]['status'] != 1) {
                            $arrayData[$i]['id_backup_format'] = '<p class="text-danger">'.$arrayData[$i]['id_backup'].'</p>';
                            $arrayData[$i]['create_by_format'] = '<p class="text-danger">'.$arrayData[$i]['create_by_format'].'</p>';
                            $arrayData[$i]['nombreRol'] = '<p class="text-danger">'.$arrayData[$i]['nombreRol'].'</p>';
                            $arrayData[$i]['creation_date'] = '<p class="text-danger">'.$arrayData[$i]['creation_date'].'</p>';
                            
                        }

                        if ($_SESSION['permisosModulo']['r']){
                            $btnInfoBackup = '<button class="btn btn-info btn-sm" 
                                                    onclick="FctBtnInfoBackup('.$arrayData[$i]['id_backup'].')" 
                                                    title="Ver info">
                                                    <i class="fas fa-eye"></i>
                                            </button>';
                        }

                        if ($arrayData[$i]['status'] != 1) {
                            $btnRemoveBackup = "";
                        } else {
                            if ($_SESSION['permisosModulo']['d']){
                                $btnRemoveBackup = '<button class="btn btn-danger btn-sm" 
                                                        onclick="FctBtnDeleteBackup('.$arrayData[$i]['id_backup'].')" 
                                                        title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                </button>';
                            }
                        }
                        

    
                        $acciones = '<div class="text-center">'.$btnInfoBackup.' '.$btnRemoveBackup.'</div>';
                        $arrayData[$i]['Acciones'] = $acciones;
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
            }
            die();
        }

        public function getBackup($id_backup) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $this->id_backup = intval($id_backup);
                    if ($this->id_backup > 0) {
                        $arrayData = $this->model->SelectBackup($this->id_backup);
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
            }
            die(); 
        }

        public function backupExecute() {
            if ($_POST) {
                if ($_POST['backup'] != "backup") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    $this->create_by = $_SESSION['dataUser']['DNI'];
                    $this->nameFile = "Respaldo prueba";

                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertBackup($this->nameFile, $this->create_by);
                    }

                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Hecho exitosamente.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }

        public function backupDelete() {
            if ($_POST) {
                $this->id_backup = intval($_POST['id_backup']);
                $this->eliminated_by = $_SESSION['dataUser']['DNI'];

                if ($this->id_backup > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteBackup($this->id_backup, $this->eliminated_by);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
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