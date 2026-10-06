<!DOCTYPE html>
<html dir="rtl" lang="ar">
<?php 
// This will check for session and redirect to login if not authenticated
include("init.php"); 
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="<?php echo $css;?>bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo $css;?>navstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet">
    <link href="<?php echo $css;?>style.css" rel="stylesheet">
    <title>لوحة تحكم شركة كويك</title>
    <script src="<?php echo $js;?>bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@panzoom/panzoom/dist/panzoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/js/tom-select.complete.min.js"></script>
    <script src="<?php echo $js;?>AutoLightbox.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <script src="<?php echo $js;?>main.js"></script>
</head>
<body>
  <!-- partial:index.partial.html -->
  <div id="nav-bar">
    <input id="nav-toggle" type="checkbox" />
    <div id="nav-header"><a id="nav-title" href="/company/index.php" target="_blank">Q<i class="fa fa-gas-pump"></i>UIK</a>
      <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
      <hr />
    </div>
    <div id="nav-content">
      <div class="nav-button" id="archive-button"><span>الرئيسية</span><i class="fas fa-archive"></i></div>
   
      <div class="nav-button" id="employees-button"><span>الموظفين</span><i class="fas fa-user"></i></div>
      <div class="nav-button" id="vacations-button"><span>الاجازات</span><i class="fas fa-umbrella-beach"></i></div>
      <div class="nav-button" id="work-button"><span>المباشرات</span><i class="fas fa-user-cog"></i></div>
      <hr />
      <div class="nav-button" id="file-management-button"><span>ادارة الملفات</span><i class="fas fa-file"></i></div>
      <div class="nav-button" id="residency-button"><span>الاقامات</span><i class="fas fa-id-card"></i></div>
      <div class="nav-button" id="insurance-button"><span>التامينات</span><i class="fas fa-id-card"></i></div>
      <div class="nav-button" id="vacation-calculator-button"><span>حاسبة الاجازات</span><i class="fas fa-umbrella-beach"></i></div>
      <div class="nav-button" id="archive-sequence-button"><span>تسلسل الارشيف</span><i class="fas fa-archive"></i></div>
      <hr />
      <div class="nav-button" id="maintenance-button"><span>الصيانة</span><i class="fas fa-tools"></i></div>
      <div class="nav-button" id="lost-items-button"><span>المفقودات</span><i class="fas fa-search"></i></div>
      <div class="nav-button" id="sales-button"><span>المبيعات</span><i class="fas fa-chart-line"></i></div>
      <div class="nav-button" id="company-documents-archive-button"><span>ارشيف وثائق الشركة</span><i class="fas fa-file-alt"></i></div>
      <div class="nav-button" id="customer-service-button"><span>خدمة العملاء</span><i class="fas fa-file-alt"></i></div>
      <div id="nav-content-highlight"></div>
    </div>
    <input id="nav-footer-toggle" type="checkbox" />
    <div id="nav-footer">
      <div id="nav-footer-heading">
        <div id="nav-footer-avatar"><img src="https://gravatar.com/avatar/4474ca42d303761c2901fa819c4f2547" /></div>
        <div id="nav-footer-titlebox">
          <a id="nav-footer-title" href="#" target="_blank">Admin</a>
          <span id="nav-footer-subtitle">المدير</span>
        </div>
        <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
      </div>
      <div id="nav-footer-content">
        <a href="<?php echo '/company/signout.php'; ?>" class="nav-footer-button">
          <i class="fas fa-sign-out-alt"></i>
          <span>تسجيل الخروج</span>
        </a>
      </div>
    </div>
  </div>

      <script>
        $(document).ready(function() {
            $('#archive-button').on('click', function() {
            window.location.href = '/company/index.php';
            });
            $('#employees-button').on('click', function() {
            window.location.href = '/company/employee/employees.php';
            });
            $('#vacations-button').on('click', function() {
            window.location.href = '/company/holday/holday.php';
            });
            $('#work-button').on('click', function() {
            window.location.href = '/company/work/work.php';
            });
            $('#file-management-button').on('click', function() {
            window.location.href = '/company/files/files.php';
            });
            $('#residency-button').on('click', function() {
            window.location.href = '/company/iqama/iqama.php';
            });
            $('#insurance-button').on('click', function() {
            window.location.href = '/company/insurance/insurance.php';
            });
            $('#vacation-calculator-button').on('click', function() {
            window.location.href = '/company/holday/hcounter.php';
            });
            $('#archive-sequence-button').on('click', function() {
            window.location.href = '/company/archive/archive.php';
            });
            $('#maintenance-button').on('click', function() {
            window.location.href = '/company/mentainance/mentainance.php';
            });
            $('#lost-items-button').on('click', function() {
            window.location.href = '/company/losts/losts.php';
            });
            $('#sales-button').on('click', function() {
            window.location.href = '/company/sales/sales.php';
            });
            $('#company-documents-archive-button').on('click', function() {
            window.location.href = '/company/docs/docs.php';
            });
            $('#customer-service-button').on('click', function() {
            window.location.href = '/company/customers/customer.php';
            });
          });
      
 

      </script>

  <div class="page-body" style="padding: 20px; background-color: #f4f4f4; min-height: 100vh;margin-right: 14%;">
