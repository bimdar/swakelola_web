<?php
include 'db.php';
$result = $conn->query("SELECT * FROM tbl_provinsi");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kota/Kab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Input Kota/Kab</h1>
    <form action="submit_kota_kab.php" method="post">
        <label for="nama_kota_kab">NAMA KOTA/KAB:</label>
        <input type="text" id="nama_kota_kab" name="nama_kota_kab" required>
        
        <label for="provinsi">PILIH PROVINSI:</label>
        <select id="provinsi" name="provinsi" required>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nama_provinsi'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Submit</button>
        <a href="kota_kab.php">Kembali</a>
    </form>
</body>
</html>
