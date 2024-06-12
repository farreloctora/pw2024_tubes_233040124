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


// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data booking
$query = "SELECT * FROM booking";
$result = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/halamanservices.css">
    <link rel="stylesheet" href="css/booking.css">
</head>

<body>
  <header>
    <h1>Booking List</h1>
    <div class="header-btn">
      <a href="generate_pdf.php" class="sign-in">Generate PDF Report</a>
      <a href="halamanadmin.php" class="sign-in">Admin</a>
      <a href="logout.php" class="sign-in">Logout</a>
    </div>
  </header>
    <table>
        <tr>
            <th>ID</th>
            <th>ID Mobil</th>
            <th>Location</th>
            <th>Pick-Up Date</th>
            <th>Return Date</th>
            <th>Booking Date</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi Status</th>
        </tr>
        <?php
        // Tampilkan data booking
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["mobil_id"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "<td>" . $row["pick_up_date"] . "</td>";
                echo "<td>" . $row["return_date"] . "</td>";
                echo "<td>" . $row["booking_date"] . "</td>";
                echo "<td>" . $row["namalengkap"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>";
                echo "<a href='update_status.php?id=" . $row['id'] . "&status=confirmed'>Confirm</a> | ";
                echo "<a href='update_status.php?id=" . $row['id'] . "&status=cancelled'>Cancel</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data booking</td></tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
// Tutup koneksi
mysqli_close($conn);
?>