<?php
    class Dashboard extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(2);
        }

        public function Dashboard(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['functions_js'] = "./Assets/js/functions_dashboard.js";
            $this->views->getViews($this,"dashboard", $data);
        }

        public function getCountUsers() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrData = $this->model->selectCountUsers();
                if (!empty($arrData)) {
                    $arrayData = array('status' => true, 'data' => $arrData);
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo '<div class="alert alert-danger" role="alert" 
                        style="position: relative;padding: 0.75rem 1.25rem;margin-bottom: 1rem;border: 
                        1px solid transparent;border-radius: 0.25rem;color: #721c24;background-color: #f8d7da;
                        border-color: #f5c6cb;border-top-color: #f1b0b7;">
                        <b>¡Restricted access!</b>: you do not have permission to manipulate this module.
                      </div>';
            }
            die();
        }

        public function getCountCourses() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrData = $this->model->selectCountCourses();
                if (!empty($arrData)) {
                    $arrayData = array('status' => true, 'data' => $arrData);
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo '<div class="alert alert-danger" role="alert" 
                        style="position: relative;padding: 0.75rem 1.25rem;margin-bottom: 1rem;border: 
                        1px solid transparent;border-radius: 0.25rem;color: #721c24;background-color: #f8d7da;
                        border-color: #f5c6cb;border-top-color: #f1b0b7;">
                        <b>¡Restricted access!</b>: you do not have permission to manipulate this module.
                    </div>';
            }
            die();
        }

        public function getCountStudens() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrData = $this->model->selectCountStudens();
                if (!empty($arrData)) {
                    $arrayData = array('status' => true, 'data' => $arrData);
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo '<div class="alert alert-danger" role="alert" 
                        style="position: relative;padding: 0.75rem 1.25rem;margin-bottom: 1rem;border: 
                        1px solid transparent;border-radius: 0.25rem;color: #721c24;background-color: #f8d7da;
                        border-color: #f5c6cb;border-top-color: #f1b0b7;">
                        <b>¡Restricted access!</b>: you do not have permission to manipulate this module.
                    </div>';
            }
            die();
        }

        public function getCountTeachers() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrData = $this->model->selectCountTeachers();
                if (!empty($arrData)) {
                    $arrayData = array('status' => true, 'data' => $arrData);
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo '<div class="alert alert-danger" role="alert" 
                        style="position: relative;padding: 0.75rem 1.25rem;margin-bottom: 1rem;border: 
                        1px solid transparent;border-radius: 0.25rem;color: #721c24;background-color: #f8d7da;
                        border-color: #f5c6cb;border-top-color: #f1b0b7;">
                        <b>¡Restricted access!</b>: you do not have permission to manipulate this module.
                    </div>';
            }
            die();
        }
    }
    
?>