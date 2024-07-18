<?php
require_once("../controladores/conexion.php");

class PDF extends conexion {
    public function generarPDF($id_compra) {
        require('fpdf/fpdf.php'); // Ruta correcta

        // Crear instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        // Obtener los detalles de la compra
        $sql = "SELECT dc.*, p.descripcion, pr.nombre AS proveedor 
                FROM detalle_compras dc
                INNER JOIN productos p ON dc.id_producto = p.id
                INNER JOIN compras co ON dc.id_compra = co.id
                INNER JOIN proveedores pr ON p.id_proveedor = pr.id
                WHERE dc.id_compra = $id_compra";
        $rs = $this->ejecutarSQL($sql);
        $compraDetalles = [];
        while ($fila = $rs->fetch_assoc()) {
            $compraDetalles[] = $fila;
        }

        // Obtener la información de la empresa
        $sql_empresa = "SELECT * FROM configuracion";
        $rs_empresa = $this->ejecutarSQL($sql_empresa);
        $empresa = $rs_empresa->fetch_assoc();

        // Título del documento (Factura)
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Factura de Compra', 0, 1, 'C');

        // Datos de la empresa
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 8, $empresa['nombre'], 0, 1, 'C');
        $pdf->Cell(190, 8, 'RUC: ' . $empresa['ruc'], 0, 1, 'C');
        $pdf->Cell(190, 8, 'Dirección: ' . $empresa['direccion'], 0, 1, 'C');
        $pdf->Ln(5);

        // Datos de la compra
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 8, 'Número de Factura:', 0, 0);
        $pdf->Cell(40, 8, $id_compra, 0, 0);
        $pdf->Cell(50, 8, 'Fecha:', 0, 0);
        $pdf->Cell(60, 8, date('d/m/Y'), 0, 1);
        $pdf->Ln(5);

        // Encabezados de la tabla de detalles
        $pdf->SetFont('Arial', 'B', 12);
        
        $pdf->Cell(70, 8, 'Descripción', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Precio Unit.', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Subtotal', 1, 1, 'C');

        // Detalles de la compra
        $pdf->SetFont('Arial', '', 12);
        foreach ($compraDetalles as $detalle) {
            
            $pdf->Cell(70, 8, substr($detalle['descripcion'], 0, 35), 1);
            $pdf->Cell(20, 8, $detalle['cantidad'], 1, 0, 'C');
            $pdf->Cell(30, 8, number_format($detalle['precio'], 2), 1, 0, 'R');
            $pdf->Cell(40, 8, number_format($detalle['subtotal'], 2), 1, 1, 'R');
        }

        // Calcular y mostrar el total de la compra
        $total_compra = 0;
        foreach ($compraDetalles as $detalle) {
            $total_compra += $detalle['subtotal'];
        }
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 8, 'Total a Pagar', 1, 0, 'R');
        $pdf->Cell(40, 8, number_format($total_compra, 2), 1, 1, 'R');

        // Mostrar en el navegador (descargar)
        $pdf->Output();
    }
}

// Asegúrate de que el id_compra esté disponible en la URL o el formulario
if (isset($_GET['id_compra'])) {
    $id_compra = $_GET['id_compra'];
    $pdf = new PDF();
    $pdf->generarPDF($id_compra);
} else {
    echo "No se ha proporcionado una ID de compra.";
}
?>
