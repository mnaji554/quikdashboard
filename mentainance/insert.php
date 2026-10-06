<?php
include '../config.php';

$task_name = $_POST['task_name'];
$frequency = $_POST['frequency'];
$last_service_date = $_POST['last_service_date'];
$next_due_date = $_POST['next_due_date'];
$responsible_person = $_POST['responsible_person'];
$status = $_POST['status'];

$sql = "INSERT INTO maintenance (task_name, frequency, last_service_date, next_due_date, responsible_person, status) 
        VALUES (?, ?, ?, ?, ?, ?)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $task_name, $frequency, $last_service_date, $next_due_date, $responsible_person, $status);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add task']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>
