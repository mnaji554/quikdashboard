<?php include '../config.php';
include '../header.php';
?>

<!-- Navigation Bar -->
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card" style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu" style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">الصيانة</a>
                </li>
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                        إضافة صيانة جديدة
                    </button>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add Task Modal -->
<div id="addTaskModal" class="modal fade" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">إضافة صيانة جديدة</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="taskForm" class="row g-3">
                    <div class="col-md-6">
                        <label for="task_name" class="form-label">اسم المهمة</label>
                        <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Task Name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="frequency" class="form-label">التكرار</label>
                        <select id="frequency" name="frequency" class="form-select" required>
                            <option value="يومي">يومي</option>
                            <option value="أسبوعي">أسبوعي</option>
                            <option value="شهري">شهري</option>
                            <option value="ربع سنوي">ربع سنوي</option>
                            <option value="نصف سنوي">نصف سنوي</option>
                            <option value="سنوي">سنوي</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="last_service_date" class="form-label">آخر خدمة</label>
                        <input type="date" class="form-control" id="last_service_date" name="last_service_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="next_due_date" class="form-label">الموعد التالي</label>
                        <input type="date" class="form-control" id="next_due_date" name="next_due_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="responsible_person" class="form-label">الشخص المسؤول</label>
                        <input type="text" class="form-control" id="responsible_person" name="responsible_person" placeholder="Responsible Person" required>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">الحالة</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="قيد الانتظار">قيد الانتظار</option>
                            <option value="قيد التنفيذ">قيد التنفيذ</option>
                            <option value="مكتمل">مكتمل</option>
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

