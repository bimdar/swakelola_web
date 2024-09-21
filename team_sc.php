<?php
include 'db.php';

// Ambil data provinsi, kota/kab, kecamatan, dan kelurahan
$provinsiSql = "SELECT * FROM tbl_provinsi";
$provinsiResult = $conn->query($provinsiSql);

$kotaKabSql = "SELECT * FROM tbl_kota_kab";
$kotaKabResult = $conn->query($kotaKabSql);

$kecamatanSql = "SELECT * FROM tbl_kecamatan";
$kecamatanResult = $conn->query($kecamatanSql);

$kelurahanSql = "SELECT * FROM tbl_kelurahan";
$kelurahanResult = $conn->query($kelurahanSql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $lembaga = $_POST['lembaga'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nik = $_POST['nik'];
    $agama = $_POST['agama'];
    $no_hp_wa = $_POST['no_hp_wa'];
    $email = $_POST['email'];
    $id_provinsi = $_POST['provinsi'];
    $id_kota_kab = $_POST['kota_kab'];
    $id_kecamatan = $_POST['kecamatan'];
    $id_kelurahan = $_POST['kelurahan'];
    $rt_rw_no = $_POST['rt_rw_no'];
    $type_program = $_POST['type_program'];
    $nama_ahli_waris = $_POST['nama_ahli_waris'];
    $nik_ahli_waris = $_POST['nik_ahli_waris'];
    $hubungan = $_POST['hubungan'];
    
    // Handle upload file
    $foto_ktp = $_FILES['foto_ktp']['name'];
    $foto_npwp = $_FILES['foto_npwp']['name'];
    $foto_diri = $_FILES['foto_diri']['name'];
    
    // Path untuk menyimpan file
    $targetDir = "uploads/";
    move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $targetDir . $foto_ktp);
    move_uploaded_file($_FILES['foto_npwp']['tmp_name'], $targetDir . $foto_npwp);
    move_uploaded_file($_FILES['foto_diri']['tmp_name'], $targetDir . $foto_diri);

    // Masukkan data ke tbl_user
    $userSql = "INSERT INTO tbl_user (nama, password, lembaga, tempat_lahir, tanggal_lahir, jenis_kelamin, nik, agama, no_hp_wa, email, id_provinsi, id_kota_kab, id_kecamatan, id_kelurahan, rt_rw_no, foto_npwp, foto_ktp, foto_diri) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("ssssssssiiiiissss", $nama, $password, $lembaga, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $nik, $agama, $no_hp_wa, $email, $id_provinsi, $id_kota_kab, $id_kecamatan, $id_kelurahan, $rt_rw_no, $foto_npwp, $foto_ktp, $foto_diri);
    
    if ($userStmt->execute()) {
        $id_user = $conn->insert_id; // Ambil ID pengguna yang baru ditambahkan
        
        // Masukkan data ke tbl_sc
        $scSql = "INSERT INTO tbl_sc (id_user, nama_ahli_waris, nik_ahli_waris, hubungan_ahli_waris) VALUES (?, ?, ?, ?)";
        $scStmt = $conn->prepare($scSql);
        $scStmt->bind_param("isss", $id_user, $nama_ahli_waris, $nik_ahli_waris, $hubungan);
        $scStmt->execute();

        // Masukkan data ke tbl_peserta (asumsi Anda sudah memiliki id_program)
        // Gantilah `1` dengan ID program yang sesuai
        $programId = 1; // Ganti dengan ID program yang benar
        $pesertaSql = "INSERT INTO tbl_peserta (id_user, id_program) VALUES (?, ?)";
        $pesertaStmt = $conn->prepare($pesertaSql);
        $pesertaStmt->bind_param("ii", $id_user, $programId);
        $pesertaStmt->execute();

        // Redirect atau tampilkan pesan sukses
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Team SC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Form Team SC</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="username">Username (KHU):</label>
        <input type="text" id="username" name="username" required>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="lembaga">Lembaga:</label>
        <input type="text" id="lembaga" name="lembaga" required>

        <label for="tempat_lahir">Tempat Lahir:</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>

        <label for="nik">NIK:</label>
        <input type="text" id="nik" name="nik" required>

        <label for="agama">Agama:</label>
        <input type="text" id="agama" name="agama" required>

        <label for="no_hp_wa">No HP/WA:</label>
        <input type="text" id="no_hp_wa" name="no_hp_wa" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="provinsi">Provinsi:</label>
        <select id="provinsi" name="provinsi" required>
            <?php while ($provinsi = $provinsiResult->fetch_assoc()): ?>
                <option value="<?= $provinsi['id'] ?>"><?= $provinsi['nama_provinsi'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="kota_kab">Kota/Kab:</label>
        <select id="kota_kab" name="kota_kab" required>
            <?php while ($kotaKab = $kotaKabResult->fetch_assoc()): ?>
                <option value="<?= $kotaKab['id'] ?>"><?= $kotaKab['nama_kota_kab'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="kecamatan">Kecamatan:</label>
        <select id="kecamatan" name="kecamatan" required>
            <?php while ($kecamatan = $kecamatanResult->fetch_assoc()): ?>
                <option value="<?= $kecamatan['id'] ?>"><?= $kecamatan['nama_kecamatan'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="kelurahan">Kel./Desa:</label>
        <select id="kelurahan" name="kelurahan" required>
            <?php while ($kelurahan = $kelurahanResult->fetch_assoc()): ?>
                <option value="<?= $kelurahan['id'] ?>"><?= $kelurahan['nama_kelurahan'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="rt_rw_no">Rt/Rw/No:</label>
        <input type="text" id="rt_rw_no" name="rt_rw_no" required>

        <label for="type_program">Type Program:</label>
        <input type="text" id="type_program" name="type_program" required>

        <label for="nama_ahli_waris">Nama Ahli Waris:</label>
        <input type="text" id="nama_ahli_waris" name="nama_ahli_waris" required>

        <label for="nik_ahli_waris">NIK Ahli Waris:</label>
        <input type="text" id="nik_ahli_waris" name="nik_ahli_waris" required>

        <label for="hubungan">Hubungan:</label>
        <input type="text" id="hubungan" name="hubungan" required>

        <label for="foto_ktp">Foto KTP:</label>
        <input type="file" id="foto_ktp" name="foto_ktp" required>

        <label for="foto_npwp">Foto NPWP:</label>
        <input type="file" id="foto_npwp" name="foto_npwp" required>

        <label for="foto_diri">Foto Diri:</label>
        <input type="file" id="foto_diri" name="foto_diri" required>

        <button type="submit">Kirim</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
