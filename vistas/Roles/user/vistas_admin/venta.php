<?php
ob_start(); // Iniciar el almacenamiento en búfer de salida

// Si hay un idProducto en la URL, obtenemos los datos del producto
$producto = null;
if (isset($_GET['idProducto'])) {
    $productoId = $_GET['idProducto'];
    $producto_controller = new Producto_controller();
    $producto = $producto_controller->obtenerPorId($productoId);
}

$clientes = new Cliente();
$cliente_controller = new ClientesController();
$producto_controller = new Producto_controller();
$venta_controller = new VentasController();
$venta = new detalle_temp();
$completarCompra = new Venta();

$idCompra = null; // Inicializar $idCompra


if (isset($_POST["completar_compra"])) {
    if ($_POST["total"] == 0) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se puede realizar la Venta',
                });
              </script>";
    } else {
        $completarCompra->setTotal($_POST["total"]);
        $fechaActual = date('Y-m-d H:i:s');
        $completarCompra->setFecha($fechaActual);

        $completarCompra->setIdCliente($_POST["opcionCliente"]);
        $completarCompra->setIdUsuario($_SESSION["usuario"][0]);
        $detalles = $venta_controller->listarDetalle($_SESSION["usuario"][0]);
        $venta_controller->guardarVentaConDetalles($completarCompra, $detalles);
        $venta_controller->vaciarDetalle($_SESSION["usuario"][0]);

        $idVenta = $venta_controller->obtenerUltimoIdVenta(); 

        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Venta completada',
                    text: 'Venta completada con éxito.',
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(function() {
                            window.open('Librerias/PDFDetalleVenta.php?id_venta={$idVenta}', '_blank');
                        }, 1000);
                    }
                });
              </script>";
    }
}



if (isset($_POST["eliminar_producto"])) {
    $id = $_POST["eliminar_producto"];
    $venta_controller->eliminar($id);
}

if (isset($_POST["agregarCompra"])) {
    $productoId = $_POST["opcionProducto"];
    $cantidad = $_POST["cantidad"];

    // Verificar disponibilidad del producto antes de agregarlo
    $productoDisponible = $venta_controller->verificarDisponibilidadProducto($productoId, $cantidad);

    if (!$productoDisponible) {
        echo "No hay suficientes existencias de este producto";
    } else {
        $producto = $producto_controller->obtenerPorId($productoId);
        $subtotal = $producto["precio_venta"] * $cantidad;

        $venta->setIdProducto($productoId);
        $venta->setIdUsuario($_SESSION["usuario"][0]);
        $venta->setPrecio($producto["precio_venta"]);
        $venta->setCantidad($cantidad);
        $venta->setSubTotal($subtotal);

        $venta_controller->agregarODetalle($venta);
    }
}

// Obtener todos los detalles de la base de datos
$detalles = $venta_controller->listarDetalle($_SESSION["usuario"][0]);

// Terminar el almacenamiento en búfer de salida
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Compra</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
    $(document).ready(function(){
        $('#opcionProducto').change(function(){
            var productoId = $('#opcionProducto').val();
            window.location.href = '?idProducto=' + productoId;
        });

        function actualizarSubtotal() {
            var cantidad = parseFloat($('#cantidad').val()) || 0;
            var precio = parseFloat($('#precio').val()) || 0;
            var subtotal = cantidad * precio;
            $('#subtotal').val(subtotal.toFixed(2));
        }

        $('#cantidad').on('input', function() {
            actualizarSubtotal();
        });

        $('#opcionProducto').change(function() {
            var precio = parseFloat($(this).find(':selected').data('precio')) || 0;
            $('#precio').val(precio.toFixed(2));
            actualizarSubtotal();
        });

        $('#completarCompraForm').submit(function(event) {
            event.preventDefault(); // Detiene el envío del formulario normal
            var formData = $(this).serialize(); // Serializa los datos del formulario

            $.post('path/to/your/php/file.php', formData, function(response) {
                if(response.success) {
                    window.location.href = 'Librerias/PDFDetalleCompra.php?id_compra=' + response.idCompra;
                } else {
                    alert('Error al completar la compra');
                }
            }, 'json');
        });
    });
    </script>
