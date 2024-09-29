<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "db_swakelola");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and fetch input data
    $nama = $_POST['nama'];
    $lembaga = $_POST['lembaga'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nik = $_POST['nik'];
    $agama = $_POST['agama'];
    $pekerjaan = $_POST['pekerjaan'];
    $no_hp_wa = $_POST['no_hp_wa'];
    $email = $_POST['email'];
    $id_provinsi = $_POST['provinsi'];
    $id_kota_kab = $_POST['kota_kab'];
    $id_kecamatan = $_POST['kecamatan'];
    $id_kelurahan = $_POST['kelurahan'];
    $rt_rw_no = $_POST['rt_rw_no'];

    // Insert data into tbl_user
    $sql_user = "INSERT INTO tbl_user (nama, lembaga, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, agama, pekerjaan, no_hp_wa, email, id_provinsi, id_kota_kab, id_kecamatan, id_kelurahan, rt_rw_no) 
                 VALUES ('$nama', '$lembaga', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$nik', '$agama', '$pekerjaan', '$no_hp_wa', '$email', '$id_provinsi', '$id_kota_kab', '$id_kecamatan', '$id_kelurahan', '$rt_rw_no')";

    if ($conn->query($sql_user) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }

    // Handle file uploads (e.g., foto_ktp, foto_npwp, foto_diri)
    // You will need to handle these similarly with the correct paths and validations
}

$conn->close();
?>
