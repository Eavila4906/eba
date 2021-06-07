<?php
    class Profile extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionNotExists();
        }

        public function Profile(){
            $data['functions_js'] = "./Assets/js/functions_profile.js";
            $this->views->getViews($this,"profile", $data);
        }
    }
    
?>