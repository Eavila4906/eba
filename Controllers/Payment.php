<?php
    class Payment extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(8);
        }

        public function Payment(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['functions_js'] = "./Assets/js/functions_payment.js";
            $data['name_page'] = "Pagos";
            $this->views->getViews($this,"payment", $data);
        } 

        public function getAllPayment() {
            $arrayData = $this->model->SelectAllPayment();
            for ($i=0; $i < count($arrayData); $i++) { 
                $btnSeePayments = "";
                $btnViewPaymentPDF = "";
                $btnViewPaymentEXCEL = "";
                $dni = "'".$arrayData[$i]['DNI']."'";
                $name = "'".$arrayData[$i]['estudiante']."'";
                if ($_SESSION['permisosModulo']['r']){
                    $btnSeePayments = '<button class="btn btn-info btn-sm btnSeePayments" onclick="FctBtnSeePayments('.$dni.','.$name.')" title="Ver pagos"><i class="fas fa-eye"></i></button>';
                    $btnViewPaymentPDF = '<button class="btn btn-danger btn-sm btnViewPaymentPDF" onclick="FctBtnViewPaymentPDF('.$dni.')" title="PDF"><i class="fas fa-file-pdf fa-lg"></i></button>';
                    $btnViewPaymentEXCEL = '<button class="btn btn-success btn-sm btnViewPaymentEXCEL" onclick="FctBtnViewPaymentEXCEL('.$dni.')" title="Excel"><i class="fas fa-file-excel fa-lg"></i></button>';
                }
                $acciones = '<div class="text-center">'.$btnSeePayments." ".$btnViewPaymentPDF." ".$btnViewPaymentEXCEL.'</div>';
                $arrayData[$i]['Acciones'] = $acciones;  
            }
            
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getSeePayment(int $dni) {
            if ($_GET) {
                $this->dni = $dni;
                $arrayData = $this->model->SelectSeePayment($this->dni);
                for ($i=0; $i < count($arrayData); $i++) { 
                    //validacion de estado
                    if ($arrayData[$i]['estado'] == 0) {
                        $arrayData[$i]['estado'] = '<spam class="badge badge-success" style="font-size:.9em;">Pagado</spam>';
                    } else if ($arrayData[$i]['estado'] == 1) {
                        $arrayData[$i]['estado'] = '<spam class="badge badge-info" style="font-size:.9em;">En proceso de pago</spam>';
                    } else if ($arrayData[$i]['estado'] == 2) {
                        $arrayData[$i]['estado'] = '<spam class="badge badge-danger" style="font-size:.9em;">Adeuda</spam>';
                    } else if ($arrayData[$i]['estado'] == 3) {
                        $arrayData[$i]['estado'] = '<spam class="badge badge-warning" style="font-size:.9em;">Proceso de pago en pausa</spam>';
                    } else if ($arrayData[$i]['estado'] == 4) {
                        $arrayData[$i]['estado'] = '<spam class="badge badge-secondary" style="font-size:.9em;">Proceso de pago cancelado</spam>';
                    }
                    //formato a valores
                    $arrayData[$i]['total_pago'] = "$".$arrayData[$i]['total_pago'];
                    $arrayData[$i]['valor_unitario'] = "$".$arrayData[$i]['valor'];

                    //rago de pagos
                    $periodo = $arrayData[$i]['periodo'];
                    $periodo = explode(" - ", $periodo);
                    $meses_contables = calculateRangeDate($periodo[0], $periodo[1]);
                    $arrayData[$i]['cantidad'] = $arrayData[$i]['cantidad']." / ".$meses_contables;
                    
                    //total a pagar
                    $arrayData[$i]['total_pagar'] = "$".doubleval(doubleval($arrayData[$i]['valor'])*intval($meses_contables)); 
                    
                    //Formato de fecha
                    setlocale(LC_ALL,"es-ES");
                    $Inicio_periodo = ucwords(strftime("%B %Y", strtotime($periodo[0])));
                    $Fin_periodo = ucwords(strftime("%B %Y", strtotime($periodo[1])));
                    $arrayData[$i]['periodo'] = $Inicio_periodo." - ".$Fin_periodo;
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>