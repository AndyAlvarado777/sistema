

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/5322/5322033.png" type="image/png" sizes="16x16 32x32 48x48 64x64">

        <title>Panel de administración</title>
        <link href="Assets/css/styles.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/datatables.min.css" rel="stylesheet">
        
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>
    <body class="sb-nav-fixed">
    
        
            <?php 
            require_once("vistas/Roles/admin/menu.php");
            ?>
            <div id="layoutSidenav_content">
                <main class="container mt-2 ml-1">
                
                    <div class="container-fluid mt-2">
                        <?php
                        $contenido = new ContenidoAdmin();
                        require_once($contenido->mostrar_archivo());
                        ?>
                    </div>
                    
                </main>
                <?php 
            require_once("vistas/Roles/admin/footer.php");
            ?>
    </body>
</html>
