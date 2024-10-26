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
    <title>Form Mitra Seller</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Form Mitra Seller</h2>
    <form action="submit_mitra_seller.php" method="post" enctype="multipart/form-data">
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

        <!-- Data toko -->
        <label for="nama_toko">Nama Toko:</label>
        <input type="text" id="nama_toko" name="nama_toko" required><br>

        <label for="produk_utama">Produk Utama:</label>
        <input type="text" id="produk_utama" name="produk_utama" required><br>

        <!-- Dropdown Provinsi, Kota/Kab, Kecamatan, Kelurahan -->
        <label for="id_provinsi">Provinsi:</label>
        <select id="id_provinsi" name="id_provinsi" onchange="fetchKotaKab(this.value)" required>
            <option value="">Pilih Provinsi</option>
            <?php while($row_provinsi = $result_provinsi->fetch_assoc()) { ?>
                <option value="<?= $row_provinsi['id'] ?>"><?= $row_provinsi['nama_provinsi'] ?></option>
            <?php } ?>
        </select><br>

        <label for="id_kota_kab">Kota/Kabupaten:</label>
        <select id="id_kota_kab" name="id_kota_kab" onchange="fetchKecamatan(this.value)" required>
            <option value="">Pilih Kota/Kabupaten</option>
        </select><br>

        <label for="id_kecamatan">Kecamatan:</label>
        <select id="id_kecamatan" name="id_kecamatan" onchange="fetchKelurahan(this.value)" required>
            <option value="">Pilih Kecamatan</option>
        </select><br>

        <label for="id_kelurahan">Kelurahan:</label>
        <select id="id_kelurahan" name="id_kelurahan" required>
            <option value="">Pilih Kelurahan</option>
        </select><br>

        <label for="rt_rw_no">RT/RW/No:</label>
        <input type="text" id="rt_rw_no" name="rt_rw_no" required><br>

        <!-- Foto upload -->
        <label for="foto_npwp">Foto NPWP:</label>
        <input type="file" id="foto_npwp" name="foto_npwp" required><br>

        <label for="foto_ktp">Foto KTP:</label>
        <input type="file" id="foto_ktp" name="foto_ktp" required><br>

        <label for="foto_logo_toko">Foto Logo Toko:</label>
        <input type="file" id="foto_logo_toko" name="foto_logo_toko" required><br>

        <button type="submit">Submit</button>
    </form>

    <script>
        document.getElementById('kode_khu').addEventListener('change', function() {
            let selectedKodeKHU = this.options[this.selectedIndex].text.split(" - ")[1];
            document.getElementById('nama_pemilik').value = selectedKodeKHU || '';
        });

        function fetchKotaKab(provinsiId) {
            if (provinsiId) {
                $.ajax({
                    url: 'fetch_kota.php',
                    type: 'POST',
                    data: { id: provinsiId },
                    success: function(response) {
                        $('#id_kota_kab').html(response);
                        $('#id_kecamatan').html('<option value="">Pilih Kecamatan</option>');
                        $('#id_kelurahan').html('<option value="">Pilih Kelurahan</option>');
                    }
                });
            }
        }

        function fetchKecamatan(kotaKabId) {
            if (kotaKabId) {
                $.ajax({
                    url: 'fetch_kecamatan.php',
                    type: 'POST',
                    data: { id: kotaKabId },
                    success: function(response) {
                        $('#id_kecamatan').html(response);
                        $('#id_kelurahan').html('<option value="">Pilih Kelurahan</option>');
                    }
                });
            }
        }

        function fetchKelurahan(kecamatanId) {
            if (kecamatanId) {
                $.ajax({
                    url: 'fetch_kelurahan.php',
                    type: 'POST',
                    data: { id: kecamatanId },
                    success: function(response) {
                        $('#id_kelurahan').html(response);
                    }
                });
            }
        }
    </script>
</body>
</html>
