<?php
 // 1- connect to db
$host="localhost";
$user="u843396249_company";
$password="Almzah13";
$database="u843396249_company";
$conn=  mysqli_connect($host, $user, $password, $database);
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, "SET CHARACTER SET 'utf8'");
mysqli_set_charset($conn, 'utf8');

if(mysqli_connect_errno())
{ die("cannot connect to database field:". mysqli_connect_error());   }

// Function to convert Hijri date to Gregorian
function hijriToGregorian($hijriDate) {
    // Return as is if the date is invalid or empty
    if (empty($hijriDate) || $hijriDate == '0000-00-00') {
        return date('Y-m-d');
    }

    // If it doesn't match YYYY-MM-DD format, return as is
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $hijriDate)) {
        return $hijriDate;
    }

    list($year, $month, $day) = explode('-', $hijriDate);
    
    // Check if it's already a Gregorian date
    // Gregorian dates should be between 1900 and 2100 for our purpose
    // This helps identify if it's already Gregorian or if it's Hijri
    if ($year >= 1900 && $year <= 2100) {
        // Validate if it's a real Gregorian date
        if (checkdate($month, $day, $year)) {
            return $hijriDate; // It's a valid Gregorian date, return as is
        }
    }
    
    // If we get here, it's a Hijri date that needs conversion
    // Convert to integers for calculation
    $year = intval($year);
    $month = intval($month);
    $day = intval($day);

    // Adjustment factors for Hijri to Gregorian conversion
    $jd = intval((11 * $year + 3) / 30) + 354 * $year + 30 * $month - intval(($month - 1) / 2) + $day + 1948440 - 385;

    if ($jd > 2299160) {
        $l = $jd + 68569;
        $n = intval((4 * $l) / 146097);
        $l = $l - intval((146097 * $n + 3) / 4);
        $i = intval((4000 * ($l + 1)) / 1461001);
        $l = $l - intval((1461 * $i) / 4) + 31;
        $j = intval((80 * $l) / 2447);
        $day = $l - intval((2447 * $j) / 80);
        $l = intval($j / 11);
        $month = $j + 2 - (12 * $l);
        $year = 100 * ($n - 49) + $i + $l;
    } else {
        $j = $jd + 1402;
        $k = intval(($j - 1) / 1461);
        $l = $j - 1461 * $k;
        $n = intval(($l - 1) / 365) - intval($l / 1461);
        $i = $l - 365 * $n + 30;
        $j = intval((80 * $i) / 2447);
        $day = $i - intval((2447 * $j) / 80);
        $i = intval($j / 11);
        $month = $j + 2 - 12 * $i;
        $year = 4 * $k + $n + $i - 4716;
    }

    // Format and return the Gregorian date
    return sprintf('%04d-%02d-%02d', $year, $month, $day);
}
?>