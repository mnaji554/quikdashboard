<?php
include '../config.php';

// Ensure proper error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);


try {
    if (!isset($_POST['id'])) {
        throw new Exception("معرف السجل مطلوب");
    }
    
    // Validate required fields
    $required_fields = ['station_id', 'product_id', 'sale_date', 
                       'opening_reading', 'closing_reading'];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            throw new Exception("الحقل {$field} مطلوب");
        }
    }
    
    // Calculate sales quantity
    $opening_reading = floatval($_POST['opening_reading']);
    $closing_reading = floatval($_POST['closing_reading']);
    
    $sales_quantity = $closing_reading - $opening_reading;
    if ($sales_quantity < 0) {
        throw new Exception("قراءة النهاية يجب أن تكون أكبر من قراءة البداية");
    }
    
    // Get price from products table
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $price_query = "SELECT price_per_unit FROM products WHERE id = '$product_id'";
    $price_result = mysqli_query($conn, $price_query);
    
    if (!$price_result || mysqli_num_rows($price_result) == 0) {
        throw new Exception("لم يتم العثور على سعر المنتج");
    }
    
    $price_row = mysqli_fetch_assoc($price_result);
    $price_per_unit = floatval($price_row['price_per_unit']);
    
    // Calculate total amount
    $total_amount = $sales_quantity * $price_per_unit;

    // Prepare data for update
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $station_id = mysqli_real_escape_string($conn, $_POST['station_id']);
    $sale_date = mysqli_real_escape_string($conn, $_POST['sale_date']);
    
    $query = "UPDATE daily_sales SET 
              station_id = '$station_id',
              product_id = '$product_id',
              sale_date = '$sale_date',
              opening_reading = '$opening_reading',
              closing_reading = '$closing_reading',
              sales_quantity = '$sales_quantity',
              total_amount = '$total_amount'
              WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'تم تحديث البيانات بنجاح'
        ]);
    } else {
        throw new Exception("خطأ في تحديث البيانات: " . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    error_log("Error in update.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    mysqli_close($conn);
}
?>
