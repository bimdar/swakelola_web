<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_kota_kab WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kota_kab = $_POST['nama_kota_kab'];
    $id_provinsi = $_POST['id_provinsi'];

    $updateSql = "UPDATE tbl_kota_kab SET nama_kota_kab=?, id_provinsi=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sii", $nama_kota_kab, $id_provinsi, $id);

    if ($updateStmt->execute()) {
        header("Location: kota_kab.php");
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
    <title>Edit Kota/Kab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Edit Kota/Kab</h1>

    <form action="" method="post">
        <label for="nama_kota_kab">Nama Kota/Kab:</label>
        <input type="text" id="nama_kota_kab" name="nama_kota_kab" value="<?= $data['nama_kota_kab'] ?>" required>

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
        <a href="kota_kab.php">Kembali</a>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
