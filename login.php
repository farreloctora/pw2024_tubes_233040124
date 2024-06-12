<?php 
session_start();

require 'functions.php';

// cek cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // ambil username berdasarkan id
  $result = mysqli_query($conn, "SELECT username FROM pengguna WHERE id = $id");
  $row = mysqli_fetch_assoc($result);

  // cek cookie dan username
  if($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}

if(isset($_SESSION['login'])) {
  header("Location: index.php");
  exit;
}

if(isset($_POST["login"])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$username'");

  // cek username
  if(mysqli_num_rows($result) === 1) {
    // cek password
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row['password'])) {
      // set session
      $_SESSION['login'] = true;
      $_SESSION['role'] = $row['role'];

      // cek remember me
      if(isset($_POST['remember'])) {
        // buat cookie

        setcookie('id', $row['id']);
        setcookie('key', hash('sha256', $row['username']));
      }

      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Login</title>
  <link rel="stylesheet" href="css/style.login">
  <link rel="stylesheet" href="css/login.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/jeep.png">
</head>
<body>

  <?php if(isset($error)):?>
    <p style="color: red; font-style: italic;">Username/Password Salah!</p>
  <?php endif;?>

  <div class="wrapper">
    <form action="" method="post">
      <h1>Login</h1>
        <div class="input-box">
          <input type="text" name="username" id="username" placeholder="Username" autofocus>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" id="password" placeholder="Password">
          <i class='bx bxs-lock-alt' ></i>
        </div>
        <div class="remember">
          <label for="remember"><input type="checkbox" name="remember" id="remember">Remember me</label>
        </div>

        <button type="submit" name="login" class="btn">Login</button>
        
        <div class="register-link">
          <p>Don't have an account? <a href="registrasi.php">Register</a></p>
        </div>
        <div class="register-link">
          <p>Go back to <a href="index.php">Main Page</a></p>
        </div>
    </form>
  </div>
  
</body>
</html>
