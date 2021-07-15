<?php
    class Logout {
        public function __construct() {
            session_start();
            $session = $_SESSION['dataUser']['nombreRol'];
            if ($session != "Super Administrador") {
                session_start();
                session_unset();
                session_destroy();
                header('location: '.BASE_URL());
            } else {
                session_start();
                session_unset();
                session_destroy();
                header('location: '.BASE_URL().'admin');
            }
            
        }
    }
?>