<?php
require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';
$pdf = new FPDF('P', 'mm', array(80, 200));
$pdf->AddPage();
$pdf->SetMargins(5, 0, 0);
$pdf->SetTitle("Ventas");
$pdf->SetFont('Arial', 'B', 12);
$id = $_GET['v'];
$idcliente = $_GET['cl'];
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);
$clientes = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
$datosC = mysqli_fetch_assoc($clientes);
$ventas = mysqli_query($conexion, "SELECT d.*, p.codproducto, p.descripcion FROM detalle_venta d INNER JOIN producto p ON d.id_producto = p.codproducto WHERE d.id_venta = $id");

$pdf->Cell(65, 5, utf8_decode($datos['nombre']), 0, 1, 'C');
$pdf->Ln();
$pdf->image("../../assets/img/logo.png", 34, 20, 16, 7, 'PNG');
$pdf->Ln();
/*
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, $datos['telefono'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, utf8_decode("Dirección: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, utf8_decode($datos['direccion']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, "Correo: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, utf8_decode($datos['email']), 0, 1, 'L');
*/
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(15, 59, 197);

$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(70, 4, "Datos del cliente", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(15, 4, utf8_decode("N° Cédula: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(15, 4, utf8_decode($datosC['cedula']), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(15, 4, utf8_decode("Nombre: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(15, 4, utf8_decode($datosC['nombre']), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(15, 4, utf8_decode('Teléfono:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(15, 4, utf8_decode($datosC['telefono']), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(15, 4, utf8_decode('Dirección:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(15, 4, utf8_decode($datosC['direccion']), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(15, 4, utf8_decode('E-mail:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(15, 4, utf8_decode($datosC['email']), 0, 1, 'L');



$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(70, 4, "Detalle de Producto", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);



$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(28,4, utf8_decode('Descripción'), 0, 0, 'L');
$pdf->Cell(10, 4, 'Tipo', 0, 0, 'L');
$pdf->Cell(8, 4, 'Cant.', 0, 0, 'L');
$pdf->Cell(8, 4, 'Precio/u', 0, 0, 'L');
$pdf->Cell(8, 4, 'Iva/u', 0, 0, 'L');
$pdf->Cell(8, 4, 'Total.', 0, 1, 'L');
$pdf->SetFont('Arial', '', 4);
$total = 0.00;
$desc = 0.00;
$total_subtotal= 0.00;
$total_iva= 0.00;

while ($row = mysqli_fetch_assoc($ventas)) {
 //   $pdf->Multicell(120, 5, utf8_decode('Descripción'), 0, 'l', false);
    $pdf->Cell(30, 4, utf8_decode($row['descripcion']), 0, 0, 'L');
    $pdf->Cell(8, 4, utf8_decode($row['tipo_prod']), 0, 0, 'L');
    $pdf->Cell(8, 4, utf8_decode($row['cantidad']), 0, 0, 'L');
    $pdf->Cell(8, 4, "$".number_format(utf8_decode($row['precioPVP']), 2, '.', ','), 0, 0, 'L');
    $pdf->Cell(8, 4, "$".number_format(utf8_decode($row['iva'] * $row['cantidad']), 2, '.', ','), 0, 0, 'L');
    $sub_total = $row['total'];
    $total_iva= $total_iva+$row['iva'] * $row['cantidad'];
    $total_subtotal= $total_subtotal + $sub_total;
    $total = $total +$sub_total;

 //   $desc = $desc + ($row['descuento']* $row['cantidad']);
    $desc = $desc + ($row['descuento']);
    $pdf->Cell(15, 4, utf8_decode("$".number_format($sub_total, 2, '.', ',')), 0, 1, 'L');
}


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(55, 4, utf8_decode("Sub Total: "), 0, 0, 'R');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(10, 4, "$".number_format(($total_subtotal - $total_iva), 2, '.', ','), 0, 1, 'R');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(55, 4, utf8_decode("IVA: "), 0, 0, 'R');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(10, 4, "$".number_format($total_iva, 2, '.', ','), 0, 1, 'R');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(55, 4, utf8_decode('Descuento Total:'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(10, 4, "$".number_format($desc, 2, '.', ','), 0, 1, 'R');


$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(55, 4, utf8_decode('Total Pagar:'), 0, 0, 'R');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(11, 4, "$".number_format($total, 2, '.', ','), 0, 1, 'R');

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(46, 4, utf8_decode('***Gracias por su compra***'), 0, 0, 'R');


$pdf->Output("ventas.pdf", "I");

?>