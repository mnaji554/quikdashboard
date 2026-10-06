<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $report_date = mysqli_real_escape_string($conn, $_POST['report_date']);
    $report_type = mysqli_real_escape_string($conn, $_POST['report_type']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $station_id = mysqli_real_escape_string($conn, $_POST['station_id']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $action_taken = mysqli_real_escape_string($conn, $_POST['action_taken']);
    $completion_date = mysqli_real_escape_string($conn, $_POST['completion_date']);

    $query = "INSERT INTO customer_reports 
              (report_date, report_type, customer_name, station_id, description, action_taken, completion_date) 
              VALUES 
              ('$report_date', '$report_type', '$customer_name', '$station_id', '$description', '$action_taken', '$completion_date')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}
?>
