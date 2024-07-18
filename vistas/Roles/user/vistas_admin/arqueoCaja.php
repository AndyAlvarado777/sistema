<?php


$caja_controller = new CierreCaja_controller();

if (isset($_POST["agregar"])) {
    $cierreCaja = new CierreCaja();
    $cierreCaja->setIdUsuario($_SESSION["usuario"][0]);
    $cierreCaja->setMontoInicial($_POST["monto_inicial"]);
    $cierreCaja->setFechaApertura($_POST["fecha_apertura"]);
     
    // Asumimos que por defecto el estado es 1 (Activo)
    $caja_controller->agregar($cierreCaja);
}

if (isset($_POST["eliminar_cliente"])) {
    $id = $_POST["eliminar_cliente"];
    $caja_controller->eliminar($id);
}

if (isset($_POST["activar_cliente"])) {
    $id = $_POST["activar_cliente"];
    $caja_controller->activar($id);
}

if (isset($_POST["cerrar"])) {
    $montoInicial = $_POST["monto_inicial2"];
    $id_usuario = $_SESSION["usuario"][0];
    $monto_final = $_POST["monto_final"];
    $fecha_cierre = $_POST["fecha_cierre"];
    $caja_controller->cerrarCaja($id_usuario,$montoInicial, $monto_final, $fecha_cierre);
}


