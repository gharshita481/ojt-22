<?php
session_start();
include("connection.php");
require('fpdf186/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['product_id']; // Dynamic Order ID
    $customer_name = $_POST['user_name']; // Fetch from DB
    $amount = $_POST['total_sum'];
    $product_name = $_POST['product_name']; // Fetch from DB
    $date = date("Y-m-d");
    $company_name = "Bellelise";
    $company_address = "Bailey Road, Patna - 80001";
    $company_phone = "+1 234 567 890";
    $company_email = "support@bellelise.com";

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Add Background Color
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Rect(0, 0, 210, 297, 'F');

    // Company Name
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->SetTextColor(50, 50, 50);
    $pdf->Cell(190, 10, $company_name, 0, 1, 'C');

    // Company Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(190, 8, $company_address, 0, 1, 'C');
    $pdf->Cell(190, 8, "Phone: " . $company_phone, 0, 1, 'C');
    $pdf->Cell(190, 8, "Email: " . $company_email, 0, 1, 'C');
    $pdf->Ln(10);

    // Invoice Title with Border
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(238, 238, 238);
$pdf->SetDrawColor(238, 238, 238); // Set border color
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(190, 10, "INVOICE", 1, 1, 'C', true);
$pdf->Ln(5);


    // Order Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetDrawColor(238, 238, 238);
    $pdf->Cell(95, 10, "Order ID: " . $order_id, 1, 0, 'L');
    $pdf->Cell(95, 10, "Date: " . $date, 1, 1, 'L');
    $pdf->Cell(190, 10, "Customer: " . $customer_name, 1, 1, 'L');
    $pdf->Ln(5);

    // Table Header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(238, 238, 238);
    $pdf->Cell(100, 10, "Item", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "Qty", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "Price", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "Total", 1, 1, 'C', true);

    // Sample Product Row
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 10, $product_name , 1, 0, 'C');
    $pdf->Cell(30, 10, "1", 1, 0, 'C');
    $pdf->Cell(30, 10, "Rs. " . $amount, 1, 0, 'C');
    $pdf->Cell(30, 10, "Rs. " . $amount, 1, 1, 'C');

    // Grand Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(238, 238, 238);
    $pdf->Cell(160, 10, "GRAND TOTAL", 1, 0, 'R', true);
    $pdf->Cell(30, 10, "Rs. " . $amount, 1, 1, 'C', true);
    
    $pdf->Ln(10);

    // Signature
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, "Authorized Signature", 0, 1, 'L');
    $pdf->Ln(20);
    $pdf->Cell(70, 10, "________________________", 0, 1, 'L');
    $pdf->Cell(70, 5, "Company Representative", 0, 1, 'L');

    $pdf->Ln(10);

    // Footer
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(190, 10, "Thank you for shopping with us!", 0, 1, 'C');
    $pdf->Cell(190, 10, "For any queries, contact us at: " . $company_email, 0, 1, 'C');

    // Save & Download PDF
    $filename = "invoice_" . $order_id . ".pdf";
    $pdf->Output("D", $filename);
    exit;
}
?>
