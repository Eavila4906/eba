<?php
    class PermisosModel extends MySQL {

        public function __construct(){
            parent::__construct();
        }

        public function SelectModulos() {
            $Query_Select_All = "SELECT * FROM modulo WHERE estadoModulo != 0";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectPermisos(int $id_rol) {
            $this->id_rol = $id_rol;
            $Query_Select_All = "SELECT * FROM permisos WHERE rol = $this->id_rol";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function deletePermisos(int $id_rol) {
            $this->id_rol = $id_rol;
            $Query_delete = "DELETE FROM permisos WHERE rol = $this->id_rol";
            $result = $this->DeleteMySQL($Query_delete);
            return $result;
        }

        public function insertPermisos(int $id_rol, int $modulo, int $r, int $w, int $u, int $d) {
            $this->id_rol = $id_rol; 
            $this->modulo = $modulo; 
            $this->r = $r; 
            $this->w = $w; 
            $this->u = $u; 
            $this->d = $d;
           
            $Query_Insert = "INSERT INTO permisos (rol, modulo, r, w, u, d) VALUES (?, ?, ?, ?, ?, ?)";
            $Array_Query = array($this->id_rol, $this->modulo, $this->r, $this->w, $this->u, $this->d);
            $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            return $result;
        }

        public function permisosModulos(int $id_rol){
            $this->id_rol = $id_rol;

            $Query_Select = "SELECT p.rol, p.modulo, m.nombreModulo, p.r, p.w, p.u, p.d
                            FROM permisos p INNER JOIN modulo m 
                            ON (p.modulo=m.id_modulo)
                            WHERE p.rol = $this->id_rol";
            $result = $this->SelectAllMySQL($Query_Select);

            $arrayPermisos = array();
            for ($i=0; $i < count($result); $i++) { 
                $arrayPermisos[$result[$i]['modulo']] = $result[$i];
            }
            return $arrayPermisos;
        }
    }
?>