<?php
include '../config.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception('يجب أن تكون الطريقة POST');
    }

    if (!isset($_POST['id'])) {
        throw new Exception('معرف الموظف مطلوب');
    }

    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete employee files first
        $files_query = "SELECT fimage FROM empfiles WHERE id = ?";
        $stmt = mysqli_prepare($conn, $files_query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result)) {
            if (!empty($row['fimage']) && file_exists($row['fimage'])) {
                unlink($row['fimage']);
            }
        }

        // Delete from empfiles table
        $delete_files = "DELETE FROM empfiles WHERE id = ?";
        $stmt = mysqli_prepare($conn, $delete_files);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        // Delete from holday table
        $delete_holidays = "DELETE FROM holday WHERE id = ?";
        $stmt = mysqli_prepare($conn, $delete_holidays);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        // Finally delete the employee
        $delete_employee = "DELETE FROM employee WHERE id = ?";
        $stmt = mysqli_prepare($conn, $delete_employee);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_affected_rows($conn) === 0) {
            throw new Exception('لم يتم العثور على الموظف');
        }

        // If we got here, commit the transaction
        mysqli_commit($conn);

        echo json_encode([
            'status' => 'success',
            'message' => 'تم حذف الموظف بنجاح'
        ]);

    } catch (Exception $e) {
        // Something went wrong, rollback the transaction
        mysqli_rollback($conn);
        throw $e;
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>