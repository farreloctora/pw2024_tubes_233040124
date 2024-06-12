<?php
session_start();
// Periksa apakah pengguna sudah login
if(!isset($_SESSION['login'])) {
  // Jika belum, redirect ke halaman login
  header("Location: login.php");
  exit; // Hentikan eksekusi skrip
}

// Periksa apakah pengguna memiliki peran sebagai admin
if($_SESSION['role'] !== 'admin') {
  // Jika tidak, redirect ke halaman yang sesuai
  header("Location: index.php");
  exit; // Hentikan eksekusi skrip
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tangkap parameter id dan status baru
$id = $_GET['id'];
$newStatus = $_GET['status'];

// Query untuk memperbarui status booking
$updateQuery = "UPDATE booking SET status = '$newStatus' WHERE id = $id";

// Jalankan query untuk memperbarui status
if (mysqli_query($conn, $updateQuery)) {
    echo "<script>
    alert('Status Berhasil Diubah!');
    document.location.href = 'booking.php';
  </script>";
} else {
    echo "Terjadi kesalahan: " . mysqli_error($conn);
}

// Tutup koneksi
mysqli_close($conn);
?>