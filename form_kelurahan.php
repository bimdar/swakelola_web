<?php
include 'db.php';

$result_kecamatan = $conn->query("SELECT * FROM tbl_kecamatan");
$result_kota = $conn->query("SELECT * FROM tbl_kota_kab");
$result_provinsi = $conn->query("SELECT * FROM tbl_provinsi");

// Check if the queries were successful
if (!$result_kecamatan || !$result_kota || !$result_provinsi) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kelurahan</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Input Kelurahan</h1>
    <form action="submit_kelurahan.php" method="post">
        <label for="nama_kelurahan">NAMA KELURAHAN:</label>
        <input type="text" id="nama_kelurahan" name="nama_kelurahan" required>

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

        <label for="kecamatan">PILIH KECAMATAN:</label>
        <select id="kecamatan" name="kecamatan" required>
            <option value="" disabled selected>Pilih Kecamatan</option>
            <?php while ($row = $result_kecamatan->fetch_assoc()): ?>
                <option data-kota_kab="<?= $row['id_kota_kab'] ?>" value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama_kecamatan']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Submit</button>
        <a href="kelurahan.php">Kembali</a>
    </form>

    <script>
       $(document).ready(function() {
        // Filter kota/kab berdasarkan provinsi
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

        // Filter kecamatan berdasarkan kota/kab
        $('#kota_kab').change(function() {
            var selectedKotaKab = $(this).val();
            $('#kecamatan option').show(); // Show all options before filtering
            $('#kecamatan option').each(function() {
                if ($(this).data('kota_kab') == selectedKotaKab) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#kecamatan').val('').change(); // Reset kecamatan selection
        });
    });
    </script>
</body>
</html>
