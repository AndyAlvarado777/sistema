
<?php
session_start();
    if (!defined('URL')) define('URL', 'http://localhost/VENTA2/');
        require_once("contenido/contenido.php");
        require_once("contenido/contenidoAdmin.php");
        require_once("controladores/usuarios_controller.php");
        require_once("controladores/clientes_controller.php");
        require_once("controladores/categoria_controller.php");
        require_once("controladores/medidas_controller.php");
        require_once("controladores/caja_controller.php");
        require_once("controladores/productos_controller.php");
        require_once("controladores/compra_controller.php");
        require_once("controladores/detalleCompra_Controler.php");
        require_once("controladores/configuracion.php");
        require_once("controladores/ventas_controller.php");
        require_once("controladores/cierre_caja_Controller.php");
        require_once("controladores/proveedores_controller.php");


        require_once("modelos/Usuario.php");
        require_once("modelos/categorias.php");
        require_once("modelos/clientes.php");
       require_once("modelos/medidas.php");
       require_once("modelos/caja.php");
       require_once("modelos/producto.php");
       require_once("modelos/detalle_compras.php");
       require_once("modelos/compra.php");
       require_once("modelos/detalle.php");
       require_once("modelos/configuracion.php");
       require_once("modelos/ventas.php");
       require_once("modelos/detalle_venta.php");
       require_once("modelos/detalle_temp.php");
       require_once("modelos/cierre_caja.php");
       require_once("modelos/proveedores.php");

        //require_once("vistas/templates/login.php");
        if(isset($_SESSION["EstadoUsuario"])){
            if($_SESSION["EstadoUsuario"] == "1") {
                if($_SESSION["usuario"][4] == "1"){
                    require_once("vistas/Roles/admin/index.php");
                } else if($_SESSION["usuario"][4] == "0"){
                    require_once("vistas/Roles/user/index.php");
                }
                // Asegúrate de que no haya nada más después de las inclusiones
                exit();
            }
        } else {
            require_once("vistas/templates/login.php");
        }
        
?>