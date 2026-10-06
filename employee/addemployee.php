<?php
ob_start(); // Start output buffering
include("../config.php");
include("../header.php");
?>
<!-- Add SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<style>
    .error-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    /* Modern Form Styling */
    .info-body {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04), 
                    0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 2.5rem;
        margin: 25px auto;
        border: 1px solid #edf2f7;
    }    .line-body {
        margin-bottom: 1.2rem;
        padding: 0 15px;
        position: relative;
    }

    .line-body span {
        display: block;
        margin-bottom: 0.5rem;
        color: #374151;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .upinput {
        border: 2px solid #e5e7eb;
        border-radius: 6px;
        padding: 0.625rem 0.875rem;
        transition: all 0.2s ease;
        background: #ffffff;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .upinput:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .upinput:hover {
        border-color: #d1d5db;
    }

    .empcol {
        padding: 1rem;
    }

    @media (max-width: 768px) {
        #res {
            flex-direction: column;
        }
        .empcol {
            width: 100%;
        }
    }    .send {
        background-color: #2563eb;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .send:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
    }

    .send:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background-color: #6b7280;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }    .nvm .card {
        background: #ffffff;
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
    }

    .navbar-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
    }

    .navbar-item a {
        color: #111827;
        font-size: 1.25rem;
        font-weight: 700;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
        border: none;
        padding: 0.625rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }/* Form section styling */
    .form-section-title {
        color: #111827;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.75rem;
        padding-bottom: 0.75rem;
        position: relative;
    }

    .form-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: #e5e7eb;
    }

    h4.form-section-title {
        font-size: 1.5rem;
        color: #1f2937;
        margin-bottom: 2rem;
        text-align: center;
    }

    h4.form-section-title::after {
        width: 100px;
        margin: 0 auto;
        background: #3b82f6;
        left: 50%;
        transform: translateX(-50%);
    }

    .empcol {
        background: #f9fafb;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
</style>

<?php
if (isset($_POST['add'])) {
    // Sanitize input data
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Check if employee ID already exists
    $check_query = "SELECT id FROM employee WHERE id = '$id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'رقم الإقامة موجود مسبقاً. الرجاء التحقق من الرقم.',
                confirmButtonText: 'حسناً'
            });
        </script>";
    } else {
        // Continue with sanitizing other input fields
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
        $doinse = mysqli_real_escape_string($conn, $_POST['DOINSE']);

        // Prepare INSERT query matching form fields
        $query = "INSERT INTO employee (
            id, name, nat, gender, phone, company, 
            Occupation, workplace, DOW, email, salary, 
            DOID, DOIDE, DOIDEH, passport, DOPE, 
            DOB, INSCAM, DOINSE
        ) VALUES (
            '$id', '$name', '$nat', '$gender', '$phone', '$company',
            '$occupation', '$workplace', '$dow', '$email', '$salary',
            '$doid', '$doide', '$doideh', '$passport', '$dope',
            '$dob', '$inscam', '$doinse'
        )";

        // Execute query and handle errors
        if (mysqli_query($conn, $query)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'تم',
                    text: 'تم إضافة الموظف بنجاح',
                    confirmButtonText: 'حسناً'
                }).then(() => {
                    window.location.href = 'employees.php';
                });
            </script>";
            exit();
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ في إضافة الموظف: " . mysqli_error($conn) . "',
                    confirmButtonText: 'حسناً'
                });
            </script>";
        }
    }
}
?>
<div class="nvm" style="margin-bottom: 10px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">

            <ul class="navbar-menu"
                style="display: ruby; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        الموظفين</a>
                    <div style="margin-right: 5px;">
                    
                    </div>
                </li>
            </ul>
        </nav>

    </div>
