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
    $id_provinsi = isset($_POST['id_provinsi']) ? $_POST['id_provinsi'] : '';
    $id_kota_kab = isset($_POST['id_kota_kab']) ? $_POST['id_kota_kab'] : '';
    $id_kecamatan = isset($_POST['id_kecamatan']) ? $_POST['id_kecamatan'] : '';
    $id_kelurahan = isset($_POST['id_kelurahan']) ? $_POST['id_kelurahan'] : '';
    $rt_rw_no = isset($_POST['rt_rw_no']) ? $_POST['rt_rw_no'] : '';
    $kode_khu = isset($_POST['kode_khu']) ? $_POST['kode_khu'] : '';
    $nama_toko = isset($_POST['nama_toko']) ? $_POST['nama_toko'] : '';
    $produk_utama = isset($_POST['produk_utama']) ? $_POST['produk_utama'] : '';

    // File uploads
    $foto_npwp = isset($_FILES['foto_npwp']['name']) ? $_FILES['foto_npwp']['name'] : '';
    $foto_ktp = isset($_FILES['foto_ktp']['name']) ? $_FILES['foto_ktp']['name'] : '';
    $foto_logo_toko = isset($_FILES['foto_logo_toko']['name']) ? $_FILES['foto_logo_toko']['name'] : '';

    // Move uploaded files
    $target_dir = "uploads/";
    if ($foto_npwp) move_uploaded_file($_FILES["foto_npwp"]["tmp_name"], $target_dir . $foto_npwp);
    if ($foto_ktp) move_uploaded_file($_FILES["foto_ktp"]["tmp_name"], $target_dir . $foto_ktp);
    if ($foto_logo_toko) move_uploaded_file($_FILES["foto_logo_toko"]["tmp_name"], $target_dir . $foto_logo_toko);

    // Insert into tbl_user
    $query_user = "INSERT INTO tbl_user (nama, password, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, no_hp_wa, email, id_provinsi, id_kota_kab, id_kecamatan, id_kelurahan, rt_rw_no, foto_npwp, foto_ktp, foto_logo_toko) 
                   VALUES ('$nama', '$password', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$nik', '$no_hp_wa', '$email', '$id_provinsi', '$id_kota_kab', '$id_kecamatan', '$id_kelurahan', '$rt_rw_no', '$foto_npwp', '$foto_ktp', '$foto_logo_toko')";

    if ($conn->query($query_user) === TRUE) {
        $user_id = $conn->insert_id;

        // Insert into tbl_peserta
        $id_program = 6; // Set id_program sesuai yang Anda inginkan
        $query_peserta = "INSERT INTO tbl_peserta (id_user, id_program) VALUES ('$user_id', '$id_program')";

        if ($conn->query($query_peserta) === TRUE) {
            // Insert into tbl_mitra_seller with id_program
            $query_mitra_seller = "INSERT INTO tbl_mitra_seller (id_peserta, id_program, nama_toko, produk_utama) 
                                    VALUES ('$user_id', '$id_program', '$nama_toko', '$produk_utama')";

            if ($conn->query($query_mitra_seller) === TRUE) {
                // Update tbl_khu
                $query_update_khu = "UPDATE tbl_khu SET pengguna_khu = '$nama', type_khu = (SELECT type_program FROM tbl_program WHERE id = $id_program) WHERE kode_khu = '$kode_khu'";
                if ($conn->query($query_update_khu) === TRUE) {
                    echo "Data berhasil disimpan dan tbl_khu diupdate.";
                } else {
                    echo "Error saat mengupdate tbl_khu: " . $conn->error;
                }
            } else {
                echo "Error saat menyimpan ke tbl_mitra_seller: " . $conn->error;
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
