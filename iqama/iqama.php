<?php include "../header.php"; ?>


<div class="nvm" style="margin-bottom: 20px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        الاقامات</a>
            </ul>
        </nav>
    </div>
</div>
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">

    <table id="iqama" class="display" style="width:100%">
        <thead>
            <tr>
                <th>م</th>
                <th>رقم الاقامة</th>
                <th>الاسم</th>
                <th>المهنة </th>
                <th>رقم الجواز</th>
                <th>انتهاء الجواز</th>
                <th>تاريخ انتهاء الاقامة </th>
                <th> تاريخ الميلاد </th>
                <th>المتبقي على الاقامة </th>
                <th> عمليات </th>
            </tr>
        </thead>
    </table>
</div>
<div id="dialog" style="display:none" title="Create new user">
    <p class="validateTips">All form fields are required.</p>
    <form>
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="text ui-widget-content ui-corner-all">
            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
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
  $("#iqama").DataTable({    ajax: "getiqama.php",
    dom: "lBfrtip", // Added 'l' to show length menu
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "الكل"]],
    pageLength: 10, // Default number of rows to show
    columns: [
      { 
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1;
        }
      },
      { data: "id" },
      { data: "name", width: "30%" },
      { data: "Occupation" },
      { data: "passport" },
      { data: "DOPE" },
      { data: "DOIDE" },
      { data: "DOB" },
      { data: "expire" },
      { data: null },
    ],
    
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
        targets: 0, // Target first column
        orderable: false,
        render: function (data, type, row, meta) {
          return meta.row + 1; // Add row number
        }
      },
      {
        targets: -1,
        render: function (data, type, row) {
          var button =
            '<a href="update.php?id=' +
            data["id"] +
            "&pass=" +
            data["passport"] +
            "&passex=" +
            data["DOPE"] +
            "&idex=" +
            data["DOIDE"] +
            '" style="padding:10px;"><i class="fa fa-pen">  </i></a>';
          return button;
        },
      },
    ],    language: {
      search: "بحث : ",
      info: "عرض _START_ الى _END_ من _TOTAL_ سجل",
      lengthMenu: "عرض _MENU_ سجل في الصفحة",
      paginate: {
        previous: "السابق",
        next: "اللاحق",
      },
      emptyTable: "لا توجد بيانات متاحة",
      zeroRecords: "لم يتم العثور على سجلات مطابقة",
    },
  });
  $("#iqama").on("click", "td", function () {});
});
</script>
</body>

</html>