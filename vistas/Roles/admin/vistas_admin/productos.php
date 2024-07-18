<?php
$errorMessage = '';
$showUpdateModal = false;
$producto_controller = new Producto_controller();
$proveedor_controller = new ProveedoresController();

if (isset($_POST["agregar"])) {
    $codigo = $_POST["codigo"];
    if ($producto_controller->existeProducto($codigo)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El codigo del producto ya existe.'
                });
              </script>";
    }else{
        $producto = new Producto();
    $producto->setCodigo($_POST["codigo"]);
    $producto->setDescripcion($_POST["descripcion"]);
    $producto->setPrecioCompra($_POST["precio_compra"]);
    $producto->setPrecioVenta($_POST["precio_venta"]);
    $producto->setCantidad(0);
    $producto->setIdMedida($_POST["opcionMedida"]);
    $producto->setIdCategoria($_POST["opcionCategoria"]);
    $producto->setProveedor($_POST["opcionProveedor"]);
    
    // El formulario ha sido enviado, procesar los datos del formulario
    // Verificar si se ha subido un archivo
    if (isset($_FILES["fichero"])) {
        // Verificar si el archivo se ha subido correctamente
        if (is_uploaded_file($_FILES['fichero']['tmp_name'])) {
            $tmp_name = $_FILES["fichero"]["tmp_name"];
            $name = "imagenes/" . $_FILES["fichero"]["name"];
            if (is_file($name)) {
                $idUnico = time(); //si existe le coloco un nombre unico
                $name = "imagenes/" . $idUnico . "-" . $_FILES["fichero"]["name"];
            }
            // Mover el archivo al directorio de imágenes
            move_uploaded_file($tmp_name, $name);
            // Guardar la ruta de la imagen en el objeto producto
            $producto->setFoto($name);
        }
    }
    $producto_controller->agregar($producto);
    }
    
}

if (isset($_POST["eliminar_producto"])) {
    $id = $_POST["eliminar_producto"];
    $producto_controller->eliminar($id);
}

if (isset($_POST["activar_producto"])) {
    $id = $_POST["activar_producto"];
    $producto_controller->activar($id);
}

if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $producto = new Producto();
    $producto->setId($id);
    $producto->setCodigo($_POST["codigo"]);
    $producto->setDescripcion($_POST["descripcion"]);
    $producto->setPrecioCompra($_POST["precio_compra"]);
    $producto->setPrecioVenta($_POST["precio_venta"]);
    $producto->setIdMedida($_POST["opcionMedida"]);
    $producto->setIdCategoria($_POST["opcionCategoria"]);
    $producto->setCantidad(0); // Asegúrate de que tu objeto Producto tenga este método
    
    // Verificar si se ha subido un nuevo archivo
    if (isset($_FILES["fichero_actualizar"]) && is_uploaded_file($_FILES["fichero_actualizar"]["tmp_name"])) {
        $tmp_name = $_FILES["fichero_actualizar"]["tmp_name"];
        $name = "imagenes/" . $_FILES["fichero_actualizar"]["name"];
        if (is_file($name)) {
            $idUnico = time(); //si existe le coloco un nombre unico
            $name = "imagenes/" . $idUnico . "-" . $_FILES["fichero_actualizar"]["name"];
        }
        // Mover el archivo al directorio de imágenes
        move_uploaded_file($tmp_name, $name);
        // Guardar la ruta de la imagen en el objeto producto
        $producto->setFoto($name);
    } else {
        // Si no se subió un nuevo archivo, mantener la foto existente
        $producto->setFoto($_POST["foto"]);
    }

    $producto_controller->actualizar($producto);
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
    <!-- Incluye DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- Incluye botones DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
