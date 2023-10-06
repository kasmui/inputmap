<?php
// Include file koneksi
include "koneksi.php";

// Query untuk menampilkan data dari database
$sql = "SELECT * FROM datamasjid";

// Eksekusi query
$query = $conn->query($sql);

// Jika query berhasil dieksekusi, maka kita akan menampilkan data dalam bentuk tabel
if ($query) {
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Data Masjid/Musholla/Gedung</title>
    <link rel="stylesheet" href="style.css">
    <style>
        button {
        border-radius: 8px;
    }
    </style>
</head>
<body>
    <div class="container-output">
        <h1>Data Masjid/Musholla/Gedung</h1>
        <a target="_top" href="input.php"><button style="background-color: #00FF00; color: black;">Tambah Data</button></a>
        <br/><br/>
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th width="31%">Nama Tempat<br/>Nomor Induk Masjid</th>
                    <th width="30%">PCM<br/>Alamat</th>
                    <th width="25%">Nama Takmir<br/>Nomor HP</th>
                    <th width="8%">Link Map</th>
					<th width="5%">Aksi</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $query->fetch_assoc()) {
                ?>
               
                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td><a href="edit_data.php?id=<?php echo $row["id"]; ?>"><?php echo $row["nama"]; ?></a><hr><?php echo $row["noidmasjid"]; ?></td>
                    <td><?php echo $row["pcm"]; ?><hr/><?php echo $row["alamat"]; ?></td>
                    <td>
                        <?php echo $row["takmir"]; ?><hr/><?php echo $row["hptakmir"]; ?>
                    </td>
                    
                    <?php 
                        $latitude = $row["lin"];
                        $longitude = $row["bj"];
                        $zoomInMeters = 300;
                        $map = "https://www.google.com/maps/@".$latitude.",".$longitude.",".$zoomInMeters."m/data=!3m1!1e3";
                    ?>
                    <td align="center"><a target="_blank" href="<?php echo $map; ?>"><img src="ikonmasjid.png" height="30px"></a></td>
					<td><a href="edit_data.php?id=<?php echo $row["id"]; ?>">Edit</a>&nbsp;
                        <a href="hapus.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a></td>
                    
                </tr>
                <?php
                $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
} else {
    // Jika query gagal dieksekusi, maka kita akan menampilkan pesan error
    echo "Query gagal dieksekusi!";
}
?>
