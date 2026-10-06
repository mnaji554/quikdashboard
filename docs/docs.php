<?php include '../config.php'; 
include '../header.php'; ?>

<!-- Add Document Form -->
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card" style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu" style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="#" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">إدارة المستندات</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add Document Button -->
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        إضافة مستند جديد
    </button>
</div>

<!-- Add Document Modal -->
<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">إضافة مستند جديد</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="docForm" class="row g-3" enctype="multipart/form-data">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <label for="doc_name" class="form-label">اسم المستند</label>
                        <input type="text" class="form-control" id="doc_name" name="doc_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="doc_type" class="form-label">نوع المستند</label>
                        <input type="text" class="form-control" id="doc_type" name="doc_type" required>
                    </div>
                    <div class="col-md-6">
                        <label for="doc_num" class="form-label">رقم المستند</label>
                        <input type="text" class="form-control" id="doc_num" name="doc_num" required>
                    </div>
                    <div class="col-md-6">
                        <label for="issue_date" class="form-label">تاريخ الإصدار</label>
                        <input type="date" class="form-control" id="issue_date" name="issue_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="expiry_date" class="form-label">تاريخ الانتهاء</label>
                        <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="doc_file" class="form-label">المستند</label>
                        <input type="file" class="form-control" id="doc_file" name="doc_file" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="col-md-6">
                        <label for="notification_days" class="form-label">التنبيه قبل (بالأيام)</label>
                        <input type="number" class="form-control" id="notification_days" name="notification_days" value="30" min="1" max="365" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" form="docForm" class="btn btn-primary">إضافة مستند</button>
            </div>
        </div>
    </div>
</div>

<!-- Documents Table -->
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <table id="documentsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>معرف</th>
                <th>المحطة</th>
                <th>اسم المستند</th>
                <th>نوع المستند </th>
                <th>رقم المستند </th>
                <th>تاريخ الإصدار</th>
                <th>تاريخ الانتهاء</th>
                <th>الأيام المتبقية</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Edit Document Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل المستند</h5>
                <button type="button" class="btn-close" style="position: absolute; left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" class="row g-3" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="col-md-6">
                        <label for="edit_station_id" class="form-label">المحطة</label>
                        <select class="form-select" id="edit_station_id" name="station_id" required>
                            <?php
                            $query = "SELECT id, stationName FROM stations ORDER BY stationName";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['stationName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_doc_name" class="form-label">اسم المستند</label>
                        <input type="text" class="form-control" id="edit_doc_name" name="doc_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_doc_type" class="form-label">نوع المستند</label>
                        <input type="text" class="form-control" id="edit_doc_type" name="doc_type" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_doc_num" class="form-label">رقم المستند</label>
                        <input type="text" class="form-control" id="edit_doc_num" name="doc_num" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_issue_date" class="form-label">تاريخ الإصدار</label>
                        <input type="date" class="form-control" id="edit_issue_date" name="issue_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_expiry_date" class="form-label">تاريخ الانتهاء</label>
                        <input type="date" class="form-control" id="edit_expiry_date" name="expiry_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_notification_days" class="form-label">التنبيه قبل (بالأيام)</label>
                        <input type="number" class="form-control" id="edit_notification_days" name="notification_days" 
                            value="30" min="1" max="365" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_doc_file" class="form-label">المستند الجديد (اختياري)</label>
                        <input type="file" class="form-control" id="edit_doc_file" name="doc_file" 
                            accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" form="editForm" class="btn btn-primary">حفظ التغييرات</button>
            </div>
        </div>
    </div>
</div>

<!-- Include DataTables and other dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables CSS - Make sure this comes after Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- Custom styles for RTL support in SweetAlert2 -->
<style>
.swal2-popup {
    font-family: 'Cairo', sans-serif !important;
    direction: rtl;
}
.swal2-title {
    font-family: 'Cairo', sans-serif !important;
}
.swal2-html-container {
    font-family: 'Cairo', sans-serif !important;
}
.swal2-confirm, .swal2-deny, .swal2-cancel {
    font-family: 'Cairo', sans-serif !important;
}
</style>

<style>
/* Override sorting arrows to prevent duplicates */
table.dataTable thead .sorting,
table.dataTable thead .sorting_asc,
table.dataTable thead .sorting_desc {
    background-image: none !important;
}
</style>

<script>
// Function to detect and convert Hijri dates to Gregorian
function formatDateDisplay(dateStr) {
    if (!dateStr) return '';
    
    // Check if it's already a valid Gregorian date
    const gregorianDate = new Date(dateStr);
    if (!isNaN(gregorianDate.getTime())) {
        // It's already a valid Gregorian date, return as is
        return dateStr;
    }
    
    // Try to parse as Hijri date (format: YYYY-MM-DD)
    const hijriMatch = dateStr.match(/^(\d{4})-(\d{2})-(\d{2})$/);
    if (hijriMatch) {
        const [_, year, month, day] = hijriMatch;
        
        try {
            // Create Hijri calendar instance
            const calendar = new Intl.DateTimeFormat('en-u-ca-islamic-umalqura', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                calendar: 'islamic-umalqura'
            });
            
            // Create a date that will represent the Hijri date
            const hijriDate = new Date(parseInt(year), parseInt(month) - 1, parseInt(day));
            
            // Convert to Gregorian using the browser's built-in conversion
            const parts = new Intl.DateTimeFormat('en-u-ca-gregory', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).formatToParts(hijriDate);
            
            // Build Gregorian date string (YYYY-MM-DD)
            const gregorianParts = {};
            parts.forEach(part => {
                if (part.type !== 'literal') {
                    gregorianParts[part.type] = part.value;
                }
            });
            
            return `${gregorianParts.year}-${gregorianParts.month}-${gregorianParts.day}`;
        } catch (e) {
            console.error('Error converting Hijri date:', e);
            return dateStr; // Return original if conversion fails
        }
    }
    
    // If neither Gregorian nor Hijri format matches, return original
    return dateStr;
}

