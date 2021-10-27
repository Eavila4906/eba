<?php
    require_once("Config/Config.php");
    require_once("Helpers/Helpers.php");
    class RegistrarseModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        // Generador de password aleatoreo //
        function passGenerator($length = 10) {
            $pass = "";
            $lengthPass = $length;
            $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $lengthCadena = strlen($cadena);

            for ($i=1; $i <= $lengthPass; $i++) { 
                $pos = rand(0, $lengthCadena-1);
                $pass .= substr($cadena, $pos, 1);
            }
            return $pass;
        }

        /* Generador de nombre de usuario con 
        su primera letra del nombre, su apellido paterno y sus 4 ultimos digito de la cedula */
        function usernameGenerator(String $nombre, String $apellidoPaterno, String $cedula) {
            $nombre = $nombre;
            $apellidoPaterno = $apellidoPaterno;
            $cedula = $cedula;

            $lengthApellido = strlen($apellidoPaterno);
            $cadena = substr($nombre, 0, 1).substr($apellidoPaterno, 0, $lengthApellido).substr($cedula, 6, 4);
            $username = strtolower($cadena);
            return $username;
        }

        public function setUsers(String $nombres, String $apellidoP, String $apellidoM, String $cedula, String $telefono, String $email) {   
            $strQuery = "INSERT INTO usuarios (cedula, nombres, apellidop, apellidom, telefono, email, username, password)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        
            // generador de username //
            $username = $this->usernameGenerator($nombres, $apellidoP, $cedula);
            // generador de password //
            $password = $this->passGenerator();

            $arrayDatas = array($cedula, $nombres, $apellidoP, $apellidoM, $telefono, $email, $username, $password);

            $request_insert = $this->InsertMySQL($strQuery, $arrayDatas);
            return $request_insert;
        }
    }
?>