<?php
// Koneksi ke database
$conn = new mysqli("localhost", "username", "password", "db_swakelola");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['kode_khu'])) {
    $kodeKhu = $conn->real_escape_string($_GET['kode_khu']);
    $sql = "SELECT nama_pemilik FROM tbl_khu WHERE kode_khu = '$kodeKhu'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['nama_pemilik' => null]);
    }
}

$conn->close();
?>
