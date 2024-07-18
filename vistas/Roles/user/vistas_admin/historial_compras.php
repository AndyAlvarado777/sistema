<?php
$compra_controller = new CompraController();
$controladorDeCompras = new Detalle_controller();

if (isset($_POST["generar_pdf"])) {
    $id = $_POST["generar_pdf"];
    echo "<script>
            window.open('Librerias/PDFDetalleCompra.php?id_compra=$id', '_blank');
          </script>";
}

if (isset($_POST["anularCompra"])) {
    $id = $_POST["anularCompra"];
    $controladorDeCompras->AnularCompra($id);
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
        <li class="breadcrumb-item active">Compras</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Compras
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($compra_controller->listar() as $compra) { ?>
                        <tr>
                            <td><?php echo $compra->getId(); ?></td>
                            <td><?php echo $compra->getTotal(); ?></td>
                            <td><?php echo $compra->getFecha(); ?></td>
                            <td>
                                <?php if ($compra->getEstado() == 1) { ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($compra->getEstado() == 1) { ?>
                                    <button type="submit" name="anularCompra" value="<?php echo $compra->getId(); ?>" class="btn btn-warning"><i class="fas fa-ban"></i></button>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $compra->getId(); ?>" name="generar_pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                    <?php } else { ?>
                                <button type="submit" class="btn btn-danger" value="<?php echo $compra->getId(); ?>" name="generar_pdf"><i class="fas fa-file-pdf"></i> PDF</button>
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
