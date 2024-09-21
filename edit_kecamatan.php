<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_kecamatan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kecamatan = $_POST['nama_kecamatan'];
    $id_kota_kab = $_POST['id_kota_kab'];

    $updateSql = "UPDATE tbl_kecamatan SET nama_kecamatan=?, id_kota_kab=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sii", $nama_kecamatan, $id_kota_kab, $id);

    if ($updateStmt->execute()) {
        header("Location: kecamatan.php");
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
    <title>Edit Kecamatan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Edit Kecamatan</h1>

    <form action="" method="post">
        <label for="nama_kecamatan">Nama Kecamatan:</label>
        <input type="text" id="nama_kecamatan" name="nama_kecamatan" value="<?= $data['nama_kecamatan'] ?>" required>

        <label for="id_kota_kab">Kota/Kab:</label>
        <select id="id_kota_kab" name="id_kota_kab" required>
            <?php
            $kotaKabSql = "SELECT * FROM tbl_kota_kab";
            $kotaKabResult = $conn->query($kotaKabSql);
            while ($kotaKab = $kotaKabResult->fetch_assoc()): ?>
                <option value="<?= $kotaKab['id'] ?>" <?= $kotaKab['id'] == $data['id_kota_kab'] ? 'selected' : '' ?>><?= $kotaKab['nama_kota_kab'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Simpan Perubahan</button>
        <a href="kecamatan.php">Kembali</a>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
