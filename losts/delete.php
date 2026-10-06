<?php
include '../config.php';

$id = $_POST['id'];
$response = [];

if (mysqli_query($conn, "DELETE FROM losts WHERE id = $id")) {
    $response = [
        'status' => 'success',
        'message' => 'تم حذف البيانات بنجاح'
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'حدث خطأ أثناء حذف البيانات: ' . mysqli_error($conn)
    ];
}

mysqli_close($conn);
echo json_encode($response);
?>
