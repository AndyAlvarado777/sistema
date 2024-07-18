
<?php

class Contenido { 
    public function mostrar_archivo(){ 
        $pagina="";
        $url=isset($_GET["url"])? $_GET["url"]:null;
        $url=explode('/',$url);
        if($url[0]==null){ 
            $pagina = "vistas/Roles/user/vistas_admin/bienvenido.php";
        }elseif ($url[0]=="bienvenido") {
            $pagina = "vistas/bienvenido.php";
        }
        
        elseif ($url[0]=="cerrar") {
            $pagina = "vistas/Roles/user/vistas_admin/cerrar.php";
        }
        elseif ($url[0]=="Clientes") {
            $pagina = "vistas/Roles/user/vistas_admin/clientes.php";
        }
        elseif ($url[0]=="categoria") {
            $pagina = "vistas/Roles/user/vistas_admin/categoria.php";
        }
        elseif ($url[0]=="medidas") {
            $pagina = "vistas/Roles/user/vistas_admin/medidas.php";
        }
        elseif ($url[0]=="cajas") {
            $pagina = "vistas/Roles/user/vistas_admin/caja.php";
        }
        elseif ($url[0]=="productos") {
            $pagina = "vistas/Roles/user/vistas_admin/productos.php";
        }
       
        elseif ($url[0]=="venta") {
            $pagina = "vistas/Roles/user/vistas_admin/venta.php";
        }
        elseif ($url[0]=="historialVentas") {
            $pagina = "vistas/Roles/user/vistas_admin/historial_ventas.php";
        }
        elseif ($url[0]=="perfil") {
            $pagina = "vistas/Roles/user/vistas_admin/perfil.php";
        }
        elseif ($url[0]=="arqueo") {
            $pagina = "vistas/Roles/user/vistas_admin/arqueoCaja.php";
        }
        else {
            // Página no encontrada
            $pagina = "vistas/Roles/user/vistas_admin/error404.php";
        }
        
        
        
        return $pagina;
        
}
} 

?>