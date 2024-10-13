<?php
include 'db.php';

$kode_khu = $_POST['kode_khu'];
$nama_pemilik = $_POST['nama_pemilik'];
$nama = $_POST['nama'];
$password = $_POST['password'];
$pekerjaan = $_POST['pekerjaan'];
$Lembaga = $_POST['Lembaga'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$nik = $_POST['nik'];
$agama = $_POST['agama'];
$no_hp_wa = $_POST['no_hp_wa'];
$email = $_POST['email'];
$id_provinsi = $_POST['id_provinsi'];
$id_kota_kab = $_POST['id_kota_kab'];
$id_kecamatan = $_POST['id_kecamatan'];
$id_kelurahan = $_POST['id_kelurahan'];
$rt_rw_no = $_POST['rt_rw_no'];
$nama_ahli_waris = $_POST['nama_ahli_waris'];
$nik_ahli_waris = $_POST['nik_ahli_waris'];
$hubungan_ahli_waris = $_POST['hubungan_ahli_waris'];
$foto_npwp = $_FILES['foto_npwp']['name'];
$foto_ktp = $_FILES['foto_ktp']['name'];
$foto_diri = $_FILES['foto_diri']['name'];
$id_program = 5; // ID untuk WinPro

// Upload foto
$target_dir = "uploads/";
move_uploaded_file($_FILES['foto_npwp']['tmp_name'], $target_dir . $foto_npwp);
move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $target_dir . $foto_ktp);
move_uploaded_file($_FILES['foto_diri']['tmp_name'], $target_dir . $foto_diri);

// Insert ke tabel user
$sql_user = "INSERT INTO tbl_user (nama, password, pekerjaan, Lembaga, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, agama, no_hp_wa, email, id_provinsi, id_kota_kab, id_kecamatan, id_kelurahan, rt_rw_no, foto_npwp, foto_ktp, foto_diri) 
VALUES ('$nama', '$password', '$pekerjaan', '$Lembaga', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$nik', '$agama', '$no_hp_wa', '$email', '$id_provinsi', '$id_kota_kab', '$id_kecamatan', '$id_kelurahan', '$rt_rw_no', '$foto_npwp', '$foto_ktp', '$foto_diri')";

if ($conn->query($sql_user) === TRUE) {
    $id_user = $conn->insert_id;

    // Insert ke tabel peserta
    $sql_peserta = "INSERT INTO tbl_peserta (id_user, id_program) VALUES ('$id_user', '$id_program')";
    if ($conn->query($sql_peserta) === TRUE) {
        $id_peserta = $conn->insert_id;

        // Insert ke tabel swakelola
        $sql_swakelola = "INSERT INTO tbl_swakelola (id_peserta, id_program, nama_ahli_waris, nik_ahli_waris, hubungan_ahli_waris) 
        VALUES ('$id_peserta', '$id_program', '$nama_ahli_waris', '$nik_ahli_waris', '$hubungan_ahli_waris')";
        
        if ($conn->query($sql_swakelola) === TRUE) {
            // Update pengguna_khu pada tbl_khu
            $sql_update_khu = "UPDATE tbl_khu SET pengguna_khu = '$nama' WHERE kode_khu = '$kode_khu' AND nama_pemilik = '$nama_pemilik'";
            if ($conn->query($sql_update_khu) === TRUE) {
                echo "Data berhasil disimpan!";
            } else {
                echo "Error: " . $sql_update_khu . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_swakelola . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_peserta . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_user . "<br>" . $conn->error;
}

$conn->close();
?>
