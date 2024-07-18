<?php
// Verificar si el usuario ya está autenticado


$configuracion = new ConfiguracionController();


if(isset($_SESSION["EstadoUsuario"]) && $_SESSION["EstadoUsuario"] == "1") {
    if($_SESSION["usuario"][4] == "1"){
        header("Location: vistas/Roles/admin/index.php");
    } else if($_SESSION["usuario"][4] == "0"){
        header("Location: vistas/Roles/user/index.php");
    }
    exit();
}

if(isset($_POST["ok1"])) {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    $usuario_controller = new Usuarios();
    $usuarios = $usuario_controller->Validar($usuario);

    if(count($usuarios) > 0) {
        $usuarioRes = $usuarios[0];

        if(password_verify($clave, $usuarioRes->getClave())) {
            if($usuarioRes->getEstado() == 1) {
                $_SESSION["EstadoUsuario"] = "1";
                $_SESSION["usuario"] = array(
                    $usuarioRes->getId(),
                    $usuarioRes->getUsuario(),
                    $usuarioRes->getNombre(),
                    $usuarioRes->getClave(),
                    $usuarioRes->getIdRol(),
                    $usuarioRes->getIdCaja(),
                    $usuarioRes->getEstado()
                );
                if($usuarioRes->getIdRol() == "1") {
                    header("Location: index.php");
                } else if($usuarioRes->getIdRol() == "0") {
                    header("Location: index.php");
                }
                exit();
            } else {
                echo '<div class="alert alert-primary" role="alert">
                        <strong>Usuario no Activo</strong>
                      </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    <strong>Credenciales incorrectas</strong>
                  </div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
                <strong>Credenciales incorrectas</strong>
              </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/6522/6522581.png" type="image/png" sizes="32x32">
    <title>Iniciar sesión</title>
    <link href="Assets/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        
        .vh-100 {
            background: linear-gradient(to right, #89CFF0, #0000FF);
        }

        .card {
            border-radius: 1rem;
            display: flex;
        }

        .card img {
            border-radius: 1rem 0 0 1rem;
            height: 100%;
            width: auto;
            object-fit: cover;
        }

        .card-body {
            padding: 4rem;
            flex:1
        }

        .form-control {
            border-radius: .5rem;
        }

        .btn-dark {
            background-color: #000;
            border: none;
            border-radius: .5rem;
        }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://us.123rf.com/450wm/adambaihaqi/adambaihaqi2008/adambaihaqi200800006/152595747-ilustraci%C3%B3n-de-quiosco-de-ventas-dibujos-animados-3d-isom%C3%A9tricos-de-estilo-azul-de-mercado-de.jpg" alt="login form" class="img-fluid" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body text-black">
                                    <form id="frmLogin" method="post">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="bi bi-person-badge-fill" style="color: #ff6219; font-size: 2rem;"></i> 
                                        <span class="h1 fw-bold mb-0">Tienda <?php
                           echo  $configuracion->nombreEmpresa2();
                        ?></span>

                                        </div>
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Inicia sesión en tu cuenta</h5>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="usuario" name="usuario" class="form-control form-control-lg" placeholder="Ingrese usuario" />
                                            <label class="form-label" for="usuario">Usuario</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" id="clave" name="clave" class="form-control form-control-lg" placeholder="Ingrese contraseña" />
                                            <label class="form-label" for="clave">Contraseña</label>
                                        </div>
                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit" name="ok1">Login</button>
                                        </div>


                                  
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="Assets/js/scripts.js"></script>
    
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <script>
        const base_url = "<?php echo URL; ?>"
    </script>
    <script src="Assets/js/funciones.js"></script>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket-fill" viewBox="0 0 16 16">
  <path d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0z"/>
</svg>
</body>
</html>
