<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kelurahan = $conn->real_escape_string($_POST['nama_kelurahan']);
    $id_kecamatan = $conn->real_escape_string($_POST['kecamatan']);
    $id_kota_kab = $conn->real_escape_string($_POST['kota_kab']);
    $id_provinsi = $conn->real_escape_string($_POST['provinsi']);

    $sql = "INSERT INTO tbl_kelurahan (nama_kelurahan, id_kecamatan, id_kota_kab, id_provinsi) VALUES ('$nama_kelurahan', '$id_kecamatan', '$id_kota_kab', '$id_provinsi')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Kelurahan berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<a href="kelurahan.php">Kembali ke Halaman Utama</a>
