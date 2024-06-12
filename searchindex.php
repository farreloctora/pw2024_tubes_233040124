<?php
session_start();

require 'functions.php';

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



if(isset($_GET['keyword'])) {
  $keyword = $_GET['keyword'];
  $mobil_list = cari($keyword);

  foreach ($mobil_list as $mobil) {
    echo "
    <div class='box'>
      <div class='box-img'>
        <img src='img/{$mobil['gambar']}' alt=''>
      </div>
      <p>{$mobil['tahun']}</p>
      <h3>{$mobil['merk']}</h3>
      <h2>$". number_format($mobil['harga'], 2) ." <span>/day</span></h2>
      <a href='detail_mobil.php?id={$mobil['id']}' class='btn'>Rent now</a>
    </div>
    ";
  }
}
?>
