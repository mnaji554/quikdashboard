<?php
include '../config.php';

// Ensure proper error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

try {
    // Validate required fields
    if (!isset($_FILES['doc_file']) || !isset($_POST['station_id']) || !isset($_POST['doc_name']) 
        || !isset($_POST['doc_type']) || !isset($_POST['doc_num'])) {
        throw new Exception('جميع الحقول مطلوبة');
    }

    $uploadDir = '../uploads/docs/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['doc_file'];
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;

    // Validate file type
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('نوع الملف غير صالح. يسمح فقط بملفات PDF والصور');
    }

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('حدث خطأ أثناء رفع الملف');
    }

    // Prepare data
    $station_id = mysqli_real_escape_string($conn, $_POST['station_id']);
    $doc_name = mysqli_real_escape_string($conn, $_POST['doc_name']);
    $doc_type = mysqli_real_escape_string($conn, $_POST['doc_type']);
    $doc_num = mysqli_real_escape_string($conn, $_POST['doc_num']);
    $issue_date = mysqli_real_escape_string($conn, $_POST['issue_date']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $notification_days = mysqli_real_escape_string($conn, $_POST['notification_days']);

    $query = "INSERT INTO station_documents (station_id, doc_name, doc_type, doc_num, issue_date, expiry_date, doc_file, notification_days) 
              VALUES ('$station_id', '$doc_name', '$doc_type', '$doc_num', '$issue_date', '$expiry_date', '$fileName', '$notification_days')";    if (mysqli_query($conn, $query)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'تم إضافة المستند بنجاح'
        ]);
    } else {
        throw new Exception(mysqli_error($conn));
    }
} catch (Exception $e) {
    error_log("Error in insert.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    mysqli_close($conn);
}
?>
