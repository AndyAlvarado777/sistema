<?php
require_once("../controladores/conexion.php");

class PDF extends conexion {

    public function generarPDF($id_venta) {
        require('fpdf/fpdf.php'); // Incluir FPDF
        
        // Crear instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        // Obtener la información de la empresa desde la tabla configuracion
        $sql_configuracion = "SELECT * FROM configuracion";
        $resultado_configuracion = $this->ejecutarSQL($sql_configuracion);
        $configuracion = $resultado_configuracion->fetch_assoc();

        // Título del documento (Factura de Venta)
        $pdf->Cell(190, 10, 'Factura de Venta', 0, 1, 'C');
        $pdf->Ln(10); // Línea en blanco

        // Nombre de la empresa
        $pdf->Cell(190, 8, $configuracion['nombre'], 0, 1, 'C');

        // Otros datos de la empresa
        $pdf->Cell(190, 8, 'RUC: ' . $configuracion['ruc'], 0, 1, 'C');
        $pdf->Cell(190, 8, 'Dirección: ' . $configuracion['direccion'], 0, 1, 'C');
        $pdf->Ln(5); // Línea en blanco

        // Obtener los detalles de la venta y el nombre del cliente
        $sql = "SELECT dv.*, p.descripcion AS nombre_producto, c.nombre AS nombre_cliente
                FROM detalle_ventas dv
                INNER JOIN productos p ON dv.id_producto = p.id
                INNER JOIN ventas v ON dv.id_venta = v.id
                INNER JOIN clientes c ON v.id_cliente = c.id
                WHERE dv.id_venta = $id_venta";
        $rs = $this->ejecutarSQL($sql);
        $VentaDetalles = [];
        while ($fila = $rs->fetch_assoc()) {
            $VentaDetalles[] = $fila;
        }

        // Encabezados de la tabla de detalles
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Producto', 1);
        $pdf->Cell(30, 10, 'Cantidad', 1);
        $pdf->Cell(40, 10, 'Precio Unit.', 1);
        $pdf->Cell(40, 10, 'Subtotal', 1);
        $pdf->Ln();

        // Agregar datos de los detalles
        $pdf->SetFont('Arial', '', 12);
        foreach ($VentaDetalles as $detalle) {
            $pdf->Cell(60, 10, $detalle['nombre_producto'], 1);
            $pdf->Cell(30, 10, $detalle['cantidad'], 1, 0, 'C');
            $pdf->Cell(40, 10, number_format($detalle['precio'], 2), 1, 0, 'R');
            $pdf->Cell(40, 10, number_format($detalle['sub_total'], 2), 1, 1, 'R');
        }

        // Obtener el total de la venta
        $sql_total = "SELECT SUM(sub_total) AS total FROM detalle_ventas WHERE id_venta = $id_venta";
        $rs_total = $this->ejecutarSQL($sql_total);
        $total_venta = $rs_total->fetch_assoc()['total'];

        // Mostrar el total de la venta
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(110, 10, 'Total a Pagar', 1, 0, 'R');
        $pdf->Cell(60, 10, number_format($total_venta, 2), 1, 1, 'R');

        // Mostrar el nombre del cliente
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, 'Cliente: ' . $VentaDetalles[0]['nombre_cliente'], 0, 1, 'L');

        // Limpiar el búfer de salida y generar el PDF
        $pdf->Output();
    }
}

// Asegúrate de que el id_venta esté disponible en la URL o el formulario
if (isset($_GET['id_venta'])) {
    $id_venta = $_GET['id_venta'];
    $pdf = new PDF();
    $pdf->generarPDF($id_venta);
} else {
    echo "No se ha proporcionado una ID de Venta.";
}
?>
