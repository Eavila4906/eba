<?php
    class Logout {
        public function __construct() {
            if(!isset($_SESSION)) { 
                session_start(); 
            }
            $session = $_SESSION['dataUser']['nombreRol'];
            if ($session != "Super Administrador") {
                if(!isset($_SESSION)) { 
                    session_start(); 
                }
                session_unset();
                session_destroy();
                header('location: '.BASE_URL());
            } else {
                if(!isset($_SESSION)) { 
                    session_start(); 
                }
                session_unset();
                session_destroy();
                header('location: '.BASE_URL().'admin');
            }
            
        }
    }
?>