<?php
include '../config.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    // Validate input
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception('Invalid ID provided');
    }

    $id = intval($_POST['id']);

    $sql = "DELETE FROM maintenance WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Task deleted successfully'
            ]);
        } else {
            throw new Exception('Task not found');
        }
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    // Log the error
    error_log("Error in delete.php: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
