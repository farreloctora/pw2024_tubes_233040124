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

// query data mahasiswa berdasarkan id
$row = query("SELECT * FROM mobil WHERE id = $id")[0];

// cek tombol submit sudah ditekan belum
if(isset($_POST["submit"])) {
 
  // cek apakah data diubah tidak
  if(ubah($_POST) > 0) {
    echo "
    <script>
      alert('Data Berhasil Diubah!');
      document.location.href = 'halamanservices.php';
    </script>
    ";
  } else {
    echo "
    <script>
      alert('Data Gagal Diubah!');
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
  <title>Ubah Data Mobil</title>
  <link rel="stylesheet" href="css/ubah.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Ubah data Mobil</h1>
    <div class="header-btn">
      <a href="halamanservices.php" class="sign-in">Kembali</a>
      <a href="logout.php" class="sign-in">Logout</a>
    </div>

  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="<?= $row["id"];?>">
    <input type="hidden" name="gambarLama" id="id" value="<?= $row["gambar"];?>">
    <ul>
      <li>
        <label for="tahun">Tahun: </label>
        <input type="text" name="tahun" id="tahun" required value="<?= $row["tahun"];?>">
      </li>
      <li>
        <label for="merk">Merk: </label>
        <input type="text" name="merk" id="merk" required value="<?= $row["merk"];?>">
      </li>
      <li>
        <label for="harga">Harga: </label>
        <input type="text" name="harga" id="harga" value="<?= $row["harga"];?>">
      </li>
      <li>
        <label for="gambar">Gambar: </label> <br>
        <img src="img/<?= $row['gambar'];?>" width="100" alt=""> <br>
        <input type="file" name="gambar" id="gambar" value="<?= $row["gambar"];?>">
      </li>
      <li>
        <button type="submit" name="submit">Simpan Perubahan</button>
      </li>
    </ul>
  </form>

</body>
</html>