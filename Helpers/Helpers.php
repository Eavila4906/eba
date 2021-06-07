<?php
    // Mostrar url //
    function BASE_URL() {
        return BASE_URL;
    }

    // Assets kn
    function ASSETS_KN() {
        return ASSETS_KN;
    }
    // Assets Vali
    function ASSETS_VALI() {
        return ASSETS_VALI;
    }
    // Assets
    function MEDIA() {
        return MEDIA;
    }

    //View header
    function header_view($data=""){
        $header = "Views/Templates/header.php";
        require_once($header);
    }

    //View footer
    function footer_view($data=""){
        $footer = "Views/Templates/footer.php";
        require_once($footer);
    }

    /*Validar session admin*/
    //not exists
    function ValidarSesionNotExists(){
        session_start();
        if (empty($_SESSION['Login'])) {
            header('location: '.BASE_URL().'admin');
        }
    }
    //Yes exists
    function ValidarSesionYesExists(){
        session_start();
        if (isset($_SESSION['Login'])) {
            header('location: '.BASE_URL().'dashboard');
        }
    }

    function ValidarSesion(){
        session_start();
        if (empty($_SESSION['Login'])) {
            header('location: '.BASE_URL().'admin');
        }
    }

    //Mostrar modals
    function getModal(String $name_modal, $data){
        $View_modal = "Views/Templates/Modals/{$name_modal}.php";
        require_once($View_modal);
    }
    

    // Generador de password aleatoreo //
    function passGenerator($length = 10) {
        $pass = "";
        $lengthPass = $length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $lengthCadena = strlen($cadena);

        for ($i=1; $i <= $lengthPass; $i++) { 
            $pos = rand(0, $lengthCadena-1);
            $pass .= substr($cadena, $pos, 1);
        }
        return $pass;
    }

    /* Generador de nombre de usuario con 
    su primera letra del nombre, su apellido paterno y sus 4 ultimos digito de la cedula */
    function usernameGenerator(String $nombre, String $apellidoPaterno, String $cedula) {
        $nombre = $nombre;
        $apellidoPaterno = $apellidoPaterno;
        $cedula = $cedula;

        $lengthApellido = strlen($apellidoPaterno);
        $cadena = substr($nombre, 0, 1).substr($apellidoPaterno, 0, $lengthApellido).substr($cedula, 6, 4);
        $username = strtolower($cadena);
        return $username;
    }

    //Limpiar cadena en login para evitar injection sql
    function strClean($cadena) {
        $cadena = str_replace("'", "\'", $cadena);
        return $cadena;
    }

    //Muestra información formateada
	function dep($data)
    {
        $format  = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }
?>