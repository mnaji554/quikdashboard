<?php
include '../config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {    // Validate required fields
    $required_fields = ['station_name', 'escape_date', 'escape_time', 'car_number', 
                       'amount', 'report_status', 'reported_by', 'collection_status', 'fuel_type'];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("الحقل {$field} مطلوب");
        }
    }

    // Prepare data with proper escaping
    $data = [
        'station_name' => mysqli_real_escape_string($conn, $_POST['station_name']),
        'escape_date' => mysqli_real_escape_string($conn, $_POST['escape_date']),
        'escape_time' => mysqli_real_escape_string($conn, $_POST['escape_time']),       
        'car_type' => !empty($_POST['car_type']) ? mysqli_real_escape_string($conn, $_POST['car_type']) : null,
        'car_number' => mysqli_real_escape_string($conn, $_POST['car_number']),
        'amount' => mysqli_real_escape_string($conn, $_POST['amount']),
        'report_status' => mysqli_real_escape_string($conn, $_POST['report_status']),
        'reported_by' => mysqli_real_escape_string($conn, $_POST['reported_by']),
        'collection_status' => mysqli_real_escape_string($conn, $_POST['collection_status']),
        'collection_date' => !empty($_POST['collection_date']) ? mysqli_real_escape_string($conn, $_POST['collection_date']) : null,
        'collection_method' => !empty($_POST['collection_method']) ? mysqli_real_escape_string($conn, $_POST['collection_method']) : null,
        'client_mobile' => !empty($_POST['client_mobile']) ? mysqli_real_escape_string($conn, $_POST['client_mobile']) : null,
        'pump_number' => !empty($_POST['pump_number']) ? mysqli_real_escape_string($conn, $_POST['pump_number']) : null,
        'fuel_type' => mysqli_real_escape_string($conn, $_POST['fuel_type'])
    ];

    // Build SQL query
    $columns = implode(", ", array_keys($data));
    $values = [];
    foreach ($data as $value) {
        $values[] = $value === null ? "NULL" : "'" . $value . "'";
    }
    $valueString = implode(", ", $values);
    
    $sql = "INSERT INTO losts ({$columns}) VALUES ({$valueString})";
    
    // Log the query for debugging
    error_log("SQL Query: " . $sql);

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'تم إضافة البيانات بنجاح',
            'id' => mysqli_insert_id($conn)
        ]);
    } else {
        throw new Exception(mysqli_error($conn));
    }

} catch (Exception $e) {
    error_log("Error in insert.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'حدث خطأ أثناء إضافة البيانات: ' . $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>
