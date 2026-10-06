<?php
include '../config.php';
try {
    if (!isset($_POST['id'])) {
        throw new Exception("معرف السجل مطلوب");
    }
    
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $query = "DELETE FROM daily_sales WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'تم حذف السجل بنجاح'
        ]);
    } else {
        throw new Exception(mysqli_error($conn));
    }
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    mysqli_close($conn);
}
?>
