<?php
include 'db.php';

// Query untuk mendapatkan data provinsi
$query_provinsi = "SELECT id, nama_provinsi FROM tbl_provinsi";
$result_provinsi = $conn->query($query_provinsi);

// Query untuk mendapatkan data dari tbl_khu
$query_khu = "SELECT kode_khu, nama_pemilik FROM tbl_khu";
$result_khu = $conn->query($query_khu);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Form Input Data</h2>
    <form action="submit.php" method="post" enctype="multipart/form-data">
        
        <!-- Dropdown untuk kode_khu dan nama_pemilik -->
        <label for="kode_khu">Kode KHU:</label>
        <select id="kode_khu" name="kode_khu">
            <option value="">Pilih Kode KHU</option>
            <?php while($row_khu = $result_khu->fetch_assoc()) { ?>
                <option value="<?= $row_khu['kode_khu'] ?>"><?= $row_khu['kode_khu'] ?> - <?= $row_khu['nama_pemilik'] ?></option>
            <?php } ?>
        </select><br>

        <label for="nama_pemilik">Nama Pemilik:</label>
        <input type="text" id="nama_pemilik" name="nama_pemilik" readonly><br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="pekerjaan">Pekerjaan:</label>
        <input type="text" id="pekerjaan" name="pekerjaan"><br>

        <label for="Lembaga">Lembaga:</label>
        <input type="text" id="Lembaga" name="Lembaga"><br>

        <label for="tempat_lahir">Tempat Lahir:</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir"><br>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir"><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin">
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select><br>

        <label for="nik">NIK:</label>
        <input type="text" id="nik" name="nik"><br>

        <label for="agama">Agama:</label>
        <input type="text" id="agama" name="agama"><br>

        <label for="no_hp_wa">No. HP/WA:</label>
        <input type="text" id="no_hp_wa" name="no_hp_wa"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>

        <!-- Dropdown Provinsi, Kota/Kab, Kecamatan, Kelurahan -->
        <label for="id_provinsi">Provinsi:</label>
        <select id="id_provinsi" name="id_provinsi" onchange="fetchKotaKab(this.value)">
            <option value="">Pilih Provinsi</option>
            <?php while($row_provinsi = $result_provinsi->fetch_assoc()) { ?>
                <option value="<?= $row_provinsi['id'] ?>"><?= $row_provinsi['nama_provinsi'] ?></option>
            <?php } ?>
        </select><br>

        <label for="id_kota_kab">Kota/Kabupaten:</label>
        <select id="id_kota_kab" name="id_kota_kab" onchange="fetchKecamatan(this.value)">
            <option value="">Pilih Kota/Kabupaten</option>
        </select><br>

        <label for="id_kecamatan">Kecamatan:</label>
        <select id="id_kecamatan" name="id_kecamatan" onchange="fetchKelurahan(this.value)">
            <option value="">Pilih Kecamatan</option>
        </select><br>

        <label for="id_kelurahan">Kelurahan:</label>
        <select id="id_kelurahan" name="id_kelurahan">
            <option value="">Pilih Kelurahan</option>
        </select><br>

        <label for="rt_rw_no">RT/RW/No:</label>
        <input type="text" id="rt_rw_no" name="rt_rw_no"><br>

        <label for="nama_ahli_waris">Nama Ahli Waris:</label>
        <input type="text" id="nama_ahli_waris" name="nama_ahli_waris"><br>

        <label for="nik_ahli_waris">NIK Ahli Waris:</label>
        <input type="text" id="nik_ahli_waris" name="nik_ahli_waris"><br>

        <label for="hubungan_ahli_waris">Hubungan Ahli Waris:</label>
        <input type="text" id="hubungan_ahli_waris" name="hubungan_ahli_waris"><br>

        <label for="foto_npwp">Foto NPWP:</label>
        <input type="file" id="foto_npwp" name="foto_npwp"><br>

        <label for="foto_ktp">Foto KTP:</label>
        <input type="file" id="foto_ktp" name="foto_ktp"><br>

        <label for="foto_diri">Foto Diri:</label>
        <input type="file" id="foto_diri" name="foto_diri"><br>

        <button type="submit">Submit</button>
    </form>

    <script>
        // Sync Nama Pemilik berdasarkan Kode KHU
        document.getElementById('kode_khu').addEventListener('change', function() {
            let selectedKodeKHU = this.options[this.selectedIndex].text.split(" - ")[1];
            document.getElementById('nama_pemilik').value = selectedKodeKHU || '';
        });

        // Function untuk fetch Kota/Kab, Kecamatan, Kelurahan
        function fetchKotaKab(provinsiId) {
            // AJAX untuk mengambil data Kota/Kabupaten
        }

        function fetchKecamatan(kotaKabId) {
            // AJAX untuk mengambil data Kecamatan
        }

        function fetchKelurahan(kecamatanId) {
            // AJAX untuk mengambil data Kelurahan
        }
    </script>
</body>
</html>
