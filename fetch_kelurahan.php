<?php
include 'db.php'; // Pastikan koneksi ke database

if (isset($_POST['id'])) {
    $id_kecamatan = $_POST['id'];

    // Query untuk mendapatkan data Kelurahan berdasarkan id_kecamatan
    $query = "SELECT id, nama_kelurahan FROM tbl_kelurahan WHERE id_kecamatan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_kecamatan); // Mengikat parameter untuk query
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        // Outputkan hasilnya dalam bentuk <option>
        echo '<option value="">Pilih Kelurahan</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['nama_kelurahan'] . '</option>';
        }
    } else {
        // Jika tidak ada data
        echo '<option value="">Kelurahan tidak ditemukan</option>';
    }

    $stmt->close(); // Tutup statement
} else {
    echo '<option value="">Error: ID Kecamatan tidak ditemukan</option>';
}
?>
