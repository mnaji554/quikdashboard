<?php
include '../config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM losts WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);
mysqli_close($conn);
?>
