<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_provinsi = $conn->real_escape_string($_POST['nama_provinsi']);

    $sql = "INSERT INTO tbl_provinsi (nama_provinsi) VALUES ('$nama_provinsi')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Provinsi berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<a href="provinsi.php">Kembali ke Halaman Utama</a>
