<?php
include("../config.php");

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "SELECT r.*, s.stationName as station_name 
              FROM customer_reports r
              LEFT JOIN stations s ON r.station_id = s.id
              WHERE r.id = '$id'";
              
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Report not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>
