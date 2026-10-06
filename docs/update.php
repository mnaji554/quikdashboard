<?php
include '../config.php';

header('Content-Type: application/json');

try {
    if (!isset($_POST['id']) || !isset($_POST['station_id']) || !isset($_POST['doc_name']) ||
        !isset($_POST['doc_type']) || !isset($_POST['doc_num']) || !isset($_POST['issue_date']) || 
        !isset($_POST['expiry_date']) || !isset($_POST['notification_days'])) {
        throw new Exception('جميع الحقول مطلوبة');
    }

    $file = null;
    $fileName = null;

    // Handle file upload if a new file is provided
    if (isset($_FILES['doc_file']) && $_FILES['doc_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['doc_file'];
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = '../uploads/docs/' . $fileName;

        // Validate file type
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('نوع الملف غير مسموح به. يُسمح فقط بملفات PDF والصور.');
        }

        // Create directory if it doesn't exist
        if (!file_exists('../uploads/docs/')) {
            mkdir('../uploads/docs/', 0777, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception('خطأ في رفع الملف');
        }

        // Delete old file if new file is uploaded
        $result = mysqli_query($conn, "SELECT doc_file FROM station_documents WHERE id = '" . mysqli_real_escape_string($conn, $_POST['id']) . "'");
        if (!$result) {
            throw new Exception(mysqli_error($conn));
        }
        
        $oldDoc = mysqli_fetch_assoc($result);
        
        if ($oldDoc && $oldDoc['doc_file']) {
            $oldPath = '../uploads/docs/' . $oldDoc['doc_file'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
    }

    // Update database record
    $sql = "UPDATE station_documents SET 
            station_id = '" . mysqli_real_escape_string($conn, $_POST['station_id']) . "',
            doc_name = '" . mysqli_real_escape_string($conn, $_POST['doc_name']) . "',
            doc_type = '" . mysqli_real_escape_string($conn, $_POST['doc_type']) . "',
            doc_num = '" . mysqli_real_escape_string($conn, $_POST['doc_num']) . "',
            issue_date = '" . mysqli_real_escape_string($conn, $_POST['issue_date']) . "',
            expiry_date = '" . mysqli_real_escape_string($conn, $_POST['expiry_date']) . "',
            notification_days = '" . mysqli_real_escape_string($conn, $_POST['notification_days']) . "'";
    
    if ($fileName !== null) {
        $sql .= ", doc_file = '" . mysqli_real_escape_string($conn, $fileName) . "'";
    }
    
    $sql .= " WHERE id = '" . mysqli_real_escape_string($conn, $_POST['id']) . "'";

    $updateResult = mysqli_query($conn, $sql);
    if (!$updateResult) {
        throw new Exception(mysqli_error($conn));
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'تم تحديث المستند بنجاح'
    ]);
} catch (Exception $e) {
    error_log("Error in update.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>
