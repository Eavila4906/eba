<?php
    class AdminModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectSuperAdmin(String $username, String $password) {
            $this->strUsername = $username;
            $this->strPassword = $password;

            $Query_Select = "SELECT u.id_usuario, r.nombreRol, u.estado 
                                FROM usuario u INNER JOIN roles r 
                                ON (u.rol=r.id_rol)
                                WHERE (u.username = '$this->strUsername' OR u.email = '$this->strUsername') 
                                    AND  u.password = '$this->strPassword' AND u.estado != 0
                                ";
            
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SessionLogin(int $varSession) {
            $this->intVarSession = $varSession;

            $Query_Select = "SELECT u.id_usuario, u.username, u.nombres, 
                            u.apellidoP, u.apellidoM, u.email, u.telefono, u.sexo,
                            u.fechaNaci, r.nombreRol, u.estado
                            FROM usuario u INNER JOIN roles r 
                            ON (u.rol=r.id_rol)
                            WHERE u.id_usuario = $this->intVarSession";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }
    }
?>