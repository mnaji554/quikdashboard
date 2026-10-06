<?php
include("../config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM empfiles WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Error fetching data']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>