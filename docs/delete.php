<?php
include '../config.php';

header('Content-Type: application/json');

try {
    if (!isset($_POST['id'])) {
        throw new Exception('معرف المستند مطلوب');
    }

    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Get the document file name before deleting
    $result = mysqli_query($conn, "SELECT doc_file FROM station_documents WHERE id = '$id'");
    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }
    
    $document = mysqli_fetch_assoc($result);

    if ($document) {
        // Delete the file
        $filePath = '../uploads/docs/' . $document['doc_file'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the database record
        $deleteResult = mysqli_query($conn, "DELETE FROM station_documents WHERE id = '$id'");
        if (!$deleteResult) {
            throw new Exception(mysqli_error($conn));
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'تم حذف المستند بنجاح'
        ]);
    } else {
        throw new Exception('المستند غير موجود');
    }
} catch (Exception $e) {
    error_log("Error in delete.php: " . $e->getMessage());
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
