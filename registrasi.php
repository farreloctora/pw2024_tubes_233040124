<?php 
require 'functions.php';

if(isset($_POST['register'])) {
  if(registrasi($_POST) > 0) {
    echo "
    <script>
      alert('User Baru Berhasil Ditambahkan!');
      document.location.href = 'login.php';
    </script>
    ";
  } else {
    echo "
    <script>
      alert('Registrasi Gagal!');
      document.location.href = 'registrasi.php';
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
  <title>Halaman Registrasi</title>
  <style>
    label {
      display: block;
    }
  </style>
  <link rel="stylesheet" href="css/login.css">
  <link rel="icon" href="img/jeep.png">
</head>
<body>

  <div class="wrapper">
    <form action="" method="post">
      <h1>Halaman Registrasi</h1>
      <div class="input-box">
        <input type="text" name="username" id="username" placeholder="Username" autofocus>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" id="password" placeholder="Password">
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="password" name="password2" id="password2" placeholder="Confirm Password">
        <i class='bx bxs-lock-alt' ></i>
      </div>

      <button type="submit" name="register" class="btn">Register!</button>

      <div class="register-link">
        <p>Have an account? <a href="login.php">Login</a></p>
      </div>
      <div class="register-link">
          <p>Go back to <a href="index.php">Main Page</a></p>
        </div>
    </form>
  </div>
  

  
  
</body>
</html>
