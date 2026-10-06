<!DOCTYPE html>

<html dir="rtl" lang="ar">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1;">
    <meta charset="utf-8" />
    <link href="./assets/css/fontawesome.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />


    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="./assets/css/solid.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <title>إدارة البلاغات محطة كويك</title>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="./assets/js/AutoLightbox.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="./assets/js/bootstrap.bundle.js.map"></script>
    <script src="./assets/js/main.js"></script>



</head>
<?php
 session_start();
if (isset($_SESSION['login_user'])){?>



<body style="margin:5%;">

    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>

                    <th>م</th>
                    <th>صورة الشكوى</th>
                    <th>ملاحظات</th>
                    <th>تاريخ الشكوى</th>
                    <th>وقت الشكوى</th>
                </tr>
            </thead>

        </table>
    </div>


</body>


</html>
<?php } else {
    header("location: index.php");
}

?>