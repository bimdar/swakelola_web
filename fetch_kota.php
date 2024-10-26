<?php
include 'db.php'; // Pastikan koneksi ke database

if (isset($_POST['id'])) {
    $id_provinsi = $_POST['id'];

    // Query untuk mendapatkan data Kota/Kab berdasarkan id_provinsi
    $query = "SELECT id, nama_kota_kab FROM tbl_kota_kab WHERE id_provinsi = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_provinsi); // Mengikat parameter untuk query
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        // Outputkan hasilnya dalam bentuk <option>
        echo '<option value="">Pilih Kota/Kabupaten</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['nama_kota_kab'] . '</option>';
        }
    } else {
        // Jika tidak ada data
        echo '<option value="">Kota/Kab tidak ditemukan</option>';
    }

    $stmt->close(); // Tutup statement
} else {
    echo '<option value="">Error: ID Provinsi tidak ditemukan</option>';
}
?>
