<?php
include("../config.php");
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idm']) && !empty($_POST['idm'])) {
        $idm = mysqli_real_escape_string($conn, $_POST['idm']);

        // First check if the record exists
        $check_sql = "SELECT COUNT(*) as count FROM holday WHERE idm = '$idm'";
        $check_result = mysqli_query($conn, $check_sql);
        $row = mysqli_fetch_assoc($check_result);

        if ($row['count'] == 0) {
            echo json_encode(["status" => "error", "message" => "السجل غير موجود"]);
            exit;
        }

        // Delete the record from the holday table
        $sql = "DELETE FROM holday WHERE idm = '$idm'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "Record deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Could not delete record: " . mysqli_error($conn)]);
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