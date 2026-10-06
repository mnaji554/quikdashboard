<?php include '../config.php';
include '../header.php';
?>

<!-- Page Header -->
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <span style="all: unset; font-weight:bold;font-size: 25px;">مبيعات المحطات</span>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Sales Form -->
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <div class="card" style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px;">
        <form id="salesForm" class="row g-3">
            <div class="col-md-3">
                <label for="station_id" class="form-label">المحطة</label>
                <select class="form-select" id="station_id" name="station_id" required>
                    <option value="">اختر المحطة</option>
                    <?php
                    $query = "SELECT id, stationName FROM stations ORDER BY stationName";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['stationName'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="product_id" class="form-label">المنتج</label>
                <select class="form-select" id="product_id" name="product_id" required>
                    <option value="">اختر المنتج</option>
                    <?php
                    $query = "SELECT id, name FROM products ORDER BY name";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>           
             <div class="col-md-3">
                <label for="sale_date" class="form-label">تاريخ البيع</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" required>
            </div>
            <div class="col-md-3">
                <label for="opening_reading" class="form-label">قراءة البداية</label>
                <input type="number" step="0.01" class="form-control" id="opening_reading" name="opening_reading" required>
            </div>            <div class="col-md-3">
                <label for="closing_reading" class="form-label">قراءة النهاية</label>
                <input type="number" step="0.01" class="form-control" id="closing_reading" name="closing_reading" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">حفظ</button>
            </div>
        </form>
    </div>
</div>

<!-- Sales Table -->
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable" style="margin-top: 20px;">
    <div class="card" style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px;">
        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="filter_station" class="form-label">تصفية حسب المحطة</label>
                <select class="form-select" id="filter_station">
                    <option value="">كل المحطات</option>
                    <?php
                    $query = "SELECT id, stationName FROM stations ORDER BY stationName";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['stationName'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filter_product" class="form-label">تصفية حسب المنتج</label>
                <select class="form-select" id="filter_product">
                    <option value="">كل المنتجات</option>
                    <?php
                    $query = "SELECT id, name FROM products ORDER BY name";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filter_date_start" class="form-label">من تاريخ</label>
                <input type="date" class="form-control" id="filter_date_start">
            </div>
            <div class="col-md-3">
                <label for="filter_date_end" class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" id="filter_date_end">
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card bg-primary text-white" style="width: fit-content;">
                    <div class="card-body" style="margin-top: 0%;">
                        <h5 class="card-title">إجمالي المبيعات</h5>
                        <h3 class="card-text" id="total_sales">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white" style="width: fit-content;">
                    <div class="card-body" style="margin-top: 0%;">
                        <h5 class="card-title">إجمالي الكمية</h5>
                        <h3 class="card-text" id="total_quantity">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white" style="width: fit-content;">
                    <div class="card-body" style="margin-top: 0%;">
                        <h5 class="card-title">متوسط السعر</h5>
                        <h3 class="card-text" id="average_price">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <table id="salesTable" class="table table-striped table-bordered">
            <thead>
                <tr>                    
                    <th>المحطة</th>
                    <th>المنتج</th>
                    <th>التاريخ</th>
                    <th>قراءة البداية</th>
                    <th>قراءة النهاية</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
        </table>
    </div>
</div>



<!-- Include Bootstrap, DataTables and Buttons extension -->

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>



<script>
$(document).ready(function() {
    
    // Initialize DataTable
        var table = $('#salesTable').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: "copy",
                text: "نسخ",
            },
            {
                extend: "csv",
                text: "تصدير CSV",
            },
            {
                extend: "excel",
                text: "تصدير Excel",
            },
            {
                extend: "pdf",
                text: "تصدير PDF",
            },
            {
                extend: "print",
                text: "طباعة",
            }
        ],
        ajax: {
            url: 'fetch.php',
            data: function(d) {
                d.station_id = $('#filter_station').val();
                d.product_id = $('#filter_product').val();
                d.start_date = $('#filter_date_start').val();
                d.end_date = $('#filter_date_end').val();
            }
        },
        columns: [            
            { data: 'station_name' },
            { data: 'product_name' },
            { data: 'sale_date' },            { data: 'opening_reading' },
            { data: 'closing_reading' },
            { data: 'sales_quantity' },
            { 
                data: null,
                render: function(data, type, row) {
                    // Get price from the products table via products.price_per_unit
                    return row.price_per_unit || '0.00';
                }
            },
            { data: 'total_amount' },
            { data: 'actions' }
        ],
        language: {
            search: "بحث : ",
            info: "عرض _START_ الى _END_ من _TOTAL_ سجل",
            lengthMenu: "إظهار _MENU_ سجل",
            emptyTable: "لا توجد بيانات",
            paginate: {
                previous: "السابق",
                next: "اللاحق",
            }
        }
    });    // Handle form submission
    $('#salesForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var isUpdate = $(this).find('input[name="id"]').length > 0;
        var url = isUpdate ? 'update.php' : 'insert.php';

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(result) {
                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم بنجاح',
                        text: result.message,
                        confirmButtonText: 'حسناً'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#salesForm')[0].reset();
                            $('#salesForm input[name="id"]').remove();
                            table.ajax.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: result.message || 'حدث خطأ غير معروف',
                        confirmButtonText: 'حسناً'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                var errorMessage = 'حدث خطأ أثناء معالجة الطلب';
                try {
                    var result = JSON.parse(xhr.responseText);
                    if (result.message) {
                        errorMessage = result.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: errorMessage,
                    confirmButtonText: 'حسناً'
                });
            }
        });
    });

    // Handle filters
    $('#filter_station, #filter_product, #filter_date_start, #filter_date_end').change(function() {
        table.ajax.reload();
    });// Calculate totals when data is loaded
    table.on('xhr', function() {
        var json = table.ajax.json();
        if (json && json.data && Array.isArray(json.data)) {
            var totalSales = 0;
            var totalQuantity = 0;
            
            json.data.forEach(function(row) {
                totalSales += parseFloat(row.total_amount.replace(/,/g, ''));
                totalQuantity += parseFloat(row.sales_quantity.replace(/,/g, ''));
            });
            
            var averagePrice = totalQuantity ? totalSales / totalQuantity : 0;
            
            $('#total_sales').text(totalSales.toFixed(2) + ' ريال');
            $('#total_quantity').text(totalQuantity.toFixed(2) + ' لتر');
            $('#average_price').text(averagePrice.toFixed(2) + ' ريال/لتر');
        }
    });    // Handle edit button click
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.get('get_sale.php', { id: id }, function(data) {
            var sale = JSON.parse(data);
            $('#salesForm input[name="id"]').remove(); // Remove any existing id input
            $('#salesForm').append('<input type="hidden" name="id" value="' + sale.id + '">');
            $('#station_id').val(sale.station_id);
            $('#product_id').val(sale.product_id);
            $('#sale_date').val(sale.sale_date);
            $('#opening_reading').val(sale.opening_reading);
            $('#closing_reading').val(sale.closing_reading);
            $('#price_per_unit').val(sale.price_per_unit);
            
            // Scroll to form
            $('html, body').animate({
                scrollTop: $('#salesForm').offset().top - 100
            }, 500);
        });
    });

    // Handle delete button click
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'لا يمكن التراجع عن هذا الإجراء!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('delete.php', { id: id }, function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحذف',
                            text: result.message,
                            confirmButtonText: 'حسناً'
                        });
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: result.message,
                            confirmButtonText: 'حسناً'
                        });
                    }
                });
            }
        });
    });
});
</script>

</body>

</html>