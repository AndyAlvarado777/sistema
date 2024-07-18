<?php 
if(isset($_POST["destruir"])){ 
    
    // Opcional: destruir toda la sesión
    session_unset();
    session_destroy();

    // Redirigir después de destruir la sesión
    header("Location:login");
    exit();
}

$configuracion = new ConfiguracionController();
?>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo URL;?>"><?php
                           echo  $configuracion->nombreEmpresa2();
                        ?></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    
                </div>
            </form>
            <!-- Navbar-->
            <form action="" method="post">
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="perfil">Perfil</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" href="cerrar" name="destruir">Cerrar Session</a>
                    </div>
                </li>
            </ul>
            </form>
        </nav>
        <div id="layoutSidenav">
<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-cogs text-primary"></i></div>
                                Administración
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="usuarios">Usuarios</a>
                                    <a class="nav-link" href="empresa">Empresa</a>
                                    <a class="nav-link" href="proveedor">Proveedor</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCaja" aria-expanded="false" aria-controls="collapseCaja">
                                <div class="sb-nav-link-icon"><i class="fas fa-box text-primary"></i></div>
                                Cajas
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseCaja" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="cajas">Cajas</a>
                                    <a class="nav-link" href="arqueo">Arqueo de caja</a>
                                </nav>
                            </div>
                            <a class="nav-link " href="Clientes" >
                                <div class="sb-nav-link-icon"><i class="fas fa-users text-primary"></i></div>
                                Clientes
                            </a>
                            <a class="nav-link " href="categoria" >
                                <div class="sb-nav-link-icon"><i class="fas fa-columns text-primary"></i></div>
                                Categorias
                            </a>
                            <a class="nav-link " href="medidas" >
                                <div class="sb-nav-link-icon"><i class="fas fa-vials text-primary"></i></div>
                                Medidas
                            </a>
                            <a class="nav-link " href="productos" >
                                <div class="sb-nav-link-icon"><i class="fab fa-product-hunt text-primary"></i></div>
                                Productos
                            </a>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEntradas" aria-expanded="false" aria-controls="collapseEntradas">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart mr-2 text-primary"></i></div>
                            Entradas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseEntradas" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="compra"><i class="fas fa-shopping-cart mr-2 text-primary"></i>Nueva Compra</a>
                                <a class="nav-link" href="historialCompras"><i class="fas fa-list mr-2 text-primary"></i> Historial de compras</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSalidas" aria-expanded="false" aria-controls="collapseSalidas">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register text-primary"></i></div>
                            Salidas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseSalidas" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="venta"><i class="fas fa-shopping-cart mr-2 text-primary"></i>Nueva Venta</a>
                                <a class="nav-link" href="historialVentas"><i class="fas fa-list mr-2 text-primary"></i> Historial de Ventas</a>
                            </nav>
                        </div>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">bienvenido:</div>
                        <?php
                           echo  $configuracion->nombreEmpresa2();
                        ?>
                    </div>
                </nav>
            </div>