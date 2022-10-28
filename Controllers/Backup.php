<?php
    class Backup extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(11);
        }

        public function Backup(){
            $data['functions_js'] = "./Assets/js/functions_backup.js";
            $data['name_page'] = "Backup";
            $this->views->getViews($this,"backup", $data);
        }
    }
?>