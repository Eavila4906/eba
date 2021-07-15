<?php
    class My extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
            getPermisos(1);
        }

        public function My(){
            $data['functions_js'] = "./Assets/js/functions_my.js";
            $data['name_page'] = "Area personal";
            $this->views->getViews($this,"my", $data);
        }
    }
    
?>