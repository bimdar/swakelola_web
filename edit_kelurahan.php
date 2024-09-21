<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_kelurahan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kelurahan = $_POST['nama_kelurahan'];
    $id_kecamatan = $_POST['id_kecamatan'];
    $id_kota_kab = $_POST['id_kota_kab'];
    $id_provinsi = $_POST['id_provinsi'];

    $updateSql = "UPDATE tbl_kelurahan SET nama_kelurahan=?, id_kecamatan=?, id_kota_kab=?, id_provinsi=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("siiii", $nama_kelurahan, $id_kecamatan, $id_kota_kab, $id_provinsi, $id);

    if ($updateStmt->execute()) {
        header("Location: kelurahan.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelurahan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Edit Kelurahan</h1>

    <form action="" method="post">
        <label for="nama_kelurahan">Nama Kelurahan:</label>
        <input type="text" id="nama_kelurahan" name="nama_kelurahan" value="<?= $data['nama_kelurahan'] ?>" required>

        <label for="id_kecamatan">Kecamatan:</label>
        <select id="id_kecamatan" name="id_kecamatan" required>
            <?php
            $kecamatanSql = "SELECT * FROM tbl_kecamatan";
            $kecamatanResult = $conn->query($kecamatanSql);
            while ($kecamatan = $kecamatanResult->fetch_assoc()): ?>
                <option value="<?= $kecamatan['id'] ?>" <?= $kecamatan['id'] == $data['id_kecamatan'] ? 'selected' : '' ?>><?= $kecamatan['nama_kecamatan'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="id_kota_kab">Kota/Kab:</label>
        <select id="id_kota_kab" name="id_kota_kab" required>
            <?php
            $kotaKabSql = "SELECT * FROM tbl_kota_kab";
            $kotaKabResult = $conn->query($kotaKabSql);
            while ($kotaKab = $kotaKabResult->fetch_assoc()): ?>
                <option value="<?= $kotaKab['id'] ?>" <?= $kotaKab['id'] == $data['id_kota_kab'] ? 'selected' : '' ?>><?= $kotaKab['nama_kota_kab'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="id_provinsi">Provinsi:</label>
        <select id="id_provinsi" name="id_provinsi" required>
            <?php
            $provinsiSql = "SELECT * FROM tbl_provinsi";
            $provinsiResult = $conn->query($provinsiSql);
            while ($provinsi = $provinsiResult->fetch_assoc()): ?>
                <option value="<?= $provinsi['id'] ?>" <?= $provinsi['id'] == $data['id_provinsi'] ? 'selected' : '' ?>><?= $provinsi['nama_provinsi'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Simpan Perubahan</button>
        <a href="kelurahan.php">Kembali</a>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
