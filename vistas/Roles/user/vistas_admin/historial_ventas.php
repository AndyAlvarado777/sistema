<?php
$ventasController = new VentasController();

if (isset($_POST["anular_Venta"])) {
    $id = $_POST["anular_Venta"];
    $ventasController->AnularVenta($id);
}

if (isset($_POST["activar_compra"])) {
    $id = $_POST["activar_compra"];
    
    
    $ventasController->activar($id);
}

if (isset($_POST["generar_pdf"])) {
    $id = $_POST["generar_pdf"];
    echo "<script>
            window.open('Librerias/PDFDetalleVenta.php?id_venta=$id', '_blank');
          </script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de DataTable con Modal</title>
    <!-- Incluye Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-2">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ventas</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Ventas
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Apertura</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Apertura</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($ventasController->listarVenta() as $venta) { ?>
                        <tr>
                            <td><?php echo $venta->getId(); ?></td>
                            <td><?php echo $venta->getIdUsuario(); ?></td>
                            <td><?php echo $venta->getIdCliente(); ?></td>
                            <td><?php echo $venta->getTotal(); ?></td>
                            <td><?php echo $venta->getFecha(); ?></td>
                            <td>
                                <?php if($venta->getEstado() == 1){ ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td><?php if($venta->getApertura() == 1){ echo '<span class="badge badge-success">Abierto</span>'; }
                            else{
                                echo '<span class="badge badge-danger">Cerrado</span>';
                            }
                            ?></td>
                            <td>
                                <?php if($venta->getEstado() == 1) { 
                                    if($venta->getApertura() == 0){
                                                
                                            }else{
                                               ?>
                                               <button type="submit" class="btn btn-warning" value="<?php echo $venta->getId(); ?>" name="anular_Venta"><i class="fas fa-trash-alt"></i></button>
    
                                               <?php 
                                            }?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $venta->getId(); ?>" name="generar_pdf"><i class="fas fa-file-pdf"></i> PDF</button>

                                <?php } else { ?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $venta->getId(); ?>" name="generar_pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                    <?php } ?>
                            </td>
                            
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Incluye jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>