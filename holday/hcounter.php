<?php



include("../config.php");
include("../header.php");

function calculateRemainingHolidays($start_date, $holidays_taken, $emergencies_taken) {
    $current_date = new DateTime();
    $start_date = new DateTime($start_date);
    $interval = $start_date->diff($current_date);
    $years = $interval->y + 1;

    $annual_holidays = $years * 21 ;
    $emergency_holidays = $years * 4 ;

    $remaining_annual_holidays = $annual_holidays - $holidays_taken;
    $remaining_emergency_holidays = $emergency_holidays - $emergencies_taken;

    return [
        'annual' => $remaining_annual_holidays,
        'emergency' => $remaining_emergency_holidays,
        'years' => $years,
        'annual_holidays' => $annual_holidays
    ];
}
$current_year = date('Y');
$query = "SELECT e.id, e.name, e.DOW,
                 (SELECT SUM(DATEDIFF(h.end_date, h.start_date) + 1) 
                  FROM holday h 
                  WHERE h.id = e.id AND h.type = 'annual' AND YEAR(h.start_date) = $current_year) AS holidays_taken,
                 (SELECT SUM(DATEDIFF(h.end_date, h.start_date) + 1)
                 FROM holday h
                  WHERE h.id = e.id AND h.type = 'emergency' AND YEAR(h.start_date) = $current_year) AS emergencies_taken
          FROM employee e where e.workplace = 'الإدارة'";
$result = mysqli_query($conn, $query);
?>

   

<div class="nvm" style="margin-bottom: 20px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        حاسبة الاجازات</a>
           

            </ul>
        </nav>
    </div>
</div>
    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
        <table id="hcounter" class="display" style="width:100%">
            <thead>
                <tr>
                   
                    <th>رقم الاقامة</th>
                    <th>الاسم</th>
                    <th>بداية العمل</th>
                    <th>عدد ايام الاجازة</th>
                    <th>رصيد الاجازات</th>
                    <th>عمليات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) {
                    $remaining_holidays = calculateRemainingHolidays($row['DOW'], $row['holidays_taken'], $row['emergencies_taken']);
                    
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['DOW']; ?></td>
                    <td>سنوية:<?php echo $row['holidays_taken'];?> / طارئة :<?php echo $row['emergencies_taken']; ?> </td>
                    <td>سنوية: <?php echo $remaining_holidays['annual']; ?> / طارئة: <?php echo $remaining_holidays['emergency']; ?></td>
      
                    <td>
                        <a href="empholday.php?id=<?php echo $row['id']; ?>" class="edit-btn"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#hcounter').DataTable({
                columnDefs: [{ className: "dt-center", targets: "_all" }],  
            });
        });
    </script>
</body>
</html>