</div>
<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 mtable">
<div class="container" style="margin: 0%;">    <div class="row justify-content-center">
        <div class="col-lg-11">
            <form method="post" action="" id="employeeForm" novalidate>
                <h4 class="form-section-title text-center mb-4">بيانات الموظف الجديد</h4>
                <div class="col" id="res" style="display: flex; width:100%;">
                    <div class='col-6 empcol'>
                        <h5 class="form-section-title">المعلومات الشخصية</h5>
                        <div class='line-body eminput'> <span>الاسم :</span><input type="text"
                                class="form-control upinput" name="name" required></div>
                        <div class='line-body eminput'> <span>رقم الاقامة :</span><input type="text"
                                class="form-control upinput" name="id"></div>
                        <div class='line-body eminput'> <span>الجنس :</span><input type="text"
                                class="form-control upinput" name="gender" required></div>
                        <div class='line-body eminput'> <span>اسم المنشأة :</span><input type="text"
                                class="form-control upinput" name="company" required></div>
                        <div class='line-body eminput'> <span>المهنة بالتأشيرة :</span><input type="text"
                                class="form-control upinput" name="Occupation" required></div>
                        <div class='line-body eminput'> <span>تاريح الالتحاق :</span><input type="date"
                                class="form-control upinput" name="DOW" required></div>
                        <div class='line-body eminput'> <span>الراتب :</span><input type="text"
                                class="form-control upinput" name="salary" required></div>
                        <div class='line-body eminput'> <span> انتهاء الاقامة ميلادي :</span><input type="date"
                                class="form-control upinput" name="DOIDE" required></div>
                        <div class='line-body eminput'> <span>تأريخ الميلاد :</span><input type="date"
                                class="form-control upinput" name="DOB" required></div>
                        <div class='line-body eminput'> <span>الجنسية :</span><input type="text"
                                class="form-control upinput" name="nat" required></div>
                    </div>                    <div class='col-6 empcol'>
                        <h5 class="form-section-title">معلومات العمل والتواصل</h5>
                        <div class='line-body eminput'> <span>رقم الجوال :</span><input type="text"
                                class="form-control upinput" name="phone" required></div>
                        <div class='line-body eminput'> <span>النشاط الفعلي :</span><input type="text"
                                class="form-control upinput" name="workplace" required></div>
                        <div class='line-body eminput'> <span> البريد الالكتروني :</span><input type="email"
                                class="form-control upinput" name="email" required></div>
                        <div class='line-body eminput'> <span>تاريخ اصدار الاقامة :</span><input type="date"
                                class="form-control upinput" name="DOID" required></div>
                        <div class='line-body eminput'> <span>تاريخ انتهاء الاقامة هجري :</span><input type="date"
                                class="form-control upinput" name="DOIDEH" id="DOIDEH" required></div>
                        <div class='line-body eminput'> <span>رقم الجواز :</span><input type="text"
                                class="form-control upinput" name="passport" required></div>
                        <div class='line-body eminput'> <span>تاريخ انتهاء الجواز :</span><input type="date"
                                class="form-control upinput" name="DOPE" required></div>
                        <div class='line-body eminput'> <span>شركة التأمين :</span><input type="text"
                                class="form-control upinput" name="INSCAM" required></div>
                        <div class='line-body eminput'> <span>تاريخ انتهاء التأمين :</span><input type="date"
                                class="form-control upinput" name="DOINSE" required></div>
                    </div>
                </div>                <div class="msend mb-3 d-flex justify-content-center gap-3">
                    <button style="width: fit-content;" type="submit" name="add" class="send btn-block px-5 mt-4" role="button" id="submitBtn">
                        <i class="fas fa-user-plus me-2"></i> إضافة موظف جديد
                    </button>
                    <button style="width: fit-content;" type="button" class="send btn-secondary btn-block px-5 mt-4"
                        onclick="window.location.href='/company/index.php'">
                        <i class="fas fa-arrow-right me-2"></i> الرجوع للصفحة الرئيسية
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<!-- Add Moment.js for date handling -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script></script>