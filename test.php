<?php require "lib/fpdf/fpdf.php";

$pdf = new FPDF();
$pdf->AddPage("P", "A4");
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont("Arial", "", 12);
$pdf->SetTopMargin(10);
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);

/* --- Text --- */
$pdf->SetFontSize(24);
$pdf->Text(91, 25, "Skill Development Course");
/* --- Text --- */
$pdf->Text(91, 36, " Registration Form");

$pdf->Output("created_pdf.pdf", "I");
?>
