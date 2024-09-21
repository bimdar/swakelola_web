<?php
include 'db.php';
$result_kota = $conn->query("SELECT * FROM tbl_kota_kab");
$result_provinsi = $conn->query("SELECT * FROM tbl_provinsi");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kecamatan</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Input Kecamatan</h1>
    <form action="submit_kecamatan.php" method="post">
        <label for="nama_kecamatan">NAMA KECAMATAN:</label>
        <input type="text" id="nama_kecamatan" name="nama_kecamatan" required>

        <label for="provinsi">PILIH PROVINSI:</label>
        <select id="provinsi" name="provinsi" required>
            <option value="" disabled selected>Pilih Provinsi</option>
            <?php while ($row = $result_provinsi->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama_provinsi']) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="kota_kab">PILIH KOTA/KAB:</label>
        <select id="kota_kab" name="kota_kab" required>
            <option value="" disabled selected>Pilih Kota/Kab</option>
            <?php while ($row = $result_kota->fetch_assoc()): ?>
                <option data-province="<?= $row['id_provinsi'] ?>" value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama_kota_kab']) ?></option>
            <?php endwhile; ?>
        </select>


        <button type="submit">Submit</button>
        <a href="kecamatan.php">Kembali</a>
    </form>

    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var selectedProvinsi = $(this).val();
                $('#kota_kab option').each(function() {
                    if ($(this).data('province') == selectedProvinsi) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#kota_kab').val('').change(); // Reset kota/kab selection
            });
        });
    </script>
</body>
</html>
