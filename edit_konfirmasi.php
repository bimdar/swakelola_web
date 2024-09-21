<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_konfirm_tf WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $bank = $_POST['bank'];
    $atas_nama = $_POST['atas_nama'];
    $jumlah_transfer = $_POST['jumlah_transfer'];
    $tanggal_transfer = $_POST['tanggal_transfer'];

    $updateSql = "UPDATE tbl_konfirm_tf SET nama=?, email=?, bank=?, atas_nama=?, jumlah_transfer=?, tanggal_transfer=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssssi", $nama, $email, $bank, $atas_nama, $jumlah_transfer, $tanggal_transfer, $id);

    if ($updateStmt->execute()) {
        header("Location: konfirmasi_pembayaran.php");
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
    <title>Edit Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Edit Konfirmasi Pembayaran</h1>

    <form action="" method="post">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama" value="<?= $data['nama'] ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $data['email'] ?>" required>

        <label for="bank">Nama Bank:</label>
        <input type="text" id="bank" name="bank" value="<?= $data['bank'] ?>" required>

        <label for="atas_nama">Atas Nama:</label>
        <input type="text" id="atas_nama" name="atas_nama" value="<?= $data['atas_nama'] ?>" required>

        <label for="jumlah_transfer">Jumlah Transfer:</label>
        <input type="number" id="jumlah_transfer" name="jumlah_transfer" value="<?= $data['jumlah_transfer'] ?>" required>

        <label for="tanggal_transfer">Tanggal Transfer:</label>
        <input type="date" id="tanggal_transfer" name="tanggal_transfer" value="<?= $data['tanggal_transfer'] ?>" required>

        <button type="submit">Simpan Perubahan</button>
        <a href="konfirmasi_pembayaran.php">Kembali</a>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
