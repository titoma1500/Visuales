<?php
class MvcController{
     public function template(){
            include "views/template.php";
        }
    public function enlacesPaginasController()
    {
        // get post
        if(isset($_GET['action']))
        {
            $enlacesController= $_GET['action'];
        }
        else{
            $enlacesController = "inicio.php";
        }
        $respuesta= EnlacesPaginas::enlacesPaginasModel($enlacesController);
        include $respuesta;
    }
}


?>