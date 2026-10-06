<?php include '../config.php';
include '../header.php';
?>

<!-- Add Task Form -->
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">

            <ul class="navbar-menu"
                style="display: ruby; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        المفقودات</a>
                    <div style="margin-right: 5px;">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus"></i> إضافة جديد
                        </button>
                    </div>
                </li>
            </ul>
        </nav>

    </div>
</div>

<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <!-- Filter and Add Button Row -->
    <div class="row mb-3">
        <div class="col-md-4" style="margin-left: -130px;">
            <label for="station_filter" class="form-label">تصفية حسب المحطة</label>
            <div class="d-flex">
                <select id="station_filter" class="form-select" style="width: 55%;">
                    <option value="">الكل</option>
                    <?php
                    $query = "SELECT DISTINCT s.id,s.stationName 
                              FROM losts l 
                              INNER JOIN stations s ON l.station_name = s.id 
                              ORDER BY s.stationName";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['stationName'] . "</option>";
                    }
                    ?>
                </select>
                <button type="button" id="reset_filter" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">تصفية حسب تاريخ الهروب</label>
            <div class="d-flex">
                <input type="date" id="date_start" class="form-control" style="width: 40%;" placeholder="من تاريخ">
                <input type="date" id="date_end" class="form-control" style="width: 40%;" placeholder="إلى تاريخ">
                <button type="button" id="reset_date_filter" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">تصفية حسب تاريخ التحصيل</label>
            <div class="d-flex">
                <input type="date" id="collection_date_start" class="form-control" style="width: 40%;"
                    placeholder="من تاريخ">
                <input type="date" id="collection_date_end" class="form-control" style="width: 40%;"
                    placeholder="إلى تاريخ">
                <button type="button" id="reset_collection_date_filter" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Tasks Table -->
    <table id="taskTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>اسم المحطة</th>
                <th>تاريخ الهروب</th>
                <th>وقت الهروب</th>
                <th>نوع السياره</th>
                <th>رقم السياره</th>
                <th>مبلغ</th>
                <th>موقف البلاغ</th>
                <th>القائم بالبلاغ</th>
                <th>موقف التحصيل</th>
                <th>تاريخ التحصيل</th>
                <th>طريقه التحصيل</th>
                <th>موبايل العميل</th>
                <th>رقم المسدس</th>
                <th>نوع البنزين</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
    </table>

    <!-- Totals Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card" style="position: relative;align-content: center;">
                <div class="card-body"
                    style="background-color: #f8f9fa; border-radius: 10px;width: 100%;margin: 0 auto;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center p-3"
                                style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div class="me-3">
                                    <i class="fas fa-calculator fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">إجمالي المبلغ</h6>
                                    <h4 class="mb-0 text-primary" id="total_amount" style="font-weight: bold;">0</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center p-3"
                                style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); ">
                                <div class="me-3">
                                    <i class="fas fa-gas-pump fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">إجمالي المبلغ للمحطة المحددة</h6>
                                    <h4 class="mb-0 text-success" id="station_total_amount" style="font-weight: bold;">0
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center p-3"
                                style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); ">
                                <div class="me-3">
                                    <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">إجمالي المبالغ المحصلة</h6>
                                    <h4 class="mb-0 text-info" id="collected_amount" style="font-weight: bold;">0</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center p-3"
                                style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); ">
                                <div class="me-3">
                                    <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">المبالغ المحصلة للمحطة المحددة</h6>
                                    <h4 class="mb-0 text-warning" id="station_collected_amount"
                                        style="font-weight: bold;">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">إضافة جديد</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="taskForm" class="row g-3">
                    <div class="col-md-4">
                        <label for="station_name" class="form-label">اسم المحطة</label>
                        <select id="station_name" name="station_name" class="form-select" required>
                            <?php
                            $query = "SELECT * FROM stations";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['stationName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="escape_date" class="form-label">تاريخ الهروب</label>
                        <input type="date" class="form-control" id="escape_date" name="escape_date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="escape_time" class="form-label">وقت الهروب</label>
                        <input type="time" class="form-control" id="escape_time" name="escape_time" required>
                    </div>
                    <div class="col-md-4">
                        <label for="car_type" class="form-label">نوع السياره</label>
                        <input type="text" class="form-control" id="car_type" name="car_type">
                    </div>
                    <div class="col-md-4">
                        <label for="car_number" class="form-label">رقم السياره</label>
                        <input type="text" class="form-control" id="car_number" name="car_number" required>
                    </div>
                    <div class="col-md-4">
                        <label for="amount" class="form-label">مبلغ</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="col-md-4">
                        <label for="report_status" class="form-label">موقف البلاغ</label>
                        <select id="report_status" name="report_status" class="form-select">
                            <option value="pending">قيد الانتظار</option>
                            <option value="reported">تم البلاغ</option>
                            <option value="closed">مغلق</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="reported_by" class="form-label">القائم بالبلاغ</label>
                        <input type="text" class="form-control" id="reported_by" name="reported_by" required>
                    </div>
                    <div class="col-md-4">
                        <label for="collection_status" class="form-label">موقف التحصيل</label>
                        <select id="collection_status" name="collection_status" class="form-select">
                            <option value="pending">قيد الانتظار</option>
                            <option value="collected">تم التحصيل</option>
                            <option value="uncollected">لم يتم التحصيل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="collection_date" class="form-label">تاريخ التحصيل</label>
                        <input type="date" class="form-control" id="collection_date" name="collection_date">
                    </div>
                    <div class="col-md-4">
                        <label for="collection_method" class="form-label">طريقه التحصيل</label>
                        <select id="collection_method" name="collection_method" class="form-select">
                            <option value="cash">كاش</option>
                            <option value="bank">تحويل بنكي</option>
                            <option value="other">نقاط بيع</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="client_mobile" class="form-label">موبايل العميل</label>
                        <input type="tel" class="form-control" id="client_mobile" name="client_mobile">
                    </div>
                    <div class="col-md-4">
                        <label for="pump_number" class="form-label">رقم المسدس</label>
                        <input type="text" class="form-control" id="pump_number" name="pump_number">
                    </div>
                    <div class="col-md-4">
                        <label for="fuel_type" class="form-label">نوع البنزين</label>
                        <select id="fuel_type" name="fuel_type" class="form-select">
                            <option value="91">91</option>
                            <option value="95">95</option>
                            <option value="diesel">ديزل</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">إضافة</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل البيانات</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm" class="row g-3">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="col-md-4">
                        <label for="edit_station_name" class="form-label">اسم المحطة</label>
                        <select id="edit_station_name" name="station_name" class="form-select" required>
                            <?php
                            $query = "SELECT * FROM stations";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['stationName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_escape_date" class="form-label">تاريخ الهروب</label>
                        <input type="date" class="form-control" id="edit_escape_date" name="escape_date" required>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_escape_time" class="form-label">وقت الهروب</label>
                        <input type="time" class="form-control" id="edit_escape_time" name="escape_time" required>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_car_type" class="form-label">نوع السيارة</label>
                        <input type="text" class="form-control" id="edit_car_type" name="car_type">
                    </div>

                    <div class="col-md-4">
                        <label for="edit_car_number" class="form-label">رقم السيارة</label>
                        <input type="text" class="form-control" id="edit_car_number" name="car_number" required>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_amount" class="form-label">المبلغ</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" required>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_report_status" class="form-label">موقف البلاغ</label>
                        <select id="edit_report_status" name="report_status" class="form-select" required>
                            <option value="pending">قيد الانتظار</option>
                            <option value="reported">تم البلاغ</option>
                            <option value="closed">مغلق</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_reported_by" class="form-label">القائم بالبلاغ</label>
                        <input type="text" class="form-control" id="edit_reported_by" name="reported_by" required>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_collection_status" class="form-label">موقف التحصيل</label>
                        <select id="edit_collection_status" name="collection_status" class="form-select" required>
                            <option value="pending">قيد الانتظار</option>
                            <option value="collected">تم التحصيل</option>
                            <option value="uncollected">لم يتم التحصيل</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_collection_date" class="form-label">تاريخ التحصيل</label>
                        <input type="date" class="form-control" id="edit_collection_date" name="collection_date">
                    </div>

                    <div class="col-md-4">
                        <label for="edit_collection_method" class="form-label">طريقة التحصيل</label>
                        <select id="edit_collection_method" name="collection_method" class="form-select">
                            <option value="cash">كاش</option>
                            <option value="bank">تحويل بنكي</option>
                            <option value="other">نقاط بيع</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_client_mobile" class="form-label">موبايل العميل</label>
                        <input type="tel" class="form-control" id="edit_client_mobile" name="client_mobile">
                    </div>

                    <div class="col-md-4">
                        <label for="edit_pump_number" class="form-label">رقم المسدس</label>
                        <input type="text" class="form-control" id="edit_pump_number" name="pump_number">
                    </div>

                    <div class="col-md-4">
                        <label for="edit_fuel_type" class="form-label">نوع البنزين</label>
                        <select id="edit_fuel_type" name="fuel_type" class="form-select">
                            <option value="91">91</option>
                            <option value="95">95</option>
                            <option value="diesel">ديزل</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap, DataTables and Buttons extension -->

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#taskTable').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "الكل"]],
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
                    exportOptions: {
                        columns: ':not(:last-child)' // This excludes the last column (actions)
                        // Or specify exact columns to show:
                        // columns: [ 0, 1, 2, 3, 4, 5, 6 ] // Include only these column indexes
                    },
                    customize: function (win) {
                        $(win.document.body)
                            .css('direction', 'rtl')
                            .css('text-align', 'right');

                        // Fix table direction
                        $(win.document.body).find('table')
                            .css('direction', 'rtl')
                            .css('text-align', 'right');

                        // Fix table header direction
                        $(win.document.body).find('table thead th')
                            .css('text-align', 'right');

                        // Fix table cells direction
                        $(win.document.body).find('table tbody td')
                            .css('text-align', 'right');
                    }
                }
            ],
            ajax: {
                url: 'fetch.php',
                dataSrc: ''
            },
            columns: [
                { data: 'stationName' },
                { data: 'escape_date' },
                { data: 'escape_time' },
                { data: 'car_type' },
                { data: 'car_number' },
                { data: 'amount' },
                { data: 'report_status' },
                { data: 'reported_by' },
                { data: 'collection_status' },
                { data: 'collection_date' },
                { data: 'collection_method' },
                { data: 'client_mobile' },
                { data: 'pump_number' },
                { data: 'fuel_type' },
                { data: 'actions' }
            ],
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                {
                    targets: -1,
                },
                {
                    // Format the escape_date for proper date filtering
                    targets: 1,
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return data;
                        }
                        // For sorting and filtering, ensure date is in YYYY-MM-DD format
                        return data;
                    }
                }
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
        });

        // Function to calculate totals
        function calculateTotals(data) {
            let totalAmount = 0;
            let stationTotalAmount = 0;
            let collectedAmount = 0;
            let stationCollectedAmount = 0;
            const selectedStation = $('#station_filter').val(); data.forEach(row => {
                const amount = parseFloat(row.amount) || 0;
                totalAmount += amount;

                // Selected station calculations
                if (selectedStation && row.station_name == selectedStation) {
                    stationTotalAmount += amount;
                    if (row.collection_status === 'تم التحصيل') {
                        stationCollectedAmount += amount;
                    }
                }

                // Calculate total collected amount regardless of station
                if (row.collection_status === 'تم التحصيل') {
                    collectedAmount += amount;
                }
            });

            $('#total_amount').text(totalAmount.toLocaleString('ar-SA', {
                style: 'currency',
                currency: 'SAR'
            }));

            $('#station_total_amount').text(stationTotalAmount.toLocaleString('ar-SA', {
                style: 'currency',
                currency: 'SAR'
            }));

            $('#collected_amount').text(collectedAmount.toLocaleString('ar-SA', {
                style: 'currency',
                currency: 'SAR'
            }));

            $('#station_collected_amount').text(stationCollectedAmount.toLocaleString('ar-SA', {
                style: 'currency',
                currency: 'SAR'
            }));
        }

        // Handle station filter change
        $('#station_filter').on('change', function () {
            const selectedStation = $(this).val();

            // Clear the filter if "All" is selected
            if (!selectedStation) {
                table.column(0).search('').draw();
            } else {
                table.column(0).search(selectedStation, true, false).draw();
            }
        });

        // Reset filter button
        $('#reset_filter').on('click', function () {
            $('#station_filter').val('');
            table.column(0).search('').draw();
        });        // Handle date range filter changes
        $('#date_start, #date_end, #collection_date_start, #collection_date_end').on('change', function () {
            table.draw();
        });

        // Reset escape date filter button
        $('#reset_date_filter').on('click', function () {
            $('#date_start').val('');
            $('#date_end').val('');
            table.draw();
        });

        // Reset collection date filter button
        $('#reset_collection_date_filter').on('click', function () {
            $('#collection_date_start').val('');
            $('#collection_date_end').val('');
            table.draw();
        });

        // Custom filtering function for both date ranges
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                const dateStart = $('#date_start').val();
                const dateEnd = $('#date_end').val();
                const escapeDate = data[1]; // Index 1 is escape_date

                const collectionDateStart = $('#collection_date_start').val();
                const collectionDateEnd = $('#collection_date_end').val();
                const collectionDate = data[9]; // Index 9 is collection_date

                let escapeDateMatch = true;
                let collectionDateMatch = true;

                // Check escape date range
                if (dateStart && dateEnd) {
                    escapeDateMatch = escapeDate >= dateStart && escapeDate <= dateEnd;
                } else if (dateStart) {
                    escapeDateMatch = escapeDate >= dateStart;
                } else if (dateEnd) {
                    escapeDateMatch = escapeDate <= dateEnd;
                }

                // Check collection date range
                if (collectionDateStart && collectionDateEnd) {
                    collectionDateMatch = collectionDate >= collectionDateStart && collectionDate <= collectionDateEnd;
                } else if (collectionDateStart) {
                    collectionDateMatch = collectionDate >= collectionDateStart;
                } else if (collectionDateEnd) {
                    collectionDateMatch = collectionDate <= collectionDateEnd;
                }

                // Return true only if both date filters match
                return escapeDateMatch && collectionDateMatch;
            }
        );

        // Update totals when table is redrawn
        table.on('draw', function () {
            calculateTotals(table.data().toArray());
        });

        // Calculate initial totals
        table.on('xhr', function () {
            calculateTotals(table.data().toArray());
        });

        // Add Task
        $("#taskForm").submit(function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'تأكيد الإضافة',
                text: 'هل أنت متأكد من إضافة هذه البيانات؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، أضف',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Collect form data
                    let formData = $(this).serializeArray();
                    let postData = {};
                    formData.forEach(item => {
                        postData[item.name] = item.value || '';
                    }); $.ajax({
                        url: "insert.php",
                        type: "POST",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 'success') {
                                // Hide modal and reset form first
                                $("#addModal").modal('hide');
                                $("#taskForm")[0].reset();

                                // Show success message
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });

                                Toast.fire({
                                    icon: 'success',
                                    title: 'تم إضافة البيانات بنجاح'
                                });

                                // Reload table data
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطأ',
                                    text: data.message,
                                    confirmButtonText: 'حسناً'
                                });
                            }
                        }, error: function (xhr, status, error) {
                            console.error('Ajax error:', xhr.responseText);
                            let errorMessage = 'حدث خطأ في الاتصال بالخادم';

                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.message) {
                                    errorMessage = response.message;
                                }
                            } catch (e) {
                                console.error('Error parsing error response:', e);
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ',
                                text: errorMessage,
                                confirmButtonText: 'حسناً'
                            });
                        }
                    });
                }
            });
        });

        // Edit Task (Show Modal)
        $(document).on("click", ".editBtn", function () {
            var id = $(this).data("id");
            $.get("get_task.php?id=" + id, function (data) {
                var task = JSON.parse(data);
                $("#edit_id").val(task.id);
                $("#edit_station_name").val(task.station_name);
                $("#edit_escape_date").val(task.escape_date);
                $("#edit_escape_time").val(task.escape_time);
                $("#edit_car_type").val(task.car_type);
                $("#edit_car_number").val(task.car_number);
                $("#edit_amount").val(task.amount);
                $("#edit_report_status").val(task.report_status);
                $("#edit_reported_by").val(task.reported_by);
                $("#edit_collection_status").val(task.collection_status);
                $("#edit_collection_date").val(task.collection_date);
                $("#edit_collection_method").val(task.collection_method);
                $("#edit_client_mobile").val(task.client_mobile);
                $("#edit_pump_number").val(task.pump_number);
                $("#edit_fuel_type").val(task.fuel_type);
                $("#editModal").modal('show');
            });
        });

        // Update Task
        $("#editTaskForm").submit(function (e) {
            e.preventDefault(); $.ajax({
                url: "update.php",
                type: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'نجاح',
                            text: data.message,
                            confirmButtonText: 'حسناً'
                        });
                        table.ajax.reload();
                        $("#editModal").modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: data.message,
                            confirmButtonText: 'حسناً'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الاتصال',
                        text: 'حدث خطأ أثناء محاولة تحديث البيانات. الرجاء المحاولة مرة أخرى.',
                        confirmButtonText: 'حسناً'
                    });
                }
            });
        });

        // Delete Task
        $(document).on("click", ".deleteBtn", function () {
            var id = $(this).data("id");
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من التراجع عن هذا!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("delete.php", { id: id }, function (response) {
                        const data = JSON.parse(response);
                        if (data.status === 'success') {
                            Swal.fire(
                                'تم الحذف!',
                                data.message,
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'خطأ!',
                                data.message,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

</script>

</body>

</html>