// Function to check if it's 9 AM
function isNineAM() {
    const now = new Date();
    return now.getHours() === 9 && now.getMinutes() === 0;
}

// Function to schedule next 9 AM check
function scheduleNextNineAM() {
    const now = new Date();
    const next9AM = new Date(now);
    next9AM.setHours(9, 0, 0, 0);
    
    if (now.getHours() >= 9) {
        // If it's past 9 AM, schedule for tomorrow
        next9AM.setDate(next9AM.getDate() + 1);
    }
    
    const timeUntil9AM = next9AM.getTime() - now.getTime();
    console.log("Next check scheduled for:", next9AM);
    
    return timeUntil9AM;
}

// Set up notification checks
function startPeriodicChecks() {
    let isCurrentlyNotifying = false;
    let currentDocIndex = 0;
    let docsToProcess = [];

    // Function to process one document at a time
    async function processNextDocument() {
        if (!isCurrentlyNotifying || currentDocIndex >= docsToProcess.length) {
            isCurrentlyNotifying = false;
            currentDocIndex = 0;
            return;
        }

        const doc = docsToProcess[currentDocIndex];
        await checkDocumentNotifications([doc]); // Process single document
        currentDocIndex++;

        // Schedule next document after 10 minutes
        setTimeout(processNextDocument, 10 * 60 * 1000); // 10 minutes
    }

    // Function to start daily check
    async function dailyCheck() {
        console.log("Running daily check at 9 AM...");
        if (typeof documentsData !== 'undefined' && documentsData.length > 0) {
            // Reset notification state for new daily check
            isCurrentlyNotifying = true;
            currentDocIndex = 0;
            docsToProcess = documentsData.filter(doc => 
                (doc.status === 'soon_expire' || doc.status === 'expired')
            );
            
            if (docsToProcess.length > 0) {
                console.log(`Found ${docsToProcess.length} documents to process`);
                processNextDocument();
            }
        }

        // Schedule next day's check
        setTimeout(dailyCheck, scheduleNextNineAM());
    }

    // Start the daily check cycle
    const timeUntilFirst9AM = scheduleNextNineAM();
    setTimeout(dailyCheck, timeUntilFirst9AM);

    // Also check immediately on page load (but respect the 10-minute interval)
    if (typeof documentsData !== 'undefined' && documentsData.length > 0) {
        isCurrentlyNotifying = true;
        docsToProcess = documentsData.filter(doc => 
            (doc.status === 'soon_expire' || doc.status === 'expired')
        );
        processNextDocument();
    }
}

