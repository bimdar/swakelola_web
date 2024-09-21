<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kota_kab = $conn->real_escape_string($_POST['nama_kota_kab']);
    $id_provinsi = $conn->real_escape_string($_POST['provinsi']);

    $sql = "INSERT INTO tbl_kota_kab (nama_kota_kab, id_provinsi) VALUES ('$nama_kota_kab', '$id_provinsi')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Kota/Kab berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<a href="kota_kab.php">Kembali ke Halaman Utama</a>
