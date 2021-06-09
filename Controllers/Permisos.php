<?php
    class Permisos extends Controllers {
        public function __construct(){
            parent::__construct();
        }
        
        public function getPermisos(int $id_rol) {
            $this->id_rol = intval($id_rol);

            if ($this->id_rol > 0) {
                $arrayModulos = $this->model->SelectModulos();
                $arrayPermisos = $this->model->SelectPermisos($this->id_rol);
                
                $arrPermisos = array(
                    'r' => 0,
                    'w' => 0,
                    'u' => 0,
                    'd' => 0
                );

                $arrPermisosRol = array(
                    'id_rol' => $this->id_rol
                );

                if (empty($arrayPermisos)) {
                    for ($i=0; $i < count($arrayModulos); $i++) { 
                        $arrayModulos[$i]['permisos'] = $arrPermisos;
                    }
                } else {
                    for ($i=0; $i < count($arrayModulos); $i++) { 
                        $arrPermisos = array(
                            'r' => 0,
                            'w' => 0,
                            'u' => 0,
                            'd' => 0
                        );
                        if (isset($arrayPermisos[$i])) {
                            $arrPermisos = array(
                                'r' => $arrayPermisos[$i]['r'],
                                'w' => $arrayPermisos[$i]['w'],
                                'u' => $arrayPermisos[$i]['u'],
                                'd' => $arrayPermisos[$i]['d'] 
                            );
                        }
                        $arrayModulos[$i]['permisos'] = $arrPermisos;  
                    }
                }
                $arrPermisosRol['modulos'] = $arrayModulos;
                $html = getModal('permisos_modal', $arrPermisosRol);
            }
            die();
        }
        

        public function setPermisos() {
            if ($_POST) {
                $id_rol = intval($_POST['id_rol']);
                $modulo = $_POST['modulos'];

                $this->model->deletePermisos($id_rol);

                foreach ($modulo as $modulo) {
                    $id_modulo = $modulo['id_modulo'];
                    $r = empty($modulo['r']) ? 0 : 1;
                    $w = empty($modulo['w']) ? 0 : 1;
                    $u = empty($modulo['u']) ? 0 : 1;
                    $d = empty($modulo['d']) ? 0 : 1;  
                    $requestPermisos = $this->model->insertPermisos($id_rol, $id_modulo, $r, $w, $u, $d);  
                }

                if ($requestPermisos > 0) {
                    $arrayResult = array('status' => true, 'msg' => 'Asignados exitosamente.');
                } else {
                    $arrayResult = array('status' => false, 'msg' => 'Filed processing!');
                }
                echo json_encode($arrayResult, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>