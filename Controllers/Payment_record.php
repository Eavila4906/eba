<?php
    class Payment_record extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(7);
        }

        public function Payment_record(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['functions_js'] = "./Assets/js/functions_payment_record.js";
            $data['name_page'] = "registrar pago";
            $this->views->getViews($this,"payment_record", $data);
        }

        public function getAllAccounting() {
            $arrayData = $this->model->SelectAllAccounting();
            for ($i=0; $i < count($arrayData); $i++) { 
                $btnPaymentRecord = "";
                $dni = "'".$arrayData[$i]['DNI']."'";
                $fecha_UP = "'".$arrayData[$i]['fecha_PP']."'";
                if ($_SESSION['permisosModulo']['u']){
                    $btnPaymentRecord = '<button class="btn btn-success btn-sm btnPaymentRecord" onclick="FctBtnPaymentRecord('.$dni.','.$arrayData[$i]['id_accounting'].','.$fecha_UP.')" title="Registrar pago"><i class="fas fa-check-circle fa-lg"></i></button>';
                }
                //Formato de fecha
                //setlocale(LC_ALL,"es-ES");
                $arrayData[$i]['Ultimo_pago'] = strftime("%A, %d de %B de %Y", strtotime($arrayData[$i]['fecha_UP']));
                $arrayData[$i]['Proximo_pago'] = strftime("%A, %d de %B de %Y", strtotime($arrayData[$i]['fecha_PP']));

                $arrayData[$i]['V_cuota'] = '<spam class="badge badge-success">$ '.$arrayData[$i]['valor'].'</spam>';
                $acciones = '<div class="text-center">'.$btnPaymentRecord.'</div>';
                $arrayData[$i]['Acciones'] = $acciones;  
            }
            
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setPaymentRecord() {
            if ($_POST) {
                if ($_POST['DNI'] == "" || intval($_POST['id_accounting']) == 0 || $_POST['fecha_UP'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->DNI = $_POST['DNI'];
                    $this->id_accounting = intval($_POST['id_accounting']);
                    $this->fecha_UP = $_POST['fecha_UP'];
                    
                    $arrayData = $this->model->PaymentRecord($this->DNI, $this->id_accounting, $this->fecha_UP);
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'El pago se ha realizado exitosamente.');
                    } else if ($arrayData == "rango completo") {
                        $arrayData = array('status' => true, 'msg' => 'Se ha realizado el ultimo pago en su contabilidad.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'the process failed.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
    }
?>