<?php 
session_start();

require 'functions.php';



// // Periksa jika pengguna sudah login
// if(isset($_SESSION['login'])) {
//   // Jika sudah login, langsung arahkan ke halaman index
//   header("Location: index.php");
//   exit;
// }
$mobil_list = query("SELECT * FROM mobil");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoteCar</title>

  <head>
    <link rel="icon" href="img/jeep.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  </head>
</head>
<body>
  <header>
    <a href="" class="logo"><img src="img/jeep.png" alt=""></a>

    <div class="bx bx-menu" id="menu-icon"></div>

    <!-- navbar -->
    <ul class="navbar">
        <li><a href="#home">Home</a></li>
        <li><a href="#ride">Ride</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#about">About</a></li>
        <li><?php 
            if (isset($_SESSION['login']) && ($_SESSION['role'] == 'admin')) {
                // Tampilkan navbar admin
                echo '<a href="halamanadmin.php">Halaman Admin</a>';
              }?>
        </li>
        
    </ul>
    <div class="header-btn">
    <?php if(isset($_SESSION['login'])): ?>
            <a href="logout.php" class="sign-in">Sign Out</a>
        <?php else: ?>
            <a href="login.php" class="sign-in">Sign In</a>
            <a href="registrasi.php" class="sign-up">Sign Up</a>
        <?php endif; ?>
    </div>
  </header>

  <!-- home -->
  <section class="home" id="home">
    <div class="text">
      <h1><span>Looking</span> to <br>rent a car</h1>
      <p>You've come to the right place! <br> Our service offers a wide selection of vehicles to meet your needs and budget.</p>
      <div class="app-stores">
        <img src="img/ios.png" alt="">
        <img src="img/512x512.png" alt="">
      </div>
    </div>

    <!-- <div class="form-container" id="formContainer">
    <form action="">
      <div class="input-box">
        <span>Location</span>
        <input type="search" name="" id="" placeholder="Search Places">
      </div>
      <div class="input-box">
        <span>Pick-Up Date</span>
        <input type="date" name="" id="">
      </div>
      <div class="input-box">
        <span>Return Date</span>
        <input type="date" name="" id="">
      </div>
      <button type="submit" class="btn">Submit</button>
    </form>
  </div> -->
  </section>

  <!-- ride -->
  <section class="ride" id="ride">
    <div class="heading">
      <span>How Its Work</span>
      <h1>Rent With 3 Easy Steps</h1>
    </div>
    <div class="ride-container">
      <div class="box">
        <i class='bx bxs-map'></i>
        <h2>Choose a location</h2>
        <p>Select your locations to pick up your rental car. We have numerous branches to ensure convenience for you.</p>
      </div>
      <div class="box">
        <i class='bx bxs-calendar-check' ></i>
        <h2>Pick Up Date</h2>
        <p>Choose the date you wish to pick up the car. We offer flexible pick-up times to accommodate your schedule.</p>
      </div>
      <div class="box">
        <i class='bx bxs-calendar-star' ></i>
        <h2>Book A Car</h2>
        <p>Complete your booking by selecting the car that suits your needs. Enjoy a seamless booking experience.</p>
      </div>
    </div>
  </section>

  <!-- services -->
  <section class="services" id="services">
    <div class="heading">
      <span>Best Services</span>
      <h1>Explore Out Top Deals <br> From Top Rated Dealers</h1>
    </div>
    <div class="search-container">
      <input type="text" id="searchInput" placeholder="Search...">
    </div>
    <div class="services-container">
      <?php foreach ($mobil_list as $mobil) : ?>
      <div class="box">
        <div class="box-img">
          <img src="img/<?= $mobil['gambar']; ?>" alt="">
        </div>
        <p><?= $mobil['tahun']; ?></p>
        <h3><?= $mobil['merk']; ?></h3>
        <h2>$<?= number_format($mobil['harga'], 2); ?> <span>/day</span></h2>
        <a href="detail_mobil.php?id=<?= $mobil['id']; ?>" class="btn">Rent now</a>
      </div>
      <?php endforeach; ?>
    </div>
  </section>


  <!-- About -->
  <section class="about" id="about">
    <div class="heading">
      <span>About Us</span>
      <h1>Best Customer Experience</h1>
    </div>
    <div class="about-container">
      <div class="about-img">
        <img src="img/about.png" alt="">
      </div>
      <div class="about-text">
        <span>About Us</span>
        <p>We are dedicated to providing the best customer experience in car rentals. Our team works tirelessly to ensure you have a smooth and enjoyable rental experience.</p>
        <p>Our fleet of cars is regularly maintained and updated to provide you with the latest models and the best possible performance.</p>
        <a href="#" class="btn">Learn More</a>
      </div>
    </div>
  </section>

  <section class="divider">

  </section>

  <div class="copyright">
    <p>&#169; All Right Reserved</p>
    <div class="social">
      <a href=""><i class='bx bxl-facebook' ></i></a>
      <a href=""><i class='bx bxl-twitter'></i></a>
      <a href=""><i class='bx bxl-instagram' ></i></a>
    </div>
  </div>

  <script src="js/main.js"></script>
  <script src="js/jquery-3.7.1.min.js"></script>
  <script>
  $(document).ready(function(){
    $('#searchInput').on('keyup', function(){
      var keyword = $(this).val();
      $.ajax({
        url: 'searchindex.php',
        type: 'GET',
        data: { keyword: keyword },
        success: function(data) {
          $('.services-container').html(data);
        }
      });
    });
  });
  </script>
</body>
</html>