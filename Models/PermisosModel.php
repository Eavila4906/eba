<?php
    class PermisosModel extends Mysql {

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
    }
?>