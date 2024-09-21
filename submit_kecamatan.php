<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kecamatan = $conn->real_escape_string($_POST['nama_kecamatan']);
    $id_kota_kab = $conn->real_escape_string($_POST['kota_kab']);
    $id_provinsi = $conn->real_escape_string($_POST['provinsi']);

    $sql = "INSERT INTO tbl_kecamatan (nama_kecamatan, id_kota_kab, id_provinsi) VALUES ('$nama_kecamatan', '$id_kota_kab', '$id_provinsi')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Kecamatan berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<a href="kecamatan.php">Kembali ke Halaman Utama</a>
