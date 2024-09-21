<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM tbl_kelurahan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: kelurahan.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