<!-- Tasks Table -->
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <table id="taskTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>معرف</th>
                <th>اسم المهمة</th>
                <th>التكرار</th>
                <th>آخر خدمة</th>
                <th>الموعد التالي</th>
                <th>الشخص المسؤول</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Edit Task Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm" class="row g-3">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="col-md-6">
                        <label for="edit_task_name" class="form-label">اسم المهمة</label>
                        <input type="text" class="form-control" id="edit_task_name" name="task_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_frequency" class="form-label">التكرار</label>
                        <select id="edit_frequency" name="frequency" class="form-select" required>
                            <option value="يومي">يومي</option>
                            <option value="أسبوعي">أسبوعي</option>
                            <option value="شهري">شهري</option>
                            <option value="ربع سنوي">ربع سنوي</option>
                            <option value="نصف سنوي">نصف سنوي</option>
                            <option value="سنوي">سنوي</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_last_service_date" class="form-label">آخر خدمة</label>
                        <input type="date" class="form-control" id="edit_last_service_date" name="last_service_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_next_due_date" class="form-label">الموعد التالي</label>
                        <input type="date" class="form-control" id="edit_next_due_date" name="next_due_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_responsible_person" class="form-label">الشخص المسؤول</label>
                        <input type="text" class="form-control" id="edit_responsible_person" name="responsible_person" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_status" class="form-label">الحالة</label>
                        <select id="edit_status" name="status" class="form-select" required>
                            <option value="قيد الانتظار">قيد الانتظار</option>
                            <option value="قيد التنفيذ">قيد التنفيذ</option>
                            <option value="مكتمل">مكتمل</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#taskTable').DataTable({
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
                { data: 'id' },
                { data: 'task_name' },
                { data: 'frequency' },
                { data: 'last_service_date' },
                { data: 'next_due_date' },
                { data: 'responsible_person' },
                { data: 'status' },
                { data: 'actions' }
            ],
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                {
                    targets: -1,

                },
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
        });

        // Add Task
        $("#taskForm").submit(function (e) {
            e.preventDefault();
            
            // Validate form fields
            if (!this.checkValidity()) {
                e.stopPropagation();
                return;
            }
            
            Swal.fire({
                title: 'تأكيد الإضافة',
                text: 'هل أنت متأكد من إضافة هذه المهمة؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، أضف',
                cancelButtonText: 'إلغاء',
                customClass: {
                    confirmButton: 'btn btn-success mx-2',
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'جاري الإضافة...',
                        text: 'يرجى الانتظار',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Format dates properly
                    const formData = new FormData(this);
                    const last_service_date = formData.get('last_service_date');
                    const next_due_date = formData.get('next_due_date');

                    // Validate dates
                    if (!last_service_date || !next_due_date) {
                        Swal.fire({
                            title: 'خطأ!',
                            text: 'يرجى إدخال التواريخ المطلوبة',
                            icon: 'error',
                            confirmButtonText: 'حسناً'
                        });
                        return;
                    }

                    $.ajax({
                        url: "insert.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            try {
                                const result = JSON.parse(response);
                                if (result.status === 'success') {
                                    Swal.fire({
                                        title: 'تمت الإضافة!',
                                        text: 'تم إضافة المهمة بنجاح',
                                        icon: 'success',
                                        confirmButtonText: 'حسناً'
                                    }).then(() => {
                                        table.ajax.reload();
                                        $("#addTaskModal").modal('hide');
                                        $("#taskForm")[0].reset();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'خطأ!',
                                        text: result.message || 'حدث خطأ أثناء إضافة المهمة',
                                        icon: 'error',
                                        confirmButtonText: 'حسناً'
                                    });
                                }
                            } catch (e) {
                                console.error('Error parsing response:', e, response);
                                Swal.fire({
                                    title: 'خطأ!',
                                    text: 'حدث خطأ غير متوقع',
                                    icon: 'error',
                                    confirmButtonText: 'حسناً'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Ajax error:', status, error);
                            Swal.fire({
                                title: 'خطأ!',
                                text: 'حدث خطأ في الاتصال بالخادم: ' + error,
                                icon: 'error',
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
            $.ajax({
                url: "get_task.php",
                type: "GET",
                data: { id: id },
                success: function(response) {
                    try {
                        const task = JSON.parse(response);
                        $("#edit_id").val(task.id);
                        $("#edit_task_name").val(task.task_name);
                        $("#edit_frequency").val(task.frequency);
                        $("#edit_last_service_date").val(task.last_service_date);
                        $("#edit_next_due_date").val(task.next_due_date);
                        $("#edit_responsible_person").val(task.responsible_person);
                        $("#edit_status").val(task.status);
                        $("#editModal").modal('show');
                    } catch (e) {
                        Swal.fire({
                            title: 'خطأ!',
                            text: 'حدث خطأ في تحميل بيانات المهمة',
                            icon: 'error',
                            confirmButtonText: 'حسناً'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'خطأ!',
                        text: 'حدث خطأ في الاتصال بالخادم',
                        icon: 'error',
                        confirmButtonText: 'حسناً'
                    });
                }
            });
        });

        // Update Task
        $("#editTaskForm").submit(function (e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'تأكيد التعديل',
                text: 'هل أنت متأكد من تحديث هذه المهمة؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، حدّث',
                cancelButtonText: 'إلغاء',
                customClass: {
                    confirmButton: 'btn btn-success mx-2',
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "update.php",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            try {
                                const result = JSON.parse(response);
                                if (result.status === 'success') {
                                    Swal.fire({
                                        title: 'تم التحديث!',
                                        text: 'تم تحديث المهمة بنجاح',
                                        icon: 'success',
                                        confirmButtonText: 'حسناً'
                                    }).then(() => {
                                        table.ajax.reload();
                                        $("#editModal").modal('hide');
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'خطأ!',
                                        text: result.message || 'حدث خطأ أثناء تحديث المهمة',
                                        icon: 'error',
                                        confirmButtonText: 'حسناً'
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    title: 'خطأ!',
                                    text: 'حدث خطأ غير متوقع',
                                    icon: 'error',
                                    confirmButtonText: 'حسناً'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'خطأ!',
                                text: 'حدث خطأ في الاتصال بالخادم',
                                icon: 'error',
                                confirmButtonText: 'حسناً'
                            });
                        }
                    });
                }
            });
        });

        // Delete Task
        $(document).on("click", ".deleteBtn", function () {
            var id = $(this).data("id");
            
            Swal.fire({
                title: 'تأكيد الحذف',
                text: 'هل أنت متأكد من حذف هذه المهمة؟ لا يمكن التراجع عن هذا الإجراء!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                customClass: {
                    confirmButton: 'btn btn-danger mx-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "delete.php",
                        type: "POST",
                        data: { id: id },
                        success: function(response) {
                            try {
                                const result = JSON.parse(response);
                                if (result.status === 'success') {
                                    Swal.fire({
                                        title: 'تم الحذف!',
                                        text: 'تم حذف المهمة بنجاح',
                                        icon: 'success',
                                        confirmButtonText: 'حسناً'
                                    }).then(() => {
                                        table.ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'خطأ!',
                                        text: result.message || 'حدث خطأ أثناء حذف المهمة',
                                        icon: 'error',
                                        confirmButtonText: 'حسناً'
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    title: 'خطأ!',
                                    text: 'حدث خطأ غير متوقع',
                                    icon: 'error',
                                    confirmButtonText: 'حسناً'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'خطأ!',
                                text: 'حدث خطأ في الاتصال بالخادم',
                                icon: 'error',
                                confirmButtonText: 'حسناً'
                            });
                        }
                    });
                }
            });
        });

        // Reset forms when modals are closed
        $('#addTaskModal, #editModal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });
    });
</script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#tasksTable').DataTable({
        "order": [[0, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json"
        }
    });

    // Handle form submission
    $('#taskForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            task_name: $('#task_name').val(),
            frequency: $('#frequency').val(),
            last_service_date: $('#last_service_date').val(),
            next_due_date: $('#next_due_date').val(),
            responsible_person: $('#responsible_person').val(),
            status: $('#status').val()
        };

        $.ajax({
            url: 'insert.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    Swal.fire({
                        title: 'نجاح!',
                        text: 'تمت إضافة المهمة بنجاح',
                        icon: 'success',
                        confirmButtonText: 'حسناً'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#addTaskModal').modal('hide');
                            $('#taskForm')[0].reset();
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'خطأ!',
                        text: 'حدث خطأ أثناء إضافة المهمة',
                        icon: 'error',
                        confirmButtonText: 'حسناً'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'خطأ!',
                    text: 'حدث خطأ في الاتصال بالخادم',
                    icon: 'error',
                    confirmButtonText: 'حسناً'
                });
            }
        });
    });

    // Delete task confirmation
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'تأكيد الحذف',
            text: 'هل أنت متأكد من حذف هذه المهمة؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        const result = JSON.parse(response);
                        if (result.status === 'success') {
                            Swal.fire({
                                title: 'تم الحذف!',
                                text: 'تم حذف المهمة بنجاح',
                                icon: 'success',
                                confirmButtonText: 'حسناً'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'خطأ!',
                                text: 'حدث خطأ أثناء حذف المهمة',
                                icon: 'error',
                                confirmButtonText: 'حسناً'
                            });
                        }
                    }
                });
            }
        });
    });

    // Edit task handling
    $('.edit-btn').on('click', function() {
        const id = $(this).data('id');
        
        $.ajax({
            url: 'get_task.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                const task = JSON.parse(response);
                $('#edit_id').val(task.id);
                $('#edit_task_name').val(task.task_name);
                $('#edit_frequency').val(task.frequency);
                $('#edit_last_service_date').val(task.last_service_date);
                $('#edit_next_due_date').val(task.next_due_date);
                $('#edit_responsible_person').val(task.responsible_person);
                $('#edit_status').val(task.status);
                $('#editTaskModal').modal('show');
            }
        });
    });

    // Update task submission
    $('#editTaskForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            id: $('#edit_id').val(),
            task_name: $('#edit_task_name').val(),
            frequency: $('#edit_frequency').val(),
            last_service_date: $('#edit_last_service_date').val(),
            next_due_date: $('#edit_next_due_date').val(),
            responsible_person: $('#edit_responsible_person').val(),
            status: $('#edit_status').val()
        };

        $.ajax({
            url: 'update.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    Swal.fire({
                        title: 'نجاح!',
                        text: 'تم تحديث المهمة بنجاح',
                        icon: 'success',
                        confirmButtonText: 'حسناً'
                    }).then(() => {
                        $('#editTaskModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'خطأ!',
                        text: 'حدث خطأ أثناء تحديث المهمة',
                        icon: 'error',
                        confirmButtonText: 'حسناً'
                    });
                }
            }
        });
    });

    // Reset form when modal is closed
    $('#addTaskModal').on('hidden.bs.modal', function() {
        $('#taskForm')[0].reset();
    });

    $('#editTaskModal').on('hidden.bs.modal', function() {
        $('#editTaskForm')[0].reset();
    });
});
</script>

</body>

</html>