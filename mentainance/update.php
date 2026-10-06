<?php
include '../config.php';

$id = $_POST['id'];
$task_name = $_POST['task_name'];
$frequency = $_POST['frequency'];
$last_service_date = $_POST['last_service_date'];
$next_due_date = $_POST['next_due_date'];
$responsible_person = $_POST['responsible_person'];
$status = $_POST['status'];

$sql = "UPDATE maintenance SET 
        task_name = ?, 
        frequency = ?, 
        last_service_date = ?, 
        next_due_date = ?, 
        responsible_person = ?, 
        status = ? 
        WHERE id = ?";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $task_name, $frequency, $last_service_date, $next_due_date, $responsible_person, $status, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update task']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>
