<?php
$cliente = new Cliente();
$categoria_controller = new Categoria_controller();

if (isset($_POST["agregar"])) {
    $cliente->setNombre($_POST["nombre"]);
    // Asumimos que por defecto el estado es 1 (Activo)
    $categoria_controller->agregar($cliente);
}

if (isset($_POST["eliminar_cliente"])) {
    $id = $_POST["eliminar_cliente"];
    $categoria_controller->eliminar($id);
}

if (isset($_POST["activar_cliente"])) {
    $id = $_POST["activar_cliente"];
    $categoria_controller->activar($id);
}

if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $cliente->setId($id);
    $cliente->setNombre($nombre);
    $categoria_controller->actualizar($cliente);
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
    <!-- Incluye SweetAlert CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@9.0.9/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-2">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Categorias</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Categorias
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-primary mb-2" name="agregar_categoria" data-toggle="modal" data-target="#addUserModal">
                Nuevo
            </button>
            <form action="" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($categoria_controller->listar() as $categoriaMostrar) { ?>
                        <tr class="">
                            <td><?php echo $categoriaMostrar->getId(); ?></td>
                            <td><?php echo $categoriaMostrar->getNombre(); ?></td>
                            <td>
                                <?php if($categoriaMostrar->getEstado() == 1){ ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" name="editar_categoria" data-toggle="modal" data-target="#updateModal" data-id="<?php echo $categoriaMostrar->getId(); ?>" data-nombre="<?php echo $categoriaMostrar->getNombre(); ?>"><i class="fas fa-edit"></i></button>
                                <?php if($categoriaMostrar->getEstado() == 1) { ?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $categoriaMostrar->getId(); ?>" name="eliminar_cliente"><i class="fas fa-trash-alt"></i></button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-success" value="<?php echo $categoriaMostrar->getId(); ?>" name="activar_cliente"><i class="fas fa-redo-alt"></i></button>
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

<!-- Modal para agregar categoria -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nueva Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registrarCategoria" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Nombre de la Categoria">
                    </div>
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para actualizar categoria -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarCategoria" method="post">
                    <div class="form-group">
                        <label for="updateNombre">Nombre</label>
                        <input type="text" class="form-control" id="updateNombre" name="nombre" required placeholder="Nombre de la Categoria">
                        <input type="hidden" id="updateId" name="id">
                    </div>
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
<!-- Incluye SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.0.9/dist/sweetalert2.min.js"></script>

<!-- Script para validar el formulario -->
<script>
document.getElementById('registrarCategoria').addEventListener('submit', function(event) {
    var nombre = document.getElementById('nombre').value;

    var nombrePattern = /^[a-zA-Z\s]+$/;
    if (!nombrePattern.test(nombre)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            text: 'El nombre solo debe contener letras y espacios.'
        });
        return false;
    }

    return true;
});

document.getElementById('actualizarCategoria').addEventListener('submit', function(event) {
    var nombre = document.getElementById('updateNombre').value;

    var nombrePattern = /^[a-zA-Z\s]+$/;
    if (!nombrePattern.test(nombre)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            text: 'El nombre solo debe contener letras y espacios.'
        });
        return false;
    }

    return true;
});

$('#updateModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre = button.data('nombre');
    var modal = $(this);
    modal.find('#updateId').val(id);
    modal.find('#updateNombre').val(nombre);
});
</script>
</body>
</html>
