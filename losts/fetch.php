<?php
include '../config.php';

$sql = "SELECT losts.*, stations.stationName 
    FROM losts 
    INNER JOIN stations ON losts.station_name = stations.id 
    ORDER BY escape_date DESC, escape_time DESC";
$result = mysqli_query($conn, $sql);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Format status values in Arabic
    $row['report_status'] = match($row['report_status']) {
        'pending' => 'قيد الانتظار',
        'reported' => 'تم البلاغ',
        'closed' => 'مغلق',
        default => $row['report_status']
    };
    
    $row['collection_status'] = match($row['collection_status']) {
        'pending' => 'قيد الانتظار',
        'collected' => 'تم التحصيل',
        'uncollected' => 'لم يتم التحصيل',
        default => $row['collection_status']
    };
    
    $row['collection_method'] = match($row['collection_method']) {
        'cash' => 'كاش',
        'bank' => 'تحويل بنكي',
        'other' => 'أخرى',
        default => $row['collection_method']
    };

    // Add action buttons
    $row['actions'] = '<button class="btn btn-sm btn-primary editBtn" data-id="'.$row['id'].'"><i class="fas fa-edit"></i></button> 
                      <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row['id'].'"><i class="fas fa-trash"></i></button>';
    
    $data[] = $row;
}

echo json_encode($data);
mysqli_close($conn);
?>