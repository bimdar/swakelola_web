<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM tbl_kota_kab WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: kota_kab.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
