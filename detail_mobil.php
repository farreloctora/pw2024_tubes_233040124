<?php 
session_start();

require 'functions.php';

// Periksa apakah pengguna sudah login
if(!isset($_SESSION['login'])) {
  // Jika belum, redirect ke halaman login
  header("Location: login.php");
  exit; // Hentikan eksekusi skrip
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

// Periksa apakah parameter ID mobil telah diberikan
if(isset($_GET['id'])) {
  // Ambil ID mobil dari parameter
  $mobilId = $_GET['id'];

  // Query untuk mengambil deskripsi mobil dari database berdasarkan ID
  $query = "SELECT * FROM mobil WHERE id = $mobilId";
  $result = mysqli_query($conn, $query);

  // Periksa apakah hasil query mengembalikan baris data
  if(mysqli_num_rows($result) > 0) {
    // Ambil data deskripsi mobil
    $mobil = mysqli_fetch_assoc($result);

    // Handling form submission
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      // Ambil data dari form
      $namalengkap = $_POST['namalengkap'];
      $email = $_POST['email'];
      $location = $_POST['location'];
      $pickUpDate = $_POST['pick_up_date'];
      $returnDate = $_POST['return_date'];

      // Query untuk menyimpan data booking ke dalam tabel booking
      $insertQuery = "INSERT INTO booking (mobil_id, location, pick_up_date, return_date, namalengkap, email) 
                VALUES ($mobilId, '$location', '$pickUpDate', '$returnDate', '$namalengkap', '$email')";
      
      // Jalankan query untuk menyimpan data
      if(mysqli_query($conn, $insertQuery)) {
        echo "<script>alert('Booking berhasil disimpan!');</script>";
      } else {
        echo "<script>alert('Terjadi kesalahan: " . mysqli_error($conn) . "');</script>";
      }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Detail Mobil</title>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/detail_mobil.css">
      <link rel="icon" href="img/jeep.png">
    </head>
    <body>
      <header>
        <h1>Book <span>Now!</span></h1>
        <div class="header-btn">
          <a href="index.php" class="sign-in">Home</a>
          <a href="logout.php" class="sign-in">Sign Out</a>
        </div>
      </header>
      <div class="services-container">
        <div class="box">
          <div class="box-img">
            <img src="img/<?= $mobil['gambar']; ?>" alt="">
          </div>
          <p><?= $mobil['tahun']; ?></p>
          <h3><?= $mobil['merk']; ?></h3>
          <h2>$<?= number_format($mobil['harga'], 2); ?> <span>/day</span></h2>
          <a href="detail_mobil.php?id=<?= $mobil['id']; ?>" class="btn">Rent now</a>
        </div>
      </div>
      <div class="form-container">
        <form action="" method="post">
          <div class="input-box">
            <span>Full Name</span>
            <input type="text" name="namalengkap" placeholder="Enter your full name" required>
          </div>
          <div class="input-box">
            <span>Email</span>
            <input type="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="input-box">
            <span>Location</span>
            <input type="text" name="location" placeholder="Enter location" required>
          </div>
          <div class="input-box">
            <span>Pick-Up Date</span>
            <input type="date" name="pick_up_date" required>
          </div>
          <div class="input-box">
            <span>Return Date</span>
            <input type="date" name="return_date" required>
          </div>
          <button type="submit" class="btn">Submit</button>
        </form>
      </div>
    </body>
    </html>
    <?php
  } else {
    // Jika tidak ada data yang ditemukan, tampilkan pesan kesalahan
    echo "Deskripsi mobil tidak ditemukan";
  }
} else {
  // Jika parameter ID tidak diberikan, tampilkan pesan kesalahan
  echo "ID mobil tidak diberikan";
}
?>