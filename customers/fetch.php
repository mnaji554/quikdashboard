<?php
include("../config.php");

$query = "SELECT r.*, s.stationName as station_name 
          FROM customer_reports r
          LEFT JOIN stations s ON r.station_id = s.id
          ORDER BY r.report_date DESC";

$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $row['actions'] = '<button class="btn btn-sm btn-primary editBtn mx-1" data-id="' . $row['id'] . '">
                        <i class="fas fa-edit"></i> تعديل
                      </button>
                      <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row['id'] . '">
                        <i class="fas fa-trash"></i> حذف
                      </button>';
    $data[] = $row;
}

echo json_encode($data);
?>