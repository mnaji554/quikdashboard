<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM daily_sales WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    echo json_encode(mysqli_fetch_assoc($result));
}
?>
