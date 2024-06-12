<?php
// Mulai sesi
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

// Sambungkan ke database dan ambil data pengguna
require 'functions.php';
$users = query("SELECT * FROM pengguna");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pengguna</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/halamanservices.css">
  <link rel="stylesheet" href="css/pengguna.css">
</head>
<body>
  <header>
    <h1>Data Pengguna</h1>
    <div class="header-btn">
      <a href="halamanadmin.php" class="sign-in">Admin</a>
      <a href="logout.php" class="sign-in">Logout</a>
    </div>
  </header>

  <section class="container">
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Password</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $user['username']; ?></td>
            <td><?= $user['password']; ?></td>
            <td><?= $user['role']; ?></td>
            <td><a href="change_role.php?id=<?= $user['id']; ?>&role=<?= $user['role'] == 'admin' ? 'user' : 'admin'; ?>" class="btn-role">Ubah Role</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

  <script src="js/main.js"></script>
</body>
</html>
