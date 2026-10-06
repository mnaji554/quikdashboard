<?php include '../config.php';
include '../header.php';
?>

<!-- Add Work Record Card -->
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card" style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu" style="display: ruby; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="work.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        سجل المباشرات</a>
                    <div style="margin-right: 5px;">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            إضافة مباشرة جديدة
                        </button>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>

<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <!-- Filter Row -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="date_filter" class="form-label">تصفية حسب تاريخ المباشرة</label>
            <div class="d-flex">
                <input type="date" id="date_start" class="form-control" style="width: 40%;" placeholder="من تاريخ">
                <input type="date" id="date_end" class="form-control" style="width: 40%;" placeholder="إلى تاريخ">
                <button type="button" id="reset_date_filter" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Work Table -->
    <table id="workTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>رقم الاقامة</th>
                <th>الاسم</th>
                <th>باشر يوم</th>
                <th>العمليات</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Add Work Modal -->
<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">إضافة مباشرة جديدة</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="workForm" class="row g-3">
                    <div class="col-md-4">
                        <label for="iqama_number" class="form-label">رقم الاقامة</label>
                        <input type="text" class="form-control" id="iqama_number" name="iqama_number" required>
                    </div>
                    <div class="col-md-4">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="work_date" class="form-label">تاريخ المباشرة</label>
                        <input type="date" class="form-control" id="work_date" name="work_date" required>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Work Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل المباشرة</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editWorkForm" class="row g-3">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="col-md-4">
                        <label for="edit_iqama_number" class="form-label">رقم الاقامة</label>
                        <input type="text" class="form-control" id="edit_iqama_number" name="iqama_number" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_work_date" class="form-label">تاريخ المباشرة</label>
                        <input type="date" class="form-control" id="edit_work_date" name="work_date" required>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
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
$(document).ready(function() {
    var table = $('#workTable').DataTable({
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
            }
        ],
        ajax: {
            url: 'getwork.php',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'work_date' },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm editBtn" data-id="${row.id}">
                            <i class="fas fa-edit"></i> تعديل
                        </button>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="${row.id}">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    `;
                }
            }
        ],
        columnDefs: [
            { className: "dt-center", targets: "_all" }
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

    // Date range filter
    $('#date_start, #date_end').on('change', function() {
        table.draw();
    });

    // Reset date filter button
    $('#reset_date_filter').on('click', function() {
        $('#date_start').val('');
        $('#date_end').val('');
        table.draw();
    });

    // Custom filtering function for date range
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            const dateStart = $('#date_start').val();
            const dateEnd = $('#date_end').val();
            const workDate = data[3]; // Index 3 is work_date

            if (!dateStart && !dateEnd) return true;

            if (dateStart && !dateEnd) {
                return workDate >= dateStart;
            }
            if (!dateStart && dateEnd) {
                return workDate <= dateEnd;
            }
            return workDate >= dateStart && workDate <= dateEnd;
        }
    );

    // Add Work Record
    $("#workForm").submit(function(e) {
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
                $.ajax({
                    url: "insert.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $("#addModal").modal('hide');
                        $("#workForm")[0].reset();
                        table.ajax.reload();
                        Swal.fire({
                            title: 'تم!',
                            text: 'تمت إضافة البيانات بنجاح',
                            icon: 'success',
                            confirmButtonText: 'حسناً'
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء إضافة البيانات',
                            icon: 'error',
                            confirmButtonText: 'حسناً'
                        });
                    }
                });
            }
        });
    });

    // Edit Work Record (Show Modal)
    $(document).on("click", ".editBtn", function() {
        var id = $(this).data("id");
        $.get("get_single.php?id=" + id, function(data) {
            var work = JSON.parse(data);
            $("#edit_id").val(work.id);
            $("#edit_iqama_number").val(work.iqama_number);
            $("#edit_name").val(work.name);
            $("#edit_work_date").val(work.work_date);
            $("#editModal").modal('show');
        });
    });

    // Update Work Record
    $("#editWorkForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "update.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $("#editModal").modal('hide');
                table.ajax.reload();
                Swal.fire({
                    title: 'تم!',
                    text: 'تم تحديث البيانات بنجاح',
                    icon: 'success',
                    confirmButtonText: 'حسناً'
                });
            },
            error: function() {
                Swal.fire({
                    title: 'خطأ!',
                    text: 'حدث خطأ أثناء تحديث البيانات',
                    icon: 'error',
                    confirmButtonText: 'حسناً'
                });
            }
        });
    });

    // Delete Work Record
    $(document).on("click", ".deleteBtn", function() {
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
                $.ajax({
                    url: "delete.php",
                    type: "POST",
                    data: { id: id },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire({
                            title: 'تم الحذف!',
                            text: 'تم حذف البيانات بنجاح',
                            icon: 'success',
                            confirmButtonText: 'حسناً'
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء حذف البيانات',
                            icon: 'error',
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