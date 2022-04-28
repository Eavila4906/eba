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

        public function setMyContent() {
            if ($_POST) {
                $this->id_my_content = intval($_POST['id_my_content']);
                $this->InputNombre = $_POST['InputNombre'];
                $this->InputDescripcion = $_POST['InputDescripcion'];
                $this->InputLink = $_POST['InputLink'];
                $this->InputEstado = $_POST['InputEstado'];
                $this->user_session = $_SESSION['dataUser']['DNI'];
                $arrayData = "";
                if ($this->id_my_content == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertMyContent($this->InputNombre, 
                                                                    $this->InputDescripcion, 
                                                                    $this->InputLink,
                                                                    $this->user_session, 
                                                                    $this->InputEstado
                                                                );
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        $arrayData = $this->model->UpdateMyContent($this->id_my_content, 
                                                                    $this->InputNombre, 
                                                                    $this->InputDescripcion, 
                                                                    $this->InputLink, 
                                                                    $this->user_session,
                                                                    $this->InputEstado
                                                                );
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente.');
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualizado exitosmente.');
                    }  
                } else if ($arrayData == "ani") {
                    $arrayData = array('status' => false, 'msg' => 'Autor no identificado.');
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'El contenido ya esta registrado.');
                } else if ($arrayData == "Notexists") {
                    $arrayData = array('status' => false, 'msg' => 'Usted no existe como docente.', 'dni' => $this->user_session);
                } else if ($arrayData == 0) {
                    $arrayData = array('status' => false, 'msg' => 'Error insertion.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function getAllMyContentTeacher() {
            if ($_SESSION['permisosModulo']['r']) {
                $this->user_session = $_SESSION['dataUser']['DNI'];
                $arrayData = $this->model->SelectAllMyContentTeacher($this->user_session);
                return $arrayData;
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

        public function getAllMyContentStudent() {
            if ($_SESSION['permisosModulo']['r']) {
                $this->user_session = $_SESSION['dataUser']['DNI'];
                $this->current_date = date("Y-m-d");
                $arrayData = $this->model->SelectAllMyContentStudent($this->user_session);

                for ($i=0;  $i < count($arrayData); $i++) { 
                    $arrayData[$i]['teacher'] = array($this->model->SelectMyTeacherContentStudent($arrayData[$i]['content']));
                    //validar si tiene la compra de un curso en su actualidad
                    $arrayData[$i]['apc'] = array($this->model->SelectAllAccounting($this->user_session, $this->current_date));
                }
                
                return $arrayData;
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

        public function getMyContent($id_my_content) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $this->id_my_content = intval($id_my_content);
                    if ($this->id_my_content > 0) {
                        $arrayData = $this->model->SelectMyContent($this->id_my_content);
                        if (!empty($arrayData)) {
                            $arrayData = array('status' => true, 'data' => $arrayData);
                        } else {
                            $arrayData = array('status' => false, 'msg' => 'Datos no encontrados!');
                        }
                        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                    }
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

        public function getAllStudentNotMyContent($id_my_content) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $this->id_my_content = intval($id_my_content);
                    if ($this->id_my_content > 0) {
                        $this->current_date = date("Y-m-d");
                        $arrayData = $this->model->SelectAllStudentNotMyContent($this->id_my_content);
                        for ($i=0; $i < count($arrayData); $i++) { 
                            $this->current_date = date("Y-m-d");
                            $arrayData2 = $this->model->SelectAllAccounting($arrayData[$i]['DNI'], 
                            $this->current_date);

                            $btnAdd = "";
                            $id = "'".$arrayData[$i]['DNI']."'";
                            if ($_SESSION['permisosModulo']['r']){
                                if ($arrayData[$i]['proceso_contable'] != 1 && $arrayData2 == false) {
                                    $btnAdd = '<button class="btn btn-secondary btn-sm btnAddStudent" 
                                    title="Not available" disabled>
                                        <i class="fas fa-plus-circle fa-lg"></i>
                                    </button>'; 
                                } else {
                                    $btnAdd = '<button class="btn btn-success btn-sm btnAddStudent" 
                                    onclick="FctBtnAddOrDeleteStudent('.$id.', 1)" 
                                    title="Vincular">
                                        <i class="fas fa-plus-circle fa-lg"></i>
                                    </button>'; 
                                }
                            }
                            $acciones = '<div class="text-center">'.$btnAdd.'</div>';
                            $arrayData[$i]['Accion'] = $acciones;

                            //Proceso contable o Compra total
                            if ($arrayData[$i]['proceso_contable'] != 1 && $arrayData2 == false) {
                                $arrayData[$i]['id_student'] = '<div class="text-muted">'.$arrayData[$i]['id_student'].'</div>';
                                $arrayData[$i]['nombres'] = '<div class="text-muted">'.$arrayData[$i]['nombres'].'</div>';
                                $arrayData[$i]['DNI'] = '<div class="text-muted">'.$arrayData[$i]['DNI'].'</div>'; 
                                $arrayData[$i]['telefono'] = '<div class="text-muted">'.$arrayData[$i]['telefono'].'</div>';  
                                $arrayData[$i]['email'] = '<div class="text-muted">'.$arrayData[$i]['email'].'</div>';   
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

        public function getAllStudentYesMyContent($id_my_content) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $this->id_my_content = intval($id_my_content);
                    if ($this->id_my_content > 0) {
                        $arrayData = $this->model->SelectAllStudentYesMyContent($this->id_my_content);
                        for ($i=0; $i < count($arrayData); $i++) { 
                            $this->current_date = date("Y-m-d");
                            $arrayData2 = $this->model->SelectAllAccounting($arrayData[$i]['DNI'], $this->current_date);

                            $btnAdd = "";
                            $id = "'".$arrayData[$i]['DNI']."'";
                            if ($_SESSION['permisosModulo']['r']){
                                $btnAdd = '<button class="btn btn-danger btn-sm btnDeleteStudent" 
                                onclick="FctBtnAddOrDeleteStudent('.$id.', 2)" 
                                title="Desvincular">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>'; 
                            }
                            $acciones = '<div class="text-center">'.$btnAdd.'</div>';
                            $arrayData[$i]['Accion'] = $acciones;

                            //Proceso contable o Compra total
                            if ($arrayData[$i]['proceso_contable'] != 1 && $arrayData2 == true) {
                                $arrayData[$i]['id_detail_my_content_student'] = '<div class="text-danger">'.$arrayData[$i]['id_detail_my_content_student'].'</div>';
                                $arrayData[$i]['nombres'] = '<div class="text-danger">'.$arrayData[$i]['nombres'].'</div>';
                                $arrayData[$i]['DNI'] = '<div class="text-danger">'.$arrayData[$i]['DNI'].'</div>';
                                $arrayData[$i]['telefono'] = '<div class="text-danger">'.$arrayData[$i]['telefono'].'</div>';
                                $arrayData[$i]['email'] = '<div class="text-danger">'.$arrayData[$i]['email'].'</div>';
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

        public function getAllCountStudent($id_my_content) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $this->id_my_content = intval($id_my_content);
                    if ($this->id_my_content > 0) {
                        $arrayData = $this->model->SelectAllCountStudent($this->id_my_content);
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

        public function setStudentCourse() {
            if ($_POST) {
                if ($_POST['DNI'] == "" || $_POST['option'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    $this->dni = $_POST['DNI'];
                    $this->idContent = $_POST['idContent'];
                    $this->option = intval($_POST['option']);

                    if ($this->option == 1) {
                        if ($_SESSION['permisosModulo']['w']) {
                            $arrayData = $this->model->InsertStudentContent($this->dni, $this->idContent);
                            $opcion = 1;
                        }
                    } else {
                        if ($_SESSION['permisosModulo']['d']) {
                            $arrayData = $this->model->DeleteStudentContent($this->dni, $this->idContent);
                            $opcion = 2;
                        }
                    }

                    if ($arrayData > 0) {
                        if ($opcion == 1) {
                            $arrayData = array('status' => true, 'msg' => 'Agregado al curso.');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'Eliminado del curso.');
                        }  
                    } else if ($arrayData == "exists") {
                        $arrayData = array('status' => false, 'msg' => 'El estudiante ya se encuentra agregado en este curso.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }

        public function deleteCourse() {
            if ($_POST) {
                $this->id_my_content = intval($_POST['id_my_content']);
                if ($this->id_my_content > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteCourse($this->id_my_content);
                        if ($arrayData > 0) {
                            $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                        } else {
                            $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                        }
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
    
?>