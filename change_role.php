<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
  // Jika belum, redirect ke halaman login
  header("Location: login.php");
  exit; // Hentikan eksekusi skrip
}

// Periksa apakah pengguna memiliki peran sebagai admin
if ($_SESSION['role'] !== 'admin') {
  // Jika tidak, redirect ke halaman yang sesuai
  header("Location: index.php");
  exit; // Hentikan eksekusi skrip
}

// Sambungkan ke database
require 'functions.php';

// Tangani permintaan perubahan role
if (isset($_GET['id']) && isset($_GET['role'])) {
  $id = $_GET['id'];
  $newRole = $_GET['role'];

  // Update role pengguna berdasarkan ID
  $query = "UPDATE pengguna SET role = ? WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("si", $newRole, $id);
  $stmt->execute();

  // Redirect kembali ke halaman pengguna.php
  header("Location: pengguna.php");
  exit;
} else {
  // Jika tidak ada ID atau role, redirect ke halaman pengguna.php
  header("Location: pengguna.php");
  exit;
}
?>