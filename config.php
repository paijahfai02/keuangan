<?php
$host = "localhost";  // Server database
$user = "root";       // Username MySQL
$pass = "";           // Password MySQL
$db   = "keuangan";   // Nama database

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>