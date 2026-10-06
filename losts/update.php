<?php
// Suppress PHP errors to prevent corruption of JSON response
error_reporting(0);
header('Content-Type: application/json');

include '../config.php';

if (!isset($_POST['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing ID parameter'
    ]);
    exit;
}

$id = mysqli_real_escape_string($conn, $_POST['id']);
$data = [
    'station_name' => $_POST['station_name'],
    'escape_date' => $_POST['escape_date'],
    'escape_time' => $_POST['escape_time'],
    'car_type' => $_POST['car_type'],
    'car_number' => $_POST['car_number'],
    'amount' => $_POST['amount'],
    'report_status' => $_POST['report_status'],
    'reported_by' => $_POST['reported_by'],
    'collection_status' => $_POST['collection_status'],
    'collection_date' => $_POST['collection_date'] ?: null,
    'collection_method' => $_POST['collection_method'] ?: null,
    'client_mobile' => $_POST['client_mobile'] ?: null,
    'pump_number' => $_POST['pump_number'],
    'fuel_type' => $_POST['fuel_type']
];

$updateFields = [];
foreach ($data as $key => $value) {
    if ($value === null) {
        $updateFields[] = "`$key` = NULL";
    } else {
        $value = mysqli_real_escape_string($conn, $value);
        $updateFields[] = "`$key` = '$value'";
    }
}

$sql = "UPDATE losts SET " . implode(", ", $updateFields) . " WHERE id = $id";

$response = [];
if (mysqli_query($conn, $sql)) {
    $response = [
        'status' => 'success',
        'message' => 'تم تحديث البيانات بنجاح'
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'حدث خطأ أثناء تحديث البيانات: ' . mysqli_error($conn)
    ];
}

mysqli_close($conn);



// Clean any output buffers
while (ob_get_level()) {
    ob_end_clean();
}

echo json_encode($response);
exit;
