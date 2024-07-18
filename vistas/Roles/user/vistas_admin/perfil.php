<?php

$usuarioController = new Usuarios();

if (isset($_POST['edit'])) {
    $usuario = new User();
    $usuario->setId($_SESSION["usuario"][0]);
    $usuario->setUsuario($_POST['usuario']);
    $usuario->setNombre($_POST['nombre']);
    $usuario->setIdCaja($_POST['id_caja']);

    $usuarioController->actualizar($usuario);
}

if (isset($_POST['change-password'])) {
    $id = $_SESSION["usuario"][0];
    $currentPassword = $_POST['currentpassword'];
    $newPassword = $_POST['newpassword'];
    $renewPassword = $_POST['renewpassword'];

    // Verifica que las nuevas contraseñas coincidan
    if ($newPassword !== $renewPassword) {
        $_SESSION['password_error'] = 'Las contraseñas no coinciden.';
    } else {
        // Asegúrate de verificar la contraseña actual antes de cambiarla
        if ($usuarioController->verificarClave($id, $currentPassword)) {
            $usuarioController->actualizarClave($id, $newPassword);
            $_SESSION['password_success'] = 'Contraseña actualizada correctamente.';
        } else {
            $_SESSION['password_error'] = 'La contraseña actual es incorrecta.';
        }
    }
}

$usuario = $usuarioController->obtenerPorId($_SESSION["usuario"][0]);
?>

<div>
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" width="200em" alt="Profile" class="rounded-circle">
              <h2><?php echo $usuario["nombre"]; ?></h2>
              <h3>Web</h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8">
          <div class="card">
            <div class="card-body pt-3">
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Vista General</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Cambiar Contraseña</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Acerca De</h5>
                  <p class="small fst-italic">Son libres los tiempos de ser acusados, no el nombre de los mayores, a la vez libres. El tiempo libre no es donde viene el dolor. Es justo, por tanto, que las cosas sean odiadas por quienes de vez en cuando las siguen. Huida que sigue a menudo dondequiera. </p>
                  <h5 class="card-title">Detalles de Perfil</h5>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Correo</div>
                    <div class="col-lg-9 col-md-8"><?php echo $usuario["usuario"]; ?></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nombre Completo</div>
                    <div class="col-lg-9 col-md-8"><?php echo $usuario["nombre"]; ?></div>
                  </div>
                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form -->
                  <form method="post">
                    <div class="row mb-3">
                      <label for="usuario" class="col-md-4 col-lg-3 col-form-label">Usuario</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="usuario" type="text" class="form-control" id="usuario" value="<?php echo $usuario['usuario']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nombre Completo</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nombre" type="text" class="form-control" id="fullName" value="<?php echo $usuario['nombre']; ?>">
                      </div>
                    </div>

                    

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="edit">Guardar Cambios</button>
                    </div>
                  </form><!-- End Profile Edit Form -->
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form method="post">
                    <?php
                    if (isset($_SESSION['password_error'])) {
                        echo '<div class="text-danger mb-3">'.$_SESSION['password_error'].'</div>';
                        unset($_SESSION['password_error']);
                    }
                    if (isset($_SESSION['password_success'])) {
                        echo '<div class="text-success mb-3">'.$_SESSION['password_success'].'</div>';
                        unset($_SESSION['password_success']);
                    }
                    ?>
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Contraseña Actual</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="currentpassword" type="password" class="form-control" id="currentPassword" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Contraseña Nueva</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-escribir Contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" required>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="change-password">Cambiar Contraseña</button>
                    </div>
                  </form><!-- End Change Password Form -->
                </div>
              </div><!-- End Bordered Tabs -->
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
