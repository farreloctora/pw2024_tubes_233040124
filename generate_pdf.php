<?php
require('fpdf/fpdf.php');

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data booking
$query = "SELECT * FROM booking";
$result = mysqli_query($conn, $query);

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 6);

// Header tabel
$pdf->Cell(7, 6, 'ID', 1);
$pdf->Cell(10, 6, 'ID Mobil', 1);
$pdf->Cell(20, 6, 'Location', 1);
$pdf->Cell(20, 6, 'Pick-Up Date', 1);
$pdf->Cell(20, 6, 'Return Date', 1);
$pdf->Cell(40, 6, 'Booking Date', 1);
$pdf->Cell(30, 6, 'Nama Lengkap', 1);
$pdf->Cell(30, 6, 'Email', 1);
$pdf->Cell(15, 6, 'Status', 1);
$pdf->Ln();

// Set font for table rows
$pdf->SetFont('Arial', '', 6);

// Tampilkan data booking
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(7, 6, $row["id"], 1);
        $pdf->Cell(10, 6, $row["mobil_id"], 1);
        $pdf->Cell(20, 6, $row["location"], 1);
        $pdf->Cell(20, 6, $row["pick_up_date"], 1);
        $pdf->Cell(20, 6, $row["return_date"], 1);
        $pdf->Cell(40, 6, $row["booking_date"], 1);
        $pdf->Cell(30, 6, $row["namalengkap"], 1);
        $pdf->Cell(30, 6, $row["email"], 1);
        $pdf->Cell(15, 6, $row["status"], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 6, 'Tidak ada data booking', 1);
}

// Output PDF
$pdf->Output('D', 'Booking_Report.pdf');

// Tutup koneksi
mysqli_close($conn);
?>