// Start periodic checks
startPeriodicChecks();

// Store already notified documents to prevent duplicate notifications
let notifiedDocuments = new Set();

async function showSmartAlert(title, message, type = 'warning') {
    const iconMap = {
        'warning': 'warning',
        'error': 'error',
        'success': 'success',
        'info': 'info'
    };

    await Swal.fire({
        title: title,
        html: message,
        icon: iconMap[type] || 'info',
        confirmButtonText: 'حسناً',
        confirmButtonColor: '#3085d6',
        position: 'top-end',
        toast: true,
        timer: 5000,
        timerProgressBar: true,
        showCloseButton: true,
        customClass: {
            popup: 'swal2-rtl',
            title: 'swal2-title-rtl',
            content: 'swal2-content-rtl',
            confirmButton: 'swal2-confirm-rtl'
        }
    });
}

async function showDocumentAlert(doc) {
    const statusColors = {
        'expired': '#dc3545',
        'soon_expire': '#ffc107'
    };

    const daysText = doc.status === 'expired' ? 'منتهي' : `سينتهي خلال ${doc.days_remaining} يوم`;
    const title = "تنبيه انتهاء صلاحية مستند";
    const message = `
        <div class="alert-content" style="text-align: right; direction: rtl;">
            <p><strong>اسم المستند:</strong> ${doc.doc_name}</p>
            <p><strong>نوع المستند:</strong> ${doc.doc_type}</p>
            <p><strong>المحطة:</strong> ${doc.station_name}</p>
            <p><strong>الحالة:</strong> <span style="color: ${statusColors[doc.status]}">${daysText}</span></p>
        </div>
    `;

    await showSmartAlert(title, message, doc.status === 'expired' ? 'error' : 'warning');
}

async function checkDocumentNotifications(documents) {
    console.log("Checking documents for notifications...", documents);

    try {
        // Filter documents that need notification
        const docsToNotify = documents.filter(doc => 
            (doc.status === 'soon_expire' || doc.status === 'expired') && 
            !notifiedDocuments.has(`${doc.id}-${doc.expiry_date}`)
        );

        console.log("Documents to notify:", docsToNotify);

        // Show notifications for filtered documents
        for (const doc of docsToNotify) {
            const notificationKey = `${doc.id}-${doc.expiry_date}`;
            
            console.log("Creating alert for:", doc.doc_name);
            await showDocumentAlert(doc);

            // Store to prevent duplicates
            notifiedDocuments.add(notificationKey);

            // Add delay between notifications
            await new Promise(resolve => setTimeout(resolve, 6000)); // Wait 6 seconds between alerts
        }
    } catch (error) {
        console.error("Error in checkDocumentNotifications:", error);
    }}


