<?php
    class Courses extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(10);
        }

        public function Courses(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['functions_js'] = "./Assets/js/functions_courses.js";
            $data['name_page'] = "Cursos";
            $this->views->getViews($this,"courses", $data);
        }
        
        public function getAllCourses() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllCourses();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnEditCourse = "";
                    $btnRemoveCourse = "";

                    if ($arrayData[$i]['status'] == 1) {
                        $arrayData[$i]['status'] = '<spam class="badge badge-success">Activo</spam>';
                    } else {
                        $arrayData[$i]['status'] = '<spam class="badge badge-danger">Inactivo</spam>';
                    }

                    if ($_SESSION['permisosModulo']['u']){
                        $btnEditCourse = '<button class="btn btn-info btn-sm btnEditarRol" 
                                                      onclick="FctBtnUpdateCourse('.$arrayData[$i]['id_course'].')" 
                                                      title="Editar">
                                                      <i class="fas fa-pencil-alt"></i>
                                              </button>';
                    }

                    if ($_SESSION['permisosModulo']['d']){
                        $btnRemoveCourse = '<button class="btn btn-danger btn-sm btnEliminarRol" 
                                                   onclick="FctBtnDeleteCourse('.$arrayData[$i]['id_course'].')" 
                                                   title="Eliminar">
                                                   <i class="fas fa-trash"></i>
                                           </button>';
                        
                    }

                    $acciones = '<div class="text-center">'.$btnEditCourse.' '.$btnRemoveCourse.'</div>';
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
            die();
        }
        /*
        public function getCategory($id_category) {
            if ($_SESSION['permisosModulo']['r']) {
                $this->id_category = intval($id_category);
                if ($this->id_category > 0) {
                    $arrayData = $this->model->SelectCategory($this->id_category);
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

        public function setCategory() {
            if ($_POST) {
                $this->id_category = intval($_POST['id_category']);
                $this->category = $_POST['InputCategory'];
                $this->description = $_POST['InputDescription'];
                $this->status = $_POST['InputStatus'];
                $arrayData = "";

                if ($this->category == "" || $this->description == "" || $this->status == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    if ($this->id_category == 0) {
                        if ($_SESSION['permisosModulo']['w']) {
                            $arrayData = $this->model->InsertCategory($this->category,
                                                                      $this->description,
                                                                      $this->status
                                                                    );
                            $opcion = 1;
                        }
                    } else {
                        if ($_SESSION['permisosModulo']['u']) {
                            $arrayData = $this->model->UpdateCategory($this->id_category,
                                                                      $this->category,
                                                                      $this->description,
                                                                      $this->status
                                                                    );
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
                        $arrayData = array('status' => false, 'msg' => 'La categoría ya esta registrado en el sistema.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }

        public function DeleteCategory() {
            if ($_POST) {
                $this->id_category = intval($_POST['id_category']);
                if ($this->id_category > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteCategory($this->id_category);
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
        */
    }
?>