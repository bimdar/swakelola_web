<?php
include 'db.php';

// Query untuk mengambil data dari tabel tbl_provinsi
$sql = "SELECT * FROM tbl_provinsi";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Provinsi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Data Provinsi</h1>

    <a href="index.php">Halaman Utama</a>
    <br>
    <br>
    <a href="form_provinsi.php">Tambah Provinsi</a>
    <table>
        <thead>
            <tr>
                <th>Provinsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nama_provinsi'] ?></td>
                        <td>
                            <a href="edit_provinsi.php?id=<?= $row['id'] ?>">Edit</a> |
                            <a href="hapus_provinsi.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus provinsi ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Tidak ada data provinsi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
