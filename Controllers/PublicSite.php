<?php
    class PublicSite extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(3);
        }

        public function PublicSite(){
            if (empty($_SESSION['permisosModulo']['r'])) {
                if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                    header('location: '.BASE_URL().'dashboard');
                } else {
                    header('location: '.BASE_URL().'my');
                }
            }
            $data['functions_js'] = "./Assets/js/functions_publicsite.js";
            $data['name_page'] = "Sitio Publico";
            $this->views->getViews($this,"publicsite", $data);
        }

        /* Start home */
        public function getAllContentGaleryHome() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllContentGaleryHome();
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

        public function getContents($id_cont) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $arrayData = "";
                    $this->id_cont = intval($id_cont);
                    if ($this->id_cont > 0) {
                        $arrayData = $this->model->SelectContents($this->id_cont);
                        if (!empty($arrayData)) {
                            $arrayData['url_image'] = MEDIA().'images/image-public-site/carousel-image-home/'.$arrayData['image'];
                            $arrayData = array('status' => true, 'data' => $arrayData);
                        } else {
                            $arrayData = array('status' => false, 'msg' => 'Datos no encontrados!');
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

        public function setContentGaleryHome() {
            if ($_POST) {
                $arrayData = "";
                $this->InputId_cont = intval($_POST['id_cont']);
                $this->InputTitulo = $_POST['InputTitulo'];
                $this->InputDescripcion = $_POST['InputDescripcion'];
                $this->InputEstado = $_POST['InputEstado'];

                $dataImage = $_FILES['image'];
                $this->nameImage = $dataImage['name'];
                $this->type = $dataImage['type'];
				$this->url_temp = $dataImage['tmp_name'];
				$imgPortada = 'imageDefault.jpg';
                if($this->nameImage != ''){
                    $imgPortada = 'img_carousel_'.md5(date('d-m-Y H:m:s')).'.jpg';
                }

                if ($this->InputId_cont == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertContentGaleryHome($this->InputTitulo, $this->InputDescripcion, $this->InputEstado, $imgPortada);
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        if($this->nameImage == ''){
                            if($_POST['image_actual'] != 'imageDefault.jpg' && $_POST['image_remove'] == 0 ){
                                $imgPortada = $_POST['image_actual'];
                            }
                        }
                        $arrayData = $this->model->UpdateContentGaleryHome($this->InputId_cont, $this->InputTitulo, $this->InputDescripcion, $this->InputEstado, $imgPortada);
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente.');
                        if($this->nameImage != ''){ 
                            uploadImageServer($dataImage, $imgPortada); 
                        }
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualización Exitosa.');
                        if($this->nameImage != ''){ 
                            uploadImageServer($dataImage, $imgPortada); 
                        }
                        if(($this->nameImage == '' && $_POST['image_remove'] == 1 && $_POST['image_actual'] != 'imageDefault.jpg')
							|| ($this->nameImage != '' && $_POST['image_actual'] != 'imageDefault.jpg')){
                            deleteImageServer($_POST['image_actual']);
						}
                    }  
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'El contenido ya esta registrado en el sistema.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function deleteContents() {
            if ($_POST) {
                $this->id_cont = intval($_POST['id_cont']);
                $this->img = intval($_POST['img']);
                if ($this->id_cont > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteContents($this->id_cont);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                        deleteImageServer($_POST['img']);
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        /* Finish home */

        /* Start icons */
        public function getAllIconsAbout() {
            $htmlOptions = "";
            $arrayData = "";
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllIconsAbout();
            }
			if(!empty($arrayData)){
				for ($i=0; $i < count($arrayData); $i++) { 	
				    $htmlOptions .= '<option value="'.$arrayData[$i]['id_icon'].'" class="fas">'.$arrayData[$i]['codigo'].' '.$arrayData[$i]['nombre'].'</option>';	
				}
			} else {
                $htmlOptions .= '<option selected disabled class="none-block">No existen datos para mostrar!</option>';
            }
			echo $htmlOptions;
			die();
        }

        public function getAllIconsSocialMedia() {
            $htmlOptions = "";
            $arrayData = "";
            if ($_SESSION['permisosModulo']['r']) {
			    $arrayData = $this->model->SelectAllIconsSocialMedia();
            }
			if(!empty($arrayData)){
				for ($i=0; $i < count($arrayData); $i++) { 	
				    $htmlOptions .= '<option value="'.$arrayData[$i]['id_icon'].'" class="fab">'.$arrayData[$i]['codigo'].' '.$arrayData[$i]['nombre'].'</option>';	
				}
			} else {
                $htmlOptions .= '<option selected disabled class="none-block">No existen datos para mostrar!</option>';
            }
			echo $htmlOptions;
			die();
        }

        public function setIcon() {
            if ($_POST) {
                $this->InputNombre = $_POST['InputNombre'];
                $this->InputCodigo = '&#x'.$_POST['InputCodigo'].';';
                $this->InputUtilidad = $_POST['InputUtilidad'];
                $arrayData = "";
                if ($_SESSION['permisosModulo']['w']) {
                    $arrayData = $this->model->InsertIcons($this->InputCodigo, $this->InputNombre, $this->InputUtilidad);
                }
                if ($arrayData > 0) {
                    $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente.');       
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'El icono ya esta registrado.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
        /* Finish icons */

        /* Start about */
        public function getAllContentAbout() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllContentAbout();
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

        public function getContentsAbout($id_contAbout) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $this->id_contAbout = intval($id_contAbout);
                    if ($this->id_contAbout > 0) {
                        $arrayData = $this->model->SelectContentsAbout($this->id_contAbout);
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

        public function setContentAbout() {
            if ($_POST) {
                $this->InputId_contAbout = intval($_POST['id_contAbout']);
                $this->InputTituloAbout = $_POST['InputTituloAbout'];
                $this->InputDescripcionAbout = $_POST['InputDescripcionAbout'];
                $this->InputEstadoAbout = $_POST['InputEstadoAbout'];
                $this->InputIcono = $_POST['InputIconoAbout'];
                $arrayData = "";

                if ($this->InputId_contAbout == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertContentAbout($this->InputTituloAbout, $this->InputDescripcionAbout, $this->InputIcono, $this->InputEstadoAbout);
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        $arrayData = $this->model->UpdateContentAbout($this->InputId_contAbout, $this->InputTituloAbout, $this->InputDescripcionAbout, $this->InputIcono, $this->InputEstadoAbout);
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente.');
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualización Exitosa.');
                    }  
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'El contenido ya esta registrado en el sistema.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE); 
            }
            die();
        }

        public function deleteContentsAbout() {
            if ($_POST) {
                $this->id_contAbout = intval($_POST['id_contAbout']);
                if ($this->id_contAbout > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteContentsAbout($this->id_contAbout);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        /* Finish about */

        /* Start headquarter */
        public function getAllHeadquarter() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllHeadquarter();
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

        public function getHeadquarter($id_headquarter) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $this->id_headquarter = intval($id_headquarter);
                    if ($this->id_headquarter > 0) {
                        $arrayData = $this->model->SelectHeadquarter($this->id_headquarter);
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

        public function setHeadquarter() {
            if ($_POST) {
                $this->InputId_headquarter = intval($_POST['id_headquarter']);
                $this->InputUbicacion = $_POST['InputUbicacion'];
                $this->InputLongitud = $_POST['InputLongitud'];
                $this->InputLatitud = $_POST['InputLatitud'];
                $this->InputEstadoH = $_POST['InputEstadoH'];
                $arrayData = "";

                if ($this->InputId_headquarter == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertHeadquarter($this->InputUbicacion, $this->InputLongitud, $this->InputLatitud, $this->InputEstadoH);
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        $arrayData = $this->model->UpdateHeadquarter($this->InputId_headquarter, $this->InputUbicacion, $this->InputLongitud, $this->InputLatitud, $this->InputEstadoH);
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $arrayData = array('status' => true, 'msg' => 'Reguistrada exitosmente.');
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualizada exitosmente.');
                    }  
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'La sede ya esta registrado en el sistema.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function deleteHeadquarter() {
            if ($_POST) {
                $this->id_headquarter = intval($_POST['id_headquarter']);
                if ($this->id_headquarter > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteHeadquarter($this->id_headquarter);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminada con exito.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        /* Finish headquarter */

        /* Start contacts */
        public function getAllContacts() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllContacts();
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

        public function getContacts($id_contacts) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $this->id_contacts = intval($id_contacts);
                    if ($this->id_contacts > 0) {
                        $arrayData = $this->model->SelectContacts($this->id_contacts);
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

        public function setContacts() {
            if ($_POST) {
                $this->InputId_contacts = intval($_POST['id_contacts']);
                $this->InputTelefono = $_POST['InputTelefono'];
                $this->InputEmail = $_POST['InputEmail'];
                $this->InputEstadoC = $_POST['InputEstadoC'];
                $arrayData = "";

                if ($this->InputId_contacts == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertContacts($this->InputTelefono, $this->InputEmail, $this->InputEstadoC);
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        $arrayData = $this->model->UpdateContacts($this->InputId_contacts, $this->InputTelefono, $this->InputEmail, $this->InputEstadoC);
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $arrayData = array('status' => true, 'msg' => 'Reguistrado exitosmente.');
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualizado exitosmente.');
                    }  
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'Los datos ya estan registrados en el sistema.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function deleteContacts() {
            if ($_POST) {
                $this->id_contacts = intval($_POST['id_contacts']);
                if ($this->id_contacts > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteContacts($this->id_contacts);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminado con exito.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        /* Finish contacts */

        /* Start social media */
        public function getAllSocialMedia() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllSocialMedia();
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

        public function getSocialMedia($id_socialMedia) {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']) {
                    $this->id_socialMedia = intval($id_socialMedia);
                    if ($this->id_socialMedia > 0) {
                        $arrayData = $this->model->SelectSocialMedia($this->id_socialMedia);
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

        public function setSocialMedia() {
            if ($_POST) {
                $this->InputId_socialMedia = intval($_POST['id_socialMedia']);
                $this->InputNombreRS = $_POST['InputNombreRS'];
                $this->InputLinkRS = $_POST['InputLinkRS'];
                $this->InputIconoRS = $_POST['InputIconoRS'];
                $this->InputEstadoRS = $_POST['InputEstadoRS'];
                $arrayData = "";

                if ($this->InputId_socialMedia == 0) {
                    if ($_SESSION['permisosModulo']['w']) {
                        $arrayData = $this->model->InsertSocialMedia($this->InputNombreRS, $this->InputLinkRS, $this->InputIconoRS, $this->InputEstadoRS);
                        $opcion = 1;
                    }
                } else {
                    if ($_SESSION['permisosModulo']['u']) {
                        $arrayData = $this->model->UpdateSocialMedia($this->InputId_socialMedia, $this->InputNombreRS, $this->InputLinkRS, $this->InputIconoRS, $this->InputEstadoRS);
                        $opcion = 2;
                    }
                }

                if ($arrayData > 0) {
                    if ($opcion == 1) {
                        $arrayData = array('status' => true, 'msg' => 'Reguistrada exitosmente.');
                    } else {
                        $arrayData = array('status' => true, 'msg' => 'Actualizada exitosmente.');
                    }  
                } else if ($arrayData == "exists") {
                    $arrayData = array('status' => false, 'msg' => 'Los datos ya estan registrados en el sistema.');
                } else {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                }
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function deleteSocialMedia() {
            if ($_POST) {
                $this->id_socialMedia = intval($_POST['id_socialMedia']);
                if ($this->id_socialMedia > 0) {
                    $arrayData = "";
                    if ($_SESSION['permisosModulo']['d']) {
                        $arrayData = $this->model->DeleteSocialMedia($this->id_socialMedia);
                    }
                    if ($arrayData == "ok") {
                        $arrayData = array('status' => true, 'msg' => 'Eliminada con exito.');
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        /* Finish social media */

        /* Start teachers */
        public function getAllTeachers() {
            if ($_SESSION['permisosModulo']['r']) {
                $arrayData = $this->model->SelectAllTeachers();
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

        public function getAllTeachersSelect() {
            if ($_GET) {
                if ($_SESSION['permisosModulo']['r']){
                    $arrayData = $this->model->SelectAllTeachers_2();
                    for ($i=0; $i < count($arrayData); $i++) { 
                        $btnOn = "";
                        $id = "'".$arrayData[$i]['id_teacher']."'";
                        if ($_SESSION['permisosModulo']['r']){
                            $btnOn = '<button class="btn btn-success btn-sm btnSeePayments" 
                            onclick="FctBtnOnOrOffTeacher('.$id.', 1)" 
                            title="Agregar a la portada">
                                <i class="fas fa-power-off"></i>
                            </button>'; 
                        }
                        $acciones = '<div class="text-center">'.$btnOn.'</div>';

                        $arrayData[$i]['Accion'] = $acciones;  
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

        public function setTeacherContent() {
            if ($_POST) {
                if ($_POST['id_teacher'] == "" || $_POST['option'] == "") {
                    $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                } else {
                    $this->id_teacher = $_POST['id_teacher'];
                    $this->option = intval($_POST['option']);

                    if ($this->option == 1) {
                        if ($_SESSION['permisosModulo']['w']) {
                            $arrayData = $this->model->UpdateStatusTeacher($this->id_teacher, 1);
                            $opcion = 1;
                        }
                    } else {
                        if ($_SESSION['permisosModulo']['w']) {
                            $arrayData = $this->model->UpdateStatusTeacher($this->id_teacher, 0);
                            $opcion = 2;
                        }
                    }

                    if ($arrayData > 0) {
                        if ($opcion == 1) {
                            $arrayData = array('status' => true, 'msg' => 'Se ha agregado a la portada.');
                        } else {
                            $arrayData = array('status' => true, 'msg' => 'Se ha quitado de la portada.');
                        }  
                    } else {
                        $arrayData = array('status' => false, 'msg' => 'No se pudo ejecutar este proceso.');
                    }
                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }

        /* Finish teachers */
    }
    
?>