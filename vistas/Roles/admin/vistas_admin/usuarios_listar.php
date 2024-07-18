<?php
$usuario = new User();
$usuario_controller = new Usuarios();
$errorMessage = '';
$showUpdateModal = false;

if (isset($_POST["agregar"])) {
    try {
        $usuario = $_POST["usuario"];
        $clave = $_POST["clave"];
        $confirmar = $_POST["confirmar"];
        
        // Verifica si el usuario ya existe
        if ($usuario_controller->existeUsuario($usuario)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El usuario ya existe en la base de datos.'
                    });
                  </script>";
        } else if ($clave != $confirmar) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Las contraseñas no coinciden.'
                    });
                  </script>";
        } else {
            // Si no existe y las contraseñas coinciden, procede a agregar el usuario
            $usuario_obj = new User(); // Asumiendo que tienes una clase Usuario
            $usuario_obj->setUsuario($usuario);
            $usuario_obj->setNombre($_POST["nombre"]);
            $usuario_obj->setClave($confirmar);
            $usuario_obj->setIdRol($_POST["opcionRol"]);
            $usuario_obj->setIdCaja($_POST["opcion"]);
            $usuario_controller->agregar($usuario_obj);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Usuario agregado exitosamente.'
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


if (isset($_POST["eliminar_usuario"])) {
    $id = $_POST["eliminar_usuario"];
    echo "El ID a eliminar es: " . $id;

    $usuario_controller->eliminar($id);
}

if (isset($_POST["activar_usuario"])) {
    $id = $_POST["activar_usuario"];
    $usuario_controller->Activar($id);
}

if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $clave = $_POST["clave"];
    $confirmar = $_POST["confirmar"];
    if ($clave != $confirmar) {
        $errorMessage = 'Las contraseñas no coinciden';
        $showUpdateModal = true; // Mostrar el modal de actualización incluso si hay error
    } else {
        // Crear una instancia de User y establecer los valores
        $usuario = new User();
        $usuario->setId($id);
        $usuario->setUsuario($_POST["usuario"]);
        $usuario->setNombre($_POST["nombre"]);
        
        // Encriptar la nueva contraseña antes de actualizarla
        if (!empty($clave)) {
            $hashedClave = password_hash($confirmar, PASSWORD_DEFAULT);
            $usuario->setClave($hashedClave);
        }

        $usuario->setIdCaja($_POST["opcion"]);
        $usuario_controller->actualizar($usuario);
    }
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
        <li class="breadcrumb-item active">Usuario</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        DataTable Example
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
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Caja</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Caja</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            foreach ($usuario_controller->listar() as $file) {
                        ?>
                        <tr class="">
                            <td><?php echo $file->getId(); ?></td>
                            <td><?php echo $file->getUsuario(); ?></td>
                            <td><?php echo $file->getNombre(); ?></td>
                            <td>
                                <?php if($file->getIdRol() == 1){ ?>
                                    <span class="badge badge-success">Administrador</span>
                                <?php } else { ?>
                                    <span class="badge badge-warning">Usuario</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($file->getEstado() == 1){ ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td><?php echo $file->getIdCaja(); ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" name="editar_usuario" data-toggle="modal" data-target="#updateUserModal" data-id="<?php echo $file->getId(); ?>" data-usuario="<?php echo $file->getUsuario(); ?>" data-nombre="<?php echo $file->getNombre(); ?>" data-opcion="<?php echo $file->getIdCaja(); ?>"><i class="fas fa-edit"></i></button>
                                <?php if($file->getEstado() == 1) { ?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $file->getId(); ?>" name="eliminar_usuario"><i class="fas fa-trash-alt"></i></button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-success" value="<?php echo $file->getId(); ?>" name="activar_usuario"><i class="fas fa-redo-alt"></i></button>
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

<!-- Modal para agregar usuario -->
<div class="modal fade <?php if (!empty($errorMessage)) { echo 'show'; } ?>" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true" <?php if (!empty($errorMessage)) { echo 'style="display: block;"'; } ?>>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hideModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registrarUser" method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese un usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="opcionRol" class="form-label">ROL</label>
                            <select class="form-select form-select-lg" name="opcionRol" id="opcionRol">
                                
                                    <option value="1">admin</option>
                                    <option value="0">usuario</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="clave">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmar">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmar" name="confirmar" required>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="opcion" class="form-label">Caja</label>
                            <select class="form-select form-select-lg" name="opcion" id="opcion">
                                <?php
                                foreach ($usuario_controller->mostrarCaja() as $caja) {
                                ?>
                                    <option value="<?php echo $caja["id"]; ?>"><?php echo $caja["caja"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para actualizar usuario -->
<div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">Actualizar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarUser" method="post">
                    <div class="form-group">
                        <label for="updateUsuario">Usuario</label>
                        <input type="text" class="form-control" id="updateUsuario" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="updateNombre">Nombre</label>
                        <input type="text" class="form-control" id="updateNombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="updateClave">Contraseña</label>
                        <input type="password" class="form-control" id="updateClave" name="clave" required>
                    </div>
                    <div class="form-group">
                        <label for="updateConfirmar">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="updateConfirmar" name="confirmar" required>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="updateOpcion" class="form-label">Caja</label>
                            <select class="form-select form-select-lg" name="opcion" id="updateOpcion">
                                <?php
                                foreach ($usuario_controller->mostrarCaja() as $caja) {
                                ?>
                                    <option value="<?php echo $caja["id"]; ?>"><?php echo $caja["caja"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
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

<script>
    function showErrorModal(message) {
        document.getElementById('errorModalBody').innerText = message;
        $('#errorModal').modal('show');
    }

    <?php if (!empty($errorMessage)) { ?>
    showErrorModal('<?php echo $errorMessage; ?>');
    <?php } ?>

    $('#updateUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var usuario = button.data('usuario');
        var nombre = button.data('nombre');
        var opcion = button.data('opcion');
        
        var modal = $(this);
        modal.find('#updateId').val(id);
        modal.find('#updateUsuario').val(usuario);
        modal.find('#updateNombre').val(nombre);
        modal.find('#updateOpcion').val(opcion);
    });
</script>
</body>
</html>
