<?php
    require_once("Config/Config.php");
    require_once("Helpers/Helpers.php");

    $url = !empty($_GET['url']) ? $_GET['url'] : 'Site/Site';

    $arrayUrl = explode("/", $url);

    $controller = $arrayUrl[0];
    $method = $arrayUrl[0];
    $parameter = "";

    if (!empty($arrayUrl[1])) {
        if ($arrayUrl[1] != "") {
            $method = $arrayUrl[1];
        }
    }

    if (!empty($arrayUrl[2])) {
        if ($arrayUrl[2] != "") {
            for ($i=2; $i < count($arrayUrl); $i++) { 
                $parameter .= $arrayUrl[$i].',';
            }
            $parameter = trim($parameter, ',');
        }
    }

    require_once(LIBS."Core/Autoload.php");
    require_once(LIBS."Core/Load.php");
    
?>