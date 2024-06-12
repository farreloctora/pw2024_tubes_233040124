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

// cek tombol submit sudah ditekan belum
if(isset($_POST["submit"])) {

  // cek apakah data ditambahkan tidak
  if(tambah($_POST) > 0) {
    echo "
    <script>
      alert('Data Berhasil Ditambahkan!');
      document.location.href = 'halamanservices.php';
    </script>
    ";
  } else {
    echo "
    <script>
      alert('Data Gagal Ditambahkan!');
      document.location.href = 'halamanservices.php';
    </script>
   ";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Mobil</title>
  <link rel="stylesheet" href="css/tambah.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
     
  </style>
</head>
<body>
  <h1>Tambah data mobil</h1>
    <div class="header-btn">
      <a href="halamanservices.php" class="sign-in">Kembali</a>
      <a href="logout.php" class="sign-in">Logout</a>
    </div>

  <form action="" method="post" enctype="multipart/form-data">
    <ul>
      <li>
        <label for="merk">Merk: </label>
        <input type="text" name="merk" id="merk" required>
      </li>
      <li>
        <label for="tahun">Tahun: </label>
        <input type="text" name="tahun" id="tahun" required>
      </li>
      <li>
        <label for="harga">Harga: </label>
        <input type="text" name="harga" id="harga">
      </li>
      <li>
        <label for="gambar">Gambar: </label>
        <input type="file" name="gambar" id="gambar">
      </li>
      <li>
        <button type="submit" name="submit">Tambah Data!</button>
      </li>
    </ul>
  </form>
  
</body>
</html>
