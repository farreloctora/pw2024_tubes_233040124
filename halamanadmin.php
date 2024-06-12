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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/halamanadmin.css">
</head>
<body>
  <header>
    <h1>Halaman Admin</h1>
    <div class="header-btn">
      <a href="index.php" class="sign-in">Home</a>
      <a href="logout.php" class="sign-in">Logout</a>
    </div>
  </header>

  <section class="container">
    <div class="card">
      <h2>Cars Page</h2>
      <p>Click the button below to go to the Cars page.</p>
      <a href="halamanservices.php" class="btn">Go to Services</a>
    </div>
    <div class="card">
      <h2>User Page</h2>
      <p>Click the button below to go to the User page.</p>
      <a href="pengguna.php" class="btn">Go to User Page</a>
    </div>
    <div class="card">
      <h2>Booking Page</h2>
      <p>Click the button below to go to the User page.</p>
      <a href="booking.php" class="btn">Go to Booking Page</a>
    </div>
  </section>

  
  <script src="js/main.js"></script>
</body>
</html>