<?php
    class ProfileModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }       
        
        public function SelectDataUser(int $id_session) {
            $this->id_session = $id_session;
            $Query_Select = "SELECT * FROM usuario WHERE id_usuario = $this->id_session";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function SelectPhotoProfile(int $id_session) {
            $this->id_session = $id_session;
            $Query_Select = "SELECT photo FROM usuario WHERE id_usuario = $this->id_session";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function UpdateProfilePhoto(int $id_userSession, String $photo){
            $this->id_userSession = $id_userSession;
            $this->photo = $photo;
            $Query_Update = "UPDATE usuario SET photo=? WHERE id_usuario = $this->id_userSession";
            $Array_Query = array($this->photo);
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $result;
        }

        public function UpdateDataUser(int $id_user, String $apellidoM, String $email, String $telefono, String $sexo, String $fechaNaci){
            $this->id_user = $id_user;
            $this->apellidoM = $apellidoM;
            $this->email = $email;
            $this->telefono = $telefono;
            $this->sexo = $sexo;
            $this->fechaNaci = $fechaNaci;
            $Query_Update = "UPDATE usuario SET apellidoM=?, email=?, telefono=?, sexo=?, fechaNaci=? WHERE id_usuario = $this->id_user";
            $Array_Query = array($this->apellidoM, $this->email, $this->telefono, $this->sexo, $this->fechaNaci);
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $result;
        }

        public function UpdatePassword(int $id_user, String $currentPassword, String $newPassword){
            $this->id_user = $id_user;
            $this->currentPassword = $currentPassword;
            $this->newPassword = $newPassword;
            $Query_Select = "SELECT password FROM usuario WHERE id_usuario = $this->id_user AND password = '$this->currentPassword'";
            $valiPass = $this->SelectMySQL($Query_Select);
            if (!empty($valiPass)) {
                $Query_Update = "UPDATE usuario SET password=? WHERE id_usuario = $this->id_user";
                $Array_Query = array($this->newPassword);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "noPass";
            }
            return $result;
        }
    }
?>