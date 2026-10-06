<?php
include("../config.php");

// Validate and sanitize input
$id = mysqli_real_escape_string($conn, $_POST['id']);

if (empty($id)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'معرف العمل مطلوب'
    ]);
    exit;
}

// Delete query
$query = "DELETE FROM work WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'تم حذف العمل بنجاح'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'خطأ في حذف العمل: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>
