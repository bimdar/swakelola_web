<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "db_swakelola");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and fetch input data
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $tempat_lahir = isset($_POST['tempat_lahir']) ? $_POST['tempat_lahir'] : '';
    $tanggal_lahir = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
    $nik = isset($_POST['nik']) ? $_POST['nik'] : '';
    $no_hp_wa = isset($_POST['no_hp_wa']) ? $_POST['no_hp_wa'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    // $id_provinsi = isset($_POST['id_provinsi']) ? $_POST['id_provinsi'] : '';
    // $id_kota_kab = isset($_POST['id_kota_kab']) ? $_POST['id_kota_kab'] : '';
    // $id_kecamatan = isset($_POST['id_kecamatan']) ? $_POST['id_kecamatan'] : '';
    // $id_kelurahan = isset($_POST['id_kelurahan']) ? $_POST['id_kelurahan'] : '';
    $merek_kendaraan = isset($_POST['merek_kendaraan']) ? $_POST['merek_kendaraan'] : '';
    $kode_khu = isset($_POST['kode_khu']) ? $_POST['kode_khu'] : '';
    $jenis_kendaraan = isset($_POST['jenis_kendaraan']) ? $_POST['jenis_kendaraan'] : '';
    $type_kendaraan = isset($_POST['type_kendaraan']) ? $_POST['type_kendaraan'] : '';
    $tahun_pembuatan = isset($_POST['tahun_pembuatan']) ? $_POST['tahun_pembuatan'] : '';
    $no_plat_kendaraan = isset($_POST['no_plat_kendaraan']) ? $_POST['no_plat_kendaraan'] : '';

    // File uploads
    $foto_sim = isset($_FILES['foto_sim']['name']) ? $_FILES['foto_sim']['name'] : '';
    $foto_ktp = isset($_FILES['foto_ktp']['name']) ? $_FILES['foto_ktp']['name'] : '';
    $foto_stnk = isset($_FILES['foto_stnk']['name']) ? $_FILES['foto_stnk']['name'] : '';
    $foto_kendaraan = isset($_FILES['foto_kendaraan']['name']) ? $_FILES['foto_kendaraan']['name'] : '';

    // Move uploaded files
    $target_dir = "uploads/";
    if ($foto_sim) move_uploaded_file($_FILES["foto_sim"]["tmp_name"], $target_dir . $foto_sim);
    if ($foto_ktp) move_uploaded_file($_FILES["foto_ktp"]["tmp_name"], $target_dir . $foto_ktp);
    if ($foto_stnk) move_uploaded_file($_FILES["foto_stnk"]["tmp_name"], $target_dir . $foto_stnk);
    if ($foto_kendaraan) move_uploaded_file($_FILES["foto_kendaraan"]["tmp_name"], $target_dir . $foto_kendaraan);

    // Insert into tbl_user
    $query_user = "INSERT INTO tbl_user (nama, password, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, no_hp_wa, email, foto_ktp) 
                   VALUES ('$nama', '$password', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$nik', '$no_hp_wa', '$email', '$foto_ktp')";

    if ($conn->query($query_user) === TRUE) {
        $user_id = $conn->insert_id;

        // Insert into tbl_peserta
        $id_program = 7; // Set id_program sesuai yang Anda inginkan
        $query_peserta = "INSERT INTO tbl_peserta (id_user, id_program) VALUES ('$user_id', '$id_program')";

        if ($conn->query($query_peserta) === TRUE) {
            // Insert into tbl_kurir_mds with id_program
            $query_kurir_mds = "INSERT INTO tbl_kurir_mds (id_peserta, id_program, merek_kendaraan, jenis_kendaraan, type_kendaraan, tahun_pembuatan, no_plat_kendaraan, foto_sim, foto_stnk, foto_kendaraan) 
                                    VALUES ('$user_id', '$id_program', '$merek_kendaraan', '$jenis_kendaraan', '$type_kendaraan', '$tahun_pembuatan', '$no_plat_kendaraan', '$foto_sim', '$foto_stnk', '$foto_kendaraan')";

            if ($conn->query($query_kurir_mds) === TRUE) {
                // Update tbl_khu
                $query_update_khu = "UPDATE tbl_khu SET pengguna_khu = '$nama', type_khu = (SELECT type_program FROM tbl_program WHERE id = $id_program) WHERE kode_khu = '$kode_khu'";
                if ($conn->query($query_update_khu) === TRUE) {
                    echo "Data berhasil disimpan dan tbl_khu diupdate.";
                } else {
                    echo "Error saat mengupdate tbl_khu: " . $conn->error;
                }
            } else {
                echo "Error saat menyimpan ke tbl_kurir_mds: " . $conn->error;
            }
        } else {
            echo "Error saat menyimpan ke tbl_peserta: " . $conn->error;
        }
    } else {
        echo "Error saat menyimpan ke tbl_user: " . $conn->error;
    }

    $conn->close();
}
?>
