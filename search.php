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
  $mobil = cari($keyword);

  $output = '
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No.</th>
      <th>Aksi</th>
      <th>Gambar</th>
      <th>Nama Mobil</th>
      <th>Tahun</th>
      <th>Harga</th>
      <th>ID</th>
    </tr>';

  $i = 1;
  foreach($mobil as $row) {
    $output .= '
    <tr>
      <td>' . $i . '</td>
      <td>
        <a href="ubah.php?id=' . $row["id"] . '">Ubah</a> | 
        <a href="hapus.php?id=' . $row["id"] . '" onclick="return confirm(\'Apakah anda yakin ingin menghapus?\');">Hapus</a>
      </td>
      <td><img src="img/' . $row["gambar"] . '" alt="' . $row["merk"] . '" width="150"></td>
      <td>' . $row["merk"] . '</td>
      <td>' . $row["tahun"] . '</td>
      <td>' . $row["harga"] . '</td>
      <td>' . $row["id"] . '</td>
    </tr>';
    $i++;
  }
  $output .= '</table>';

  echo $output;
}
?>