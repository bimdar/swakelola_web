<?php
include 'db.php'; // Pastikan koneksi ke database

if (isset($_POST['id'])) {
    $id_kota_kab = $_POST['id'];

    // Query untuk mendapatkan data Kecamatan berdasarkan id_kota_kab
    $query = "SELECT id, nama_kecamatan FROM tbl_kecamatan WHERE id_kota_kab = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_kota_kab); // Mengikat parameter untuk query
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        // Outputkan hasilnya dalam bentuk <option>
        echo '<option value="">Pilih Kecamatan</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['nama_kecamatan'] . '</option>';
        }
    } else {
        // Jika tidak ada data
        echo '<option value="">Kecamatan tidak ditemukan</option>';
    }

    $stmt->close(); // Tutup statement
} else {
    echo '<option value="">Error: ID Kota/Kab tidak ditemukan</option>';
}
?>
