<?php
require_once "DB.php";
require "lib/fpdf/fpdf.php";

if (!isset($_GET["uid"])) {
  echo "<h1>Error 404: Object not found</h1>";
  exit();
}

$uid = $_GET["uid"];

$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$uid]);

if ($stmt->rowCount() == 0) {
  echo "<h1>Error 404: Object not found</h1>";
  exit();
}

class MyPDF extends FPDF
{
  // Page header
  function Header()
  {
    $this->SetMargins(20, 30, 10);
    // Logo image
    $this->Image("static/logo.png", 53, 10, 120);
    $this->Ln($h = 25);
    // Arial bold 15
    $this->SetFont("Arial", "B", 20);

    // Title
    $this->Cell(75);
    // Move to the right
    $this->Cell(30, 15, "Skill Development Course Registration", 0, 0, "C");

    $this->SetDrawColor(188, 188, 188);
    $this->Line(0, 52, 297, 52);
    $this->Line(0, 53, 297, 53);

    $this->Ln($h = 20);
  }

  // Page footer
  function Footer()
  {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
  }

  // User data
  function UserData($data)
  {
    $this->Image("static/photos/" . $data["photo"], 10, 10, 35);
    // Set font
    $this->SetFont("Arial", "", 12);

    // UID
    $this->Cell(40, 10, "Reg. ID:", 0);
    $this->Cell(60, 10, $data["uid"], 0, 1);

    // Name
    $this->Cell(40, 10, "Name:", 0);
    $this->Cell(60, 10, $data["NAME"], 0, 1);

    // Father
    $this->Cell(40, 10, "Father:", 0);
    $this->Cell(60, 10, $data["father"], 0, 1);

    // Mother
    $this->Cell(40, 10, "Mother:", 0);
    $this->Cell(60, 10, $data["mother"], 0, 1);

    // Contact
    $this->Cell(40, 10, "Contact:", 0);
    $this->Cell(60, 10, $data["contact"], 0, 1);

    // Birthday
    $this->Cell(40, 10, "Birthday:", 0);
    $this->Cell(60, 10, $data["birthday"], 0, 1);

    // Education
    $this->Cell(40, 10, "Education:", 0);
    $this->Cell(60, 10, $data["education"], 0, 1);

    // CGPA
    $this->Cell(40, 10, "CGPA:", 0);
    $this->Cell(60, 10, $data["cgpa"], 0, 1);

    // Interest
    $this->Cell(40, 10, "Interest:", 0);
    $this->Cell(60, 10, $data["interest"], 0, 1);

    // Amount
    $this->Cell(40, 10, "Amount:", 0);
    $this->Cell(60, 10, $data["amount"], 0, 1);

    // TRXID
    $this->Cell(40, 10, "TRXID:", 0);
    $this->Cell(60, 10, $data["trxid"], 0, 1);
    $this->Cell(40, 10, "Photo:", 0);
    $this->Cell(60, 10, $data["photo"], 0, 1);

    // Status
    $this->Cell(40, 10, "Status:", 0);
    $this->Cell(60, 10, $data["STATUS"], 0, 1);

    // Created at
    $this->Cell(40, 10, "Application Date:", 0);
    $this->Cell(60, 10, $data["created_at"], 0, 1);

    // Line break
    $this->Ln(20);
  }
}

$pdf = new MyPDF("P", "mm");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->UserData($stmt->fetch());
$pdf->Output($_GET["uid"] . ".pdf", "I");

?>
