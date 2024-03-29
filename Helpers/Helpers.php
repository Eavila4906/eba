<?php
    // Mostrar url //
    function BASE_URL() {
        return BASE_URL;
    }

    // Assets kn
    function ASSETS_KN() {
        return BASE_URL.ASSETS_KN;
    }
    // Assets Vali
    function ASSETS_VALI() {
        return BASE_URL.ASSETS_VALI;
    }
    // Assets
    function MEDIA() {
        return BASE_URL.MEDIA;
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

    //Cors
    function Cors() {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
            // whitelist of safe domains
            //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        }
    }

    //Format date leguage
    function FormatDateLeguage() {
        return setlocale(LC_ALL,"es-MX");
    }

    /*Validar session admin*/
    //not exists
    function ValidarSesionNotExists(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['Login'])) {
            header('location: '.BASE_URL());
        }
    }
    //Yes exists
    function ValidarSesionYesExists(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['Login'])) {
            if ($_SESSION['dataUser']['nombreRol'] == 'Super Administrador') {
                header('location: '.BASE_URL().'dashboard');
            } else {
                header('location: '.BASE_URL().'my');
            }
        }
    }

    //Modulos y permisos
    function getPermisos(int $id_modulo){
        require_once("Models/PermisosModel.php");
        $ObjPermisos =new PermisosModel();
        $id_rol = $_SESSION['dataUser']['id_rol'];
        $arrayData = $ObjPermisos->permisosModulos($id_rol);

        $permisos = "";
        $permisosModulo = "";

        if (count($arrayData) > 0) {
            $permisos = $arrayData;
            $permisosModulo = isset($arrayData[$id_modulo]) ? $arrayData[$id_modulo] : "";
        }

        $_SESSION['permisos'] = $permisos;
        $_SESSION['permisosModulo'] = $permisosModulo;
    }

    //Mostrar modals
    function getModal(String $name_modal, $data){
        $View_modal = "Views/Templates/Modals/{$name_modal}.php";
        require_once($View_modal);
    }

    //upload image to server
    function uploadImageServer(array $data, string $name){
        $url_temp = $data['tmp_name'];
        $destino    = 'Assets/images/image-public-site/carousel-image-home/'.$name;        
        $move = move_uploaded_file($url_temp, $destino);
        return $move;
    }

    function uploadProfilePhotoServer(array $data, string $name){
        $url_temp = $data['tmp_name'];
        $destino    = 'Assets/images/image-profiles/'.$name;        
        $move = move_uploaded_file($url_temp, $destino);
        return $move;
    }

    //delete image to server
    function deleteImageServer(String $name_image) {
        unlink('Assets/images/image-public-site/carousel-image-home/'.$name_image);
    }

    function deleteProfilePhotoServer(String $name_image) {
        unlink('Assets/images/image-profiles/'.$name_image);
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

    //Genera un token
    function token()
    {
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }

    //Envio de correos
    function sendEmail($data,$template) {
        $asunto = $data['asunto'];
        $emailDestino = $data['email'];
        $empresa = SENDER_NAME;
        $remitente = SENDER_EMAIL;
        //ENVIO DE CORREO
        $de = "MIME-Version: 1.0\r\n";
        $de .= "Content-type: text/html; charset=UTF-8\r\n";
        $de .= "From: {$empresa} <{$remitente}>\r\n";
        ob_start();
        require_once("Views/Templates/Emails/".$template.".php");
        $mensaje = ob_get_clean();
        $send = mail($emailDestino, $asunto, $mensaje, $de);
        return $send;
    }

    //Calcular rango de fechas
    function calculateRangeDate($initialDate, $endDate, $differenceFormat="%m") {
        $initialDate  = date_create($initialDate);
        $endDate = date_create($endDate);
        $difference = date_diff($initialDate, $endDate);
        $calculation = $difference->format($differenceFormat);
        return $calculation+1;
    }   

    //dia de pago
    function paymentDay($d) {
        $date = strtotime($d);
        $year = date("Y", $date);
        $month = date("m", $date);
        $result = $year.'-'.$month.'-';
        return $result;
    }

    //Elimina exceso de espacios entre palabras
    function strClean2($strCadena){
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
        $string = trim($string); //Elimina espacios en blanco al inicio y al final
        $string = stripslashes($string); // Elimina las \ invertidas
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        return $string;
    }
?>