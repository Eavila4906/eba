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
                $btnPaymentNotAccounting = "";
                $dni = "'".$arrayData[$i]['DNI']."'";
                $nombres = "'".$arrayData[$i]['estudiante']."'";
                $fecha_UP = "'".$arrayData[$i]['fecha_PP']."'";
                if ($_SESSION['permisosModulo']['w']){
                    $btnPaymentRecord = '<button class="btn btn-success btn-sm btnPaymentRecord" onclick="FctBtnPaymentRecord(1,'.$dni.','.$nombres.','.$arrayData[$i]['id_accounting'].','.$fecha_UP.')" title="Registrar pago"><i class="fas fa-check-circle fa-lg"></i></button>';
                    $btnPaymentNotAccounting = '<button class="btn btn-danger btn-sm btnPaymentRecord" onclick="FctBtnPaymentRecord(2,'.$dni.','.$nombres.','.$arrayData[$i]['id_accounting'].','.$fecha_UP.')" title="Registrar pago no contable"><i class="fas fa-calendar-times fa-lg"></i></button>';
                }
                //Formato de fecha
                setlocale(LC_ALL,"es-ES");
                $arrayData[$i]['Ultimo_pago'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_UP']));
                $arrayData[$i]['Proximo_pago'] = strftime("%d de %B de %Y", strtotime($arrayData[$i]['fecha_PP']));

                $arrayData[$i]['V_cuota'] = '<spam class="badge badge-success">$ '.$arrayData[$i]['valor'].'</spam>';
                $acciones = '<div class="text-center">'.$btnPaymentRecord.' '.$btnPaymentNotAccounting.'</div>';
                $arrayData[$i]['Acciones'] = $acciones;  
            }
            
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setPaymentRecord() {
            if ($_POST) {
                if (intval($_POST['accion']) == 0 || $_POST['DNI'] == "" || intval($_POST['id_accounting']) == 0 || $_POST['fecha_UP'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                } else {
                    $this->accion = intval($_POST['accion']);
                    $this->DNI = $_POST['DNI'];
                    $this->id_accounting = intval($_POST['id_accounting']);
                    $this->fecha_UP = $_POST['fecha_UP'];

                    if ($this->accion == 1) {
                        $arrayData = $this->model->InsertPaymentRecord($this->DNI, $this->id_accounting, $this->fecha_UP);
                        $request = 1;
                    } else if ($this->accion == 2) {
                        $arrayData = $this->model->InsertPaymentRecordNotAccounting($this->DNI, $this->id_accounting, $this->fecha_UP);
                        $request = 2;
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'the process failed, try again later!');
                    }

                    if ($arrayData > 0) {
                        if ($request == 1) {
                            $arrayData = array('status' => true, 'msg' => 'El pago se ha realizado exitosamente.');
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
                            sendEmail($dataUser, 'email_payment_notifications');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'Se registro el pago no contable exitosamente.');
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
                            sendEmail($dataUser, 'email_payment_no_accounting_notifications');
                        }
                    } else if ($arrayData == "rango completo") {
                        $arrayData = array('status' => true, 'msg' => 'Se ha realizado el ultimo pago en su contabilidad.');
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
                        sendEmail($dataUser, 'email_payment_notifications');
                    } else if ($arrayData == "rango completo - no contable") {
                        $arrayData = array('status' => true, 'msg' => 'Se registro el pago no contable exitosamente, y se ha culminado el periodo de su contabilidad');
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
                        sendEmail($dataUser, 'email_payment_no_accounting_notifications');
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