<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Sanitize input
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $report_date = mysqli_real_escape_string($conn, $_POST['report_date']);
    $report_type = mysqli_real_escape_string($conn, $_POST['report_type']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $station_id = mysqli_real_escape_string($conn, $_POST['station_id']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $action_taken = mysqli_real_escape_string($conn, $_POST['action_taken']);
    $completion_date = mysqli_real_escape_string($conn, $_POST['completion_date']);

    $query = "UPDATE customer_reports 
              SET report_date = '$report_date',
                  report_type = '$report_type',
                  customer_name = '$customer_name',
                  station_id = '$station_id',
                  description = '$description',
                  action_taken = '$action_taken',
                  completion_date = '$completion_date'
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
