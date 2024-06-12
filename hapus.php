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

require 'functions.php';

$id = $_GET["id"];

if(hapus($id) > 0) {
  echo "
    <script>
      alert('Data Berhasil Dihapus!');
      document.location.href = 'halamanadmin.php';
    </script>
  ";
} else {
  echo "
    <script>
      alert('Data Gagal Dihapus!');
      document.location.href = 'halamanadmin.php';
    </script>
  ";
}
?>