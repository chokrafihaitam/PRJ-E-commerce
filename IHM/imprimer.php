<?php
require('../tfpdf/tfpdf.php'); // Include the FPDF library

// Fetch invoice data from the database (example)
$idcmd = $_GET['id']; // Get the command ID from the URL
include "../acces_bd/connexion.php"; // Include your database connection

// Fetch command details
$sql = "SELECT * FROM commandes WHERE id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $idcmd);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$commande = mysqli_fetch_assoc($result);

// Fetch line items for the command
$sql2 = "SELECT * FROM ligne_cmd WHERE id_cmd = ?";
$stmt2 = mysqli_prepare($link, $sql2);
mysqli_stmt_bind_param($stmt2, "i", $idcmd);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$items = [];
while ($row = mysqli_fetch_assoc($result2)) {
    $items[] = $row;
}

// Create a new PDF instance
$pdf = new tFPDF();
$pdf->AddPage();

// Set font for the title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Facture', 0, 1, 'C');

// Add a UTF-8 font (e.g., DejaVuSans)
$pdf->AddFont('DejaVuSans', '', 'DejaVuSans.ttf', true);
$pdf->SetFont('DejaVuSans', '', 14);

// Set encoding to UTF-8
$pdf->SetFont('DejaVuSans', '', 12);

// Add invoice title
//$pdf->Cell(0, 10, 'فاتورة', 0, 1, 'C'); // Example of Arabic text

// Add invoice details
//$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nº Facture: ' . $commande['datecmd'], 0, 1);
$pdf->Cell(0, 10, 'Date: ' . date("d/m/Y", strtotime($commande['datecmd'])), 0, 1);
$pdf->Cell(0, 10, 'Status: ' . $commande['status'], 0, 1);

// Add a table for line items
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Produit', 1, 0, 'C');
$pdf->Cell(40, 10, 'Quantite', 1, 0, 'C');
$pdf->Cell(40, 10, 'Prix Unitaire', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$totalAmount = 0;
foreach ($items as $item) {
    // Fetch product details (example)
    $sql3 = "SELECT * FROM products WHERE id = ?";
    $stmt3 = mysqli_prepare($link, $sql3);
    mysqli_stmt_bind_param($stmt3, "i", $item['id_produit']);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    $product = mysqli_fetch_assoc($result3);

    $unitPrice = $product['price'];
    $quantity = $item['quantites'];
    $total = $unitPrice * $quantity;
    $totalAmount += $total;

    $pdf->Cell(40, 10, $product['name'], 1, 0, 'C');
    $pdf->Cell(40, 10, $quantity, 1, 0, 'C');
    $pdf->Cell(40, 10,  number_format($unitPrice, 2). 'DH', 1, 0, 'C');
    $pdf->Cell(40, 10,  number_format($total, 2). 'DH', 1, 1, 'C');
    
}

// Add total amount
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(120, 10, 'Montant Total:', 1, 0, 'R');
$pdf->Cell(40, 10,  number_format($totalAmount, 2).'DH', 1, 1, 'C');

// Output the PDF
$pdf->Output('D', 'Facture_' . $commande['id'] . '.pdf'); // 'D' forces download