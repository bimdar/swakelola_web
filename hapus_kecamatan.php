<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM tbl_kecamatan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: kecamatan.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
