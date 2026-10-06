<?php
// Suppress PHP errors to prevent corruption of JSON response
error_reporting(0);

include '../config.php';

function sendJsonResponse($status, $message, $data = null) {
    $response = [
        'status' => $status,
        'message' => $message
    ];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    sendJsonResponse('error', 'طريقة طلب غير صالحة أو معرف غير موجود');
}

// Get and validate required fields
$id = $_POST['id'];
$employee_id = $_POST['employee_id'] ?? '';
$insurance_company = $_POST['insurance_company'] ?? '';
$end_date = $_POST['end_date'] ?? '';

// Validate required fields
if (empty($employee_id) || empty($insurance_company) || empty($end_date)) {
    sendJsonResponse('error', 'جميع الحقول المطلوبة يجب أن تكون موجودة');
}

try {
    // Calculate insurance status based on end date
    $today = new DateTime();
    $end = new DateTime($end_date);
    $status = 'active';

    if ($end < $today) {
        $status = 'expired';
    }

    // Update employee table with insurance information
    $query = "UPDATE employee SET 
        INSCAM = ?,
        DOINSE = ?
        WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", 
        $insurance_company,
        $end_date,
        $employee_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($conn));
    }

    if (mysqli_affected_rows($conn) > 0) {
        sendJsonResponse('success', 'تم تحديث التأمين بنجاح');
    } else {
        sendJsonResponse('info', 'لم يتم إجراء أي تغييرات');
    }

} catch (Exception $e) {
    sendJsonResponse('error', 'حدث خطأ أثناء تحديث التأمين: ' . $e->getMessage());
}
?>
