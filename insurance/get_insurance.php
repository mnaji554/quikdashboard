<?php
include '../config.php';



if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $query = "SELECT 
        id,
        id as id_number,
        INSCAM as insurance_company,
        DOINSE as end_date
    FROM employee 
    WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $insurance = mysqli_fetch_assoc($result);
    
    echo json_encode($insurance);
} else {
    echo json_encode(['status' => 'error', 'message' => 'معرف غير صالح']);
}
?>
