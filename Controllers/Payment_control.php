<?php
    class Payment_control extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(12);
        }

        public function Payment_control(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['functions_js'] = "./Assets/js/functions_payment_control.js";
            $data['name_page'] = "Registrar control de pago";
            $this->views->getViews($this,"payment_control", $data);
        }

        //*
        public function getAllStudents_YesControl() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllStudents_YesControl();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnPaymentControl = "";
                    $btnPaymentHistory = "";
                    $btnPaymentControlFinish = "";

                    $date = (explode(" ",$arrayData[$i]['date_NP']));
                    $date = "'".$date[0]."'";

                    if ($_SESSION['permisosModulo']['w']){
                        $btnPaymentControl = '<button class="btn btn-success btn-sm" 
                        onclick="paymentControl('.$arrayData[$i]['id_student'].",".$date.',1)" 
                        title="Registrar pago">
                            <i class="far fa-calendar-check fa-lg"></i>
                        </button>';
                    }

                    if ($_SESSION['permisosModulo']['w']){
                        $btnPaymentControlFinish = '<button class="btn btn-warning btn-sm" 
                        onclick="paymentControl('.$arrayData[$i]['id_student'].",".$date.',2)" 
                        title="Registrar pago y finalizar control">
                            <i class="far fa-calendar-check fa-lg"></i>
                        </button>';
                    }
                    /*
                    if ($_SESSION['permisosModulo']['r']){
                        $btnPaymentHistory = '<button class="btn btn-info btn-sm" 
                        onclick="FctBtnPaymentHistory('.$arrayData[$i]['id_payment_control'].')" 
                        title="Historial">
                            <i class="fas fa-eye fa-lg"></i>
                        </button>';
                    }*/
                    //Formato de fecha
                    FormatDateLeguage();
                    $arrayData[$i]['payment_lp'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['date_control_LP']));
                    $arrayData[$i]['payment_np'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['date_NP']));

                    $acciones = '<div class="text-center">'.$btnPaymentControl.' '.$btnPaymentHistory.$btnPaymentControlFinish.'</div>';
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

        public function getAllStudents_NoControl() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllStudents_NoControl();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnNewPaymentControl = "";

                    $date = "'".date("Y-m-d")."'";

                    if ($_SESSION['permisosModulo']['w']){
                        $btnNewPaymentControl = '<button class="btn btn-success btn-sm" 
                        onclick="paymentControl('.$arrayData[$i]['id_student'].",".$date.', 1)" 
                        title="Iniciar control">
                            <i class="far fa-calendar-check fa-lg"> Iniciar control</i>
                        </button>';
                    }
                    
                    $acciones = '<div class="text-center">'.$btnNewPaymentControl.'</div>';
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

        //#
        public function setPaymentControl() {
            if ($_POST) {
                if (intval($_POST['id_student']) == 0 || $_POST['InputDate_LP'] == "" || intval($_POST['action']) == 0) {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso1.');
                } else {
                    $this->action = intval($_POST['action']);
                    $this->id_student = intval($_POST['id_student']);
                    $this->InputDate_LP = $_POST['InputDate_LP'];
                    $this->InputDescripcion = $_POST['InputDescripcion'];
                    $arrayData = "";
                    $request = 0;

                    if ($this->action == 1) {
                        if ($_SESSION['permisosModulo']['w']) {
                            $arrayData = $this->model->InsertPaymentControl($this->id_student, 
                                                                           $this->InputDate_LP, 
                                                                           $this->InputDescripcion);
                        }
                        $request = 1;
                    } else if ($this->action == 2) {
                        if ($_SESSION['permisosModulo']['w']) {
                            $arrayData = $this->model->InsertPaymentControlFinish($this->id_student, 
                                                                           $this->InputDate_LP, 
                                                                           $this->InputDescripcion);
                        }
                        $request = 2;
                    }

                    if ($arrayData > 0) {
                        if ($request == 1) {
                            $arrayData = array('status' => true, 'msg' => 'El pago se ha realizado exitosamente.');
                        } else if ($request == 2) {
                            $arrayData = array('status' => true, 'msg' => 'El pago se ha realizado exitosamente y se ha finalizado el control.');
                        }
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso2.');
                    }  
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>