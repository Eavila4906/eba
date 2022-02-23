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
            if ($_SESSION['permisosModulo']['r']){
                $arrayData = $this->model->SelectAllPayment();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnSeePayments = "";
                    $btnViewPaymentPDF = "";
                    $btnViewPaymentEXCEL = "";
                    $dni = "'".$arrayData[$i]['DNI']."'";
                    $name = "'".$arrayData[$i]['estudiante']."'";
                    if ($_SESSION['permisosModulo']['r']){
                        $btnSeePayments = '<button class="btn btn-info btn-sm btnSeePayments" onclick="FctBtnSeePayments('.$dni.','.$name.')" title="Ver pagos"><i class="fas fa-eye"></i></button>';
                        //$btnViewPaymentPDF = '<button class="btn btn-danger btn-sm btnViewPaymentPDF" onclick="FctBtnViewPaymentPDF('.$dni.')" title="PDF"><i class="fas fa-file-pdf fa-lg"></i></button>';
                        //$btnViewPaymentEXCEL = '<button class="btn btn-success btn-sm btnViewPaymentEXCEL" onclick="FctBtnViewPaymentEXCEL('.$dni.')" title="Excel"><i class="fas fa-file-excel fa-lg"></i></button>';
                    }
                    $acciones = '<div class="text-center">'.$btnSeePayments." ".$btnViewPaymentPDF." ".$btnViewPaymentEXCEL.'</div>';
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

        public function getSeePayment($dni) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $this->dni = $dni;
                    $arrayData = $this->model->SelectSeePayment($this->dni);
                    for ($i=0; $i < count($arrayData); $i++) { 
                        $periodo = $arrayData[$i]['periodo'];
                        $periodo = explode(" - ", $periodo);
                        $meses_contables = calculateRangeDate($periodo[0], $periodo[1]);
                        //rago de pagos
                        if ($arrayData[$i]['cantidad'] == 1 && $arrayData[$i]['estado'] == 5) {
                            $arrayData[$i]['cantidad-rs'] = "1 / 1";
                            $o = 1;
                        } else {
                            $arrayData[$i]['cantidad-rs'] = $arrayData[$i]['cantidad']." / ".$meses_contables;
                            $o = 0;
                        }

                        //Formato de fecha
                        FormatDateLeguage();
                        $Inicio_periodo = ucwords(strftime("%B %Y", strtotime($periodo[0])));
                        $Fin_periodo = ucwords(strftime("%B %Y", strtotime($periodo[1])));
                        $arrayData[$i]['periodo_format'] = $Inicio_periodo." - ".$Fin_periodo; 
                        
                        //formato a valores
                        $arrayData[$i]['total_pago'] = "$".$arrayData[$i]['total_pago'];
                        if ($arrayData[$i]['cantidad'] == 1 && $arrayData[$i]['estado'] == 5) {
                            $vu = $arrayData[$i]['valor'] / $meses_contables;
                            $arrayData[$i]['valor_unitario'] = "$".$arrayData[$i]['valor'];
                            //total a pagar
                            $arrayData[$i]['total_pagar'] = "$".doubleval(doubleval($vu)*intval($meses_contables));
                        } else {
                            $arrayData[$i]['valor_unitario'] = "$".$arrayData[$i]['valor'];
                            //total a pagar
                            $arrayData[$i]['total_pagar'] = "$".doubleval(doubleval($arrayData[$i]['valor'])*intval($meses_contables));
                        }
                        
                        //validacion de estado
                        if ($arrayData[$i]['estado'] == 0 || $arrayData[$i]['estado'] == 5) {
                            $arrayData[$i]['estado'] = '<spam class="badge badge-success" style="font-size:.9em;">Completo</spam>';
                        } else if ($arrayData[$i]['estado'] == 1) {
                            $arrayData[$i]['estado'] = '<spam class="badge badge-info" style="font-size:.9em;">En proceso de pago</spam>';
                        } else if ($arrayData[$i]['estado'] == 2) {
                            $arrayData[$i]['estado'] = '<spam class="badge badge-danger" style="font-size:.9em;">Adeuda</spam>';
                        } else if ($arrayData[$i]['estado'] == 3) {
                            $arrayData[$i]['estado'] = '<spam class="badge badge-warning" style="font-size:.9em;">Proceso de pago en pausa</spam>';
                        } else if ($arrayData[$i]['estado'] == 4) {
                            $arrayData[$i]['estado'] = '<spam class="badge badge-secondary" style="font-size:.9em;">Proceso de pago cancelado</spam>';
                        }

                        $btnSeePayments = "";
                       
                        if ($_SESSION['permisosModulo']['r']){
                            $pf = "'".$arrayData[$i]['periodo_format']."'";
                            $p = "'".$arrayData[$i]['periodo']."'";
                            $e = "'".$arrayData[$i]['DNI']."'";
                            $btnSeePayments = '<button class="btn btn-primary btn-sm btnSeePayments" 
                            onclick="FctBtnIndividualPayments('.$pf.','.$p.','.$e.','.$o.')" 
                            title="Ver pagos individuales">
                                <i class="fas fa-folder-open"></i>
                            </button>'; 
                        }
                        $acciones = '<div class="text-center">'.$btnSeePayments.'</div>';

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

        public function getSeeIndividualPayments($parameters) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $arrayparameters = explode(',',$parameters);
                    $dni = $arrayparameters[0];
                    $periodo = $arrayparameters[1];
                    $opcion = $arrayparameters[2];
                    
                    if ($opcion == 0) {
                        $arrayData = $this->model->SelectSeeIndividualPayments0($periodo, $dni);
                        for ($i=0; $i < count($arrayData); $i++) { 
                            //formato de tipo de pago
                            if ($arrayData[$i]['tipo_pago'] == "") {
                                $arrayData[$i]['tipo_pago_format'] = '<spam class="badge badge-Light text-center" 
                                style="font-size:.9em;">
                                    -
                                </spam>';
                            } else {
                                $arrayData[$i]['tipo_pago_format'] = $arrayData[$i]['tipo_pago'];
                            }
                            //Formato de fecha
                            FormatDateLeguage();
                            $arrayData[$i]['fecha_pago_format'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_pago']));
                            //formato de valor
                            $arrayData[$i]['valor_format'] = "$".$arrayData[$i]['valor'];
                            //formato de estado
                            if ($arrayData[$i]['estado'] != 5 && $arrayData[$i]['observacion'] == 0) {
                                $arrayData[$i]['estado_format'] = '<spam class="badge badge-success" 
                                style="font-size:.9em;">
                                    Pagado
                                </spam>';
                            } else if ($arrayData[$i]['estado'] != 5 && $arrayData[$i]['observacion'] == 1) {
                                $arrayData[$i]['estado_format'] = '<spam class="badge badge-danger" 
                                style="font-size:.9em;">
                                    Pagado
                                </spam>';
                            }
                            //formato de observacion
                            if ($arrayData[$i]['observacion'] == 0) {
                                $arrayData[$i]['observacion_format'] = '<spam class="badge badge-Light text-center" 
                                style="font-size:.9em;">
                                    -
                                </spam>';
                            } else {
                                $arrayData[$i]['observacion_format'] = '<spam class="badge badge-danger" 
                                style="font-size:.9em;">
                                    No contable
                                </spam>';
                            }
                            //formato de descripcion
                            if ($arrayData[$i]['descripcion'] == "") {
                                $arrayData[$i]['descripcion_format'] = '<spam class="badge badge-Light text-center" 
                                style="font-size:.9em;">
                                    -
                                </spam>';
                            } else {
                                $arrayData[$i]['descripcion_format'] = $arrayData[$i]['descripcion'];
                            }
                        }
                    } else {
                        $arrayData = $this->model->SelectSeeIndividualPayments1($periodo, $dni);
                        for ($i=0; $i < count($arrayData); $i++) { 
                            //formato de tipo de pago
                            if ($arrayData[$i]['tipo_pago'] == "") {
                                $arrayData[$i]['tipo_pago_format'] = '<spam class="badge badge-Light text-center" 
                                style="font-size:.9em;">
                                    -
                                </spam>';
                            } else {
                                $arrayData[$i]['tipo_pago_format'] = $arrayData[$i]['tipo_pago'];
                            }
                            //Formato de fecha
                            setlocale(LC_ALL,"es-ES"); 
                            $arrayData[$i]['fecha_pago_format'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_pago']));
                            //formato de valor
                            $arrayData[$i]['valor_format'] = "$".$arrayData[$i]['valor'];
                            //formato de estado
                            if ($arrayData[$i]['estado'] == 5 && $arrayData[$i]['observacion'] == 0) {
                                $arrayData[$i]['estado_format'] = '<spam class="badge badge-success" 
                                style="font-size:.9em;">
                                    Pagado
                                </spam>';
                            }
                            //formato de observacion
                            if ($arrayData[$i]['observacion'] == 0) {
                                $arrayData[$i]['observacion_format'] = '<spam class="badge badge-Light text-center" 
                                style="font-size:.9em;">
                                    -
                                </spam>';
                            }
                            //formato de descripcion
                            if ($arrayData[$i]['descripcion'] == "") {
                                $arrayData[$i]['descripcion_format'] = '<spam class="badge badge-Light text-center" 
                                style="font-size:.9em;">
                                    -
                                </spam>';
                            } else {
                                $arrayData[$i]['descripcion_format'] = $arrayData[$i]['descripcion'];
                            }
                        }
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

        public function getFinancialReport() {
            if ($_SESSION['permisosModulo']['r']){
                $arrayData = $this->model->SelectAllFinancialReport();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $arrayData[$i]['ingresos_format'] = "$".$arrayData[$i]['saldo'];
                    $arrayData[$i]['egresos'] = 0;
                    $arrayData[$i]['egresos_format'] = "$".$arrayData[$i]['egresos'];
                    $arrayData[$i]['saldo_neto'] = $arrayData[$i]['saldo'] - $arrayData[$i]['egresos'];
                    $arrayData[$i]['saldo_neto_format'] = "$".$arrayData[$i]['saldo_neto'];
                    /* funcionalida para actualizacion 
                    $btnExpenses = "";
                    if ($_SESSION['permisosModulo']['w']) {
                        $btnExpenses = '<button class="btn btn-danger btn-sm btnSeePayments" 
                            onclick="FctBtnExpenses()" 
                            title="Registrar egreso">
                                <i class="fas fa-hand-holding-usd"></i>
                            </button>';
                    }

                    $acciones = '<div class="text-center">'.$btnExpenses.'</div>';
                    $arrayData[$i]['Accion'] = $acciones;*/
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
    }
?>