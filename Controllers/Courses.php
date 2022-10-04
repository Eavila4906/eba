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
        
        public function getCourse($id_course) {
            if ($_SESSION['permisosModulo']['r']) {
                $this->id_course = intval($id_course);
                if ($this->id_course > 0) {
                    $arrayData = $this->model->SelectCourse($this->id_course);
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
        
        public function getCategoryList() {
            if ($_POST) {
                $arrayData = $this->model->SelectAllCategory();
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        
        public function setCourse() {
            if ($_POST) {
                $this->id_course = intval($_POST['id_course']);
                $this->course = $_POST['InputCourse'];
                $this->category = intval($_POST['category']);
                $this->description = $_POST['InputDescription'];
                $this->dateStart = $_POST['InputDateStart'];
                $this->dateFinal = $_POST['InputDateFinal'];
                $this->value = $_POST['InputValue'];
                $this->status = $_POST['InputStatus'];
                $arrayData = "";

                if ($this->course == "" || $this->category == 0 || $this->description == "" 
                    || $this->dateStart == "" || $this->dateFinal == "" || $this->value == "" 
                    || $this->status == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    if ($this->id_course == 0) {
                        if ($_SESSION['permisosModulo']['w']) {
                            $arrayData = $this->model->InsertCategory($this->course,
                                                                      $this->category,
                                                                      $this->description,
                                                                      $this->dateStart,
                                                                      $this->dateFinal,
                                                                      $this->value,
                                                                      $this->status
                                                                    );
                            $opcion = 1;
                        }
                    } else {
                        if ($_SESSION['permisosModulo']['u']) {
                            $arrayData = $this->model->UpdateCategory($this->id_course,
                                                                      $this->course,
                                                                      $this->category,
                                                                      $this->description,
                                                                      $this->dateStart,
                                                                      $this->dateFinal,
                                                                      $this->value,
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
                        $arrayData = array('status' => false, 'msg' => 'El curso ya esta registrado en el sistema.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }

        public function DeleteCourse() {
            if ($_POST) {
                $this->id_course = intval($_POST['id_course']);
                if ($this->id_course > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteCourse($this->id_course);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                    } else if ($arrayData == "Exists") {
                        $arrayData = array('status' => false, 'msg' => 'No es posible eliminar un curso asociado a un usuario.');
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