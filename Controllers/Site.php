<?php
    class Site extends Controllers {
        public function __construct(){
            parent::__construct();
            ValidarSesionYesExists(); 
        }

        public function Site(){
            $data['page'] = "";
            $this -> views -> getViews($this,"site", $data);
        }

        /* Start home */
        public function getAllContentsHome() {
			$arrayData = $this->model->SelectAllContentsHome();
            return $arrayData;
			die();
        }
        /* Finish home */

        /* Start about */
        public function getAllContentsAbout() {
			$arrayData = $this->model->SelectAllContentsAbout();
            return $arrayData;
			die();
        }
        /* Finish about */

        /* Start headquarter */
        public function getAllContentsHeadquarter() {
			$arrayData = $this->model->SelectAllContentsHeadquarter();
            return $arrayData;
			die();
        }
        /* Finish headquarter */

        /* Start contacts */
        public function getAllContentsContacts() {
			$arrayData = $this->model->SelectAllContentsContacts();
            return $arrayData;
			die();
        }
        /* Finish contacts */

        /* Start social media */
        public function getAllContentsSocialMedia() {
			$arrayData = $this->model->SelectAllContentsSocialMedia();
            return $arrayData;
			die();
        }
        /* Finish social media */
    }
    
?>