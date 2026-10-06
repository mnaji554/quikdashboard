
<?php 
include ("../config.php");
include ("../header.php");
?>
<!-- Add SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<?php
if (isset($_POST['update'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $nat = mysqli_real_escape_string($conn, $_POST['nat']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $company = mysqli_real_escape_string($conn, $_POST['company']);
        $occupation = mysqli_real_escape_string($conn, $_POST['Occupation']);
        $workplace = mysqli_real_escape_string($conn, $_POST['workplace']);
        $dow = mysqli_real_escape_string($conn, $_POST['DOW']);
        $email = mysqli_real_escape_string($conn, $_POST['email']); // Changed from salnow
        $salary = mysqli_real_escape_string($conn, $_POST['salary']); // Changed from salbe
        $doid = mysqli_real_escape_string($conn, $_POST['DOID']);
        $doide = mysqli_real_escape_string($conn, $_POST['DOIDE']);
        $doideh = mysqli_real_escape_string($conn, $_POST['DOIDEH']);
        $passport = mysqli_real_escape_string($conn, $_POST['passport']);
        $dope = mysqli_real_escape_string($conn, $_POST['DOPE']);
        $dob = mysqli_real_escape_string($conn, $_POST['DOB']);
        $inscam = mysqli_real_escape_string($conn, $_POST['INSCAM']);
        $doinse = mysqli_real_escape_string($conn, $_POST['DOINSE']);    $query = "UPDATE employee SET 
        name = '$name',
        nat = '$nat',
        gender = '$gender',
        phone = '$phone',
        company = '$company',
        Occupation = '$occupation',
        workplace = '$workplace',
        DOW = '$dow',
        email = '$email',
        salary = '$salary',
        DOB = '$dob',
        DOID = '$doid',
        DOIDE = '$doide',
        passport = '$passport',
        DOPE = '$dope',
        INSCAM = '$inscam',
        DOINSE = '$doinse'
        WHERE id = '$id'";if(mysqli_query($conn, $query)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'تم',
                text: 'تم تحديث بيانات الموظف بنجاح',
                confirmButtonText: 'حسناً'
            }).then(() => {
                window.location.href = 'employee.php?id=$id';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ في تحديث البيانات: " . mysqli_error($conn) . "',
                confirmButtonText: 'حسناً'
            });
        </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT *, DATEDIFF(DOIDE,CURDATE()) as expire FROM employee where id = $id limit 1";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result)) {
?>
    <div class="container">
        <div class="row">
            <div class="col-lg info-body">
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">       
                                 <div class="col" id="res" style="display: flex; width:94%;">
                        <div class='col-6 empcol'>
                            <div class='line-body eminput'> <span>الاسم :</span><input type="text" class="form-control upinput" name="name" value="<?php echo $row['name']; ?>" ></div>
                            <div class='line-body eminput'> <span>رقم الاقامة :</span><input disabled type="text" class="form-control upinput" name="id" value="<?php echo $row['id']; ?>"></div>
                            <div class='line-body eminput'> <span>الجنسية :</span><input type="text" class="form-control upinput" name="nat" value="<?php echo $row['nat']; ?>" ></div>
                            <div class='line-body eminput'> <span>الجنس :</span><input type="text" class="form-control upinput" name="gender" value="<?php echo $row['gender']; ?>" ></div>
                            <div class='line-body eminput'> <span>رقم الجوال :</span><input type="text" class="form-control upinput" name="phone" value="<?php echo $row['phone']; ?>" ></div>
                            <div class='line-body eminput'> <span>اسم المنشأة :</span><input type="text" class="form-control upinput" name="company" value="<?php echo $row['company']; ?>" ></div>
                            <div class='line-body eminput'> <span>المهنة بالتأشيرة :</span><input type="text" class="form-control upinput" name="Occupation" value="<?php echo $row['Occupation']; ?>" ></div>
                            <div class='line-body eminput'> <span>النشاط الفعلي :</span><input type="text" class="form-control upinput" name="workplace" value="<?php echo $row['workplace']; ?>" ></div>                            
                            <div class='line-body eminput'> <span>تاريخ الالتحاق :</span><input type="date" class="form-control upinput" name="DOW" value="<?php echo $row['DOW']; ?>" ></div>
                            <div class='line-body eminput'> <span>تاريخ الميلاد :</span><input type="date" class="form-control upinput" name="DOB" value="<?php echo $row['DOB']; ?>" ></div>
                        </div>
                        <div class='col-6 empcol'>

                            <div class='line-body eminput'> <span>الراتب :</span><input type="text" class="form-control upinput" name="salary" value="<?php echo $row['salary']; ?>" ></div>
                            <div class='line-body eminput'> <span>البريد الإلكتروني :</span><input type="email" class="form-control upinput" name="email" value="<?php echo $row['email']; ?>"></div>
                            <div class='line-body eminput'> <span>تاريخ اصدار الاقامة :</span><input type="date" class="form-control upinput" name="DOID" value="<?php echo $row['DOID']; ?>" ></div>
                            <div class='line-body eminput'> <span>تاريخ انتهاء الاقامة :</span><input type="date" class="form-control upinput" name="DOIDE" value="<?php echo $row['DOIDE']; ?>" ></div>
                            <div class='line-body eminput'> <span>تاريخ انتهاء الاقامة هجري :</span><input type="date" class="form-control upinput" name="DOIDEH" value="<?php echo $row['DOIDEH']; ?>" ></div>
                            <div class='line-body eminput'> <span>رقم الجواز :</span><input type="text" class="form-control upinput" name="passport" value="<?php echo $row['passport']; ?>" ></div>
                            <div class='line-body eminput'> <span>تاريخ انتهاء الجواز :</span><input type="date" class="form-control upinput" name="DOPE" value="<?php echo $row['DOPE']; ?>" ></div>
                            <div class='line-body eminput'> <span>شركة التأمين :</span><input type="text" class="form-control upinput" name="INSCAM" value="<?php echo $row['INSCAM']; ?>" ></div>
                            <div class='line-body eminput'> <span>تاريخ انتهاء التأمين :</span><input type="date" class="form-control upinput" name="DOINSE" value="<?php echo $row['DOINSE']; ?>" ></div>
                        </div>
                    </div>
                    <div class="msend mb-3">
                        <button type="submit" name="update" class="send btn-block w-100 mt-4" role="button">
                            تعديل البيانات
                        </button>
                        <button type="button" class="send btn-secondary btn-block w-100 mt-2" onclick="window.location.href='index.php'">
                           الرجوع للصفحة الرئيسية
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    }
}
?>
<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
</body>
</html>