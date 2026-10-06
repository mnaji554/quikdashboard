<?php
include '../config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get posted data
$employee_id = $_POST['employee_id'];
$insurance_company = $_POST['insurance_company'];
$end_date = $_POST['end_date'];

// Update employee table
$query = "UPDATE employee SET 
    INSCAM = ?,
    DOINSE = ?
WHERE id = ?";

// Calculate insurance status
$today = new DateTime();
$end = new DateTime($end_date);
$status = 'active';

if ($end < $today) {
    $status = 'expired';
} 

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sss", 
    $insurance_company,
    $end_date,
    $employee_id
);

$response = array();
if (mysqli_stmt_execute($stmt)) {
    $response['status'] = 'success';
    $response['message'] = 'تم إضافة التأمين بنجاح';
} else {
    $response['status'] = 'error';
    $response['message'] = 'حدث خطأ أثناء إضافة التأمين: ' . mysqli_error($conn);
}

echo json_encode($response);
?>
