document.addEventListener("DOMContentLoaded", function (event) {
  const showNavbar = (toggleId, navId, bodyId, headerId) => {
    const toggle = document.getElementById(toggleId),
      nav = document.getElementById(navId),
      bodypd = document.getElementById(bodyId),
      headerpd = document.getElementById(headerId);
    // Validate that all variables exist
    if (toggle && nav && bodypd && headerpd) {
      toggle.addEventListener("click", () => {
        // show navbar
        nav.classList.toggle("show");
        // change icon
        toggle.classList.toggle("bx-x");
        // add padding to body
        bodypd.classList.toggle("body-pd");
        // add padding to header
        headerpd.classList.toggle("body-pd");
      });
    }
  };
  showNavbar("header-toggle", "nav-bar", "body-pd", "header");
  /*===== LINK ACTIVE =====*/
  const linkColor = document.querySelectorAll(".nav_link");
  function colorLink() {
    if (linkColor) {
      linkColor.forEach((l) => l.classList.remove("active"));
      this.classList.add("active");
    }
  }
  linkColor.forEach((l) => l.addEventListener("click", colorLink));
  // Your code to run since DOM is loaded and ready
});

//get employees
$(document).ready(function () {
  $("#example").DataTable({
    ajax: "getcoms.php",
    columns: [
      { data: "ComId" },
      {
        data: "ComImage",
        render: function (data) {
          return (
            '<article style=""><img src="./uploads/' +
            data +
            '" id="img1" width="70px" style="margin: -3px;" /></article> '
          );
        },
      },
      { data: "ComText", width: "30%" },
      { data: "ComDate" },
      { data: "Comtime" },
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
    columnDefs: [{ className: "dt-center", targets: "_all" }],
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
  $("#example").on("click", "td", function () {
    $("article").AutoLightbox({
      dimBackground: false,
      height: 700,
      width: 700,
    });
  });
});
//get archive
$(document).ready(function () {
  $("#archive").DataTable({
    ajax: "getarchive.php",
    columns: [
      { data: "seq" },
      { data: "name", width: "30%" },
      { data: "redid" },
      { data: "nat" },
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
    columnDefs: [{ className: "dt-center", targets: "_all" }],
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
  $("#example").on("click", "td", function () {
    $("article").AutoLightbox({
      dimBackground: false,
      height: 700,
      width: 700,
    });
  });
});
// //get iqama

//get holidays

// //get emp holidays
// $(document).ready(function () {
//   var table = $('#empholday').DataTable({
//     ajax: "getempholday.php",
//     columns: [
//       { data: "idm" },
//       { data: "id" },
//       { data: "employee_name", width: "30%" },
//       { data: "start_date" },
//       { data: "end_date" },
//       { data: "reason" },

//     ],
//     columnDefs: [
//       { className: "dt-center", targets: "_all" },

//     ],
//     select: {
//       style: 'os',
//       selector: 'td:first-child'
//     },
//     responsive: true,
//     dom: 'Bfrtip',
//     buttons: [
//       'copy', 'csv', 'excel', 'pdf', 'print'
//     ],
//     language: {
//       search: "بحث : ",
//       info: "عرض _START_ الى _END_ من _TOTAL_ سجل",
//       lengthMenu: "إظهار _MENU_ سجل",
//       paginate: {
//         previous: "السابق",
//         next: "اللاحق",
//       },
//     },
//   });

//   $('#empholday').on('click', 'tbody td:not(:first-child)', function(e) {
//     var cell = table.cell(this);
//     var columnIndex = cell.index().column;
//     var originalValue = cell.data();

//     // Exclude specific columns from inline editing
//     if (columnIndex !== 0 && columnIndex !== 1 && columnIndex !== 2 && columnIndex !== 5) {
//       // Check if an input element already exists
//       if ($(this).find('input').length === 0) {
//         // Clear the cell content
//         $(this).empty();

//         // Determine input type based on column
//         var inputType = columnIndex === 5 ? 'text' : 'date';

//         // Create an input element
//         var input = $('<input>', {
//           type: inputType,
//           value: originalValue,
//           blur: function() {
//             var newValue = input.val();
//             if (newValue !== originalValue) {
//               cell.data(newValue).draw();
//               // Send the updated data to the server
//               $.ajax({
//                 url: 'updateholday.php',
//                 method: 'POST',
//                 data: {
//                   id: table.row(cell.index().row).data().id,
//                   column: columnIndex,
//                   value: newValue
//                 },
//                 success: function(response) {
//                   console.log('Update successful');
//                 },
//                 error: function(xhr, status, error) {
//                   console.error('Update failed: ' + error);
//                 }
//               });
//             } else {
//               // Restore the original value if no change
//               cell.data(originalValue).draw();
//             }
//             // Remove the input element
//             input.remove();
//           },
//           keyup: function(e) {
//             if (e.keyCode === 13) { // Enter key
//               input.blur();
//             }
//           }
//         }).appendTo(cell.node()).focus().select();
//       }
//     }
//   });

//   // Hide the input text when clicking outside
//   $(document).on('click', function(e) {
//     if (!$(e.target).closest('#empholday').length) {
//       $('#empholday input').blur();
//     }
//   });
// });
