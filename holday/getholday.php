<?php
include ("../config.php");

// Modify the query to perform an INNER JOIN between employee and holday tables
$query = "SELECT holday.*, employee.id as employee_id, employee.name as employee_name 
          FROM holday 
          INNER JOIN employee ON holday.id = employee.id
          WHERE CURRENT_DATE BETWEEN holday.start_date AND holday.end_date
          ORDER BY employee.name";

$result = mysqli_query($conn, $query);
if (! $result) {
   die('Error in query');
} 

$output = array();
while ($row = mysqli_fetch_assoc($result)) {
    $output[] = $row;
}

if ($output) {
    print '{"data":' . json_encode($output) . '}'; // this will print the output in JSON
} else {
    print("{'msg':'No data found'}");
}

// Clear result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>