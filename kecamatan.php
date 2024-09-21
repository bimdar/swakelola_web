<?php
include 'db.php';

// Query untuk mengambil data dari tabel tbl_kecamatan
$sql = "SELECT k.*, kc.nama_kota_kab, p.nama_provinsi 
        FROM tbl_kecamatan k 
        JOIN tbl_kota_kab kc ON k.id_kota_kab = kc.id 
        JOIN tbl_provinsi p ON kc.id_provinsi = p.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Data Kecamatan</h1>

    <a href="index.php">Halaman Home</a>
    <br>
    <br>
    <a href="form_kecamatan.php">Tambah Kecamatan</a>

    <table>
        <thead>
            <tr>
                <th>Kecamatan</th>
                <th>Kota/Kab</th>
                <th>Provinsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nama_kecamatan'] ?></td>
                        <td><?= $row['nama_kota_kab'] ?></td>
                        <td><?= $row['nama_provinsi'] ?></td>
                        <td>
                            <a href="edit_kecamatan.php?id=<?= $row['id'] ?>">Edit</a> |
                            <a href="hapus_kecamatan.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kecamatan ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Tidak ada data kecamatan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
