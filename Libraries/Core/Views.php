<?php
    class Views {
        public function getViews($controllers, $view, $data=" "){
            $controllers = get_class($controllers);
            if ($controllers == "Site") {
                $view = VIEWS.$view.".php";
            } else {
                $view = VIEWS.$controllers."/".$view.".php";
            }
            require_once($view);
        }

    }
?>