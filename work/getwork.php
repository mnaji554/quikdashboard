<?php
include ("../config.php");

// Query to fetch required work data
$query = "SELECT id, name, DOW as work_date FROM employee ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die(json_encode([
        'error' => true,
        'message' => 'Database query failed: ' . mysqli_error($conn)
    ]));
}

$output = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Format the work date if it exists
    if ($row['work_date']) {
        $row['work_date'] = date('Y-m-d', strtotime($row['work_date']));
    }
    $output[] = $row;
}

// Return JSON array directly as DataTables expects
echo json_encode($output);

mysqli_free_result($result);
mysqli_close($conn);
?>