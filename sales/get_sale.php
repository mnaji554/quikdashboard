<?php
include '../config.php';


try {
    if (!isset($_GET['id'])) {
        throw new Exception("معرف السجل مطلوب");
    }

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT ds.*, p.price_per_unit 
              FROM daily_sales ds
              LEFT JOIN products p ON ds.product_id = p.id 
              WHERE ds.id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }
    
    $sale = mysqli_fetch_assoc($result);
    if (!$sale) {
        throw new Exception("لم يتم العثور على السجل");
    }
    
    echo json_encode($sale);
    
} catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    mysqli_close($conn);
}
?>
