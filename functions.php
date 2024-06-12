<?php 
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;

    // Ambil tiap elemen dalam form
    $merk = htmlspecialchars($data["merk"]);
    $tahun = htmlspecialchars($data["tahun"]);
    $harga = htmlspecialchars($data["harga"]);

    // Upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    // Query insert data
    $query = "INSERT INTO mobil (merk, tahun, harga, gambar) 
              VALUES ('$merk', '$tahun', '$harga', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];
  
    // cek apakah ada gambar yang di upload
    if($error === 4) {
      echo "
      <script>
        alert('Pilih gambar terlebih dahulu!');
        document.location.href = 'index.php';
      </script>";
      return false;
    }
  
    // cek apakah yang diupload gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
      echo "
      <script>
        alert('Tolong Upload File Gambar jpg/jpeg/png!');
        document.location.href = 'index.php';
      </script>";
      return false;
    }
  
    // cek jika ukurannya terlalu besar
    if($ukuranFile > 5242880){
      echo "
      <script>
        alert('Ukuran Gambar Terlalu Besar!');
        document.location.href = 'index.php';
      </script>";
      return false;
    }
  
    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
  
    // Ganti path penyimpanan gambar menjadi 'uploads/'
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
  
    return $namaFileBaru;
  }  

function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mobil WHERE id = $id");  
    return mysqli_affected_rows($conn);
}

function ubah($data){
    global $conn;

    $id = $data["id"];
    $merk = htmlspecialchars($data["merk"]);
    $tahun = htmlspecialchars($data["tahun"]);
    $harga = htmlspecialchars($data["harga"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // Cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // Query update data
    $query = "UPDATE mobil 
              SET merk = '$merk',
                  tahun = '$tahun',
                  harga = '$harga',
                  gambar = '$gambar'
              WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM mobil 
              WHERE 
              merk LIKE '%$keyword%' OR
              tahun LIKE '%$keyword%' OR
              harga LIKE '%$keyword%'";
    
    return query($query);
}

function registrasi($data) {
    global $conn;
  
    // Mengambil nilai username dan membersihkan dari karakter yang tidak diinginkan
    $username = strtolower(stripslashes($data["username"]));
  
    // Mengambil nilai password dan password konfirmasi serta membersihkan dari karakter yang tidak diinginkan
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
  
    // Cek apakah username sudah terdaftar
    $result = mysqli_query($conn, "SELECT username FROM pengguna WHERE username = '$username'");
    
    // Jika username sudah terdaftar, tampilkan pesan kesalahan
    if(mysqli_num_rows($result) > 0) {
      echo "
      <script>
        alert('Username Sudah Terdaftar!');
        window.location.href = 'registrasi.php';
      </script>
      "; 
      return false;
    }
  
    // Cek kesesuaian password
    if($password !== $password2) {
      echo "
        <script>
        alert('Konfirmasi Password Tidak Sesuai!');
        window.location.href = 'registrasi.php';
        </script>
      ";
      return false;
    }
  
    // Enkripsi password sebelum disimpan ke dalam basis data
    $password = password_hash($password, PASSWORD_DEFAULT);
  
    // Simpan pengguna baru ke dalam tabel 'pengguna' dalam basis data
    $query = "INSERT INTO pengguna (username, password) VALUES ('$username', '$password')";
    if(mysqli_query($conn, $query)) {
      return true;
    } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
      return false;
    }
}
?>
