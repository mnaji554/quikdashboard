<?php include("../header.php"); ?>

<div class="nvm" style="margin-bottom: 20px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        الاجازات</a>
                <li class="navbar-item" style="margin-right: 30px;margin-left: 20px;margin-top: 15px;">
                    <a href="addholday.php" style="all: unset; cursor: pointer;"><i class="fas fa-user-plus"></i>
                        اضافة إجازة</a>
                </li>

            </ul>
        </nav>
    </div>
</div>
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
    <table id="holday" class="display" style="width:100%">
        <thead>
            <tr>
                <th>م</th>
                <th>رقم الاقامة</th>
                <th>الاسم</th>
                <th>تاريخ السفر </th>
                <th>تاريخ العودة </th>
                <th> سبب الاجازة </th>
                <th> حالة الاجازة </th>
                <th> عمليات </th>
            </tr>
        </thead>
    </table>
</div>
</div>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>



<script>
    $(document).ready(function () {
  // Helper function to format dates
  function formatDate(dateString) {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('en-GB');
  }

  // Helper function to calculate holiday status
  function calculateHolidayStatus(startDate, endDate) {
    const now = new Date();
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    if (isNaN(start.getTime()) || isNaN(end.getTime())) {
      return { status: 'error', text: 'تاريخ غير صالح' };
    }

    if (now < start) {
      return { 
        status: 'pending',
        text: 'لم تبدأ بعد',
        class: 'bg-info'
      };
    } else if (now > end) {
      return { 
        status: 'completed',
        text: 'انتهت',
        class: 'bg-secondary'
      };
    } else {
      return { 
        status: 'active',
        text: 'في إجازة',
        class: 'bg-success'
      };
    }
  }

  var table = $("#holday").DataTable({
    ajax: {
      url: "getholday.php",
      dataSrc: function(json) {
        // Ensure we have an array to work with
        const data = Array.isArray(json) ? json : (json.data || []);
        
        // Process each row of data
        return data.map(function(row) {
          try {
            const holidayStatus = calculateHolidayStatus(row.start_date, row.end_date);
            return {
              ...row,
              in_holiday: holidayStatus.text,
              holiday_class: holidayStatus.class
            };
          } catch (error) {
            console.error('Error processing row:', error, row);
            return {
              ...row,
              in_holiday: 'خطأ في البيانات',
              holiday_class: 'bg-danger'
            };
          }
        });
      }
    },
    columns: [
      { data: "idm" },
      { data: "id" },
      { data: "employee_name", width: "30%" },
      { 
        data: "start_date",
        render: function(data) {
          return formatDate(data);
        }
      },
      { 
        data: "end_date",
        render: function(data) {
          return formatDate(data);
        }
      },
            { data: "reason" },

      { 
        data: "in_holiday",
        render: function(data, type, row) {
          return `<span class="badge ${row.holiday_class}">${data}</span>`;
        }
      },
      { data: null },
    ],
    dom: "Bfrtip",
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
          columns: ":not(:last-child)", // This excludes the last column (actions)
          // Or specify exact columns to show:
          // columns: [ 0, 1, 2, 3, 4, 5, 6 ] // Include only these column indexes
        },
        customize: function (win) {
          $(win.document.body)
            .css("direction", "rtl")
            .css("text-align", "right");

          // Fix table direction
          $(win.document.body)
            .find("table")
            .css("direction", "rtl")
            .css("text-align", "right");

          // Fix table header direction
          $(win.document.body)
            .find("table thead th")
            .css("text-align", "right");

          // Fix table cells direction
          $(win.document.body)
            .find("table tbody td")
            .css("text-align", "right");
        },
      },
    ],
    columnDefs: [
      { className: "dt-center", targets: "_all" },
      {
        targets: -1,
        render: function (data, type, row) {
          var button =
            '<a href="javascript:void(0);" class="delete-btn" data-id="' +
            data["idm"] +
            '" style="padding:10px;"><i class="fa fa-trash">  </i></a>';
          return button;
        },
      },
    ],
    select: {
      style: "os",
      selector: "td:first-child",
    },
    responsive: true,
    dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "pdf", "print"],
    language: {
      search: "بحث : ",
      info: "عرض _START_ الى _END_ من _TOTAL_ سجل",
      lengthMenu: "إظهار _MENU_ سجل",
      paginate: {
        previous: "السابق",
        next: "اللاحق",
      },
    },
  });
  $("#holday").on("click", ".delete-btn", function (e) {
    e.preventDefault();
    var idm = $(this).data("id");
    var row = table.row($(this).closest('tr'));
    var employeeName = row.data().employee_name;

    // Use SweetAlert2 for confirmation
    Swal.fire({
      title: 'تأكيد الحذف',
      html: `هل أنت متأكد من حذف إجازة الموظف <strong>${employeeName}</strong>؟`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'نعم، احذف',
      cancelButtonText: 'إلغاء',
      customClass: {
        popup: 'swal2-rtl'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "deleteholday.php",
          method: "POST",
          data: { idm: idm },
          success: function (response) {
            try {
              const result = typeof response === 'string' ? JSON.parse(response) : response;
              if (result.status === "success") {
                table.ajax.reload();
                Swal.fire({
                  title: 'تم الحذف',
                  text: 'تم حذف الإجازة بنجاح',
                  icon: 'success',
                  customClass: {
                    popup: 'swal2-rtl'
                  }
                });
              } else {
                Swal.fire({
                  title: 'خطأ',
                  text: result.message || 'فشل حذف الإجازة',
                  icon: 'error',
                  customClass: {
                    popup: 'swal2-rtl'
                  }
                });
              }
            } catch (e) {
              console.error('Error parsing response:', e);
              Swal.fire({
                title: 'خطأ',
                text: 'حدث خطأ غير متوقع',
                icon: 'error',
                customClass: {
                  popup: 'swal2-rtl'
                }
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("Delete failed:", error);
            Swal.fire({
              title: 'خطأ',
              text: 'حدث خطأ أثناء حذف الإجازة',
              icon: 'error',
              customClass: {
                popup: 'swal2-rtl'
              }
            });
          }
        });
      }
    });
  });

  $("#holday").on("click", "tbody td:not(:first-child)", function (e) {
    var cell = table.cell(this);
    var columnIndex = cell.index().column;
    var originalValue = cell.data();
    var row = table.row(cell.index().row);
    var rowData = row.data();

    // Exclude specific columns from inline editing
    if (
      columnIndex !== 0 &&
      columnIndex !== 1 &&
      columnIndex !== 2 &&
      columnIndex !== 5 &&
      columnIndex !== 6
    ) {
      // Check if an input element already exists
      if ($(this).find("input").length === 0) {
        // Clear the cell content
        $(this).empty();

        // Determine input type and validation based on column
        var inputType = columnIndex === 5 ? "text" : "date";
        var minDate = columnIndex === 3 ? new Date().toISOString().split('T')[0] : rowData.start_date;
        var maxDate = columnIndex === 4 ? null : rowData.end_date;

        // Create an input element
        var input = $("<input>", {
          type: inputType,
          value: originalValue,
          min: minDate,
          max: maxDate,
          class: 'form-control',
          blur: function () {
            var newValue = input.val();
            
            // Validate dates
            if (inputType === "date") {
              const newDate = new Date(newValue);
              const startDate = new Date(rowData.start_date);
              const endDate = new Date(rowData.end_date);
              
              if (columnIndex === 3 && endDate && newDate > endDate) {
                Swal.fire({
                  title: 'خطأ',
                  text: 'تاريخ البداية يجب أن يكون قبل تاريخ النهاية',
                  icon: 'error',
                  customClass: { popup: 'swal2-rtl' }
                });
                cell.data(originalValue).draw();
                input.remove();
                return;
              }
              
              if (columnIndex === 4 && startDate && newDate < startDate) {
                Swal.fire({
                  title: 'خطأ',
                  text: 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية',
                  icon: 'error',
                  customClass: { popup: 'swal2-rtl' }
                });
                cell.data(originalValue).draw();
                input.remove();
                return;
              }
            }

            if (newValue !== originalValue) {
              // Show loading state
              $(cell.node()).append('<div class="spinner-border spinner-border-sm ms-2" role="status"></div>');
              
              // Send the updated data to the server
              $.ajax({
                url: "updateholday.php",
                method: "POST",
                data: {
                  id: rowData.id,
                  column: columnIndex,
                  value: newValue,
                },
                success: function (response) {
                  try {
                    const result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.status === "success") {
                      table.ajax.reload();
                      Swal.fire({
                        title: 'تم التحديث',
                        text: 'تم تحديث الإجازة بنجاح',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: { popup: 'swal2-rtl' }
                      });
                    } else {
                      cell.data(originalValue).draw();
                      Swal.fire({
                        title: 'خطأ',
                        text: result.message || 'فشل تحديث الإجازة',
                        icon: 'error',
                        customClass: { popup: 'swal2-rtl' }
                      });
                    }
                  } catch (e) {
                    console.error('Error parsing response:', e);
                    cell.data(originalValue).draw();
                    Swal.fire({
                      title: 'خطأ',
                      text: 'حدث خطأ غير متوقع',
                      icon: 'error',
                      customClass: { popup: 'swal2-rtl' }
                    });
                  }
                },
                error: function (xhr, status, error) {
                  console.error("Update failed:", error);
                  cell.data(originalValue).draw();
                  Swal.fire({
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء تحديث الإجازة',
                    icon: 'error',
                    customClass: { popup: 'swal2-rtl' }
                  });
                }
              });
            }
            // Remove the input element
            input.remove();
          },
          keyup: function (e) {
            if (e.keyCode === 13) { // Enter key
              input.blur();
            }
            if (e.keyCode === 27) { // Escape key
              cell.data(originalValue).draw();
              input.remove();
            }
          }
        })
        .appendTo(cell.node())
        .focus()
        .select();
      }
    }
  });

  // Hide the input text when clicking outside
  $(document).on("click", function (e) {
    if (!$(e.target).closest("#holday").length) {
      $("#holday input").blur();
    }
  });
});
</script>
</body>
</html>