$(document).ready(function() {
    // Fetch latest documents every hour to keep data fresh
    async function updateDocumentsData() {
        try {
            console.log("Updating documents data...");
            const response = await fetch('fetch.php');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            documentsData = data; // Update global data
            console.log("Documents data updated successfully");
        } catch (error) {
            console.error('Error updating documents data:', error);
        }
    }

    // Update documents data every hour
    setInterval(updateDocumentsData, 60 * 60 * 1000);
    
    // Initial data fetch
    updateDocumentsData();

    var table = $('#documentsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: "copy",
                text: "نسخ",
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: "csv",
                text: "تصدير CSV",
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: "excel",
                text: "تصدير Excel",
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: "pdf",
                text: "تصدير PDF",
                exportOptions: { columns: ':not(:last-child)' },
                customize: function(doc) {
                    doc.defaultStyle.direction = 'rtl';
                    doc.defaultStyle.textAlign = 'right';
                }
            },
            {
                extend: "print",
                text: "طباعة",
                exportOptions: { columns: ':not(:last-child)' },
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
        ],        ajax: {
            url: 'fetch.php',
            dataSrc: function(json) {
                // Check for expiring documents
                checkDocumentNotifications(json);
                return json;
            }
        },
        columns: [
            { data: 'id' },
            { data: 'station_name' },
            { data: 'doc_name' },
            { data: 'doc_type' },
            { data: 'doc_num' },
            { 
                data: 'issue_date',
                render: function(data, type) {
                    if (type === 'display') {
                        return formatDateDisplay(data);
                    }
                    return data; // Use original date for sorting/filtering
                }
            },
            { 
                data: 'expiry_date',
                render: function(data, type) {
                    if (type === 'display') {
                        return formatDateDisplay(data);
                    }
                    return data; // Use original date for sorting/filtering
                }
            },
            { 
                data: 'days_remaining',
                render: function(data) {
                    return data < 0 ? 'منتهي' : data + ' يوم';
                }
            },
            { 
                data: 'status',
                render: function(data) {
                    const colors = {
                        'active': 'success',
                        'expired': 'danger',
                        'soon_expire': 'warning'
                    };
                    const labels = {
                        'active': 'ساري',
                        'expired': 'منتهي',
                        'soon_expire': 'قريب الانتهاء'
                    };
                    return `<span class="badge bg-${colors[data]}">${labels[data]}</span>`;
                }
            },
            { data: 'actions' }
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
            },
        },
        order: [[5, 'asc']] // Sort by days remaining
    });

    // Add Document
    $("#docForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: "insert.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                table.ajax.reload();
                $("#docForm")[0].reset();
                $("#addModal").modal('hide');
                showSmartAlert("نجاح", "تم إضافة المستند بنجاح", "success");
            },
            error: function(xhr) {
                showSmartAlert("خطأ", "حدث خطأ: " + (xhr.responseJSON ? xhr.responseJSON.error : 'خطأ غير معروف'), "error");
            }
        });
    });

    // Edit Document
    $(document).on("click", ".editBtn", function() {
        var id = $(this).data("id");
        $.getJSON("fetch.php?id=" + id, function(doc) {
            $("#edit_id").val(doc.id);
            $("#edit_station_id").val(doc.station_id);
            $("#edit_doc_name").val(doc.doc_name);
            $("#edit_doc_type").val(doc.doc_type);
            $("#edit_doc_num").val(doc.doc_num);
            $("#edit_issue_date").val(doc.issue_date);
            $("#edit_expiry_date").val(doc.expiry_date);
            $("#edit_notification_days").val(doc.notification_days);
            $("#editModal").modal('show');
        });
    });    // Update Document
    $("#editForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: "update.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    table.ajax.reload();
                    $("#editModal").modal('hide');
                    showSmartAlert("نجاح", response.message, "success");
                } else {
                    showSmartAlert("خطأ", "حدث خطأ: " + response.message, "error");
                }
            },
            error: function(xhr) {
                var error = xhr.responseJSON ? xhr.responseJSON.message : 'خطأ غير معروف';
                showSmartAlert("خطأ", "حدث خطأ: " + error, "error");
            }
        });
    });    // Delete Document
    $(document).on("click", ".deleteBtn", function() {
        var id = $(this).data("id");
        Swal.fire({
            title: "تأكيد الحذف",
            text: "هل أنت متأكد من حذف هذا المستند؟",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "نعم، احذف",
            cancelButtonText: "إلغاء",
            customClass: {
                popup: 'swal2-rtl',
                title: 'swal2-title-rtl',
                content: 'swal2-content-rtl',
                confirmButton: 'swal2-confirm-rtl',
                cancelButton: 'swal2-cancel-rtl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("delete.php", { id: id }, function(response) {
                    if (response.status === 'success') {
                        table.ajax.reload();
                        showSmartAlert("نجاح", response.message, "success");
                    } else {
                        showSmartAlert("خطأ", "حدث خطأ: " + response.message, "error");
                    }
                }, 'json').fail(function(xhr) {
                    var error = xhr.responseJSON ? xhr.responseJSON.message : 'خطأ غير معروف';
                    showSmartAlert("خطأ", "حدث خطأ: " + error, "error");
                });
            }
        });
    });
    });

</script>