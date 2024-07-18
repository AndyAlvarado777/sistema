<?php
$cliente = new Cliente();
$cliente_controller = new ClientesController();

if (isset($_POST["agregar"])) {
    try {
        $dui = $_POST["dui"];
        
        // Verifica si el cliente ya existe
        if ($cliente_controller->existeCliente($dui)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El DUI ya existe en la base de datos.'
                    });
                  </script>";
        } else {
            // Si no existe, procede a agregar el cliente
            $cliente->setDui($dui);
            $cliente->setNombre($_POST["nombre"]);
            $cliente->setTelefono($_POST["telefono"]);
            $cliente->setDireccion($_POST["direccion"]);
            $cliente_controller->agregar($cliente);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Cliente agregado exitosamente.'
                    });
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error: " . $e->getMessage() . "'
                });
              </script>";
    }
}



if (isset($_POST["eliminar_cliente"])) {
    $id = $_POST["eliminar_cliente"];
    $cliente_controller->eliminar($id);
}

if (isset($_POST["activar_cliente"])) {
    $id = $_POST["activar_cliente"];
    $cliente_controller->activar($id);
}

if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $cliente->setId($id);
    $cliente->setNombre($nombre);
    $cliente->setTelefono($telefono);
    $cliente->setDireccion($direccion);
    $cliente_controller->actualizar($cliente);
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
        <li class="breadcrumb-item active">Clientes</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Clientes
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-primary mb-2" name="agregar_usuario" data-toggle="modal" data-target="#addUserModal">
                Nuevo
            </button>
            <form action="" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($cliente_controller->listar() as $clienteMostrar) { ?>
                        <tr class="">
                            <td><?php echo $clienteMostrar->getId(); ?></td>
                            <td><?php echo $clienteMostrar->getDui(); ?></td>
                            <td><?php echo $clienteMostrar->getNombre(); ?></td>
                            <td><?php echo $clienteMostrar->getTelefono(); ?></td>
                            <td><?php echo $clienteMostrar->getDireccion(); ?></td>
                            <td>
                                <?php if($clienteMostrar->getEstado() == 1){ ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" name="editar_usuario" data-toggle="modal" data-target="#updateModal" data-id="<?php echo $clienteMostrar->getId(); ?>" data-dui="<?php echo $clienteMostrar->getDui(); ?>" data-nombre="<?php echo $clienteMostrar->getNombre(); ?>" data-telefono="<?php echo $clienteMostrar->getTelefono(); ?>" data-direccion="<?php echo $clienteMostrar->getDireccion(); ?>"><i class="fas fa-edit"></i></button>
                                <?php if($clienteMostrar->getEstado() == 1) { ?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $clienteMostrar->getId(); ?>" name="eliminar_cliente"><i class="fas fa-trash-alt"></i></button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-success" value="<?php echo $clienteMostrar->getId(); ?>" name="activar_cliente"><i class="fas fa-redo-alt"></i></button>
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

<!-- Modal para agregar cliente -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registrarUser" method="post">
                    <div class="form-group">
                        <label for="dui">DUI</label>
                        <input type="text" class="form-control" id="dui" name="dui" required placeholder="Documento de identidad">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Nombre del cliente">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" class="form-control" id="telefono" name="telefono" required placeholder="Teléfono del cliente">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Dirección del cliente">
                    </div>
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para actualizar cliente -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarCliente" method="post">
                    
                    <div class="form-group">
                        <label for="updateNombre">Nombre</label>
                        <input type="text" class="form-control" id="updateNombre" name="nombre" required placeholder="Nombre del cliente">
                    </div>
                    <div class="form-group">
                        <label for="updateTelefono">Teléfono</label>
                        <input type="number" class="form-control" id="updateTelefono" name="telefono" required placeholder="Teléfono del cliente">
                    </div>
                    <div class="form-group">
                        <label for="updateDireccion">Dirección</label>
                        <input type="text" class="form-control" id="updateDireccion" name="direccion" required placeholder="Dirección del cliente">
                    </div>
                    <input type="hidden" id="updateId" name="id">
                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Error -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error de Validación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="errorModalBody">
                <!-- Mensaje de error se llenará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Incluye jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('registrarUser').addEventListener('submit', function(event) {
    var dui = document.getElementById('dui').value;
    var telefono = document.getElementById('telefono').value;

    var duiPattern = /^\d{8}-\d{1}$/;
    if (!duiPattern.test(dui)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Formato de DUI incorrecto. Debe ser 00000000-0',
            footer: '<a href="#">¿Por qué tengo este problema?</a>'
        });
        return false;
    }

    var telefonoPattern = /^\d{8}$/;
    if (!telefonoPattern.test(telefono)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Formato de teléfono incorrecto. Debe ser 00000000',
            footer: '<a href="#">¿Por qué tengo este problema?</a>'
        });
        return false;
    }

    return true;
});

document.getElementById('actualizarCliente').addEventListener('submit', function(event) {
    var dui = document.getElementById('updateDui').value;
    var telefono = document.getElementById('updateTelefono').value;

    var duiPattern = /^\d{8}-\d{1}$/;
    if (!duiPattern.test(dui)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Ingresaste un DUI incorrecto',
            text: 'Formato de DUI incorrecto. Debe ser 00000000-0',
            footer: '<a href="#">¿Por qué tengo este problema?</a>'
        });
        return false;
    }

    var telefonoPattern = /^\d{8}$/;
    if (!telefonoPattern.test(telefono)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Ingresaste un formato de teléfono incorrecto',
            text: 'Formato de teléfono incorrecto. Debe ser 00000000',
            footer: '<a href="#">¿Por qué tengo este problema?</a>'
        });
        return false;
    }

    return true;
});

$('#updateModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var dui = button.data('dui');
    var nombre = button.data('nombre');
    var telefono = button.data('telefono');
    var direccion = button.data('direccion');
    
    var modal = $(this);
    modal.find('#updateId').val(id);
    modal.find('#updateDui').val(dui);
    modal.find('#updateNombre').val(nombre);
    modal.find('#updateTelefono').val(telefono);
    modal.find('#updateDireccion').val(direccion);
});

</script>
</body>
</html>
