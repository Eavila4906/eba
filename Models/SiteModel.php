<?php
    class SiteModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }
        
        /* Start home */
        public function SelectAllContentsHome() {
            $Query_Select_All = "SELECT titulo, descripcion, image FROM galeryhome WHERE estado = 1 ORDER BY id_cont DESC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }
        /* Finish home */

        /* Start about */
        public function SelectAllContentsAbout() {
            $Query_Select_All = "SELECT ab.id_cont, ab.titulo, ab.descripcion, ic.nombre AS icono 
                                 FROM about ab INNER JOIN icons ic ON (ab.icon=ic.id_icon) 
                                 WHERE ab.estado = 1 ORDER BY ab.id_cont ASC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }
        /* Finish about */

        /* Start headquarter */
        public function SelectAllContentsHeadquarter() {
            $Query_Select_All = "SELECT ubicacion, longitud, latitud FROM headquarter WHERE estado = 1 ORDER BY id_headquarter ASC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }
        /* Finish headquarter */

        /* Start contacts */
        public function SelectAllContentsContacts() {
            $Query_Select_All = "SELECT telefono, email FROM contacts WHERE estado = 1 ORDER BY id_contacts ASC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }
        /* Finish contacts */

        /* Start social media */
        public function SelectAllContentsSocialMedia() {
            $Query_Select_All = "SELECT sm.nombre,sm.link, ic.nombre AS icono
                                 FROM socialMedia sm INNER JOIN icons ic ON (sm.icono=ic.id_icon) 
                                 WHERE sm.estado = 1 ORDER BY sm.id_socialMedia ASC";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }
        /* Finish social media */
    }
?>