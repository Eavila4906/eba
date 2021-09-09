<?php
    class Accounting extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(6);
        }

        public function Accounting(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['functions_js'] = "./Assets/js/functions_accounting.js";
            $data['name_page'] = "Contabilidad";
            $this->views->getViews($this,"accounting", $data);
        }

        /* Starts starts accounting */
        public function getAllStudents() {
            $arrayData = $this->model->SelectAllStudents();
            for ($i=0; $i < count($arrayData); $i++) { 
                $btnStartsAccounting = "";
                if ($_SESSION['permisosModulo']['w']){
                    $btnStartsAccounting = '<button class="btn btn-success btn-sm btnStartsAccounting" onclick="FctBtnStartsAccounting('.$arrayData[$i]['DNI'].')" title="Iniciar contabilidad"><i class="fas fa-play-circle fa-lg"></i></button>';
                }
                $acciones = '<div class="text-center">'.$btnStartsAccounting.'</div>';
                $arrayData[$i]['Acciones'] = $acciones;  
            }
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setAccounting() {
            if ($_POST) {
                if ($_POST['id_student'] == "" || $_POST['InputCuota'] == "" || $_POST['InputValor'] == "" || $_POST['InputFechaFC'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->id_student = $_POST['id_student'];
                    $this->InputCuota = $_POST['InputCuota'];
                    $this->InputValor = $_POST['InputValor'];
                    $this->InputFechaFC = $_POST['InputFechaFC'];
                    $arrayData = $this->model->InsertAccounting($this->id_student, $this->InputCuota, $this->InputValor, $this->InputFechaFC);
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Contabilidad iniciada.');
                    } else if ($arrayData == "invalid date") {
                        $arrayData = array('status' => false, 'msg' => 'La fecha que ingresastes no es valida.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'the process failed.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
        /* Finish starts accounting */

        /* Starts stopt accounting */
        public function getAllAccounting() {
            $arrayData = $this->model->SelectAllAccounting();
            for ($i=0; $i < count($arrayData); $i++) { 
                $btnStopAccounting = "";
                $btnPauseAccounting = "";
                $btnPlayAccounting = "";
                $periodo = "'".$arrayData[$i]['fecha_IC']." - ".$arrayData[$i]['fecha_FC']."'";
                if ($_SESSION['permisosModulo']['u']){
                    $btnStopAccounting = '<button class="btn btn-danger btn-sm btnStopAccounting" onclick="FctBtnStopAccounting('.$arrayData[$i]['DNI'].','.$periodo.')" title="Detener contabilidad"><i class="fas fa-stop-circle fa-lg"></i></button>';
                    $btnPauseAccounting = '<button class="btn btn-info btn-sm btnPauseAccounting" onclick="FctBtnPauseAccounting('.$arrayData[$i]['DNI'].','.$periodo.')" title="Pausar contabilidad"><i class="fas fa-pause-circle fa-lg"></i></button>';
                    $btnPlayAccounting = '<button class="btn btn-info btn-sm btnPlayAccounting" onclick="FctBtnPlayAccounting('.$arrayData[$i]['DNI'].','.$periodo.')" title="Continuar contabilidad"><i class="fas fa-play-circle fa-lg"></i></button>';   
                }
                //Formato de fecha
                setlocale(LC_ALL,"es-ES");
                $arrayData[$i]['Inicio_contable'] = strftime("%B %Y", strtotime($arrayData[$i]['fecha_IC']));
                $arrayData[$i]['Final_contable'] = strftime("%B %Y", strtotime($arrayData[$i]['fecha_FC']));
                $arrayData[$i]['Ultimo_pago'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_UP']));
                $arrayData[$i]['Proximo_pago'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_PP']));
                $arrayData[$i]['Fecha_inicio-final'] = $arrayData[$i]['Inicio_contable']." - ".$arrayData[$i]['Final_contable'];
                $arrayData[$i]['V_cuota'] = '<spam class="badge badge-success">$ '.$arrayData[$i]['valor'].'</spam>';
                
                if ($arrayData[$i]['estado'] == '1') {
                    $acciones = '<div class="text-center">'.$btnPauseAccounting.''.$btnStopAccounting.'</div>';     
                } else {
                    $acciones = '<div class="text-center">'.$btnPlayAccounting.''.$btnStopAccounting.'</div>';
                }
                
                $arrayData[$i]['Acciones'] = $acciones;  
            }
            
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function stopAccounting() {
            if ($_POST) {
                if ($_POST['id_student'] == '' || $_POST['periodo'] == '') {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->id_student = $_POST['id_student'];
                    $this->periodo = $_POST['periodo'];
                    $arrayData = $this->model->stopAccounting($this->id_student, $this->periodo);
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Detenida exitosamente.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'the process failed.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function pauseAccounting() {
            if ($_POST) {
                if ($_POST['id_student'] == '' || $_POST['periodo'] == '') {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->id_student = $_POST['id_student'];
                    $this->periodo = $_POST['periodo'];
                    $arrayData = $this->model->pauseAccounting($this->id_student, $this->periodo);
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Pausada exitosamente.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'the process failed.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function playAccounting() {
            if ($_POST) {
                if ($_POST['id_student'] == '' || $_POST['periodo'] == '') {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->id_student = $_POST['id_student'];
                    $this->periodo = $_POST['periodo'];
                    $arrayData = $this->model->playAccounting($this->id_student, $this->periodo);
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Contabilidad reanudada.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'the process failed.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        /* Finish stopt accounting */
    }
?>