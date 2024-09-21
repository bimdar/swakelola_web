<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $bank = $conn->real_escape_string($_POST['bank']);
    $atas_nama = $conn->real_escape_string($_POST['atas_nama']);
    $jumlah_transfer = $conn->real_escape_string($_POST['jumlah_transfer']);
    $tanggal_transfer = $conn->real_escape_string($_POST['tanggal_transfer']);
    
    // Mengelola file bukti transfer
    $target_dir = "uploads/";
    $file_name = basename($_FILES["bukti_transfer"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file benar-benar gambar
    $check = getimagesize($_FILES["bukti_transfer"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Batasi jenis file yang diizinkan
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk bernilai 0 (gagal)
    if ($uploadOk == 0) {
        echo "File gagal diupload.";
    } else {
        // Jika semua pengecekan lolos, coba unggah file
        if (move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $target_file)) {
            // Setelah file berhasil diupload, simpan data ke database
            $sql = "INSERT INTO tbl_konfirm_tf (nama, email, bank, atas_nama, jumlah_transfer, tanggal_transfer, bukti_transfer) 
                    VALUES ('$nama', '$email', '$bank', '$atas_nama', '$jumlah_transfer', '$tanggal_transfer', '$file_name')";

            if ($conn->query($sql) === TRUE) {
                echo "Konfirmasi transaksi berhasil disimpan.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Terjadi kesalahan saat mengupload file.";
        }
    }

    $conn->close();
}
?>
