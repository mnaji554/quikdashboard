<?php
include '../config.php'; 
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM maintenance WHERE id=$id");
echo json_encode($result->fetch_assoc());
?>
