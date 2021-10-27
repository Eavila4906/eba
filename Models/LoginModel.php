<?php
    class LoginModel extends MySQL {
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

        public function getUserEmail(String $emailRP) {
            $this->EmailRP = $emailRP;
            $Query_Select = "SELECT id_usuario, nombres, apellidoP, apellidoM, estado 
                                FROM usuario WHERE email = '$this->EmailRP' AND estado = 1";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function setTokenUser(int $id_usuario, string $token){
			$this->Id_usuario = $id_usuario;
			$this->Token = $token;
			$Query_Update = "UPDATE usuario SET token=? WHERE id_usuario = $this->Id_usuario";
            $Array_Query = array($this->Token);
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $result;
		}

        public function getUser(String $email, String $token) {
            $this->email = $email;
            $this->token = $token;
            $Query_Select = "SELECT id_usuario FROM usuario WHERE email = '$this->email' AND token = '$this->token' AND estado = 1";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function updatePassword(int $id_usuario, String $password) {
            $this->id_usuario = $id_usuario;
            $this->password = $password;    
            $Query_Update = "UPDATE usuario SET password=?, token=? WHERE id_usuario = $this->id_usuario";
            $Array_Query = array($this->password, "");
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $result;
        }
    }
?>