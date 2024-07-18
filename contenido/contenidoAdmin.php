
<?php

class ContenidoAdmin { 
    public function mostrar_archivo(){ 
        $pagina="";
        $url=isset($_GET["url"])? $_GET["url"]:null;
        $url=explode('/',$url);
        if($url[0]==null){ 
            $pagina = "vistas/Roles/admin/vistas_admin/bienvenido.php";
        }elseif ($url[0]=="bienvenido") {
            $pagina = "vistas/bienvenido.php";
        }
        elseif ($url[0]=="usuarios") {
            $pagina = "vistas/Roles/admin/vistas_admin/usuarios_listar.php";
        }
        elseif ($url[0]=="cerrar") {
            $pagina = "vistas/Roles/admin/vistas_admin/cerrar.php";
        }
        elseif ($url[0]=="Clientes") {
            $pagina = "vistas/Roles/admin/vistas_admin/clientes.php";
        }
        elseif ($url[0]=="categoria") {
            $pagina = "vistas/Roles/admin/vistas_admin/categoria.php";
        }
        elseif ($url[0]=="medidas") {
            $pagina = "vistas/Roles/admin/vistas_admin/medidas.php";
        }
        elseif ($url[0]=="cajas") {
            $pagina = "vistas/Roles/admin/vistas_admin/caja.php";
        }
        elseif ($url[0]=="productos") {
            $pagina = "vistas/Roles/admin/vistas_admin/productos.php";
        }
        elseif ($url[0]=="compra") {
            $pagina = "vistas/Roles/admin/vistas_admin/compras.php";
        }
        elseif ($url[0]=="historialCompras") {
            $pagina = "vistas/Roles/admin/vistas_admin/historial_compras.php";
        }
        elseif ($url[0]=="empresa") {
            $pagina = "vistas/Roles/admin/vistas_admin/empresa.php";
        }
        elseif ($url[0]=="venta") {
            $pagina = "vistas/Roles/admin/vistas_admin/venta.php";
        }
        elseif ($url[0]=="historialVentas") {
            $pagina = "vistas/Roles/admin/vistas_admin/historial_ventas.php";
        }
        elseif ($url[0]=="perfil") {
            $pagina = "vistas/Roles/admin/vistas_admin/perfil.php";
        }
        elseif ($url[0]=="proveedor") {
            $pagina = "vistas/Roles/admin/vistas_admin/proveedor.php";
        }
        elseif ($url[0]=="arqueo") {
            $pagina = "vistas/Roles/admin/vistas_admin/arqueoCaja.php";
        }else {
            // Página no encontrada
            $pagina = "vistas/Roles/admin/vistas_admin/error404.php";
        }
        
        return $pagina;
        
}
} 

?>