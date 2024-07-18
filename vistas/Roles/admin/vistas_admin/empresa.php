<?php
// Asegúrate de incluir el modelo Configuracion

$configuracionController = new ConfiguracionController();
$configuracion = new Configuracion();

// Verificación y procesamiento del formulario de actualización
if (isset($_POST["ActualizarEmpresa"])) {
    // Validación básica de los datos del formulario (puedes mejorarla según tus necesidades)
    $configuracion->setId($_POST["id"]); // Añadir ID oculto para identificar la configuración
    $configuracion->setRuc($_POST["ruc"]);
    $configuracion->setNombre($_POST["nombre"]);
    $configuracion->setTelefono($_POST["telefono"]);
    $configuracion->setDireccion($_POST["direccion"]);
    $configuracion->setMensaje($_POST["mensaje"]);

    $configuracionController->actualizar($configuracion);

    // Redireccionar o mostrar mensaje de éxito
    // Por ejemplo, redireccionamos a la misma página para reflejar los cambios
    
}

// Obtener la configuración actual para mostrar en el formulario
$idConfiguracion = 1; // Cambia el 1 por el ID correcto de tu configuración
$configuracionActual = $configuracionController->obtenerPorId($idConfiguracion);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Configuración</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white"><h4>Mi Empresa </h4></div>
        <div class="card-body">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $configuracionActual['id']; ?>">
                <div class="form-group">
                    <label for="ruc">RUC</label>
                    <input type="text" class="form-control" id="ruc" name="ruc" value="<?php echo $configuracionActual['ruc']; ?>">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $configuracionActual['nombre']; ?>">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $configuracionActual['telefono']; ?>">
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $configuracionActual['direccion']; ?>">
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje"><?php echo $configuracionActual['mensaje']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="ActualizarEmpresa">Actualizar</button>
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
