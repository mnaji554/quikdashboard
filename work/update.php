<?php
include("../config.php");

// Validate and sanitize input
$work_id = mysqli_real_escape_string($conn, $_POST['work_id']);
$work_name = mysqli_real_escape_string($conn, $_POST['work_name']);
$work_description = mysqli_real_escape_string($conn, $_POST['work_description']);
$start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
$end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

// Validate required fields
if (empty($work_id) || empty($work_name) || empty($work_description) || empty($start_date) || empty($end_date) || empty($status)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'جميع الحقول مطلوبة'
    ]);
    exit;
}

// Update query
$query = "UPDATE work 
          SET work_name = '$work_name', 
              work_description = '$work_description', 
              start_date = '$start_date', 
              end_date = '$end_date', 
              status = '$status' 
          WHERE id = '$work_id'";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'تم تحديث العمل بنجاح'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'خطأ في تحديث العمل: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>
