<?php
    class DashboardModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        public function selectCountUsers() {
            $Query_Select = "SELECT COUNT(id_usuario) AS countUsers 
                            FROM usuario 
                            WHERE estado != 0
                            ";
            
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function selectCountCourses() {
            $Query_Select = "SELECT COUNT(id_curso) AS countCourses
                            FROM curso 
                            WHERE estado != 0
                            ";
            
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function selectCountStudens() {
            $Query_Select = "SELECT COUNT(u.id_usuario) AS countStudens 
                            FROM usuario u INNER JOIN roles r 
                            ON (u.rol=r.id_rol) 
                            WHERE r.nombreRol = 'Estudiante' AND u.estado != 0
                            ";
            
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function selectCountTeachers() {
            $Query_Select = "SELECT COUNT(u.id_usuario) AS countTeachers
                            FROM usuario u INNER JOIN roles r 
                            ON (u.rol=r.id_rol) 
                            WHERE r.nombreRol = 'Docente' AND u.estado != 0
                            ";
            
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function selectCountAccounting() {
            $Query_Select = "SELECT COUNT(id_accounting) AS countAccounting
                            FROM accounting WHERE estado != 0
                            ";
            
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }
        
    }
?>