<?php
include "../config.php";

header('Content-Type: application/json; charset=utf-8');

try {
    if (isset($_GET['id'])) {
        // Fetch single document
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT d.*, s.stationName as station_name 
                 FROM station_documents d 
                 LEFT JOIN stations s ON d.station_id = s.id 
                 WHERE d.id = '$id'";
        
        $result = mysqli_query($conn, $query);
        
        if ($result && $document = mysqli_fetch_assoc($result)) {
            // Convert dates for single document fetch
            $document['issue_date'] = hijriToGregorian($document['issue_date']);
            $document['expiry_date'] = hijriToGregorian($document['expiry_date']);
            echo json_encode($document);
        } else {
            throw new Exception('لم يتم العثور على المستند');
        }
    } else {
        // Fetch all documents
        $query = "SELECT d.*, s.stationName as station_name
                 FROM station_documents d
                 LEFT JOIN stations s ON d.station_id = s.id
                 ORDER BY d.expiry_date ASC";
        
        $result = mysqli_query($conn, $query);
        $documents = [];        
        while ($doc = mysqli_fetch_assoc($result)) {
            // Convert dates to Gregorian format
            $doc['issue_date'] = hijriToGregorian($doc['issue_date']);
            $doc['expiry_date'] = hijriToGregorian($doc['expiry_date']);
            
            // Calculate days remaining based on converted Gregorian date
            $today = new DateTime();
            $expiryDate = new DateTime($doc['expiry_date']);
            $interval = $today->diff($expiryDate);
            $doc['days_remaining'] = $expiryDate > $today ? $interval->days : -$interval->days;
            
            // Calculate status based on converted date
            if ($expiryDate < $today) {
                $doc['status'] = 'expired';
            } elseif ($doc['days_remaining'] <= $doc['notification_days']) {
                $doc['status'] = 'soon_expire';
            } else {
                $doc['status'] = 'active';
            }
            
            $downloadLink = '<a href="../uploads/docs/' . $doc['doc_file'] . '" class="btn btn-sm btn-info" download>تحميل</a>';
            $doc['actions'] = '<div class="btn-group">
                <button class="btn btn-sm btn-primary editBtn" data-id="' . $doc['id'] . '">تعديل</button>
                ' . $downloadLink . '
                <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $doc['id'] . '">حذف</button>
            </div>';
            $documents[] = $doc;
        }
        echo json_encode($documents);
    }
} catch (Exception $e) {
    error_log("Error in fetch.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    mysqli_close($conn);
}
?>