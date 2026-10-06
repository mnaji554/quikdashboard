<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Check if there's an attachment to delete
    $query = "SELECT attachment FROM employee_insurance WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $insurance = mysqli_fetch_assoc($result);
    
    // Delete the file if it exists
    if (!empty($insurance['attachment'])) {
        $file_path = '../' . $insurance['attachment'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // Delete the record
    $query = "DELETE FROM employee_insurance WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    $response = array();
    if (mysqli_stmt_execute($stmt)) {
        $response['status'] = 'success';
        $response['message'] = 'تم حذف التأمين بنجاح';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'حدث خطأ أثناء حذف التأمين';
    }
    
    echo json_encode($response);
}
?>
