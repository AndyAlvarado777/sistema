<?php
$sistemaMedida = new Medidas();
$medidas_controller = new MedidasController();

if (isset($_POST["agregar"])) {
    $nombre = $_POST["nombre"];
    if (preg_match('/\d/', $nombre)) {
        echo "<script>Swal.fire('Error', 'El nombre no puede contener números.', 'error');</script>";
    } else {
        $nombreCorto = (strlen($nombre) >= 3) ? $nombre[0] . $nombre[2] : '';
        $sistemaMedida->setNombre($nombre);
        $sistemaMedida->setNombreCorto($nombreCorto);
        $medidas_controller->agregar($sistemaMedida);
    }
}

if (isset($_POST["eliminar_medida"])) {
    $id = $_POST["eliminar_medida"];
    $medidas_controller->eliminar($id);
}

if (isset($_POST["activar_medida"])) {
    $id = $_POST["activar_medida"];
    $medidas_controller->activar($id);
}

if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    if (preg_match('/\d/', $nombre)) {
        echo "<script>Swal.fire('Error', 'El nombre no puede contener números.', 'error');</script>";
    } else {
        $nombreCorto = (strlen($nombre) >= 3) ? $nombre[0] . $nombre[2] : '';
        $sistemaMedida->setId($id);
        $sistemaMedida->setNombre($nombre);
        $sistemaMedida->setNombreCorto($nombreCorto);
        $medidas_controller->actualizar($sistemaMedida);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de DataTable con Modal</title>
    <link rel="icon" href="https://w7.pngwing.com/pngs/247/254/png-transparent-computer-icons-measuring-scales-measurement-others-text-measurement-logo.png" type="image/png" sizes="16x16 32x32 48x48 64x64">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container-fluid mt-2">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Medidas</li>
    </ol>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Medidas
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-primary mb-2" name="agregar_medida" data-toggle="modal" data-target="#addMedidaModal">
                Nuevo
            </button>
            <form action="" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Nombre Corto</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Nombre Corto</th>
                            <th>Estado</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($medidas_controller->listar() as $medidaMostrar) { ?>
                        <tr class="">
                            <td><?php echo $medidaMostrar->getId(); ?></td>
                            <td><?php echo $medidaMostrar->getNombre(); ?></td>
                            <td><?php echo $medidaMostrar->getNombreCorto(); ?></td>
                            <td>
                                <?php if($medidaMostrar->getEstado() == 1){ ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" name="editar_medida" data-toggle="modal" data-target="#updateModal" data-id="<?php echo $medidaMostrar->getId(); ?>" data-nombre="<?php echo $medidaMostrar->getNombre(); ?>" data-nombrecorto="<?php echo $medidaMostrar->getNombreCorto(); ?>"><i class="fas fa-edit"></i></button>
                                <?php if($medidaMostrar->getEstado() == 1) { ?>
                                    <button type="submit" class="btn btn-danger" value="<?php echo $medidaMostrar->getId(); ?>" name="eliminar_medida"><i class="fas fa-trash-alt"></i></button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-success" value="<?php echo $medidaMostrar->getId(); ?>" name="activar_medida"><i class="fas fa-redo-alt"></i></button>
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

<!-- Modal para agregar medida -->
<div class="modal fade" id="addMedidaModal" tabindex="-1" role="dialog" aria-labelledby="addMedidaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMedidaModalLabel">Agregar Nueva Medida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registrarMedida" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Nombre de la Medida" oninput="generarNombreCorto(this.value, 'nombreCorto'); validarNombre(this);">
                    </div>
                    <div class="form-group">
                        <label for="nombreCorto">Nombre Corto</label>
                        <input type="text" class="form-control" id="nombreCorto" name="nombreCorto" required placeholder="Nombre Corto" readonly>
                    </div>
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para actualizar medida -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Medida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarMedida" method="post">
                    <div class="form-group">
                        <label for="updateNombre">Nombre</label>
                        <input type="text" class="form-control" id="updateNombre" name="nombre" required placeholder="Nombre de la Medida" oninput="generarNombreCorto(this.value, 'updateNombreCorto'); validarNombre(this);">
                    </div>
                    <div class="form-group">
                        <label for="updateNombreCorto">Nombre Corto</label>
                        <input type="text" class="form-control" id="updateNombreCorto" name="nombreCorto" required placeholder="Nombre Corto" readonly>
                    </div>
                    <input type="hidden" id="updateId" name="id">
                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function generarNombreCorto(nombre, idNombreCorto) {
        var nombreCorto = (nombre.length >= 3) ? nombre[0] + nombre[2] : '';
        document.getElementById(idNombreCorto).value = nombreCorto;
    }

    function validarNombre(input) {
        var valor = input.value;
        var regex = /\d/;
        if (regex.test(valor)) {
            Swal.fire('Error', 'El nombre no puede contener números.', 'error');
            input.value = valor.replace(regex, '');
        }
    }

    document.getElementById('registrarMedida').addEventListener('submit', function(event) {
        var nombre = document.getElementById('nombre').value;
        var nombreCorto = document.getElementById('nombreCorto').value;

        if (nombre === '' || nombreCorto === '') {
            Swal.fire('Error', 'Todos los campos son obligatorios.', 'error');
            event.preventDefault();
            return false;
        }

        return true;
    });

    document.getElementById('actualizarMedida').addEventListener('submit', function(event) {
        var nombre = document.getElementById('updateNombre').value;
        var nombreCorto = document.getElementById('updateNombreCorto').value;

        if (nombre === '' || nombreCorto === '') {
            Swal.fire('Error', 'Todos los campos son obligatorios.', 'error');
            event.preventDefault();
            return false;
        }

        return true;
    });

    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var nombreCorto = button.data('nombrecorto');
        
        var modal = $(this);
        modal.find('#updateId').val(id);
        modal.find('#updateNombre').val(nombre);
        modal.find('#updateNombreCorto').val(nombreCorto);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
