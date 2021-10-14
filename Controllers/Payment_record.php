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
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllAccounting();
                for ($i=0; $i < count($arrayData); $i++) { 
                    $btnPaymentRecord = "";
                    /*$btnPaymentRecordTotal = "";*/
                    //$btnPaymentNotAccounting = "";
                    $dni = "'".$arrayData[$i]['DNI']."'";
                    $nombres = "'".$arrayData[$i]['estudiante']."'";
                    $fecha_UP = "'".$arrayData[$i]['fecha_PP']."'";
                    if ($_SESSION['permisosModulo']['w']){
                        $btnPaymentRecord = '<button class="btn btn-success btn-sm btnPaymentRecord" 
                        onclick="FctBtnPaymentRecord(1,'.$dni.','.$nombres.','.$arrayData[$i]['id_accounting'].','.$fecha_UP.')" 
                        title="Registrar pago mensual">
                            <i class="far fa-calendar-check fa-lg"> Registrar pago</i>
                        </button>';
                        //$btnPaymentRecordTotal = '<button class="btn btn-info btn-sm btnPaymentRecord" onclick="FctBtnPaymentRecord(2,'.$dni.','.$nombres.','.$arrayData[$i]['id_accounting'].','.$fecha_UP.')" title="Registrar todos los pagos"><i class="fas fa-calendar-check fa-lg"></i></button>';
                        //$btnPaymentNotAccounting = '<button class="btn btn-danger btn-sm btnPaymentRecord" onclick="FctBtnPaymentRecord(2,'.$dni.','.$nombres.','.$arrayData[$i]['id_accounting'].','.$fecha_UP.')" title="Registrar pago no contable"><i class="fas fa-calendar-times fa-lg"></i></button>';
                    }
                    //Formato de fecha
                    setlocale(LC_ALL,"es-ES");
                    $arrayData[$i]['Ultimo_pago'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_UP']));
                    $arrayData[$i]['Proximo_pago'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_PP']));

                    $arrayData[$i]['V_cuota'] = '<spam class="badge badge-success">$ '.$arrayData[$i]['valor'].'</spam>';
                    $acciones = '<div class="text-center">'.$btnPaymentRecord.'</div>';
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

        public function setPaymentRecord() {
            if ($_POST) {
                if (intval($_POST['accion']) == 0 || $_POST['DNI'] == "" || intval($_POST['id_accounting']) == 0 || $_POST['fecha_UP'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    $this->accion = intval($_POST['accion']);
                    $this->DNI = $_POST['DNI'];
                    $this->id_accounting = intval($_POST['id_accounting']);
                    $this->fecha_UP = $_POST['fecha_UP'];
                    $this->InputTypePayment = $_POST['InputTypePayment'];
                    $this->InputDescripcion = $_POST['InputDescripcion'];
                    $arrayData = "";

                    if ($this->accion == 1) {
                        if ($_POST['InputTypePayment'] == "") {
                            $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');  
                        } else {
                            if ($_SESSION['permisosModulo']['w']) {
                                $arrayData = $this->model->InsertPaymentRecord($this->DNI, 
                                                                               $this->id_accounting, 
                                                                               $this->fecha_UP,
                                                                               $this->InputTypePayment,
                                                                               $this->InputDescripcion);
                                $request = 1;
                            }
                        }
                    } else if ($this->accion == 2) {
                        if ($_POST['InputDescripcion'] == "") {
                            $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                        } else {
                            if ($_SESSION['permisosModulo']['w']) {
                                $arrayData = $this->model->InsertPaymentRecordNotAccounting($this->DNI, 
                                                                                            $this->id_accounting, 
                                                                                            $this->fecha_UP,
                                                                                            $this->InputDescripcion);
                                $request = 2;
                            }
                        }
                    } else if ($this->accion == 3) {
                        if ($_SESSION['permisosModulo']['w']) {
                            $data = $this->model->SelectPeriodo($this->DNI, $this->id_accounting);
                            $fecha_IC = $data['fecha_IC'];
                            $fecha_FC = $data['fecha_FC'];
                            $rango = calculateRangeDate($fecha_IC, $fecha_FC);
                            for ($i=0; $i < $rango; $i++) { 
                                $data = $this->model->SelectPeriodo($this->DNI, $this->id_accounting);
                                $this->fecha_UP = $data['fecha_UP'];
                                $arrayData = $this->model->InsertPaymentRecordTotal($this->DNI, 
                                                                                    $this->id_accounting, 
                                                                                    $this->fecha_UP);
                            }
                            $request = 3;
                        }
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }

                    if ($arrayData > 0) {
                        if ($request == 1) {
                            setlocale(LC_ALL,"es-ES");
                            $arrDataUser = $this->model->SelectDataUserAccounting($this->DNI, $this->id_accounting);
                            $mes = ucwords(strftime("%B", strtotime($arrDataUser['fecha_UP'])));
                            $dataUser = array(
                                'usuario' => $arrDataUser['nombres'],
                                'DNI' => $arrDataUser['DNI'],
                                'email' => $arrDataUser['email'],
                                'asunto' => 'Notificación de pago '.$mes.' - '.SENDER_NAME,
                                'url' => BASE_URL(),
                                'mes' => $mes
                            );
                            $sendEmail = sendEmail($dataUser, 'email_payment_notifications');
                            if ($sendEmail) {
                                $arrayData = array('status' => true, 'msg' => 'El pago se ha realizado exitosamente.');
                            } else {
                                $arrayData = array('status' => true, 'msg' => 'El pago se ha realizado exitosamente, pero hubo un error al enviar el email.');
                            }
                        } else if ($request == 2) {
                            setlocale(LC_ALL,"es-ES");
                            $arrDataUser = $this->model->SelectDataUserAccounting($this->DNI, $this->id_accounting);
                            $mes = ucwords(strftime("%B", strtotime($arrDataUser['fecha_UP'])));
                            $dataUser = array(
                                'usuario' => $arrDataUser['nombres'],
                                'DNI' => $arrDataUser['DNI'],
                                'email' => $arrDataUser['email'],
                                'asunto' => 'Notificación de pago '.$mes.' - '.SENDER_NAME,
                                'url' => BASE_URL(),
                                'mes' => $mes
                            );
                            $sendEmail = sendEmail($dataUser, 'email_payment_no_accounting_notifications');
                            if ($sendEmail) {
                                $arrayData = array('status' => true, 'msg' => 'Se registro el pago no contable exitosamente.');
                            } else {
                                $arrayData = array('status' => true, 'msg' => 'Se registro el pago no contable exitosamente, pero hubo un error al enviar el email.');
                            }
                        } else if ($request == 3) {
                            $arrayData = array('status' => true, 'msg' => 'Se ha registrado el pago total de su contabilidad.');
                            /*
                            setlocale(LC_ALL,"es-ES");
                            $arrDataUser = $this->model->SelectDataUserAccounting($this->DNI, $this->id_accounting);
                            $mes = ucwords(strftime("%B", strtotime($arrDataUser['fecha_UP'])));
                            $dataUser = array(
                                'usuario' => $arrDataUser['nombres'],
                                'DNI' => $arrDataUser['DNI'],
                                'email' => $arrDataUser['email'],
                                'asunto' => 'Notificación de pago '.$mes.' - '.SENDER_NAME,
                                'url' => BASE_URL(),
                                'mes' => $mes
                            );
                            sendEmail($dataUser, 'email_payment_total_notifications');
                            */
                        }
                    } else if ($arrayData == "rango completo") {
                        setlocale(LC_ALL,"es-ES");
                        $arrDataUser = $this->model->SelectDataUserAccounting($this->DNI, $this->id_accounting);
                        $mes = ucwords(strftime("%B", strtotime($arrDataUser['fecha_UP'])));
                        $dataUser = array(
                            'usuario' => $arrDataUser['nombres'],
                            'DNI' => $arrDataUser['DNI'],
                            'email' => $arrDataUser['email'],
                            'asunto' => 'Notificación de pago final '.$mes.' - '.SENDER_NAME,
                            'url' => BASE_URL(),
                            'mes' => $mes
                        );
                        $sendEmail = sendEmail($dataUser, 'email_payment_notifications');
                        if ($sendEmail) {
                            $arrayData = array('status' => true, 'msg' => 'Se ha realizado el ultimo pago en su contabilidad.');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'Se ha realizado el ultimo pago en su contabilidad, pero hubo un error al enviar el email.');
                        }
                    } else if ($arrayData == "rango completo - no contable") {
                        setlocale(LC_ALL,"es-ES");
                        $arrDataUser = $this->model->SelectDataUserAccounting($this->DNI, $this->id_accounting);
                        $mes = ucwords(strftime("%B", strtotime($arrDataUser['fecha_UP'])));
                        $dataUser = array(
                            'usuario' => $arrDataUser['nombres'],
                            'DNI' => $arrDataUser['DNI'],
                            'email' => $arrDataUser['email'],
                            'asunto' => 'Notificación de pago '.$mes.' - '.SENDER_NAME,
                            'url' => BASE_URL(),
                            'mes' => $mes
                        );
                        $sendEmail = sendEmail($dataUser, 'email_payment_no_accounting_notifications');
                        if ($sendEmail) {
                            $arrayData = array('status' => true, 'msg' => 'Se registro el pago no contable exitosamente, y se ha culminado el periodo de su contabilidad');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'Se registro el pago no contable exitosamente, y se ha culminado el periodo de su contabilidad, pero hubo un error al enviar el email.');
                        }
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }  
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>