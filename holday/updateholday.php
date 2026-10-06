<?php
include("../config.php");
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['column']) && isset($_POST['value'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $column = (int)$_POST['column'];
        $value = mysqli_real_escape_string($conn, $_POST['value']);

        // Map column index to column name
        $columns = [
            3 => 'start_date',
            4 => 'end_date',
            5 => 'reason'
        ];

        if (array_key_exists($column, $columns)) {
            $columnName = $columns[$column];

            // Update the holday table
            $sql = "UPDATE holday SET $columnName = '$value' WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo json_encode(["status" => "success", "message" => "Record updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Could not update record: " . mysqli_error($conn)]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid column index."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

// Close connection
mysqli_close($conn);
?>