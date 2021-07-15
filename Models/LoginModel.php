<?php
    class LoginModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectUserLogin(String $username, String $password) {
            $this->Username = $username;
            $this->Password = $password;

            $Query_Select = "SELECT u.id_usuario, r.nombreRol, u.estado 
                                FROM usuario u INNER JOIN roles r 
                                ON (u.rol=r.id_rol)
                                WHERE (u.username = '$this->Username' OR u.email = '$this->Username') 
                                AND  u.password = '$this->Password' AND u.estado != 0
                            ";
            
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SessionLogin(int $varSession) {
            $this->intVarSession = $varSession;

            $Query_Select = "SELECT u.id_usuario, DNI, u.username, u.nombres, 
                            u.apellidoP, u.apellidoM, u.email, u.telefono, u.sexo,
                            u.fechaNaci, r.id_rol, r.nombreRol, u.estado, u.photo
                            FROM usuario u INNER JOIN roles r 
                            ON (u.rol=r.id_rol)
                            WHERE u.id_usuario = $this->intVarSession";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }
    }
?>