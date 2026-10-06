<?php include("../header.php"); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<link rel="stylesheet" href="../assets/css/employees.css">

<div class="page-header">
    <div class="header-content">
        <h1 class="page-title">الموظفين</h1>
        
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" 
                   class="search-input" 
                   id="username" 
                   name="username" 
                   placeholder="بحث عن موظف" 
                   autocomplete="off" 
                   autofocus>
        </div>

        <a href="addemployee.php" class="add-employee-btn">
            <i class="fas fa-user-plus"></i>
            اضافة موظف
        </a>
    </div>
</div>

<div class="employee-grid" id="empcard">
    <?php
    include("../config.php");
    $limit = 24;
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_from = ($page - 1) * $limit;
    
    $query = "SELECT *, DATEDIFF(DOIDE,CURDATE()) as expire FROM employee 
              ORDER BY 
                CASE WHEN nat = 'سعودي' THEN 1 ELSE 0 END, 
                expire ASC 
              LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $query);
    
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
    <?php } ?>
</div>

<div class="pagination">
    <?php
    $result_db = mysqli_query($conn, "SELECT COUNT(id) FROM employee");
    $row_db = mysqli_fetch_row($result_db);
    $total_records = $row_db[0];
    $total_pages = ceil($total_records / $limit);
    
    echo "<ul class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        $activeClass = $page == $i ? 'active' : '';
        echo "<li class='page-item $activeClass'>
                <a class='page-link' href='employees.php?page=$i'>$i</a>
              </li>";
    }
    echo "</ul>";
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function () {
        let searchTimer;
        
        $("#username").on("input", function () {
            clearTimeout(searchTimer);
            const filter = $(this).val();
            
            searchTimer = setTimeout(() => {
                $.ajax({
                    url: "filter.php",
                    method: "post",
                    data: { query: filter },
                    success: function (data) {
                        $('#empcard').html(data);
                    }
                });
            }, 300); // Add debouncing for better performance
        });
    });

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'تأكيد الحذف',
            text: 'هل أنت متأكد من حذف الموظف ' + name + '؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#3b82f6',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                deleteEmployee(id);
            }
        });
    }

    function deleteEmployee(id) {
        $.ajax({
            url: 'delete.php',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم',
                        text: response.message,
                        confirmButtonText: 'حسناً'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: response.message,
                        confirmButtonText: 'حسناً'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء الاتصال بالخادم',
                    confirmButtonText: 'حسناً'
                });
            }
        });
    }
</script>
</body>
</html>