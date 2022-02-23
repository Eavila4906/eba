<?php
    class My extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(1);
        }

        public function My(){
            $data['functions_js'] = "./Assets/js/functions_my.js";
            $data['name_page'] = "Area personal";
            $this->views->getViews($this,"my", $data);
        }

        public function notifications() {
            $this->user = $_SESSION['dataUser']['DNI'];
            $arrayData = $this->model->SelectAllNotifications($this->user);
            //Formato de fecha
            FormatDateLeguage();
            for ($i=0; $i < count($arrayData); $i++) { 
                $arrayData[$i]['Mes'] = ucwords(strftime("%B", strtotime($arrayData[$i]['fecha'])));
            }
            
            if ($arrayData > 0) {
                $arrayData = array('status' => true, 'data' => $arrayData);
            } else {
                $arrayData = array('status' => false, 'msg' => 'the process failed.');
            }
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();   
        }

        public function markRead() {
            if (intval($_POST['id_notification']) <= 0) {
                $arrayData = array('status' => false, 'msg' => 'the process failed, wrong request.');
            } else {
                $this->user = $_SESSION['dataUser']['DNI'];
                $this->id_notification = intval($_POST['id_notification']);
                $arrayData = $this->model->UpdateMarkReadNotifications($this->id_notification, $this->user);
                if ($arrayData > 0) {
                    $arrayData = array('status' => true);
                } else {
                    $arrayData = array('status' => false, 'msg' => 'the process failed.');
                }
            }
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die(); 
        }

        public function infoNotificaionsPayment() {
            if ($_POST['date'] == "") {
                $arrayData = array('status' => false, 'msg' => 'the process failed, wrong request.');
            } else {
                $this->user = $_SESSION['dataUser']['DNI'];
                $this->date = $_POST['date'];
                $arrayData = $this->model->SelectInfoNotificationsPayment($this->user, $this->date);
                $paymentDay = $this->model->SelectPaymentDay();
                if ($paymentDay['day'] <= 9) {
                    $paymentDay['day'] = '0'.$paymentDay['day'];
                }
                $day = $paymentDay['day'];
                $date_format = paymentDay($this->date).$day;
                $arrayData['fecha_pp'] = $this->model->SelectNextDate($date_format);
                
                //rago de pagos
                $periodo = $arrayData['periodo'];
                $periodo = explode(" - ", $periodo);
                $meses_contables = calculateRangeDate($periodo[0], $periodo[1]);
                $arrayData['meses_contables'] = $meses_contables;
                $meses_pagados = intval($this->model->SelectMesesActualesPagados($this->user, $arrayData['periodo'], $this->date));
                $arrayData['meses_pagados'] = $meses_pagados;
                $arrayData['meses_por_pagar'] = $meses_contables - $meses_pagados;

                //Formato de fecha
                FormatDateLeguage();
                $arrayData['fecha_pago'] = strftime("%d de %B de %Y", strtotime($arrayData['fecha_pago']));
                $arrayData['fecha_pp'] = strftime("%d de %B de %Y", strtotime($arrayData['fecha_pp']));
                $Inicio_periodo = ucwords(strftime("%B %Y", strtotime($periodo[0])));
                $Fin_periodo = ucwords(strftime("%B %Y", strtotime($periodo[1])));
                $arrayData['periodo'] = $Inicio_periodo." - ".$Fin_periodo;
                
                if ($arrayData > 0) {
                    $arrayData = array('status' => true, 'data' => $arrayData);
                } else {
                    $arrayData = array('status' => false, 'msg' => 'the process failed.');
                }
            }
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function infoNotificationPaymentReminder() {
            $this->user = $_SESSION['dataUser']['DNI'];
            $this->date = $_POST['date'];
            $arrayData = $this->model->SelectNotification($this->user);
            $paymentDay = $this->model->SelectPaymentDay();
            if ($paymentDay['day'] <= 9) {
                $paymentDay['day'] = '0'.$paymentDay['day'];
            }
            $day = $paymentDay['day'];
            $date_format = paymentDay($this->date).$day;
            $arrayData['fecha_pp'] = $date_format;

            //Formato de fecha
            FormatDateLeguage();
            $periodo = $arrayData['periodo'];
            $periodo = explode(" - ", $periodo);
            $meses_contables = calculateRangeDate($periodo[0], $periodo[1]);
            
            $arrayData['fecha_pp'] = strftime("%d de %B de %Y", strtotime($arrayData['fecha_pp']));
            $Inicio_periodo = ucwords(strftime("%B %Y", strtotime($periodo[0])));
            $Fin_periodo = ucwords(strftime("%B %Y", strtotime($periodo[1])));
            $arrayData['periodo'] = $Inicio_periodo." - ".$Fin_periodo;
                
            if ($arrayData > 0) {
                $arrayData = array('status' => true, 'data' => $arrayData);
            } else {
                $arrayData = array('status' => false, 'msg' => 'the process failed.');
            }
    
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            die();
        }

    }
    
?>