if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $cierreCaja = new CierreCaja();
    $cierreCaja->setId($id);
    $cierreCaja->setIdUsuario($_SESSION["usuario"][0]);
    $cierreCaja->setMontoInicial($_POST["monto_inicial"]);
    $cierreCaja->setMontoFinal($_POST["monto_final"]);
    $cierreCaja->setFechaApertura($_POST["fecha_apertura"]);
    $cierreCaja->setFechaCierre($_POST["fecha_cierre"]);
    $cierreCaja->setEstado($_POST["estado"]);
    $caja_controller->actualizar($cierreCaja);
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
        <li class="breadcrumb-item active">Arqueo de Cajas</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Caja
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-primary mb-2" name="agregar_categoria" data-toggle="modal" data-target="#addUserModal">
                Nuevo
            </button>
            <button type="button" class="btn btn-warning mb-2" name="agregar_categoria" data-toggle="modal" data-target="#cerrarCaja">
                Cerrar Caja
            </button>
            <form action="" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Monto Inicial</th>
                            <th>Monto Final</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Total Ventas</th>
                            <th>Monto Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Monto Inicial</th>
                            <th>Monto Final</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Total Ventas</th>
                            <th>Monto Total</th>
                            <th>Estado</th>
                            
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($caja_controller->obtenerPorId($_SESSION["usuario"][0]) as $cajaMostrar) { ?>
                        <tr>
                            <td><?php echo $cajaMostrar->getId(); ?></td>
                            <td><?php echo $cajaMostrar->getIdUsuario(); ?></td>
                            <td><?php echo $cajaMostrar->getMontoInicial(); ?></td>
                            <td><?php echo $cajaMostrar->getMontoFinal(); ?></td>
                            <td><?php echo $cajaMostrar->getFechaApertura(); ?></td>
                            <td><?php echo $cajaMostrar->getFechaCierre(); ?></td>
                            <td><?php echo $cajaMostrar->getTotalVentas(); ?></td>
                            <td><?php echo $cajaMostrar->getMontoTotal(); ?></td>
                            <td>
                                <?php if($cajaMostrar->getEstado() == 1){ ?>
                                    <span class="badge badge-success">Abierto</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Cerrado</span>
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

<!-- Modal para agregar caja -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nueva Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registrarCaja" method="post">
                    
                    <div class="form-group">
                        <label for="monto_inicial">Monto Inicial</label>
                        <input type="text" class="form-control" id="monto_inicial" name="monto_inicial" required placeholder="Monto Inicial">
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_apertura">Fecha Apertura</label>
                        <input type="date" class="form-control" id="fecha_apertura" name="fecha_apertura" required placeholder="Fecha Apertura">
                    </div>
                   
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cerrar caja -->
<div class="modal fade" id="cerrarCaja" tabindex="-1" role="dialog" aria-labelledby="cerrarCajaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cerrarCajaLabel">Cerrar Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cerrarCajaForm" method="post">
                    <div class="form-group">
                        <label for="monto_inicial2">Monto Inicial</label>
                        <input type="number" step="0.01" class="form-control" id="monto_inicial2" name="monto_inicial2" value="<?php echo $caja_controller->MontoInicial($_SESSION["usuario"][0]); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="monto_final">Monto Final</label>
                        <input type="number" step="0.01" class="form-control" id="monto_final" name="monto_final" value="<?php echo $caja_controller->montoTotal($_SESSION["usuario"][0]); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="fecha_cierre">Fecha Cierre</label>
                        <input type="date" class="form-control" id="fecha_cierre" name="fecha_cierre" required>
                    </div>
                    <div class="form-group">
                        <label for="total_ventas">Total Ventas</label>
                        <input type="number" step="0.01" class="form-control" id="total_ventas" name="total_ventas" value="<?php echo $caja_controller->TotalVentas($_SESSION["usuario"][0]); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="monto_total">Monto Total</label>
                        <input type="number" step="0.01" class="form-control" id="monto_total" name="monto_total" required readonly>
                    </div>
                    <button type="submit" name="cerrar" class="btn btn-primary">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal para actualizar caja -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarCategoria" method="post">
                    <div class="form-group">
                        <label for="updateIdUsuario">ID Usuario</label>
                        <input type="text" class="form-control" id="updateIdUsuario" name="id_usuario" required placeholder="ID del Usuario">
                    </div>
                    <div class="form-group">
                        <label for="updateMontoInicial">Monto Inicial</label>
                        <input type="text" class="form-control" id="updateMontoInicial" name="monto_inicial" required placeholder="Monto Inicial">
                    </div>
                    <div class="form-group">
                        <label for="updateMontoFinal">Monto Final</label>
                        <input type="text" class="form-control" id="updateMontoFinal" name="monto_final" required placeholder="Monto Final">
                    </div>
                    <div class="form-group">
                        <label for="updateFechaApertura">Fecha Apertura</label>
                        <input type="text" class="form-control" id="updateFechaApertura" name="fecha_apertura" required placeholder="Fecha Apertura">
                    </div>
                    <div class="form-group">
                        <label for="updateFechaCierre">Fecha Cierre</label>
                        <input type="text" class="form-control" id="updateFechaCierre" name="fecha_cierre" required placeholder="Fecha Cierre">
                    </div>
                    <div class="form-group">
                        <label for="updateTotalVentas">Total Ventas</label>
                        <input type="text" class="form-control" id="updateTotalVentas" name="total_ventas" required placeholder="Total Ventas">
                    </div>
                    <div class="form-group">
                        <label for="updateMontoTotal">Monto Total</label>
                        <input type="text" class="form-control" id="updateMontoTotal" name="monto_total" required placeholder="Monto Total">
                    </div>
                    <div class="form-group">
                        <label for="updateEstado">Estado</label>
                        <input type="text" class="form-control" id="updateEstado" name="estado" required placeholder="Estado">
                    </div>
                    <input type="hidden" id="updateId" name="id">
                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Incluye jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Script para llenar el modal de actualización con los datos correspondientes -->
<script>
$('#updateModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var id_usuario = button.data('id_usuario');
    var monto_inicial = button.data('monto_inicial');
    var monto_final = button.data('monto_final');
    var fecha_apertura = button.data('fecha_apertura');
    var fecha_cierre = button.data('fecha_cierre');
    var total_ventas = button.data('total_ventas');
    var monto_total = button.data('monto_total');
    var estado = button.data('estado');
    var modal = $(this);
    modal.find('#updateId').val(id);
    modal.find('#updateIdUsuario').val(id_usuario);
    modal.find('#updateMontoInicial').val(monto_inicial);
    modal.find('#updateMontoFinal').val(monto_final);
    modal.find('#updateFechaApertura').val(fecha_apertura);
    modal.find('#updateFechaCierre').val(fecha_cierre);
    modal.find('#updateTotalVentas').val(total_ventas);
    modal.find('#updateMontoTotal').val(monto_total);
    modal.find('#updateEstado').val(estado);

    
});
</script>
<script>
$('#cerrarCaja').on('show.bs.modal', function (event) {
    var modal = $(this);
    
    // Obtener los valores de monto inicial y monto final
    var monto_inicial = parseFloat(modal.find('#monto_inicial2').val());
    var monto_final = parseFloat(modal.find('#monto_final').val());
    
    // Calcular el monto total
    var monto_total = monto_inicial + monto_final;
    
    // Actualizar el campo monto_total
    modal.find('#monto_total').val(monto_total.toFixed(2));
});

</script>
</body>
</html>
