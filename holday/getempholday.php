<?php
include("../config.php");

// Modify the query to perform an INNER JOIN between employee and holday tables
$id = $_GET['id'];
$query = "SELECT holday.*, employee.id as employee_id, employee.name as employee_name 
          FROM holday 
          INNER JOIN employee ON holday.id = employee.id
          WHERE holday.id = $id";

$result = mysqli_query($conn, $query);
if (!$result) {
    die('Error in query');
}

$output = array();
while ($row = mysqli_fetch_assoc($result)) {
    $output[] = $row;
}

if (count($output) == 0) {
    print '{"data":[]}'; // this will print an empty JSON object
} else {

    print '{"data":' . json_encode($output) . '}'; // this will print the output in JSON
}
// Clear result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>