<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Konfirmasi Transaksi</h1>
    <form action="submit_konfirmasi.php" method="post" enctype="multipart/form-data">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="bank">Nama Bank:</label>
        <input type="text" id="bank" name="bank" required>

        <label for="atas_nama">Atas Nama:</label>
        <input type="text" id="atas_nama" name="atas_nama" required>

        <label for="jumlah_transfer">Jumlah Transfer:</label>
        <input type="number" id="jumlah_transfer" name="jumlah_transfer" required>

        <label for="tanggal_transfer">Tanggal Transfer:</label>
        <input type="date" id="tanggal_transfer" name="tanggal_transfer" required>

        <label for="bukti_transfer">Bukti Transfer:</label>
        <input type="file" id="bukti_transfer" name="bukti_transfer" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
