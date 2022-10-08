<?php
    class RolesModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllRoles() {
            $Query_Select_All = "SELECT * FROM roles WHERE estadoRol != 0 ORDER BY id_rol DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function InsertRol(String $NombreRol, String $descripcionRol, int $estadoRol) {
            $this->nombreRol = $NombreRol;
            $this->descripcionRol = $descripcionRol;
            $this->estadoRol = $estadoRol;

            $Query_Select_All = "SELECT * FROM roles WHERE nombreRol = '$this->nombreRol' AND estadoRol != 0 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO roles (nombreRol, descripRol, estadoRol) VALUES (?, ?, ?)";
                $Array_Query = array($this->nombreRol, $this->descripcionRol, $this->estadoRol);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateRol(int $id_rol, String $NombreRol, String $descripcionRol, int $estadoRol) {
            $this->id_rol = $id_rol;
            $this->nombreRol = $NombreRol;
            $this->descripcionRol = $descripcionRol;
            $this->estadoRol = $estadoRol;

            $Query_Select_All = "SELECT * FROM roles WHERE nombreRol = '$this->nombreRol' AND id_rol != $this->id_rol AND estadoRol != 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE roles SET nombreRol=?, descripRol=?, estadoRol=? WHERE id_rol = $this->id_rol";
                $Array_Query = array($this->nombreRol, $this->descripcionRol, $this->estadoRol);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function SelectRol(int $id_rol) {
            $this->id_rol = $id_rol;
            $Query_Select = "SELECT * FROM roles WHERE id_rol = $this->id_rol";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function DeleteRol(int $id_rol) {
            $this->id_rol = $id_rol;
            $this->Delete = 0;

            $Query_Select_All = "SELECT * FROM usuario WHERE rol = $this->id_rol";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE roles SET estadoRol=? WHERE id_rol = $this->id_rol";
                $Array_Query = array($this->Delete);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
                if ($result) {
                    $result = "ok";
                } else {
                    $result = "Error";
                }
            } else {
                $result = "Exists";
            }
            return $result;
        }
    }
?>