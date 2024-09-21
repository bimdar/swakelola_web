<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_provinsi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_provinsi = $_POST['nama_provinsi'];

    $updateSql = "UPDATE tbl_provinsi SET nama_provinsi=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $nama_provinsi, $id);

    if ($updateStmt->execute()) {
        header("Location: provinsi.php");
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
    <title>Edit Provinsi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Edit Provinsi</h1>

    <form action="" method="post">
        <label for="nama_provinsi">Nama Provinsi:</label>
        <input type="text" id="nama_provinsi" name="nama_provinsi" value="<?= $data['nama_provinsi'] ?>" required>

        <button type="submit">Simpan Perubahan</button>
        <a href="provinsi.php">Kembali</a>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
