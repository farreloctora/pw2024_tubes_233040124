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
$mobil = query("SELECT * FROM mobil");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mobil - Rental Mobil</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/halamanservices.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <header>
    <h1>Daftar Mobil</h1>
    <div class="header-btn">
      <a href="tambah.php" class="sign-up">Tambah Data Mobil</a>
      <a href="halamanadmin.php" class="sign-in">Admin</a>
      <a href="logout.php" class="sign-in">Logout</a>
    </div>
  </header>

  <form action="" method="post">
    <input type="text" name="keyword" id="keyword" size="40" autofocus placeholder="Masukkan kata kunci pencarian..." autocomplete="off">
  </form>

  <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Gambar</th>
        <th>Nama Mobil</th>
        <th>Tahun</th>
        <th>Harga</th>
        <th>ID</th>
      </tr>
      <?php 
      $i = 0;
      foreach($mobil as $row): 
      $i++;
      ?>
      <tr>
        <td><?= $i?></td>
        <td>
          <a href="ubah.php?id=<?= $row["id"];?>">Ubah</a> | 
          <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus?');">Hapus</a>
        </td>
        <td><img src="img/<?= $row["gambar"];?>" alt="<?= $row["merk"];?>" width="150"></td>
        <td><?= $row["merk"];?></td>
        <td><?= $row["tahun"];?></td>
        <td><?= $row["harga"];?></td>
        <td><?= $row["id"]; ?></td>
      </tr>
      <?php endforeach;?>
    </table>
  </div>

  <script>
    $(document).ready(function(){
      $('#keyword').on('keyup', function(){
        var keyword = $(this).val();
        $.ajax({
          url: 'search.php',
          type: 'GET',
          data: { keyword: keyword },
          success: function(data) {
            $('#container').html(data);
          }
        });
      });
    });
  </script>
</body>
</html>
