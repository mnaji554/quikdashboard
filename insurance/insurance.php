<?php include '../config.php';
include '../header.php';
?>

<!-- Add Insurance Form -->
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: ruby; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="#" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        تأمين الموظفين</a>
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

<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable"> <!-- Filter Row -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="status_filter" class="form-label">تصفية حسب حالة التأمين</label>
            <div class="d-flex">
                <select id="status_filter" class="form-select" style="width: 80%;">
                    <option value="">الكل</option>
                    <option value="active">ساري</option>
                    <option value="warning">ينتهي قريباً</option>
                    <option value="expired">منتهي</option>
                    <option value="pending">غير مؤمن</option>
                </select>
                <button type="button" id="reset_status_filter" class="btn btn-secondary">
                    <i class="fas fa-times"></i> </button>
            </div>
        </div>
        <div class="col-md-4">
            <label for="nationality_filter" class="form-label">تصفية حسب الجنسية</label>
            <div class="d-flex">
                <select id="nationality_filter" class="form-select" style="width: 80%;">
                    <option value="">الكل</option>
                    <?php
                    $nat_query = "SELECT DISTINCT nat FROM employee WHERE nat IS NOT NULL ORDER BY nat";
                    $nat_result = mysqli_query($conn, $nat_query);
                    while ($row = mysqli_fetch_assoc($nat_result)) {
                        echo "<option value='" . $row['nat'] . "'>" . $row['nat'] . "</option>";
                    }
                    ?>
                </select>
                <button type="button" id="reset_nationality_filter" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Insurance Table -->
    <table id="insuranceTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>اسم الموظف</th>
                <th>رقم الهوية/الإقامة</th>
                <th>الجنسية</th>
                <th>تاريخ الميلاد</th>
                <th>شركة التأمين</th>
                <th>تاريخ الانتهاء</th>
                <th>حالة التأمين</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Add Insurance Modal -->
<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">إضافة تأمين جديد</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="insuranceForm" class="row g-3">
                    <div class="col-md-6">
                        <label for="employee_id" class="form-label">الموظف</label>
                        <select id="employee_id" name="employee_id" class="form-select" required>
                            <option value="">اختر الموظف</option> <?php
                                                                    $query = "SELECT id, name FROM employee ORDER BY name";
                                                                    $result = mysqli_query($conn, $query);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<option value='" . $row['id'] . "' data-iqama='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                                    }
                                                                    ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="id_number" class="form-label">رقم الهوية/الإقامة</label>
                        <input type="text" class="form-control" id="id_number" name="id_number" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="insurance_company" class="form-label">شركة التأمين</label>
                        <input type="text" class="form-control" id="insurance_company" name="insurance_company"
                            required>
                    </div>


                    <div class="col-md-6">
                        <label for="end_date" class="form-label">تاريخ الانتهاء</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
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

