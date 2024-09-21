<?php
$host = "localhost";
$username = "root"; // ganti dengan username database
$password = ""; // ganti dengan password database
$dbname = "db_swakelola";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
