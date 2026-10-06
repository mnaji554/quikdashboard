<?php
include '../config.php';

$query = "SELECT ds.*, s.stationName as station_name, p.name as product_name, p.price_per_unit
          FROM daily_sales ds
          LEFT JOIN stations s ON ds.station_id = s.id
          LEFT JOIN products p ON ds.product_id = p.id
          WHERE 1=1";

// Apply filters if provided
if (isset($_GET['station_id']) && !empty($_GET['station_id'])) {
    $station_id = mysqli_real_escape_string($conn, $_GET['station_id']);
    $query .= " AND ds.station_id = '$station_id'";
}

if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);
    $query .= " AND ds.product_id = '$product_id'";
}

if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $start_date = mysqli_real_escape_string($conn, $_GET['start_date']);
    $query .= " AND ds.sale_date >= '$start_date'";
}

if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
    $end_date = mysqli_real_escape_string($conn, $_GET['end_date']);
    $query .= " AND ds.sale_date <= '$end_date'";
}

$query .= " ORDER BY ds.sale_date DESC, s.stationName";

$result = mysqli_query($conn, $query);
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    // Format numbers
    $row['sales_quantity'] = number_format($row['sales_quantity'], 2);
    $row['price_per_unit'] = number_format($row['price_per_unit'], 2);
    $row['total_amount'] = number_format($row['total_amount'], 2);
    
    // Add actions column
    $row['actions'] = '<button class="btn btn-sm btn-primary editBtn" data-id="' . $row['id'] . '">
        <i class="fas fa-edit"></i> تعديل
    </button>&nbsp;
    <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row['id'] . '">
        <i class="fas fa-trash"></i> حذف
    </button>';
    $data[] = $row;
}

// Set proper content type
header('Content-Type: application/json');

// Return the data in the format DataTables expects
echo json_encode(array(
    "draw" => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
    "recordsTotal" => count($data),
    "recordsFiltered" => count($data),
    "data" => $data
));
?>