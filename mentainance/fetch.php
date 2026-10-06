<?php
include("../config.php");

$query = "SELECT id, task_name, frequency, last_service_date, next_due_date, responsible_person, status FROM maintenance";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $row['actions'] = '<button class="editBtn" data-id="' . $row['id'] . '">Edit</button> | <button class="deleteBtn" data-id="' . $row['id'] . '">Delete</button>';
    $data[] = $row;
}

echo json_encode($data);
?> 