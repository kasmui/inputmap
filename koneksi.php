<?php
// Koneksi ke database MySQL
$host = "localhost";
$user = "username";
$pass = "";
$dbname = "database_name";

// Buat koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