</head>
<body>
<div class="container-fluid mt-2">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Producto</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-primary mb-2" name="agregar_producto" data-toggle="modal" data-target="#addProductModal">
                Nuevo
            </button>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Cantidad</th>
                            <th>Medida</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Foto</th>
                            <th>Proveedor</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Cantidad</th>
                            <th>Medida</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Foto</th>
                            <th>Proveedor</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            foreach ($producto_controller->listar() as $file) {
                        ?>
                        <tr>
                            <td><?php echo $file["id"]; ?></td>
                            <td><?php echo $file["codigo"]; ?></td>
                            <td><?php echo $file["descripcion"]; ?></td>
                            <td><?php echo $file["precio_compra"]; ?></td>
                            <td><?php echo $file["precio_venta"]; ?></td>
                            <td><?php echo $file["cantidad"]; ?></td>
                            <td><?php echo $file["medida"]; ?></td>
                            <td><?php echo $file["categoria"]; ?></td>
                            
                            <td>
                                <?php if($file["estado"] == 1){ ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td><img src="<?php echo $file["foto"]; ?>" alt="Foto" style="width: 50px; height: 50px;"></td>
                            <td><?php echo $file["id_proveedor"]; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" name="editar_producto" data-toggle="modal" data-target="#updateProductModal" data-id="<?php echo $file["id"]; ?>" data-codigo="<?php echo $file["codigo"]; ?>" data-descripcion="<?php echo $file["descripcion"]; ?>" data-preciocompra="<?php echo $file["precio_compra"]; ?>" data-precioventa="<?php echo $file["precio_venta"]; ?>" data-cantidad="<?php echo $file["cantidad"]; ?>" data-idmedida="<?php echo $file["medida_id"]; ?>" data-idcategoria="<?php echo $file["categoria_id"]; ?>" data-foto="<?php echo $file["foto"]; ?>"><i class="fas fa-edit"></i></button>
                                <?php if($file["estado"] == 1) { ?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $file["id"]; ?>" name="eliminar_producto"><i class="fas fa-trash-alt"></i></button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-success" value="<?php echo $file["id"]; ?>" name="activar_producto"><i class="fas fa-redo-alt"></i></button>
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
<!-- Modal para agregar producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Agregar Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="form-group">
                        <label for="opcionProveedor">Proveedor</label>
                        <select class="form-control" id="opcionProveedor" name="opcionProveedor">
                            <!-- Aquí debes incluir las opciones de medidas -->
                            <?php foreach ($proveedor_controller->mostrarProveedor() as $medida) { ?>
                                <option value="<?php echo $medida['id']; ?>"><?php echo $medida['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="precio_compra">Precio de Compra</label>
                        <input type="text" class="form-control" id="precio_compra" name="precio_compra" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_venta">Precio de Venta</label>
                        <input type="text" class="form-control" id="precio_venta" name="precio_venta" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="opcionMedida">Medida</label>
                        <select class="form-control" id="opcionMedida" name="opcionMedida">
                            <!-- Aquí debes incluir las opciones de medidas -->
                            <?php foreach ($producto_controller->mostrarMedida() as $medida) { ?>
                                <option value="<?php echo $medida['id']; ?>"><?php echo $medida['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="opcionCategoria">Categoría</label>
                        <select class="form-control" id="opcionCategoria" name="opcionCategoria">
                            <!-- Aquí debes incluir las opciones de categorías -->
                            <?php foreach ($producto_controller->mostrarCategoria() as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fichero">Imagen</label>
                        <input type="file" class="form-control-file" id="fichero" name="fichero">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" name="agregar">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para actualizar producto -->
<div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Actualizar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_compra">Precio de Compra</label>
                        <input type="text" class="form-control" id="precio_compra" name="precio_compra" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_venta">Precio de Venta</label>
                        <input type="text" class="form-control" id="precio_venta" name="precio_venta" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="opcionMedida">Medida</label>
                        <select class="form-control" id="opcionMedida" name="opcionMedida">
                            <!-- Aquí debes incluir las opciones de medidas -->
                            <?php foreach ($producto_controller->mostrarMedida() as $medida) { ?>
                                <option value="<?php echo $medida['id']; ?>"><?php echo $medida['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="opcionCategoria">Categoría</label>
                        <select class="form-control" id="opcionCategoria" name="opcionCategoria">
                            <!-- Aquí debes incluir las opciones de categorías -->
                            <?php foreach ($producto_controller->mostrarCategoria() as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fichero_actualizar">Imagen</label>
                        <input type="file" class="form-control-file" id="fichero_actualizar" name="fichero_actualizar">
                    </div>
                    <input type="hidden" id="foto" name="foto">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluye jQuery y Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Incluye Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Incluye DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<!-- Incluye botones DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    


        // Función para cargar datos en el modal de actualización
        $('#updateProductModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var codigo = button.data('codigo');
    var descripcion = button.data('descripcion');
    var precioCompra = button.data('preciocompra');
    var precioVenta = button.data('precioventa');
    var cantidad = button.data('cantidad'); // Asegúrate de que la cantidad se pase correctamente
    var idMedida = button.data('idmedida');
    var idCategoria = button.data('idcategoria');
    var foto = button.data('foto');
    
    var modal = $(this);
    modal.find('#updateId').val(id);
    modal.find('#updateCodigo').val(codigo);
    modal.find('#updateDescripcion').val(descripcion);
    modal.find('#updatePrecioCompra').val(precioCompra);
    modal.find('#updatePrecioVenta').val(precioVenta);
    modal.find('#updateCantidad').val(cantidad); // Asigna la cantidad al campo de cantidad
    modal.find('#updateOpcionMedida').val(idMedida);
    modal.find('#updateOpcionCategoria').val(idCategoria);
    modal.find('#updateFoto').val(foto);

    // Restablecer la vista previa de la imagen cuando se abre el modal de actualización
    var preview = document.getElementById('update-img-preview');
    var cancelButton = document.getElementById('cancel-update-img-btn');
    preview.style.display = 'none';
    preview.src = '';
    document.getElementById('fichero_actualizar').value = '';
    cancelButton.style.display = 'none';
});


    document.getElementById('fichero').addEventListener('change', function(event) {
        var input = event.target;
        var preview = document.getElementById('img-preview');
        var cancelButton = document.getElementById('cancel-img-btn');
        var file = input.files[0];
        
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                cancelButton.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            cancelButton.style.display = 'none';
        }
    });

    document.getElementById('fichero_actualizar').addEventListener('change', function(event) {
        var input = event.target;
        var preview = document.getElementById('update-img-preview');
        var cancelButton = document.getElementById('cancel-update-img-btn');
        var file = input.files[0];
        
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                cancelButton.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            cancelButton.style.display = 'none';
        }
    });

    document.getElementById('cancel-img-btn').addEventListener('click', function() {
        var input = document.getElementById('fichero');
        var preview = document.getElementById('img-preview');
        var cancelButton = document.getElementById('cancel-img-btn');
        input.value = '';
        preview.src = '';
        preview.style.display = 'none';
        cancelButton.style.display = 'none';
    });

    document.getElementById('cancel-update-img-btn').addEventListener('click', function() {
        var input = document.getElementById('fichero_actualizar');
        var preview = document.getElementById('update-img-preview');
        var cancelButton = document.getElementById('cancel-update-img-btn');
        input.value = '';
        preview.src = '';
        preview.style.display = 'none';
        cancelButton.style.display = 'none';
    });
        
    });


    
</script>
</body>
</html>


