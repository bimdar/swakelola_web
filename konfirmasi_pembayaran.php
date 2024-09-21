<?php
include 'db.php';

// Query untuk mengambil data dari tabel tbl_konfirm_tf
$sql = "SELECT * FROM tbl_konfirm_tf";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Daftar Konfirmasi Pembayaran</h1>

    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Nama Bank</th>
                <th>Atas Nama</th>
                <th>Jumlah Transfer</th>
                <th>Tanggal Transfer</th>
                <th>Bukti Transfer</th>
                <th>Aksi</th> <!-- Kolom Aksi -->
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['bank'] ?></td>
                        <td><?= $row['atas_nama'] ?></td>
                        <td>Rp <?= number_format($row['jumlah_transfer'], 0, ',', '.') ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_transfer'])) ?></td>
                        <td>
                            <?php if (!empty($row['bukti_transfer'])): ?>
                                <a href="uploads/<?= $row['bukti_transfer'] ?>" target="_blank">Lihat Bukti</a>
                            <?php else: ?>
                                Tidak ada bukti
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="detail_konfirmasi.php?id=<?= $row['id'] ?>">Lihat</a> |
                            <a href="edit_konfirmasi.php?id=<?= $row['id'] ?>">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Tidak ada data konfirmasi pembayaran.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>

</body>
</html>
