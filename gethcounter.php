<?php
include ("config.php");
$query = "SELECT *, DATEDIFF(CURDATE(), workstart) as daycount, DATEDIFF(CURDATE(), workstart) - 365 as rest from hcounter";
$result = mysqli_query($conn, $query);
if (! $result) {
   die('Error in query');
} 
$output = array();
while ($row=mysqli_fetch_assoc($result)) {
    $output [] = $row;
}
if ($output) {
    $data= "data";
	print '{"data":'.json_encode($output).'}';// this will print the output in json

 
 }
 else{
 	print("{'msg':' cannot login'}");
 }


// 4 clear
mysqli_free_result($result);
//5- close connection
mysqli_close($conn);
?>