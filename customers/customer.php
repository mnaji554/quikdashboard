<?php include '../config.php';
include '../header.php';
?>

<!-- Add Report Form -->
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="#" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        بلاغات العملاء</a>
            </ul>
        </nav>
    </div>
</div>

<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <form id="reportForm" class="row g-3">        <div class="col-md-4">
            <label for="report_date" class="form-label">تاريخ البلاغ</label>
            <input type="date" class="form-control datepicker" id="report_date" name="report_date" required>
        </div>
        <div class="col-md-4">
            <label for="report_type" class="form-label">نوع البلاغ</label>
            <select id="report_type" name="report_type" class="form-select" required>
                <option value="شكوى">شكوى</option>
                <option value="اقتراح">اقتراح</option>
                <option value="طلب">طلب</option>
                <option value="أخرى">أخرى</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="customer_name" class="form-label">اسم العميل</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="col-md-4">
            <label for="station_id" class="form-label">المحطة</label>
            <select id="station_id" name="station_id" class="form-select" required>
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
        <div class="col-md-8">
            <label for="description" class="form-label">وصف البلاغ</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="col-md-8">
            <label for="action_taken" class="form-label">الإجراء المتخذ</label>
            <textarea class="form-control" id="action_taken" name="action_taken" rows="3"></textarea>
        </div>        <div class="col-md-4">
            <label for="completion_date" class="form-label">تاريخ الإنجاز</label>
            <input type="date" class="form-control hijri-date-input" id="completion_date" name="completion_date">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">إضافة البلاغ</button>
        </div>
    </form>
</div>

<!-- Reports Table -->
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <table id="reportsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>معرف</th>
                <th>تاريخ البلاغ</th>
                <th>نوع البلاغ</th>
                <th>اسم العميل</th>
                <th>المحطة</th>
                <th>وصف البلاغ</th>
                <th>الإجراء المتخذ</th>
                <th>تاريخ الإنجاز</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Edit Report Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل البلاغ</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReportForm" class="row g-3">
                    <input type="hidden" name="id" id="edit_id">                    <div class="col-md-6">
                        <label for="edit_report_date" class="form-label">تاريخ البلاغ</label>
                        <input type="text" class="form-control hijri-date-input" id="edit_report_date" name="report_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_report_type" class="form-label">نوع البلاغ</label>
                        <select id="edit_report_type" name="report_type" class="form-select" required>
                            <option value="شكوى">شكوى</option>
                            <option value="اقتراح">اقتراح</option>
                            <option value="طلب">طلب</option>
                            <option value="أخرى">أخرى</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_customer_name" class="form-label">اسم العميل</label>
                        <input type="text" class="form-control" id="edit_customer_name" name="customer_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_station_id" class="form-label">المحطة</label>
                        <select id="edit_station_id" name="station_id" class="form-select" required>
                            <?php
                            $result = mysqli_query($conn, "SELECT id, stationName FROM stations ORDER BY stationName");
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['stationName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="edit_description" class="form-label">وصف البلاغ</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="edit_action_taken" class="form-label">الإجراء المتخذ</label>
                        <textarea class="form-control" id="edit_action_taken" name="action_taken" rows="3"></textarea>
                    </div>                    <div class="col-md-6">
                        <label for="edit_completion_date" class="form-label">تاريخ الإنجاز</label>
                        <input type="date" class="form-control hijri-date-input" id="edit_completion_date" name="completion_date">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">تحديث البلاغ</button>
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
        var table = $('#reportsTable').DataTable({
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
                    exportOptions: {
                        columns: ':not(:last-child)' // This excludes the last column (actions)
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
                { data: 'id' },
                { data: 'report_date' },
                { data: 'report_type' },
                { data: 'customer_name' },
                { data: 'station_name' },
                { data: 'description' },
                { data: 'action_taken' },
                { data: 'completion_date' },
                { data: 'actions' }
            ],
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                {
                    targets: -1,
                },                {
                    targets: [1, 7], // Date columns
                    render: function(data) {
                        if (!data) return '';
                        const date = new Date(data);
                        return date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    }
                },
                {
                    targets: [5, 6], // Description and Action columns
                    render: function(data) {
                        return data ? data.substring(0, 50) + (data.length > 50 ? '...' : '') : '';
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
                },
            },
            order: [[1, 'desc']] // Sort by report date descending
        });

        // Add Report
        $("#reportForm").submit(function (e) {
            e.preventDefault();
            $.post("insert.php", $(this).serialize(), function () {
                table.ajax.reload();
                $("#reportForm")[0].reset();
            });
        });

        // Edit Report (Show Modal)
        $(document).on("click", ".editBtn", function () {
            var id = $(this).data("id");
            $.get("get_report.php?id=" + id, function (data) {
                var report = JSON.parse(data);
                $("#edit_id").val(report.id);
                $("#edit_report_date").val(report.report_date);
                $("#edit_report_type").val(report.report_type);
                $("#edit_customer_name").val(report.customer_name);
                $("#edit_station_id").val(report.station_id);
                $("#edit_description").val(report.description);
                $("#edit_action_taken").val(report.action_taken);
                $("#edit_completion_date").val(report.completion_date);
                $("#editModal").modal('show');
            });
        });

        // Update Report
        $("#editReportForm").submit(function (e) {
            e.preventDefault();
            $.post("update.php", $(this).serialize(), function () {
                table.ajax.reload();
                $("#editModal").modal('hide');
            });
        });

        // Delete Report
        $(document).on("click", ".deleteBtn", function () {
            var id = $(this).data("id");
            if (confirm("هل أنت متأكد من حذف هذا البلاغ؟")) {
                $.post("delete.php", { id: id }, function () {
                    table.ajax.reload();
                });
            }
        });
    });

</script>

</body>

</html>