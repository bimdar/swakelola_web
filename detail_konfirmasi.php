<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_konfirm_tf WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Detail Konfirmasi Pembayaran</h1>
    
    <?php if ($data): ?>
        <p><strong>Nama Lengkap:</strong> <?= $data['nama'] ?></p>
        <p><strong>Email:</strong> <?= $data['email'] ?></p>
        <p><strong>Nama Bank:</strong> <?= $data['bank'] ?></p>
        <p><strong>Atas Nama:</strong> <?= $data['atas_nama'] ?></p>
        <p><strong>Jumlah Transfer:</strong> Rp <?= number_format($data['jumlah_transfer'], 0, ',', '.') ?></p>
        <p><strong>Tanggal Transfer:</strong> <?= date('d-m-Y', strtotime($data['tanggal_transfer'])) ?></p>
        <p><strong>Bukti Transfer:</strong> 
            <?php if (!empty($data['bukti_transfer'])): ?>
                <a href="uploads/<?= $data['bukti_transfer'] ?>" target="_blank">Lihat Bukti</a>
            <?php else: ?>
                Tidak ada bukti
            <?php endif; ?>
        </p>
    <?php else: ?>
        <p>Data tidak ditemukan.</p>
    <?php endif; ?>

    <a href="konfirmasi_pembayaran.php">Kembali</a>

    <?php $conn->close(); ?>
</body>
</html>
