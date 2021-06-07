<?php
    class UsersModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllUsers() {
            $Query_Select_All = "SELECT u.id_usuario, u.DNI, CONCAT(u.nombres, ' ', u.apellidoP, ' ', u.apellidoM) AS nombres,
                                u.username, r.nombreRol, u.estado
                                FROM usuario u INNER JOIN roles r
                                ON (u.rol=r.id_rol)
                                WHERE u.estado != 0 AND r.nombreRol != 'Super Administrador' ORDER BY u.id_usuario DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllRoles() {
            $Query_Select_All = "SELECT id_rol, nombreRol FROM roles WHERE estadoRol != 0 AND estadoRol != 2 AND nombreRol != 'Super Administrador' ORDER BY id_rol DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectInfoUser(int $id_user) {
            $this->id_user = $id_user;
            $Query_Select = "SELECT u.id_usuario, u.username, u.password, u.DNI AS ced, u.nombres, u.apellidoP, u.apellidoM,
                                CONCAT(u.nombres, ' ', u.apellidoP, ' ', u.apellidoM) AS nombresApellidos,
                                u.email, u.telefono, u.fechaNaci, u.sexo, r.id_rol, r.nombreRol, u.estado, u.photo
                                FROM usuario u INNER JOIN roles r
                                ON (u.rol=r.id_rol)
                                WHERE u.id_usuario = $this->id_user";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertUser(String $InputCedulaPasaporte, String $InputUsername, String $InputPassword, String $InputNombres, String $InputApellidoP, String $InputApellidoM, String $InputEmail, String $InputTelefono, String $InputfechaNaci, String $InputSexo, int $InputTipoRol, int $InputEstado, String $InputPhoto) {
            
            $this->InputCedulaPasaporte = $InputCedulaPasaporte;
            $this->InputUsername = $InputUsername;
            $this->InputPassword = $InputPassword;
            $this->InputNombres = $InputNombres;
            $this->InputApellidoP = $InputApellidoP;
            $this->InputApellidoM = $InputApellidoM;
            $this->InputEmail = $InputEmail;
            $this->InputTelefono = $InputTelefono;
            $this->InputfechaNaci = $InputfechaNaci;
            $this->InputSexo = $InputSexo;
            $this->InputTipoRol = $InputTipoRol;
            $this->InputEstado = $InputEstado;
            $this->InputPhoto = $InputPhoto;

            $Query_Select_All_Ced = "SELECT * FROM usuario WHERE DNI = '$this->InputCedulaPasaporte' AND estado != 0 ";
            $result_Select_All_Ced = $this->SelectAllMySQL($Query_Select_All_Ced);

            $Query_Select_All_Email = "SELECT * FROM usuario WHERE email = '$this->InputEmail' AND estado != 0 ";
            $result_Select_All_Email = $this->SelectAllMySQL($Query_Select_All_Email);

            if (!empty($result_Select_All_Ced)) {
                $result = "ExistsCed";
            } elseif (!empty($result_Select_All_Email)) {
                $result = "ExistsEmail";
            } else {
                $Query_Insert = "INSERT INTO usuario (DNI, username, password, nombres, apellidoP, apellidoM, email, telefono, sexo, fechaNaci, rol, estado, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $Array_Query = array($this->InputCedulaPasaporte, $this->InputUsername, $this->InputPassword, $this->InputNombres, $this->InputApellidoP, $this->InputApellidoM, $this->InputEmail, $this->InputTelefono, $this->InputSexo, $this->InputfechaNaci, $this->InputTipoRol, $this->InputEstado, $this->InputPhoto);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);  
            }
            return $result;
        }

        public function UpdateUser(int $id_usuario, String $InputPassword, String $InputTelefono, String $InputfechaNaci, String $InputSexo, int $InputTipoRol, int $InputEstado) {
            $this->Id_usuario = $id_usuario;
            $this->InputPassword = $InputPassword;
            $this->InputTelefono = $InputTelefono;
            $this->InputfechaNaci = $InputfechaNaci;
            $this->InputSexo = $InputSexo;
            $this->InputTipoRol = $InputTipoRol;
            $this->InputEstado = $InputEstado; 

            $Query_Select_password = "SELECT password FROM usuario WHERE id_usuario = $this->Id_usuario";
            $result_Select_password = $this->SelectMySQL($Query_Select_password);

            if (empty($this->InputPassword)) {
                $Query_Update = "UPDATE usuario SET telefono=?, sexo=?, fechaNaci=?, rol=?, estado=? WHERE id_usuario = $this->Id_usuario";
                $Array_Query = array($this->InputTelefono, $this->InputSexo, $this->InputfechaNaci, $this->InputTipoRol, $this->InputEstado);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $password = hash("SHA256", $this->InputPassword);
                $Query_Update = "UPDATE usuario SET password=?, telefono=?, sexo=?, fechaNaci=?, rol=?, estado=? WHERE id_usuario = $this->Id_usuario";
                $Array_Query = array($password, $this->InputTelefono, $this->InputSexo, $this->InputfechaNaci, $this->InputTipoRol, $this->InputEstado);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            }
            return $result;
        }
        
        public function DeleteUser(int $id_usuario) {
            $this->id_usuario = $id_usuario;
            $this->Delete = 0;

            $Query_Update = "UPDATE usuario SET estado=? WHERE id_usuario = $this->id_usuario";
            $Array_Query = array($this->Delete);
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);

            if ($result) {
                $result = "ok";
            } else {
                $result = "Error";
            }
            return $result;
        }
        
    }
?>