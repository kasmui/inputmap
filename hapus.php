<?php
include "koneksi.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Buat query DELETE
    $sql = "DELETE FROM datamasjid WHERE id = $id";
    
    // Eksekusi query DELETE
    if ($conn->query($sql)) {
        header("Location: output.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

    // Redirect kembali ke halaman utama
    // Redirect kembali ke halaman daftar data setelah mengupdate
    header("Location: output.php");
    exit;
?>
