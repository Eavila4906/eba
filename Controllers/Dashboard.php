<?php
    class Dashboard extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(2);
        }

        public function Dashboard(){
            $data['functions_js'] = "./Assets/js/functions_dashboard.js";
            $this->views->getViews($this,"dashboard", $data);
        }

        public function getCountUsers() {
            $arrData = $this->model->selectCountUsers();
            if (!empty($arrData)) {
                $arrayData = array('status' => true, 'data' => $arrData);
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function getCountCourses() {
            $arrData = $this->model->selectCountCourses();
            if (!empty($arrData)) {
                $arrayData = array('status' => true, 'data' => $arrData);
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function getCountStudens() {
            $arrData = $this->model->selectCountStudens();
            if (!empty($arrData)) {
                $arrayData = array('status' => true, 'data' => $arrData);
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function getCountTeachers() {
            $arrData = $this->model->selectCountTeachers();
            if (!empty($arrData)) {
                $arrayData = array('status' => true, 'data' => $arrData);
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
    
?>