</head>
<body>
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white"><h4>Nueva Venta</h4></div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="opcionProducto" class="form-label"><i class="fas fa-barcode"></i> Codigo de Barras</label>
                        <select class="form-control" name="opcionProducto" id="opcionProducto" required>
                            <option value="">Seleccione un producto</option>
                            <?php
                            foreach ($producto_controller->mostrarProducto() as $productoItem) {
                                if ($productoItem["estado"] != 0 && $productoItem["cantidad"] != 0) {
                            ?>
                                <option value="<?php echo $productoItem["id"]; ?>" data-precio="<?php echo $productoItem["precio_venta"]; ?>" <?php if (isset($producto) && $producto['id'] == $productoItem["id"]) echo 'selected'; ?>>
                                    <?php echo $productoItem["codigo"]; ?>
                                </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del producto" value="<?php echo isset($producto) ? $producto['descripcion'] : ''; ?>" disabled>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="precio">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio Venta" value="<?php echo isset($producto) ? $producto['precio_venta'] : ''; ?>" disabled>
                    </div>
                    <div class="form-group col-md-2">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" min="1" required>
                    <div id="errorCantidad" class="error-message">La cantidad debe ser mayor a 0.</div>
                </div>
                <script>
                    document.getElementById('cantidad').addEventListener('input', function() {
                        var cantidad = this.value;
                        var errorCantidad = document.getElementById('errorCantidad');

                        if (cantidad <= 0) {
                            errorCantidad.style.display = 'block';
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'La cantidad debe ser mayor a 0.',
                            });
                            this.value = '';
                        } else {
                            errorCantidad.style.display = 'none';
                        }
                    });
                </script>
                    <div class="form-group col-md-2">
                        <label for="subtotal">Sub-total</label>
                        <input type="number" class="form-control" name="subtotal" id="subtotal" placeholder="Sub-Total" disabled>
                    </div>
                    <div class="form-group col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary" name="agregarCompra">
                            Agregar Compra
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>

    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Sub Total</th>
                <th>#</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Sub Total</th>
                <th>#</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        foreach ($detalles as $file) {
            $producto = $producto_controller->obtenerPorId($file["id_producto"]);
            ?>
            <tr>
                <td><?php echo $file["id"]; ?></td>
                <td><?php echo $producto["codigo"]; ?></td>
                <td><?php echo $producto["descripcion"]; ?></td>
                <td><?php echo $file["cantidad"]; ?></td>
                <td><?php echo $file["precio"]; ?></td>
                <td><?php echo $file["sub_total"]; ?></td>
                <form action="" method="post">
                <td><button type="submit" class="btn btn-danger" value="<?php echo $file["id"]; ?>" name="eliminar_producto"><i class="fas fa-trash-alt"></i></button></td>
                </form>                
            </tr>
            <?php 
        } 
        ?>
        </tbody>
    </table>
    <br>
    <form action="" method="post">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="total" class="font-weight-bold">Total</label>
                        <input type="number" value="<?php echo $venta_controller->obtenerTotalPorUsuario($_SESSION["usuario"][0]); ?>" class="form-control" name="total" id="total" readonly>
                    </div>
                    <button type="submit" class="btn btn-warning" name="completar_compra">
                        Completar Compra
                    </button>
                    <?php if ($idCompra !== null): ?>
                        <a href="Librerias/PDFDetalleCompra.php?id_compra=<?php echo $idCompra; ?>" target="_blank" class="btn btn-success" style="margin-top: 1em;">Generar Reportes</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="opcionCliente" class="font-weight-bold">Cliente</label>
                        <select class="form-control" name="opcionCliente" id="opcionCliente" required>
                            <option value="">Seleccione un Cliente</option>
                            <?php
                            foreach ($cliente_controller->listar() as $cliente) {
                            ?>
                                <option value="<?php echo $cliente->getId(); ?>">
                                    <?php echo $cliente->getNombre(); ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    </form>
</div>
</body>
</html>
