<?php
include 'db.php';

// Query untuk mendapatkan data dari tbl_khu
$query_khu = "SELECT kode_khu, nama_pemilik FROM tbl_khu";
$result_khu = $conn->query($query_khu);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kurir MDS</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Form Kurir MDS</h2>
    <form action="submit_kurir_mds.php" method="post" enctype="multipart/form-data">
        <!-- Dropdown untuk kode_khu dan nama_pemilik -->
        <label for="kode_khu">Kode KHU:</label>
        <select id="kode_khu" name="kode_khu" required>
            <option value="">Pilih Kode KHU</option>
            <?php while($row_khu = $result_khu->fetch_assoc()) { ?>
                <option value="<?= $row_khu['kode_khu'] ?>"><?= $row_khu['kode_khu'] ?> - <?= $row_khu['nama_pemilik'] ?></option>
            <?php } ?>
        </select><br>

        <label for="nama_pemilik">Nama Pemilik:</label>
        <input type="text" id="nama_pemilik" name="nama_pemilik" readonly required><br>

        <!-- Data pengguna lainnya -->
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="tempat_lahir">Tempat Lahir:</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" required><br>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select><br>

        <label for="nik">NIK:</label>
        <input type="text" id="nik" name="nik" required><br>

        <label for="no_hp_wa">No. HP/WA:</label>
        <input type="text" id="no_hp_wa" name="no_hp_wa" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <!-- Data kendaraan -->
        <label for="merek_kendaraan">Merek Kendaraan:</label>
        <input type="text" id="merek_kendaraan" name="merek_kendaraan" required><br>

        <label for="jenis_kendaraan">Jenis Kendaraan:</label>
        <input type="text" id="jenis_kendaraan" name="jenis_kendaraan" required><br>

        <label for="type_kendaraan">Type Kendaraan:</label>
        <input type="text" id="type_kendaraan" name="type_kendaraan" required><br>

        <label for="tahun_pembuatan">Tahun Pembuatan:</label>
        <input type="number" id="tahun_pembuatan" name="tahun_pembuatan" required><br>

        <label for="no_plat_kendaraan">No. Plat Kendaraan:</label>
        <input type="text" id="no_plat_kendaraan" name="no_plat_kendaraan" required><br>

        <!-- Foto upload -->
        <label for="foto_ktp">Foto KTP:</label>
        <input type="file" id="foto_ktp" name="foto_ktp" required><br>

        <label for="foto_sim">Foto SIM:</label>
        <input type="file" id="foto_sim" name="foto_sim" required><br>

        <label for="foto_stnk">Foto STNK:</label>
        <input type="file" id="foto_stnk" name="foto_stnk" required><br>

        <label for="foto_kendaraan">Foto Kendaraan:</label>
        <input type="file" id="foto_kendaraan" name="foto_kendaraan" required><br>

        <button type="submit">Submit</button>
    </form>

    <script>
        document.getElementById('kode_khu').addEventListener('change', function() {
            let selectedKodeKHU = this.options[this.selectedIndex].text.split(" - ")[1];
            document.getElementById('nama_pemilik').value = selectedKodeKHU || '';
        });
    </script>
</body>
</html>
