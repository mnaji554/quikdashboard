<?php
include("../config.php");

if(isset($_POST["query"])) {
    $search = mysqli_real_escape_string($conn, $_POST["query"]);
    $query = "SELECT *, DATEDIFF(DOIDE,CURDATE()) as expire 
              FROM employee 
              WHERE name LIKE '%$search%' 
              OR id LIKE '%$search%' 
              OR Occupation LIKE '%$search%'";
    
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $expireClass = $row['expire'] <= 30 ? 'expire-warning' : 'expire-ok';
            $expireDays = $row['expire'];
            $expireText = $expireDays <= 30 ? 'ينتهي خلال ' : 'متبقي ';
            ?>
            <div class="employee-card">
                <div class="card-actions">
                    <a href="updemployed.php?id=<?php echo $row['id']; ?>" class="action-btn" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="javascript:void(0);" 
                       onclick="confirmDelete('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>')" 
                       class="action-btn delete" 
                       title="حذف">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="employee.php?id=<?php echo $row['id']; ?>" class="action-btn" title="عرض">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>

                <div class="employee-name"><?php echo $row['name']; ?></div>
                <div class="employee-id"><?php echo $row['id']; ?></div>
                
                <div class="info-row">
                    <span class="info-label">المهنة:</span>
                    <span class="info-content"><?php echo $row['Occupation']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">تاريخ الميلاد:</span>
                    <span class="info-content"><?php echo $row['DOB']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">الاقامة:</span>
                    <span class="info-content <?php echo $expireClass; ?>">
                        <?php echo $expireText . $row['expire']; ?> يوم
                    </span>
                </div>
            </div>
        <?php }
    } else {
        echo '<div class="no-results">
                <div class="no-results-content">
                    <i class="fas fa-search" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1rem;"></i>
                    <h3>لا توجد نتائج</h3>
                    <p>لم يتم العثور على نتائج مطابقة للبحث</p>
                </div>
            </div>';
    }
} ?>