<!-- Update Insurance Modal -->
<div id="updateModal" class="modal fade" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">تحديث التأمين</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" class="row g-3">
                    <input type="hidden" id="update_id" name="id">
                    <div class="col-md-6">
                        <label for="update_employee_id" class="form-label">الموظف</label>
                        <select id="update_employee_id" name="employee_id" class="form-select" required>
                            <option value="">اختر الموظف</option>
                            <?php
                            $query = "SELECT id, name FROM employee ORDER BY name";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "' data-iqama='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="update_id_number" class="form-label">رقم الهوية/الإقامة</label>
                        <input type="text" class="form-control" id="update_id_number" name="id_number" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="update_insurance_company" class="form-label">شركة التأمين</label>
                        <input type="text" class="form-control" id="update_insurance_company" name="insurance_company" required>
                    </div>
                    <div class="col-md-6">
                        <label for="update_end_date" class="form-label">تاريخ الانتهاء</label>
                        <input type="date" class="form-control" id="update_end_date" name="end_date" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include necessary scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#insuranceTable').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "الكل"]
            ],
            buttons: [{
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
                        columns: ':not(:last-child)'
                    },
                    customize: function(win) {
                        $(win.document.body)
                            .css('direction', 'rtl')
                            .css('text-align', 'right');
                        $(win.document.body).find('table')
                            .css('direction', 'rtl')
                            .css('text-align', 'right');
                        $(win.document.body).find('table thead th')
                            .css('text-align', 'right');
                        $(win.document.body).find('table tbody td')
                            .css('text-align', 'right');
                    }
                }
            ],
            ajax: {
                url: 'fetch.php',
                dataSrc: ''
            },
            columns: [{
                    data: 'employee_name'
                },
                {
                    data: 'id_number'
                },
                {
                    data: 'nationality'
                },
                {
                    data: 'date_of_birth'
                },
                {
                    data: 'insurance_company'
                },
                {
                    data: 'end_date',
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        let badge = '';
                        let text = '';
                        switch (data) {
                            case 'active':
                                badge = 'success';
                                text = 'ساري';
                                if (row.days_remaining) {
                                    text += ' (' + row.days_remaining + ' يوم)';
                                }
                                break;
                            case 'expired':
                                badge = 'danger';
                                text = 'منتهي';
                                if (row.days_remaining) {
                                    text += ' (منذ ' + Math.abs(row.days_remaining) + ' يوم)';
                                }
                                break;
                            case 'warning':
                                badge = 'warning';
                                text = 'ينتهي قريباً';
                                if (row.days_remaining) {
                                    text += ' (خلال ' + row.days_remaining + ' يوم)';
                                }
                                break;
                            case 'pending':
                                badge = 'secondary';
                                text = 'غير مؤمن';
                                break;
                        }
                        return '<span class="badge bg-' + badge + '">' + text + '</span>';
                    }
                },
                {
                    data: 'actions'
                }
            ],
            columnDefs: [{
                    className: "dt-center",
                    targets: "_all"
                },
                {
                    targets: -1,
                    orderable: false
                }
            ],
            language: {
                search: "بحث : ",
                info: "عرض _START_ الى _END_ من _TOTAL_ سجل",
                lengthMenu: "إظهار _MENU_ سجل",
                emptyTable: "لا توجد بيانات",
                paginate: {
                    previous: "السابق",
                    next: "التالي",
                }
            },
            order: [
                [5, 'desc']
            ] // Sort by start date by default
        });

        // Handle employee selection
        $('#employee_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            $('#id_number').val(selectedOption.data('iqama'));
        }); // Handle filters
        $('#status_filter, #nationality_filter').on('change', function() {
            table.draw();
        }); // Custom filter function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var status = $('#status_filter').val();
            var nationality = $('#nationality_filter').val();

            // Determine status based on insurance company and end date
            var insuranceCompany = data[4]; // Column index for insurance company
            var endDate = data[5]; // Column index for end date
            var rowStatus = '';

            if (!insuranceCompany || !endDate) {
                rowStatus = 'pending'; // غير مؤمن
            } else {
                var today = new Date();
                var expiryDate = new Date(endDate);
                var daysRemaining = Math.ceil((expiryDate - today) / (1000 * 60 * 60 * 24));

                if (daysRemaining < 0) {
                    rowStatus = 'expired'; // منتهي
                } else if (daysRemaining <= 30) {
                    rowStatus = 'warning'; // ينتهي قريباً
                } else {
                    rowStatus = 'active'; // ساري
                }
            }

            if (status && rowStatus !== status) return false;
            if (nationality && data[2] !== nationality) return false;

            return true;
        }); // Reset filters
        $('#reset_status_filter').on('click', function() {
            $('#status_filter').val('').trigger('change');
        });

        $('#reset_nationality_filter').on('click', function() {
            $('#nationality_filter').val('').trigger('change');
        });

        // Handle form submission
        $('#insuranceForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: 'insert.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#addModal').modal('hide');
                        $('#insuranceForm')[0].reset();
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'تم',
                            text: 'تم إضافة التأمين بنجاح'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: data.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء إضافة التأمين'
                    });
                }
            });
        });

        // Handle edit button click
        $('#insuranceTable').on('click', '.editBtn', function() {
            var id = $(this).data('id');
            
            // Get employee data
            $.ajax({
                url: 'get_insurance.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data) {
                        $('#update_id').val(data.id);
                        $('#update_employee_id').val(data.id);
                        $('#update_id_number').val(data.id_number);
                        $('#update_insurance_company').val(data.insurance_company);
                        $('#update_end_date').val(data.end_date);
                        $('#updateModal').modal('show');
                    }
                }
            });
        });

        // Handle update form submission
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: 'update.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#updateModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'تم',
                            text: 'تم تحديث التأمين بنجاح'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: data.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء تحديث التأمين'
                    });
                }
            });
        });

        // Handle update employee selection
        $('#update_employee_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            $('#update_id_number').val(selectedOption.data('iqama'));
        });
    });
</script>

</body>

</html>