<?php
    class Site extends Controllers {
        public function __construct(){
            //ValidarSesionYesExists();
            parent::__construct();
        }

        public function Site(){
            $data['page'] = "";
            $this -> views -> getViews($this,"site", $data);
        }
    }
    
?>