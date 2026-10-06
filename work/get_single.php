<?php
include("../config.php");

// Validate and sanitize input
$id = mysqli_real_escape_string($conn, $_GET['id']);

if (empty($id)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'معرف العمل مطلوب'
    ]);
    exit;
}

// Select query
$query = "SELECT DOW FROM employee  WHERE id = '$id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if ($result && $row = mysqli_fetch_assoc($result)) {
    // Format dates for form
    $row['start_date'] = date('Y-m-d', strtotime($row['start_date']));
    $row['end_date'] = date('Y-m-d', strtotime($row['end_date']));
    echo json_encode($row);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'العمل غير موجود'
    ]);
}

mysqli_close($conn);
?>
