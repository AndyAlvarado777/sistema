<?php
ob_start(); // Iniciar el almacenamiento en búfer de salida

$producto = null;
if (isset($_GET['idProducto'])) {
    $productoId = $_GET['idProducto'];
    $producto_controller = new Producto_controller();
    $producto = $producto_controller->obtenerPorId($productoId);
}

$producto_controller = new Producto_controller();
$compra_controller = new Detalle_controller();
$compra = new Detalle();
$completarCompra = new Compra();

$idCompra = null; // Inicializar $idCompra

if (isset($_POST["completar_compra"])) {
    if ($_POST["total"] == 0) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se puede realizar la compra',
                });
              </script>";
    } else {
        $completarCompra->setTotal($_POST["total"]);
        $fechaActual = date('Y-m-d H:i:s');
        $completarCompra->setFecha($fechaActual);
        $detalles = $compra_controller->listar($_SESSION["usuario"][0]);
        $compra_controller->guardarCompraConDetalles($completarCompra, $detalles);
        $compra_controller->vaciarDetalle($_SESSION["usuario"][0]);
        
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Compra completada',
                    text: 'Compra completada con éxito.',
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(function() {
                            window.open('Librerias/PDFDetalleCompra.php?id_compra={$compra_controller->obtenerUltimoIdCompra()}', '_blank');
                        }, 1000);
                    }
                });
              </script>";
    }
}

if (isset($_POST["eliminar_producto"])) {
    $id = $_POST["eliminar_producto"];
    $compra_controller->eliminar($id);
}

if (isset($_POST["agregarCompra"])) {
    if($_POST["cantidad"] != 0){
        $productoId = $_POST["opcionProducto"];
        $cantidad = $_POST["cantidad"];
    
        $producto = $producto_controller->obtenerPorId($productoId);
        $subtotal = $producto["precio_compra"] * $cantidad;
    
        $compra->setIdProducto($productoId);
        $compra->setIdUsuario($_SESSION["usuario"][0]);
        $compra->setPrecio($producto["precio_compra"]);
        $compra->setCantidad($cantidad);
        $compra->setSubTotal($subtotal);
    
        $compra_controller->agregarODetalle($compra);
    }else{
        echo "<div class='alert alert-danger'>No se puede realizar la compra</div>";
    }
   
}

$detalles = $compra_controller->listar($_SESSION["usuario"][0]);

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#opcionProducto').change(function(){
            var productoId = $(this).val();
            if (!productoId) {
                alert('Por favor seleccione un producto.');
            } else {
                window.location.href = '?idProducto=' + productoId;
            }
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
    });
    </script>
</head>
<body>
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Nueva Compra</h4>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="opcionProducto">Código de Barras</label>
                        <select class="form-control" name="opcionProducto" id="opcionProducto" required>
                            <option value="">Seleccione un producto</option>
                            <?php
                            foreach ($producto_controller->mostrarProducto() as $productoItem) {
                                if ($productoItem["estado"] != 0) {
                            ?>
                                    <option value="<?php echo $productoItem["id"]; ?>" data-precio="<?php echo $productoItem["precio_compra"]; ?>" <?php if (isset($producto) && $producto['id'] == $productoItem["id"]) echo 'selected'; ?>>
                                        <?php echo $productoItem["codigo"]; ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del producto" value="<?php echo isset($producto) ? $producto['descripcion'] : ''; ?>" disabled>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="precio">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio Compra" value="<?php echo isset($producto) ? $producto['precio_compra'] : ''; ?>" disabled>
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
                <th>Código</th>
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
                <th>Código</th>
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
    <div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <form id="compraForm" action="" method="post" onsubmit="return validarFormulario()">
                    <div class="form-group">
                        <label for="total" class="font-weight-bold">Total</label>
                        <input type="number" value="<?php echo $compra_controller->obtenerTotalPorUsuario($_SESSION['usuario'][0]); ?>" class="form-control" name="total" id="total" readonly >
                        <div id="errorTotal" style="color: red; display: none;">El campo Total no puede estar vacío.</div>
                    </div>
                    <button type="submit" class="btn btn-success" name="completar_compra">Completar Compra</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<script>
    function validarFormulario() {
        var total = document.getElementById("total").value;
        var errorTotal = document.getElementById("errorTotal");

        if (total === "" || total === null) {
            errorTotal.style.display = "block";
            return false; // Evita que el formulario se envíe
        } else {
            errorTotal.style.display = "none";
            return true; // Permite que el formulario se envíe
        }
    }
</script>
</body>
</html>

