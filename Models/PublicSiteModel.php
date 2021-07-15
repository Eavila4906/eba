<?php
    class PublicSiteModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }
        /* Start home */
        public function SelectAllContentGaleryHome() {
            $Query_Select_All = "SELECT * FROM galeryHome WHERE estado != 0 ORDER BY id_cont DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectContents(int $id_cont) {
            $this->id_cont = $id_cont;
            $Query_Select = "SELECT * FROM galeryhome WHERE id_cont = $this->id_cont";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertContentGaleryHome(String $titulo, String $descripcion, int $estado, String $image) {
            $this->Titulo = $titulo;
            $this->Descripcion = $descripcion;
            $this->Estado = $estado;
            $this->Image = $image;
            $this->fecha = date('Y-m-d');
            

            $Query_Select_All = "SELECT * FROM galeryhome WHERE titulo = '$this->Titulo'  AND estado != 0 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO galeryhome (titulo, descripcion, image, fechaIU, estado) VALUES (?, ?, ?, ?, ?)";
                $Array_Query = array($this->Titulo, $this->Descripcion, $this->Image, $this->fecha, $this->Estado);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateContentGaleryHome(int $id_cont, String $titulo, String $descripcion, int $estado, String $image){
            $this->Id_cont = $id_cont;
            $this->Titulo = $titulo;
            $this->Descripcion = $descripcion;
            $this->Estado = $estado;
            $this->Image = $image;
            $this->fecha = date('Y-m-d');

            $Query_Select_All = "SELECT * FROM galeryhome WHERE titulo = '$this->Titulo' AND id_cont != $this->Id_cont AND estado != 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE galeryhome SET titulo=?, descripcion=?, image=?, fechaIU=?, estado=? WHERE id_cont = $this->Id_cont";
                $Array_Query = array($this->Titulo, $this->Descripcion, $this->Image, $this->fecha, $this->Estado);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }
        
        public function DeleteContents(int $id_cont) {
            $this->Id_cont = $id_cont;
            $Query_Delete = "DELETE FROM galeryhome WHERE id_cont = $this->Id_cont";
            $result = $this->DeleteMySQL($Query_Delete);
            if ($result > 0) {
                $result = "ok";
            } else {
                $result = "Error";
            }
            return $result;
        }
        /* Finish home */

        /* Start icons */
        public function SelectAllIconsAbout() {
            $Query_Select_All = "SELECT * FROM icons WHERE utilidad = 1 ORDER BY nombre DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectAllIconsSocialMedia() {
            $Query_Select_All = "SELECT * FROM icons WHERE utilidad = 2 ORDER BY nombre DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function InsertIcons(String $codigo, String $nombre, int $utilidad) {
            $this->Codigo = $codigo;
            $this->Nombre = $nombre;
            $this->Utilidad = $utilidad;

            $Query_Select_All = "SELECT * FROM icons WHERE codigo = '$this->Codigo' OR nombre = '$this->Nombre' ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO icons (codigo, nombre, utilidad) VALUES (?, ?, ?)";
                $Array_Query = array($this->Codigo, $this->Nombre, $this->Utilidad);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }
        /* Finish icons */

        /* Start about */
        public function SelectAllContentAbout() {
            $Query_Select_All = "SELECT * FROM about WHERE estado != 0 ORDER BY id_cont DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectContentsAbout(int $id_contAbout) {
            $this->id_contAbout = $id_contAbout;
            $Query_Select = "SELECT * FROM about WHERE id_cont = $this->id_contAbout";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertContentAbout(String $tituloAbout, String $descripcionAbout, String $icono, int $estadoAbout) {
            $this->TituloAbout = $tituloAbout;
            $this->DescripcionAbout = $descripcionAbout;
            //$this->FechaC = date('Y-m-d H:m:s');
            $this->Icono = $icono;
            $this->EstadoAbout = $estadoAbout;
            
            $Query_Select_All = "SELECT * FROM about WHERE titulo = '$this->TituloAbout'  AND estado != 0 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO about (titulo, descripcion, fechaC, icon, estado) VALUES (?, ?, current_timestamp(), ?, ?)";
                $Array_Query = array($this->TituloAbout, $this->DescripcionAbout, $this->Icono, $this->EstadoAbout);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateContentAbout(int $id_contAbout, String $tituloAbout, String $descripcionAbout, String $icono, int $estadoAbout){
            $this->Id_contAbout = $id_contAbout;
            $this->TituloAbout = $tituloAbout;
            $this->DescripcionAbout = $descripcionAbout;
            //$this->fechaA = date('Y-m-d H:m:s');
            $this->Icono = $icono;
            $this->EstadoAbout = $estadoAbout;
 
            $Query_Select_All = "SELECT * FROM about WHERE titulo = '$this->TituloAbout' AND id_cont != $this->Id_contAbout AND estado != 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE about SET titulo=?, descripcion=?, fechaA=current_timestamp(), icon=?, estado=? WHERE id_cont = $this->Id_contAbout";
                $Array_Query = array($this->TituloAbout, $this->DescripcionAbout, $this->Icono, $this->EstadoAbout);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function DeleteContentsAbout(int $id_contAbout) {
            $this->Id_contAbout = $id_contAbout;
            $Query_Delete = "DELETE FROM about WHERE id_cont = $this->Id_contAbout";
            $result = $this->DeleteMySQL($Query_Delete);
            if ($result > 0) {
                $result = "ok";
            } else {
                $result = "Error";
            }
            return $result;
        }
        /* Finish about */

        /* Start headquarter */
        public function SelectAllHeadquarter() {
            $Query_Select_All = "SELECT * FROM headquarter WHERE estado != 0 ORDER BY id_headquarter DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectHeadquarter(int $id_headquarter) {
            $this->id_headquarter = $id_headquarter;
            $Query_Select = "SELECT * FROM headquarter WHERE id_headquarter = $this->id_headquarter";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertHeadquarter(String $ubicacion, String $longitud, String $latitud, int $estadoH) {
            $this->Ubicacion = $ubicacion;
            $this->Longitud = $longitud;
            $this->Latitud = $latitud;
            //$this->FechaC = date('Y-m-d H:m:s');
            $this->EstadoH = $estadoH;
            
            $Query_Select_All = "SELECT * FROM headquarter WHERE Ubicacion = '$this->Ubicacion'   AND estado != 0 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO headquarter (ubicacion, longitud, latitud, fechaC, estado) VALUES (?, ?, ?, current_timestamp(), ?)";
                $Array_Query = array($this->Ubicacion, $this->Longitud, $this->Latitud, $this->EstadoH);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateHeadquarter(int $id_headquarter, String $ubicacion, String $longitud, String $latitud, int $estadoH){
            $this->Id_headquarter = $id_headquarter;
            $this->Ubicacion = $ubicacion;
            $this->Longitud = $longitud;
            $this->Latitud = $latitud;
            //$this->FechaA = date('Y-m-d H:m:s');
            $this->EstadoH = $estadoH;

            $Query_Select_All = "SELECT * FROM headquarter WHERE ubicacion = '$this->Ubicacion' AND id_headquarter != $this->Id_headquarter AND estado != 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE headquarter SET ubicacion=?, longitud=?, latitud=?, FechaA=current_timestamp(), estado=? WHERE id_headquarter = $this->Id_headquarter";
                $Array_Query = array($this->Ubicacion, $this->Longitud, $this->Latitud, $this->EstadoH);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function DeleteHeadquarter(int $id_headquarter) {
            $this->Id_headquarter = $id_headquarter;
            $Query_Delete = "DELETE FROM headquarter WHERE id_headquarter = $this->Id_headquarter";
            $result = $this->DeleteMySQL($Query_Delete);
            if ($result > 0) {
                $result = "ok";
            } else {
                $result = "Error";
            }
            return $result;
        }
        /* Finish headquarter */

        /* Start contacts */
        public function SelectAllContacts() {
            $Query_Select_All = "SELECT * FROM contacts WHERE estado != 0 ORDER BY id_contacts DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectContacts(int $id_contacts) {
            $this->id_contacts = $id_contacts;
            $Query_Select = "SELECT * FROM contacts WHERE id_contacts = $this->id_contacts";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertContacts(String $telefono, String $email, int $estadoC) {
            $this->Telefono = $telefono;
            $this->Email = $email;
            //$this->FechaC = date('Y-m-d H:m:s');
            $this->Estado = $estadoC;
            
            $Query_Select_All = "SELECT * FROM contacts WHERE (telefono = '$this->Telefono' OR email = '$this->Email') AND estado != 0 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO contacts (telefono, email, fechaC, estado) VALUES (?, ?, current_timestamp(), ?)";
                $Array_Query = array($this->Telefono, $this->Email, $this->Estado);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateContacts(int $id_contacts, String $telefono, String $email, int $estadoC){
            $this->Id_contacts = $id_contacts;
            $this->Telefono = $telefono;
            $this->Email = $email;
            //$this->FechaA = date('Y-m-d H:m:s');
            $this->Estado = $estadoC;

            $Query_Select_All = "SELECT * FROM contacts WHERE (telefono = '$this->Telefono' OR email = '$this->Email') AND id_contacts != $this->Id_contacts AND estado != 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE contacts SET telefono=?, email=?, FechaA=current_timestamp(), estado=? WHERE id_contacts = $this->Id_contacts";
                $Array_Query = array($this->Telefono, $this->Email, $this->Estado);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function DeleteContacts(int $id_contacts) {
            $this->Id_contacts = $id_contacts;
            $Query_Delete = "DELETE FROM contacts WHERE id_contacts = $this->Id_contacts";
            $result = $this->DeleteMySQL($Query_Delete);
            if ($result > 0) {
                $result = "ok";
            } else {
                $result = "Error";
            }
            return $result;
        }
        /* Finish contacts */

        /* Start social media */
        public function SelectAllSocialMedia(){
            $Query_Select_All = "SELECT * FROM socialmedia WHERE estado != 0 ORDER BY id_socialMedia DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectSocialMedia(int $id_socialMedia) {
            $this->id_socialMedia = $id_socialMedia;
            $Query_Select = "SELECT * FROM socialmedia WHERE id_socialMedia = $this->id_socialMedia";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertSocialMedia(String $NombreRS, String $LinkRS, int $IconoRS, int $EstadoRS) {
            $this->NombreRS = $NombreRS;
            $this->LinkRS = $LinkRS;
            $this->IconoRS = $IconoRS;
            //$this->FechaC = date('Y-m-d H:m:s');
            $this->EstadoRS = $EstadoRS;
            
            $Query_Select_All = "SELECT * FROM socialmedia WHERE (nombre = '$this->NombreRS' OR link = '$this->LinkRS') AND estado != 0 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO socialmedia (nombre, link, icono, fechaC, estado) VALUES (?, ?, ?, current_timestamp(), ?)";
                $Array_Query = array($this->NombreRS, $this->LinkRS, $this->IconoRS, $this->EstadoRS);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateSocialMedia(int $id_socialMedia, String $NombreRS, String $LinkRS, int $IconoRS, int $EstadoRS){
            $this->id_socialMedia = $id_socialMedia;
            $this->NombreRS = $NombreRS;
            $this->LinkRS = $LinkRS;
            $this->IconoRS = $IconoRS;
            $this->FechaA = date('Y-m-d H:m:s');
            $this->EstadoRS = $EstadoRS;

            $Query_Select_All = "SELECT * FROM socialmedia WHERE (nombre = '$this->NombreRS' OR link = '$this->LinkRS') AND id_socialMedia != $this->id_socialMedia AND estado != 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE socialmedia SET nombre=?, link=?, icono=?, FechaA=current_timestamp(), estado=? WHERE id_socialMedia = $this->id_socialMedia";
                $Array_Query = array($this->NombreRS, $this->LinkRS, $this->IconoRS, $this->EstadoRS);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function DeleteSocialMedia(int $id_socialMedia) {
            $this->Id_socialMedia = $id_socialMedia;
            $Query_Delete = "DELETE FROM socialmedia WHERE id_socialMedia = $this->Id_socialMedia";
            $result = $this->DeleteMySQL($Query_Delete);
            if ($result > 0) {
                $result = "ok";
            } else {
                $result = "Error";
            }
            return $result;
        }
        /* Finish social media */

    }
?>