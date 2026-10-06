<?php
include '../config.php';

$query = "SELECT 
    e.id,
    e.name as employee_name,
    e.id as id_number,
    e.nat as nationality,
    e.DOB as date_of_birth,
    e.INSCAM as insurance_company,
    e.DOINSE as end_date,
    CASE 
        WHEN e.DOINSE IS NULL OR e.DOINSE = '' OR e.INSCAM IS NULL OR e.INSCAM = '' THEN 'pending'
        WHEN e.DOINSE < CURDATE() THEN 'expired'
        WHEN DATEDIFF(e.DOINSE, CURDATE()) <= 30 THEN 'warning'
        ELSE 'active'
    END as status,
    DATEDIFF(e.DOINSE, CURDATE()) as days_remaining
FROM 
    employee e
ORDER BY e.DOINSE DESC";

$result = mysqli_query($conn, $query);
$data = array();

while ($row = mysqli_fetch_assoc($result)) {    // Format dates
 
    // Add action buttons
    $row['actions'] = '
        <button type="button" class="btn btn-sm btn-primary editBtn" data-id="' . $row['id'] . '">
            <i class="fas fa-edit"></i>
        </button>';

    $data[] = $row;
}

echo json_encode($data);
?>