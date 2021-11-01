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

        public function getAllStudents() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllStudents();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnStartsAccounting = "";
                    $btnTotal_Purchase = "";
                    if ($_SESSION['permisosModulo']['w']){
                        $btnStartsAccounting = '<button class="btn btn-success btn-sm btnStartsAccounting" onclick="FctBtnStartsAccounting('.$arrayData[$i]['DNI'].')" title="Iniciar contabilidad"><i class="fas fa-calculator fa-lg"></i></button>';
                        $btnTotal_Purchase = '<button class="btn btn-info btn-sm btnStartsAccounting" onclick="FctBtnTotalPurchaseAccounting('.$arrayData[$i]['DNI'].')" title="Compra total"><i class="fas fa-cash-register fa-lg"></i></button>';
                    }
                    $acciones = '<div class="text-center">'.$btnStartsAccounting.' '.$btnTotal_Purchase.'</div>';
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

        public function setAccounting() {
            if ($_POST) {
                $arrayData = "";
                if ($_POST['id_student'] == "" || $_POST['InputTypePayment-sa'] == "" 
                    || $_POST['InputCuota'] == "" || $_POST['InputValor'] == "" 
                    || $_POST['InputFechaIC'] == "" || $_POST['InputFechaFC'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    $this->id_student = $_POST['id_student'];
                    $this->InputTypePayment_sa = $_POST['InputTypePayment-sa'];
                    $this->InputCuota = $_POST['InputCuota'];
                    $this->InputValor = $_POST['InputValor'];
                    $this->InputFechaIC = $_POST['InputFechaIC'];
                    $this->InputFechaFC = $_POST['InputFechaFC'];
                    $this->InputDescuentoIC = $_POST['InputDescuentoIC'];
                    $this->InputDescripcionIC = $_POST['InputDescripcionIC'];
                    $descuento = 0;
                    $valor_descuento = 0;
                    $valor_total_descuento = 0;
                    $cm = intval(calculateRangeDate($this->InputFechaIC, $this->InputFechaFC));

                    if (isset($_POST['InputADIC']) && $_POST['InputADIC'] == 1 && $this->InputDescuentoIC != 0) {
                        $descuento = $this->InputDescuentoIC;
                        $valor_descuento = ($this->InputDescuentoIC * $this->InputValor) / 100;
                        $valor_total_descuento = $this->InputValor - $valor_descuento;
                        $valor = $valor_total_descuento / $cm;
                    } else {
                        $valor = $this->InputValor / $cm;
                    }

                    if ($_SESSION['permisosModulo']['w']) {
                        $period_validation = $this->model->periodValidation($this->id_student,
                                                                            $this->InputFechaIC,
                                                                            $this->InputFechaFC);
                        
                        if ($period_validation) {
                            $arrayData = 0;
                        } else {
                            $arrayData = $this->model->InsertAccounting($this->id_student,
                                                                        $this->InputTypePayment_sa, 
                                                                        $this->InputCuota, 
                                                                        $valor, 
                                                                        $this->InputValor,
                                                                        $this->InputFechaIC, 
                                                                        $this->InputFechaFC,
                                                                        $descuento,
                                                                        $valor_descuento,
                                                                        $valor_total_descuento,
                                                                        $this->InputDescripcionIC);
                        }
                    }
                    if ($arrayData > 0) {
                        setlocale(LC_ALL,"es-ES");
                        $arrDataUser = $this->model->SelectDataUserAccounting($this->id_student);
                        $mes = ucwords(strftime("%B", strtotime($arrDataUser['fecha_UP'])));
                        $dataUser = array(
                            'usuario' => $arrDataUser['nombres'],
                            'DNI' => $arrDataUser['DNI'],
                            'email' => $arrDataUser['email'],
                            'asunto' => 'Notificación de pago inicial '.$mes.' - '.SENDER_NAME,
                            'url' => BASE_URL(),
                            'mes' => $mes
                        );
                        $sendEmail = sendEmail($dataUser, 'email_payment_notifications');
                        if ($sendEmail) {
                            $arrayData = array('status' => true, 'msg' => 'La contabilidad ha sido iniciado exitosamente.');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'La contabilidad ha sido iniciado, pero hubo un error al enviar el email.');
                        }
                    } else if ($arrayData == 0) {
                        $arrayData = array('status' => false, 'msg' => 'El estudiante ya cursó este periodo.');
                    }else if ($arrayData == "invalid date") {
                        $arrayData = array('status' => false, 'msg' => 'La fecha que ingresastes no es valida.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function setTotalPurchaseAccounting() {
            if ($_POST) {
                $arrayData = "";
                if ($_POST['id_student-TP'] == "" || $_POST['InputValorTP'] == "" 
                    || $_POST['InputFechaInicio'] == "" || $_POST['InputFechaFinal'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    $this->id_studentTP = $_POST['id_student-TP'];
                    $this->InputTypePayment = $_POST['InputTypePayment'];
                    $this->InputValorTP = $_POST['InputValorTP'];
                    $this->InputFechaInicio = $_POST['InputFechaInicio'];
                    $this->InputFechaFinal = $_POST['InputFechaFinal'];
                    $this->InputDescripcion = $_POST['InputDescripcion'];
                    $this->InputDescuento = $_POST['InputDescuento'];
                    $descuento = 0;
                    $valor_descuento = 0;
                    $valor_total_descuento = 0;
                    
                    if (isset($_POST['InputAD']) && $_POST['InputAD'] == 1 && $this->InputDescuento != 0) {
                        $descuento = $this->InputDescuento;
                        $valor_descuento = round(($this->InputDescuento * $this->InputValorTP) / 100);
                        $valor_total_descuento = round($this->InputValorTP - $valor_descuento);
                        $valor = round($valor_total_descuento);
                    } else {
                        $valor = round($this->InputValorTP);
                    }

                    if ($_SESSION['permisosModulo']['w']) {
                        $period_validation = $this->model->periodValidation($this->id_studentTP,
                                                                            $this->InputFechaInicio,
                                                                            $this->InputFechaFinal);
                        
                        if ($period_validation) {
                            $arrayData = 0;
                        } else {
                            $arrayData = $this->model->InsertTotalPurchaseAccounting($this->id_studentTP, 
                                                                                    $this->InputTypePayment,
                                                                                    $valor, 
                                                                                    $this->InputValorTP,
                                                                                    $this->InputFechaInicio, 
                                                                                    $this->InputFechaFinal,
                                                                                    $descuento,
                                                                                    $valor_descuento,
                                                                                    $valor_total_descuento,
                                                                                    $this->InputDescripcion);
                        }
                    }
                    if ($arrayData > 0) {
                        setlocale(LC_ALL,"es-ES");
                        $arrDataUser = $this->model->SelectDataUserPT($this->id_studentTP);
                        $Inicio_periodo = ucwords(strftime("%B %Y", strtotime($this->InputFechaInicio)));
                        $Fin_periodo = ucwords(strftime("%B %Y", strtotime($this->InputFechaFinal)));
                        $periodo = $Inicio_periodo." - ".$Fin_periodo;
                        $dataUser = array(
                            'usuario' => $arrDataUser['nombres'],
                            'DNI' => $this->id_studentTP,
                            'email' => $arrDataUser['email'],
                            'asunto' => 'Notificación de pago total '.$periodo.' - '.SENDER_NAME,
                            'url' => BASE_URL(),
                            'periodo' => $periodo
                        );
                        $sendEmail = sendEmail($dataUser, 'email_payment_total_notifications');
                        if ($sendEmail) {
                            $arrayData = array('status' => true, 'msg' => 'realizada exitosamente.');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'realizada exitosamente, pero hubo un error al enviar el email.');
                        }
                    } else if ($arrayData == 0) {
                        $arrayData = array('status' => false, 'msg' => 'El estudiante ya cursó este periodo.');
                    } else if ($arrayData == "invalid date") {
                        $arrayData = array('status' => false, 'msg' => 'La fecha que ingresastes no es valida.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        
        public function getAllAccounting() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllAccounting();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnStopAccounting = "";
                    $btnPauseAccounting = "";
                    $btnPlayAccounting = "";
                    $btnSeeDetailAccounting = "";
                    $periodo = "'".$arrayData[$i]['fecha_IC']." - ".$arrayData[$i]['fecha_FC']."'";
                    $student = "'".$arrayData[$i]['estudiante']."'";
                    if ($_SESSION['permisosModulo']['w'] && $_SESSION['permisosModulo']['u']){
                        $btnStopAccounting = '<button class="btn btn-danger btn-sm btnStopAccounting" 
                        onclick="FctBtnStopAccounting('.$arrayData[$i]['id_accounting'].','.$arrayData[$i]['DNI'].','.$periodo.')" 
                        title="Detener contabilidad">
                            <i class="fas fa-stop-circle"></i>
                        </button>';
                        /*$btnPauseAccounting = '<button class="btn btn-info btn-sm btnPauseAccounting" 
                        onclick="FctBtnPauseAccounting('.$arrayData[$i]['DNI'].','.$periodo.')" 
                        title="Pausar contabilidad">
                            <i class="fas fa-pause-circle fa-lg"></i>
                        </button>';
                        $btnPlayAccounting = '<button class="btn btn-info btn-sm btnPlayAccounting" 
                        onclick="FctBtnPlayAccounting('.$arrayData[$i]['DNI'].','.$periodo.')" 
                        title="Continuar contabilidad">
                            <i class="fas fa-play-circle fa-lg">
                        </i></button>';*/ 
                        $btnSeeDetailAccounting = '<button class="btn btn-info btn-sm btnPlayAccounting" 
                        onclick="FctBtnSeeDetailAccounting('.$arrayData[$i]['id_accounting'].','.$arrayData[$i]['DNI'].','.$periodo.','.$student.')" 
                        title="Ver detalles de la contabilidad">
                            <i class="fas fa-eye">
                        </i></button>'; 
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
                        $acciones = '<div class="text-center">'.$btnSeeDetailAccounting.' '.$btnPauseAccounting.''.$btnStopAccounting.'</div>';     
                    } else {
                        $acciones = '<div class="text-center">'.$btnPlayAccounting.''.$btnStopAccounting.'</div>';
                    }
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

        public function getAllInactiveAccounting() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllInactiveAccounting();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnSeeDetailAccounting = "";
                    $dni = "'".$arrayData[$i]['DNI']."'";
                    $student = "'".$arrayData[$i]['estudiante']."'";
                    if ($_SESSION['permisosModulo']['r']){
                        $btnSeeDetailAccounting = '<button class="btn btn-info btn-sm btnPlayAccounting" 
                        onclick="FctBtnSeeIIA('.$dni.','.$student.')" 
                        title="Ver contabilidades individuales">
                            <i class="fas fa-eye">
                        </i></button>'; 
                    }
                    
                    $acciones = '<div class="text-center">'.$btnSeeDetailAccounting.'</div>';
                
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

        public function stopAccounting() {
            if ($_POST) {
                if ($_POST['id_accounting-sa'] == '' || $_POST['id_student-sa'] == '' || $_POST['periodo-sa'] == '' || $_POST['InputJustificacion'] == '') {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso!');
                } else {
                    $this->id_accounting = $_POST['id_accounting-sa'];
                    $this->id_student = $_POST['id_student-sa'];
                    $this->periodo = $_POST['periodo-sa'];
                    $this->InputJustificacion = $_POST['InputJustificacion'];
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['w'] && $_SESSION['permisosModulo']['u']){
                        $arrayData = $this->model->stopAccounting($this->id_accounting, 
                                                                  $this->id_student, 
                                                                  $this->periodo, 
                                                                  $this->InputJustificacion);
                    }
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Detenida exitosamente.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function pauseAccounting() {
            if ($_POST) {
                if ($_POST['id_student'] == '' || $_POST['periodo'] == '') {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->id_student = $_POST['id_student'];
                    $this->periodo = $_POST['periodo'];
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['w'] && $_SESSION['permisosModulo']['u']){
                        $arrayData = $this->model->pauseAccounting($this->id_student, $this->periodo);
                    }
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Pausada exitosamente.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function playAccounting() {
            if ($_POST) {
                if ($_POST['id_student'] == '' || $_POST['periodo'] == '') {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->id_student = $_POST['id_student'];
                    $this->periodo = $_POST['periodo'];
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['w'] && $_SESSION['permisosModulo']['u']){
                        $arrayData = $this->model->playAccounting($this->id_student, $this->periodo);
                    }
                    if ($arrayData > 0) {
                        $arrayData = array('status' => true, 'msg' => 'Contabilidad reanudada.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function getSeeDetailsAccounting($parameters) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $arrayparameters = explode(',',$parameters);
                    $id_accounting = $arrayparameters[0];
                    $dni = $arrayparameters[1];
                    $periodo = $arrayparameters[2];
                    $arrayData = $this->model->SelectDetailsAccounting($id_accounting, $dni, $periodo);
                    setlocale(LC_ALL,"es-ES");
                    $arrayData['periodo'] = ucwords(strftime("%B %Y", strtotime($arrayData['fecha_IC'])))." - ".ucwords(strftime("%B %Y", strtotime($arrayData['fecha_FC'])));
                    $arrayData['fecha_UP'] = strftime("%d de %B de %Y", strtotime($arrayData['fecha_UP']));
                    $arrayData['fecha_PP'] = strftime("%d de %B de %Y", strtotime($arrayData['fecha_PP']));
                    $porc = round($arrayData['valor'] * $arrayData['descuento'] / 100);
                    $valor = round($arrayData['valor'] + $porc);
                    $arrayData['valor_m'] = "$".$valor;
                    $arrayData['valor_mcd'] = "$".$arrayData['valor'];
                    $arrayData['valor_total'] = "$".$arrayData['valor_total'];
                    $arrayData['descuento'] = $arrayData['descuento']."%";
                    $arrayData['valor_descuento'] = "$".$arrayData['valor_descuento'];
                    $arrayData['valor_total_descuento'] = "$".$arrayData['valor_total_descuento'];
                    if ($arrayData['descripcion'] == "") {
                        $arrayData['descripcion'] = "-";
                    }
                    if ($arrayData['estado'] == 1) {
                        $arrayData['estado'] = '<span class="badge badge-info" style="font-size:.9em;">En proceso de pago</span>';
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

        public function getSeeIIA($dni) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $this->dni = $dni;
                    $arrayData = $this->model->SelectSeeIIA($this->dni);
                    for ($i=0; $i < count($arrayData); $i++) {
                        //Formato de fecha
                        setlocale(LC_ALL,"es-ES");  
                        $Inicio_periodo = ucwords(strftime("%B %Y", strtotime($arrayData[$i]['fecha_IC'])));
                        $Fin_periodo = ucwords(strftime("%B %Y", strtotime($arrayData[$i]['fecha_FC'])));
                        $arrayData[$i]['periodo_format'] = $Inicio_periodo." - ".$Fin_periodo; 
                        $arrayData[$i]['fecha_UP_format'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_UP']));
                        if ($arrayData[$i]['fecha_PP'] == "0000-00-00") {
                            $arrayData[$i]['fecha_PP_format'] = "-";
                        } else {
                            $arrayData[$i]['fecha_PP_format'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_PP']));
                        }
                        
                        $btnSeeIIA = ""; 
                        $btnDeleteIIA = ""; 
                        if ($_SESSION['permisosModulo']['r']){
                            $p = "'".$arrayData[$i]['fecha_IC']." - ".$arrayData[$i]['fecha_FC']."'";
                            $e = "'".$arrayData[$i]['DNI']."'";
                            $pf = "'".$arrayData[$i]['periodo_format']."'";
                            $btnSeeIIA = '<button class="btn btn-primary btn-sm btnSeePayments" 
                            onclick="FctBtnSeeDIIA('.$p.','.$e.','.$pf.')" 
                            title="Ver detalles">
                                <i class="fas fa-folder-open"></i>
                            </button>'; 
                        }
                        if ($_SESSION['permisosModulo']['d']){
                            $p = "'".$arrayData[$i]['fecha_IC']." - ".$arrayData[$i]['fecha_FC']."'";
                            $e = "'".$arrayData[$i]['DNI']."'";
                            $pf = "'".$arrayData[$i]['periodo_format']."'";
                            /*$btnDeleteIIA = '<button class="btn btn-danger btn-sm btnSeePayments" 
                            onclick="FctBtnDeleteRDIIA('.$p.','.$e.','.$pf.')" 
                            title="Eliminar registro">
                                <i class="fas fa-trash-alt"></i>
                            </button>'; */
                        }
                        $acciones = '<div class="text-center">'.$btnSeeIIA." ".$btnDeleteIIA.'</div>';

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

        public function getSeeDIIA($parameters) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $arrayparameters = explode(',',$parameters);
                    $dni = $arrayparameters[0];
                    $periodo = $arrayparameters[1];
                    $arrayData = $this->model->SelectDIIA($dni, $periodo);
                    setlocale(LC_ALL,"es-ES");
                    $arrayData['periodo'] = ucwords(strftime("%B %Y", strtotime($arrayData['fecha_IC'])))." - ".ucwords(strftime("%B %Y", strtotime($arrayData['fecha_FC'])));
                    $arrayData['fecha_UP'] = strftime("%d de %B de %Y", strtotime($arrayData['fecha_UP']));
                    if ($arrayData['fecha_PP'] == "0000-00-00") {
                        $arrayData['fecha_PP'] = "-";
                    } else {
                        $arrayData['fecha_PP'] = strftime("%d de %B de %Y", strtotime($arrayData['fecha_PP']));;
                    }
                    $porc = round($arrayData['valor'] * $arrayData['descuento'] / 100);
                    $valor = round($arrayData['valor'] + $porc);
                    $arrayData['valor_m_DIIA'] = "$".$valor;
                    $arrayData['valor_mcd_DIIA'] = "$".$arrayData['valor'];
                    //$arrayData['valor'] = "$".$arrayData['valor'];
                    $arrayData['valor_total'] = "$".$arrayData['valor_total'];
                    $arrayData['descuento'] = $arrayData['descuento']."%";
                    $arrayData['valor_descuento'] = "$".$arrayData['valor_descuento'];
                    $arrayData['valor_total_descuento'] = "$".$arrayData['valor_total_descuento'];
                    if ($arrayData['descripcion'] == "") {
                        $arrayData['descripcion'] = "-";
                    }

                    if ($arrayData['estado'] == 0 && $arrayData['fecha_PP'] == "-") {
                        $arrayData['estado_format'] = '<span class="badge badge-info" style="font-size:.9em;">
                            Proceso de pago completo
                        </span>';
                    } else {
                        $arrayData['estado_format'] = '<span class="badge badge-danger" style="font-size:.9em;">
                            Proceso de pago cancelado
                        </span>';
                    }

                    if ($arrayData['observacion'] == '') {
                        $arrayData['obs'] = 0;
                    } else {
                        $arrayData['obs'] = 1;
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
    }
?>