<?php
include 'db.php';

// Query untuk mengambil data dari tabel tbl_kelurahan
$sql = "SELECT k.*, kc.nama_kecamatan, kab.nama_kota_kab, p.nama_provinsi 
        FROM tbl_kelurahan k 
        JOIN tbl_kecamatan kc ON k.id_kecamatan = kc.id 
        JOIN tbl_kota_kab kab ON k.id_kota_kab = kab.id 
        JOIN tbl_provinsi p ON kab.id_provinsi = p.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelurahan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Data Kelurahan</h1>

    <a href="index.php">Halaman Home</a>
    <br>
    <br>
    <a href="form_kelurahan.php">Tambah Kelurahan</a>

    <table>
        <thead>
            <tr>
                <th>Kel./Desa</th>
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
                        <td><?= $row['nama_kelurahan'] ?></td>
                        <td><?= $row['nama_kecamatan'] ?></td>
                        <td><?= $row['nama_kota_kab'] ?></td>
                        <td><?= $row['nama_provinsi'] ?></td>
                        <td>
                            <a href="edit_kelurahan.php?id=<?= $row['id'] ?>">Edit</a> |
                            <a href="hapus_kelurahan.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kelurahan ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Tidak ada data kelurahan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
