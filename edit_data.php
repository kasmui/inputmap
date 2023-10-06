<?php
// Include file koneksi
include "koneksi.php";

// Cek apakah ada ID yang dikirimkan dari halaman sebelumnya
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data berdasarkan ID
    $sql = "SELECT * FROM datamasjid WHERE id = $id";
    $result = $conn->query($sql);

    if($result) {
        $data = $result->fetch_assoc();

        if(isset($_POST['submit'])) {
            // Ambil data yang diubah dari formulir
            $nama = $_POST['nama'];
            $noidmasjid = $_POST['noidmasjid'];
            $takmir = $_POST['takmir'];
            $hptakmir = $_POST['hptakmir'];
            $alamat = $_POST['alamat'];
            $pcm = $_POST['pcm'];
            $prm = $_POST['prm'];
            $pdm = $_POST['pdm'];
            $pwm = $_POST['pwm'];
            $linkmap = $_POST['linkmap'];
            $keterangan = $_POST['keterangan'];

            // Upload pasfoto
            $pasfoto = $_FILES["pasfoto"]["name"];
            $tmp_pasfoto = $_FILES["pasfoto"]["tmp_name"];
            $target_pasfoto = "uploads/" . $pasfoto;
            move_uploaded_file($tmp_pasfoto, $target_pasfoto);
        
            // Upload file dokumen
            $file_dokumen = $_FILES["file_dokumen"]["name"];
            $tmp_file_dokumen = $_FILES["file_dokumen"]["tmp_name"];
            $target_file_dokumen = "uploads/" . $file_dokumen;
            move_uploaded_file($tmp_file_dokumen, $target_file_dokumen);              

            // Query untuk mengupdate data
            if ($pasfoto != '' && $file_dokumen != ''){
                $updateSql = "UPDATE datamasjid SET nama='$nama', noidmasjid='$noidmasjid', takmir='$takmir', hptakmir='$hptakmir', alamat='$alamat', pcm='$pcm', prm='$prm', pdm='$pdm', pwm='$pwm', linkmap = '$linkmap', keterangan='$keterangan', pasfoto = '$pasfoto', file_dokumen = '$file_dokumen' WHERE id=$id";
            } else if ($pasfoto === '' && $file_dokumen != ''){
                $updateSql = "UPDATE datamasjid SET nama='$nama', noidmasjid='$noidmasjid', takmir='$takmir', hptakmir='$hptakmir', alamat='$alamat', pcm='$pcm', prm='$prm', pdm='$pdm', pwm='$pwm', linkmap = '$linkmap', keterangan='$keterangan', file_dokumen = '$file_dokumen' WHERE id=$id";                
            } else if ($pasfoto != '' && $file_dokumen === ''){
                $updateSql = "UPDATE datamasjid SET nama='$nama', noidmasjid='$noidmasjid', takmir='$takmir', hptakmir='$hptakmir', alamat='$alamat', pcm='$pcm', prm='$prm', pdm='$pdm', pwm='$pwm', linkmap = '$linkmap', keterangan='$keterangan', pasfoto = '$pasfoto' WHERE id=$id";
            } else if ($pasfoto === '' && $file_dokumen === '') {
                $updateSql = "UPDATE datamasjid SET nama='$nama', noidmasjid='$noidmasjid', takmir='$takmir', hptakmir='$hptakmir', alamat='$alamat', pcm='$pcm', prm='$prm', pdm='$pdm', pwm='$pwm', linkmap = '$linkmap', keterangan='$keterangan' WHERE id=$id";
            }
            
            $updateResult = $conn->query($updateSql);

            if($updateResult) {
                // Redirect kembali ke halaman daftar data setelah mengupdate
                header("Location: output.php");
                exit;
            } else {
                echo "Gagal mengupdate data: " . $conn->error;
            }
        }
    } else {
        echo "Data tidak ditemukan";
    }
} else {
    echo "ID tidak valid";
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Masjid/Musholla/Gedung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #eeeeee;
            color: blue;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <style>
        button {
        border-radius: 8px;
    }
    </style>    
</head>
<body>
    <div class="container">
        <h1>Data Masjid/Musholla/Gedung</h1>
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>No.</th>
                    <td><input type="text" name="id" value="<?php echo $data['id']; ?>" disabled></td>
                </tr>                
                <tr>
                    <th>Nama Tempat</th>
                    <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>" required></td>
                </tr>
                <tr>
                    <th>Nomor Induk Masjid</th>
                    <td><input type="text" name="noidmasjid" value="<?php echo $data['noidmasjid']; ?>" ></td>
                </tr>                  
                <tr>
                    <th>Nama Takmir</th>
                    <td><input type="text" name="takmir" value="<?php echo $data['takmir']; ?>" ></td>
                </tr>
                <?php
                    function ubahNomorHP($nomor_hp) {
                        // Hapus karakter non-digit, strip, dan spasi dari nomor HP
                        $nomor_hp = preg_replace("/[^0-9]/", "", $nomor_hp);
                    
                        // Periksa apakah nomor HP sudah diawali dengan "+62"
                        if (substr($nomor_hp, 0, 3) !== '+62') {
                            // Periksa apakah nomor HP dimulai dengan "0"
                            if (substr($nomor_hp, 0, 1) === '0') {
                                // Ganti "0" dengan "+62" dan hapus awalan "0"
                                $nomor_hp = '+62' . substr($nomor_hp, 1);
                            } else {
                                // Tambahkan awalan "+62" jika tidak ada
                                $nomor_hp = '+62' . $nomor_hp;
                            }
                        }
                    
                        return $nomor_hp;
                    }
                                        

                    $hptakmir = $data['hptakmir']; 
                    $hptakmir = ubahNomorHP($hptakmir);    
                ?>
                <tr>
                    <th><a target="_blank" href="<?php echo "https://wa.me/".$hptakmir; ?>">Nomor HP Takmir</a></th>
                    <td><input type="text" name="hptakmir" value="<?php echo $data['hptakmir']; ?>" ></td>
                </tr>                
                <tr>
                    <th>Alamat Tempat</th>
                    <td><input type="text" name="alamat" value="<?php echo $data['alamat']; ?>" ></td>
                </tr>
                <tr>
                    <th>Nama PRM</th>
                    <td><input type="text" name="prm" value="<?php echo $data['prm']; ?>" ></td>
                </tr>                
                <tr>
                    <th>Nama PCM</th>
                    <td><input type="text" name="pcm" value="<?php echo $data['pcm']; ?>" ></td>
                </tr>

                <tr>
                    <th>Nama PDM</th>
                    <td><input type="text" name="pdm" value="<?php echo $data['pdm']; ?>" ></td>
                </tr>
                <tr>
                    <th>Nama PWM</th>
                    <td><input type="text" name="pwm" value="<?php echo $data['pwm']; ?>" ></td>
                </tr>                
                <tr>
                    <th>Sudut Kiblat</th>
                    <td><input type="text" name="qibla" value="<?php echo $data['qibla']; ?>" disabled></td>
                </tr>       
                <tr>
                    <th>Posisi Lintang</th>
                    <td><input type="text" name="lin" value="<?php echo $data['lin']; ?>" disabled></td>
                </tr> 
                <tr>
                    <th>Posisi Bujur</th>
                    <td><input type="text" name="bj" value="<?php echo $data['bj']; ?>" disabled></td>
                </tr> 
                <tr>
                    <th>Ketinggian (m)</th>
                    <td><input type="text" name="h" value="<?php echo $data['h']; ?>" disabled></td>
                </tr>  
                <tr>
                    <th>Zona</th>
                    <td><input type="text" name="tZone" value="<?php echo $data['tZone']; ?>" disabled></td>
                </tr> 
                    <?php 
                        $latitude = $data["lin"];
                        $longitude = $data["bj"];
                        $zoomInMeters = 300;
                        $map = "https://www.google.com/maps/@".$latitude.",".$longitude.",".$zoomInMeters."m/data=!3m1!1e3";
                    ?>                
                <tr>
                    <th><a target="_blank" href="<?php echo $map; ?>">Link Map</a></th>
                    <td><input type="text" name="linkmap" id="linkmap" value="<?php echo $map; ?>" ></a></td>
                </tr>                 
                

                <tr>
                    <th>Foto Masjid</th>
                    <td><a target="_blank" href="uploads/<?php echo $data["pasfoto"]; ?>"><img src="uploads/<?php echo $data["pasfoto"]; ?>" width="100px" height="100px"></a><br/>
                        <br/>
                        <input type="file" name="pasfoto" id="pasfoto" ></td>
                </tr>
                <tr>
                    <th>File Dokumen</th>
                    <td><a target="_blank" href="uploads/<?php echo $data["file_dokumen"]; ?>"><?php echo $data["file_dokumen"]; ?></a>
                        <br/><br/>
                        <input type="file" name="file_dokumen" id="file_dokumen" ></td>
                </tr>  
                 <tr>
                    <th>Keterangan</th>
                    <td><input type="text" name="keterangan" value="<?php echo $data['keterangan']; ?>" ></td>
                </tr>                 
            </table>
            <div class="form-group">
                    <input type="submit" name="submit" value="VALIDASI" title="Lakukan validasi jika sudah lengkap">
            </div>
        </form>
        <a target="_top" href="https://tablighkotasemarang.id/database/masjid/"><button style="background-color: #00FF00; color: black; padding: 10px; height: 40px;">Kembali</button></a>
    </div>
</body>
</html>
