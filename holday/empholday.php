<?php

include("../config.php");
include("../header.php");

$employee_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<div class="nvm" style="margin-bottom: 20px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        إجازات الموظف</a>
                </li>
           

            </ul>
        </nav>
    </div>
</div>

    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
        <input type="hidden" id="employee_id" value="<?php echo $employee_id; ?>">
        <table id="empholday" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>م</th>
                    <th>رقم الاقامة</th>
                    <th>الاسم</th>
                    <th>تاريخ السفر</th>
                    <th>تاريخ العودة</th>
                    <th>سبب الاجازة</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            var employee_id = $('#employee_id').val();
            $('#empholday').DataTable({
                ajax: {
                    url: 'getempholday.php',
                    type: 'GET',
                    data: {
                        id: employee_id
                    },
                },
                columns: [
                    { data: "idm" },
                    { data: "id" },
                    { data: "employee_name", width: "30%" },
                    { data: "start_date" },
                    { data: "end_date" },
                    { data: "reason" },

                ],
                columnDefs: [
                    { className: "dt-center", targets: "_all" },

                ],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
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

        
        });
    </script>
</body>

</html>
<?php

?>