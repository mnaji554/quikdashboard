   $id = mysqli_real_escape_string($conn, $_GET['id']);
   $name = mysqli_real_escape_string($conn, $_GET['name']);
   $nat = mysqli_real_escape_string($conn, $_GET['nat']);
   $gender = mysqli_real_escape_string($conn, $_GET['gender']);
   $phone = mysqli_real_escape_string($conn, $_GET['phone']);
   $company = mysqli_real_escape_string($conn, $_GET['company']);
   $Occupation = mysqli_real_escape_string($conn, $_GET['Occupation']);
   $workplace = mysqli_real_escape_string($conn, $_GET['workplace']);
   $DOW = mysqli_real_escape_string($conn, $_GET['DOW']);
   $Salbe = mysqli_real_escape_string($conn, $_GET['Salbe']);
   $salnow = mysqli_real_escape_string($conn, $_GET['salnow']);
   $DOID = mysqli_real_escape_string($conn, $_GET['DOID']);
   $DOIDE = mysqli_real_escape_string($conn, $_GET['DOIDE']);
   $DOIDEH = mysqli_real_escape_string($conn, $_GET['DOIDEH']);
   $remain = mysqli_real_escape_string($conn, $_GET['remain']);
   $passport = mysqli_real_escape_string($conn, $_GET['passport']);
   $border = mysqli_real_escape_string($conn, $_GET['border']);
   $DOPE = mysqli_real_escape_string($conn, $_GET['DOPE']);
   $DOB = mysqli_real_escape_string($conn, $_GET['DOB']);
   $INSCAM = mysqli_real_escape_string($conn, $_GET['INSCAM']);
   $INSSTATE = mysqli_real_escape_string($conn, $_GET['INSSTATE']);
   $DOINSE = mysqli_real_escape_string($conn, $_GET['DOINSE']);




   <div class="card-body">
        <div class="mb-3">
            <div class="inputs mb-2">
                <label for="username" class="pb-2">رقم الاقامة</label>
                <input type="text" class="form-control" id="username" name="username" autocomplete="off" required
                    autofocus>
            </div>
            <div class="msend mb-3">
                <button type="submit" id="search" class="send btn-block w-100 mt-4" role="button">
                    بحث
                </button>
            </div>
        </div>
    </div>



    page sample
    <!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1;">
    <meta charset="utf-8" />
    <link href="./assets/css/fontawesome.min.css" rel="stylesheet">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/solid.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <title>لوحة تحكم محطة تركي العامر</title>
    <script src="./assets/js/bootstrap.bundle.js.map"></script>
    <script src="./assets/js/jquery-3.6.1.min.js"></script>
</head>

<body>
    <div class="card-body">
        <div class="mb-3">
            <div class="inputs mb-2" style="text-align: center;">
                <label for="username" style="font-size:30px;font-weight: bold;" class="pb-2">إدارة الملفات</label>
            </div>
            <div class="msend mb-3">
                <button type="submit" id="search" class="send btn-block w-100 mt-4" role="button"
                    onclick="window.location.href='addfile.php'">
                    اضافة ملف جديد
                </button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg info-body">
                <div class="col" id="res" style="display: flex; width:95%;">
                    <div class='col-6'>
                        <div class='line-body'>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>