
<?php
include '../config.php';
include '../header.php';

?>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<div class="nvm" style="margin-bottom: 20px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="#" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        تسلسل الارشيف</a>
                <li class="navbar-item" style="margin-right: 30px;margin-left: 20px;margin-top: 15px;">
                    <a href="addholday.php" style="all: unset; cursor: pointer;"><i class="fas fa-user-plus"></i>
                        اضافة </a>
                </li>

            </ul>
        </nav>
    </div>
</div>



    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
        <table id="archive" class="display" style="width:100%">
            <thead>
                <tr>

                    <th>م</th>
                    <th>الاسم</th>
                    <th>رقم الاقامة</th>
                    <th>الجنسية </th>
   
                </tr>
            </thead>

        </table>
    </div>


</body>


</html>


