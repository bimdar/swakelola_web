<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "db_swakelola");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and fetch input data
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $lembaga = isset($_POST['Lembaga']) ? $_POST['Lembaga'] : '';
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $tempat_lahir = isset($_POST['tempat_lahir']) ? $_POST['tempat_lahir'] : '';
    $tanggal_lahir = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
    $nik = isset($_POST['nik']) ? $_POST['nik'] : '';
    $agama = isset($_POST['agama']) ? $_POST['agama'] : '';
    $no_hp_wa = isset($_POST['no_hp_wa']) ? $_POST['no_hp_wa'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $id_provinsi = isset($_POST['id_provinsi']) ? $_POST['id_provinsi'] : '';
    $id_kota_kab = isset($_POST['id_kota_kab']) ? $_POST['id_kota_kab'] : '';
    $id_kecamatan = isset($_POST['id_kecamatan']) ? $_POST['id_kecamatan'] : '';
    $id_kelurahan = isset($_POST['id_kelurahan']) ? $_POST['id_kelurahan'] : '';
    $rt_rw_no = isset($_POST['rt_rw_no']) ? $_POST['rt_rw_no'] : '';
    $nama_ahli_waris = isset($_POST['nama_ahli_waris']) ? $_POST['nama_ahli_waris'] : '';
    $nik_ahli_waris = isset($_POST['nik_ahli_waris']) ? $_POST['nik_ahli_waris'] : '';
    $hubungan_ahli_waris = isset($_POST['hubungan_ahli_waris']) ? $_POST['hubungan_ahli_waris'] : '';
    $kode_khu = isset($_POST['kode_khu']) ? $_POST['kode_khu'] : '';
    $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';

    // File uploads
    $foto_npwp = isset($_FILES['foto_npwp']['name']) ? $_FILES['foto_npwp']['name'] : '';
    $foto_ktp = isset($_FILES['foto_ktp']['name']) ? $_FILES['foto_ktp']['name'] : '';
    $foto_diri = isset($_FILES['foto_diri']['name']) ? $_FILES['foto_diri']['name'] : '';

    // Move uploaded files
    $target_dir = "uploads/";
    if ($foto_npwp) move_uploaded_file($_FILES["foto_npwp"]["tmp_name"], $target_dir . $foto_npwp);
    if ($foto_ktp) move_uploaded_file($_FILES["foto_ktp"]["tmp_name"], $target_dir . $foto_ktp);
    if ($foto_diri) move_uploaded_file($_FILES["foto_diri"]["tmp_name"], $target_dir . $foto_diri);

    // Insert into tbl_user
    $query_user = "INSERT INTO tbl_user (nama, password, pekerjaan, lembaga, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, agama, no_hp_wa, email, id_provinsi, id_kota_kab, id_kecamatan, id_kelurahan, rt_rw_no, foto_npwp, foto_ktp, foto_diri) 
                   VALUES ('$nama', '$password', '$pekerjaan', '$lembaga', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$nik', '$agama', '$no_hp_wa', '$email', '$id_provinsi', '$id_kota_kab', '$id_kecamatan', '$id_kelurahan', '$rt_rw_no', '$foto_npwp', '$foto_ktp', '$foto_diri')";

    if ($conn->query($query_user) === TRUE) {
        $user_id = $conn->insert_id;

        // Insert into tbl_peserta
        $id_program = 5; // Set id_program sesuai yang Anda inginkan
        $query_peserta = "INSERT INTO tbl_peserta (id_user, id_program) VALUES ('$user_id', '$id_program')";

        if ($conn->query($query_peserta) === TRUE) {
            // Insert into tbl_swakelola with id_program
            $query_swakelola = "INSERT INTO tbl_swakelola (id_peserta, id_program, nama_ahli_waris, nik_ahli_waris, hubungan_ahli_waris) 
                                VALUES ('$user_id', '$id_program', '$nama_ahli_waris', '$nik_ahli_waris', '$hubungan_ahli_waris')";

            if ($conn->query($query_swakelola) === TRUE) {
                // Update tbl_khu
                $query_update_khu = "UPDATE tbl_khu SET pengguna_khu = '$nama', type_khu = (SELECT type_program FROM tbl_program WHERE id = $id_program) WHERE kode_khu = '$kode_khu'";
                if ($conn->query($query_update_khu) === TRUE) {
                    echo "Data berhasil disimpan dan tbl_khu diupdate.";
                } else {
                    echo "Error saat mengupdate tbl_khu: " . $conn->error;
                }
            } else {
                echo "Error saat menyimpan ke tbl_swakelola: " . $conn->error;
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
