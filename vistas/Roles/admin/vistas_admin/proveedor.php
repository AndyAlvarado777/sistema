<?php



$proveedor = new Proveedor();
$proveedor_controller = new ProveedoresController();

if (isset($_POST["agregar"])) {
    $proveedor->setNombre($_POST["nombre"]);
    $proveedor->setRuc($_POST["ruc"]);
    $proveedor->setTelefono($_POST["telefono"]);
    $proveedor->setDireccion($_POST["direccion"]);
    $proveedor->setContacto($_POST["contacto"]);
    $proveedor->setEmail($_POST["email"]);
    $proveedor_controller->agregar($proveedor);
}

if (isset($_POST["eliminar_proveedor"])) {
    $id = $_POST["eliminar_proveedor"];
    $proveedor_controller->eliminar($id);
}

if (isset($_POST["activar_proveedor"])) {
    $id = $_POST["activar_proveedor"];
    $proveedor_controller->activar($id);
}

if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $ruc = $_POST["ruc"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $contacto = $_POST["contacto"];
    $email = $_POST["email"];
    $proveedor->setId($id);
    $proveedor->setNombre($nombre);
    $proveedor->setRuc($ruc);
    $proveedor->setTelefono($telefono);
    $proveedor->setDireccion($direccion);
    $proveedor->setContacto($contacto);
    $proveedor->setEmail($email);
    $proveedor_controller->actualizar($proveedor);
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
        <li class="breadcrumb-item active">Proveedores</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Proveedores
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-primary mb-2" name="agregar_proveedor" data-toggle="modal" data-target="#addUserModal">
                Nuevo
            </button>
            <form action="" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Contacto</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Contacto</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($proveedor_controller->listar() as $proveedorMostrar) { ?>
                        <tr class="">
                            <td><?php echo $proveedorMostrar->getId(); ?></td>
                            <td><?php echo $proveedorMostrar->getNombre(); ?></td>
                            <td><?php echo $proveedorMostrar->getRuc(); ?></td>
                            <td><?php echo $proveedorMostrar->getTelefono(); ?></td>
                            <td><?php echo $proveedorMostrar->getDireccion(); ?></td>
                            <td><?php echo $proveedorMostrar->getContacto(); ?></td>
                            <td><?php echo $proveedorMostrar->getEmail(); ?></td>
                            <td>
                                <?php if($proveedorMostrar->getEstado() == 1){ ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" name="editar_proveedor" data-toggle="modal" data-target="#updateModal" data-id="<?php echo $proveedorMostrar->getId(); ?>" data-nombre="<?php echo $proveedorMostrar->getNombre(); ?>" data-ruc="<?php echo $proveedorMostrar->getRuc(); ?>" data-telefono="<?php echo $proveedorMostrar->getTelefono(); ?>" data-direccion="<?php echo $proveedorMostrar->getDireccion(); ?>" data-contacto="<?php echo $proveedorMostrar->getContacto(); ?>" data-email="<?php echo $proveedorMostrar->getEmail(); ?>"><i class="fas fa-edit"></i></button>
                                <?php if($proveedorMostrar->getEstado() == 1) { ?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $proveedorMostrar->getId(); ?>" name="eliminar_proveedor"><i class="fas fa-trash-alt"></i></button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-success" value="<?php echo $proveedorMostrar->getId(); ?>" name="activar_proveedor"><i class="fas fa-redo-alt"></i></button>
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


<!-- Modal para agregar proveedor -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nuevo Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registrarUser" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Nombre del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="ruc">RUC</label>
                        <input type="text" class="form-control" id="ruc" name="ruc" required placeholder="RUC del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" class="form-control" id="telefono" name="telefono" required placeholder="Teléfono del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Dirección del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="contacto">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto" required placeholder="Nombre del contacto">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Email del proveedor">
                    </div>
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para actualizar proveedor -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarProveedor" method="post">
                    <div class="form-group">
                        <label for="updateNombre">Nombre</label>
                        <input type="text" class="form-control" id="updateNombre" name="nombre" required placeholder="Nombre del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="updateRuc">RUC</label>
                        <input type="text" class="form-control" id="updateRuc" name="ruc" required placeholder="RUC del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="updateTelefono">Teléfono</label>
                        <input type="number" class="form-control" id="updateTelefono" name="telefono" required placeholder="Teléfono del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="updateDireccion">Dirección</label>
                        <input type="text" class="form-control" id="updateDireccion" name="direccion" required placeholder="Dirección del proveedor">
                    </div>
                    <div class="form-group">
                        <label for="updateContacto">Contacto</label>
                        <input type="text" class="form-control" id="updateContacto" name="contacto" required placeholder="Nombre del contacto">
                    </div>
                    <div class="form-group">
                        <label for="updateEmail">Email</label>
                        <input type="email" class="form-control" id="updateEmail" name="email" required placeholder="Email del proveedor">
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
        var ruc = document.getElementById('ruc').value;
        var telefono = document.getElementById('telefono').value;

        var rucPattern = /^\d{11}$/; // Ajustar el patrón del RUC según las reglas de validación
        if (!rucPattern.test(ruc)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Formato de RUC incorrecto. Debe ser 11 dígitos',
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
                text: 'Formato de teléfono incorrecto. Debe ser 8 dígitos',
                footer: '<a href="#">¿Por qué tengo este problema?</a>'
            });
            return false;
        }

        return true;
    });

    document.getElementById('actualizarProveedor').addEventListener('submit', function(event) {
        var ruc = document.getElementById('updateRuc').value;
        var telefono = document.getElementById('updateTelefono').value;

        var rucPattern = /^\d{11}$/; // Ajustar el patrón del RUC según las reglas de validación
        if (!rucPattern.test(ruc)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Ingresaste un RUC incorrecto',
                text: 'Formato de RUC incorrecto. Debe ser 11 dígitos',
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
                text: 'Formato de teléfono incorrecto. Debe ser 8 dígitos',
                footer: '<a href="#">¿Por qué tengo este problema?</a>'
            });
            return false;
        }

        return true;
    });

    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var ruc = button.data('ruc');
        var telefono = button.data('telefono');
        var direccion = button.data('direccion');
        var contacto = button.data('contacto');
        var email = button.data('email');
        
        var modal = $(this);
        modal.find('#updateId').val(id);
        modal.find('#updateNombre').val(nombre);
        modal.find('#updateRuc').val(ruc);
        modal.find('#updateTelefono').val(telefono);
        modal.find('#updateDireccion').val(direccion);
        modal.find('#updateContacto').val(contacto);
        modal.find('#updateEmail').val(email);
    });
</script>
</body>
</html>
