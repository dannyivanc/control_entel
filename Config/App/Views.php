<?php
class Views{
    public function getView($controlador,$vista,$data=""){
        $controlador= get_class($controlador);
        if($controlador=="Home"){
            $vista= "Views/".$vista. ".php";
        }else{
            $vista="Views/".$controlador."/".$vista. ".php";
        }
        require $vista;
    }
    // public function getViewFromController($controllerName, $vista, $data="") {
    //     $vista = "Views/" . $controllerName . "/" . $vista . ".php";
    //     require $vista;
    // }
}
?>