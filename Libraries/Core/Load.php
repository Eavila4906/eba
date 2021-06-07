<?php
    require_once("Config/Config.php");
    $controller = ucwords($controller);
    $controllerFile = CONTR.$controller.".php";
    if (file_exists($controllerFile)) {
        require_once(CONTR.$controller.".php");
        $controller = new $controller();
        if (method_exists($controller, $method)) {
            $controller -> {$method}($parameter);
        } else {
            require_once("Controllers/Errors.php");
        }
    } else {
        require_once("Controllers/Errors.php");
    }
?>