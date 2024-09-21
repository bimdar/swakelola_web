<?php
include 'db.php';

// Query untuk mengambil data dari tabel tbl_kota_kab
$sql = "SELECT k.*, p.nama_provinsi FROM tbl_kota_kab k JOIN tbl_provinsi p ON k.id_provinsi = p.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kota/Kab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Data Kota/Kab</h1>

    <a href="index.php">Halaman Home</a>
    <br>
    <br>
    <a href="form_kota_kab.php">Tambah Kota/Kab</a>

    <table>
        <thead>
            <tr>
                <th>Kota/Kab</th>
                <th>Provinsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nama_kota_kab'] ?></td>
                        <td><?= $row['nama_provinsi'] ?></td>
                        <td>
                            <a href="edit_kota_kab.php?id=<?= $row['id'] ?>">Edit</a> |
                            <a href="hapus_kota_kab.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kota/kab ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Tidak ada data kota/kab.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
