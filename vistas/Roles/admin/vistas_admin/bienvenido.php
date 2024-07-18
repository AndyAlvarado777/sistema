<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <i class="bi bi-person-badge-fill"></i>
    <title>Dashboard</title>
    <!-- Incluir la librería Chart.js desde una CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Incluir Bootstrap CSS desde una CDN (opcional) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    $Controlador = new Producto_controller();
    $productos = $Controlador->MenorCantidadProductos();
    $productosCero = $Controlador->ProductosCantidadCero();
    $productosMasVendidos = $Controlador->ProductosMasVendidos();
    $labels = [];
    $data = [];
    foreach ($productos as $producto) {
        $labels[] = $producto['descripcion']; // Asegúrate de que 'nombre' es el nombre de la columna del producto
        $data[] = $producto['cantidad'];
    }
    $labels2 = [];
    $data2 = [];
    foreach ($productosMasVendidos as $producto) {
      $labels2[] = $producto['descripcion']; // Asegúrate de que 'descripcion' es el nombre de la columna del producto
      $data2[] = $producto['total'];
  }
    ?>

    <div class="alert alert-primary" role="alert">
    <i class="bi bi-person-badge-fill"></i>
        <strong><h1>Bienvenido</h1></strong> 
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary">
                <div class="card-body d-flex text-white">
                    Usuarios
                    <i class="fas fa-user fa-2x ml-auto"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="usuarios" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $Controlador->CantidadUsuarios(); ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success">
                <div class="card-body d-flex text-white">
                    Clientes
                    <i class="fas fa-users fa-2x ml-auto"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="Clientes" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $Controlador->CantidadClientes(); ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger">
                <div class="card-body d-flex text-white">
                    Productos
                    <i class="fab fa-product-hunt fa-2x ml-auto"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="productos" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $Controlador->CantidadProductos(); ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning">
                <div class="card-body d-flex text-white">
                    Ventas del dia
                    <i class="fas fa-cash-register fa-2x ml-auto"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="productos" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $Controlador->VentasDelDia(); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menor Cantidada de productos</h5>
                    <!-- Pie Chart -->
                    <canvas id="pieChart" style="max-height: 400px;"></canvas>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new Chart(document.querySelector('#pieChart'), {
                                type: 'pie',
                                data: {
                                    labels: <?php echo json_encode($labels); ?>,
                                    datasets: [{
                                        label: 'Cantidad de Productos',
                                        data: <?php echo json_encode($data); ?>,
                                        backgroundColor: [
                                            'rgb(255, 99, 132)',
                                            'rgb(54, 162, 235)',
                                            'rgb(255, 205, 86)',
                                            'rgb(75, 192, 192)',
                                            'rgb(153, 102, 255)',
                                            'rgb(255, 159, 64)',
                                            'rgb(199, 199, 199)',
                                            'rgb(83, 102, 255)',
                                            'rgb(132, 255, 132)',
                                            'rgb(255, 132, 192)'
                                        ],
                                        hoverOffset: 4
                                    }]
                                }
                            });
                        });
                    </script>
                    <!-- End Pie Chart -->
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Productos mas vendidos</h5>
                    <!-- Bar Chart -->
                    <canvas id="barChart" style="max-height: 400px;"></canvas>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new Chart(document.querySelector('#barChart'), {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($labels2); ?>,
                                    datasets: [{
                                        label: 'Cantidad Vendida',
                                        data: <?php echo json_encode($data2); ?>,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(199, 199, 199, 0.2)',
                                            'rgba(83, 102, 255, 0.2)',
                                            'rgba(132, 255, 132, 0.2)',
                                            'rgba(255, 132, 192, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
                                            'rgba(199, 199, 199, 1)',
                                            'rgba(83, 102, 255, 1)',
                                            'rgba(132, 255, 132, 1)',
                                            'rgba(255, 132, 192, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        });
                    </script>                   <!-- End Bar Chart -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Productos con cantidad 0</h5>
                    <!-- Tabla de Productos con cantidad 0 -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productosCero as $producto) { ?>
                                <tr>
                                    <td><?php echo $producto['id']; ?></td>
                                    <td><?php echo $producto['descripcion']; ?></td>
                                    <td><?php echo $producto['cantidad']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- End Tabla de Productos con cantidad 0 -->
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Bootstrap JS y dependencias (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
