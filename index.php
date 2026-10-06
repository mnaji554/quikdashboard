<?php
include("header.php");
include("config.php");

// Get employee statistics
$emp_query = "SELECT 
    COUNT(*) as total_employees,
    SUM(CASE WHEN DATEDIFF(DOIDE, CURDATE()) <= 30 THEN 1 ELSE 0 END) as expiring_iqamas,
    SUM(CASE WHEN DATEDIFF(DOPE, CURDATE()) <= 30 THEN 1 ELSE 0 END) as expiring_passports,
    SUM(CASE WHEN DATEDIFF(DOINSE, CURDATE()) <= 30 THEN 1 ELSE 0 END) as expiring_insurance,
    COUNT(DISTINCT nat) as total_nationalities
    FROM employee";
$emp_result = mysqli_query($conn, $emp_query);
$emp_stats = mysqli_fetch_assoc($emp_result);

// Get nationality distribution
$nat_query = "SELECT nat, COUNT(*) as count FROM employee GROUP BY nat ORDER BY count DESC ";
$nat_result = mysqli_query($conn, $nat_query);
$nationalities = [];
$nat_counts = [];
while ($row = mysqli_fetch_assoc($nat_result)) {
  $nationalities[] = $row['nat'];
  $nat_counts[] = $row['count'];
}

// Get holiday statistics
$holiday_query = "SELECT COUNT(*) as active_holidays, 
    SUM(CASE WHEN type = 'annual' THEN 1 ELSE 0 END) as annual_leaves,
    SUM(CASE WHEN type = 'emergency' THEN 1 ELSE 0 END) as emergency_leaves
    FROM holday WHERE end_date >= CURDATE()";
$holiday_result = mysqli_query($conn, $holiday_query);
$holiday_stats = mysqli_fetch_assoc($holiday_result);

// Get monthly statistics for the past 6 months
$monthly_query = "SELECT DATE_FORMAT(DOW, '%Y-%m') as month, COUNT(*) as new_employees 
    FROM employee 
    WHERE DOW >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) 
    GROUP BY month 
    ORDER BY month DESC";
$monthly_result = mysqli_query($conn, $monthly_query);
$months = [];
$new_employees = [];
while ($row = mysqli_fetch_assoc($monthly_result)) {
  $months[] = $row['month'];
  $new_employees[] = $row['new_employees'];
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Add Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    @media (max-width: 768px) {
      .container-fluid {
        padding: 10px;
      }
      .stat-card .card-title {
        font-size: 1.5rem !important;
      }
      .stat-card .card-text {
        font-size: 0.9rem !important;
      }
      .stat-card small {
        font-size: 0.8rem !important;
      }
      .chart-container {
        height: 250px !important;
      }
      .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
      }
      h3 {
        font-size: 1.5rem;
      }
    }
    
    .stat-card {
      transition: all 0.3s ease;
      cursor: pointer;
      background: white !important;
      border: none !important;
      border-radius: 15px !important;

    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-card .card-body {
      padding: 1.5rem;
      position: relative;
      z-index: 1;
      overflow: hidden;
      width: 95%;
    }

    .stat-card .icon-background {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      font-size: 5rem;
      opacity: 0.1;
      z-index: 0;
    }

    .stat-card .card-title {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
      color: #2c3e50;
    }

    .stat-card .card-text {
      font-size: 1rem;
      color: #7f8c8d;
      margin-bottom: 0.25rem;
    }

    .stat-card small {
      color: #95a5a6;
      font-size: 0.85rem;
    }

    .stat-card .stat-icon {
      margin-bottom: 1rem;
      background: rgba(0, 0, 0, 0.05);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .stat-card.primary-card .stat-icon {
      color: #3498db;
      background: rgba(52, 152, 219, 0.1);
    }

    .stat-card.warning-card .stat-icon {
      color: #f1c40f;
      background: rgba(241, 196, 15, 0.1);
    }

    .stat-card.info-card .stat-icon {
      color: #00cec9;
      background: rgba(0, 206, 201, 0.1);
    }

    .stat-card.danger-card .stat-icon {
      color: #e74c3c;
      background: rgba(231, 76, 60, 0.1);
    }

    .chart-container {
      position: relative;
      margin: auto;
      height: 300px;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="nvm" style="margin-bottom: 20px;">
      <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
          <ul class="navbar-menu"
            style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
            <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
              <span style="font-weight:bold;font-size: 25px;">لوحة التحكم</span>
            </li>
          </ul>
        </nav>
      </div>
    </div>    <!-- Enhanced Statistics Summary -->
    <div class="row g-3 mb-4">
      <div class="col-12 col-6 col-md-3">
        <div class="card stat-card primary-card h-100">
          <div class="card-body text-center">
            <div class="stat-icon">
              <i class="fas fa-users"></i>
            </div>
            <h3 class="card-title"><?php echo $emp_stats['total_employees']; ?></h3>
            <p class="card-text">إجمالي الموظفين</p>
            <small><?php echo $emp_stats['total_nationalities']; ?> جنسيات مختلفة</small>
            <i class="fas fa-users icon-background"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card stat-card warning-card h-100">
          <div class="card-body text-center">
            <div class="stat-icon">
              <i class="fas fa-id-card"></i>
            </div>
            <h3 class="card-title"><?php echo $emp_stats['expiring_iqamas']; ?></h3>
            <p class="card-text">إقامات قاربت على الانتهاء</p>
            <small>خلال 30 يوم</small>
            <i class="fas fa-id-card icon-background"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card stat-card info-card h-100">
          <div class="card-body text-center">
            <div class="stat-icon">
              <i class="fas fa-plane"></i>
            </div>
            <h3 class="card-title"><?php echo $holiday_stats['active_holidays']; ?></h3>
            <p class="card-text">إجازات نشطة</p>
            <small><?php echo $holiday_stats['annual_leaves']; ?> سنوية,
              <?php echo $holiday_stats['emergency_leaves']; ?> طارئة</small>
            <i class="fas fa-plane icon-background"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card stat-card danger-card h-100">
          <div class="card-body text-center">
            <div class="stat-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="card-title"><?php echo $emp_stats['expiring_insurance']; ?></h3>
            <p class="card-text">تأمينات قاربت على الانتهاء</p>
            <small>خلال 30 يوم</small>
            <i class="fas fa-shield-alt icon-background"></i>
          </div>
        </div>
      </div>
    </div>    <!-- Charts Section -->
    <div class="row g-3 mb-4">
      <div class="col-12 col-lg-6">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title text-center mb-3">توزيع الجنسيات</h5>
            <div class="chart-container">
              <canvas id="nationalitiesChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">الموظفون الجدد (آخر 6 أشهر)</h5>
            <div class="chart-container">
              <canvas id="employeeTrendChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>    <!-- Main Menu Cards -->
    <div
      style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px; justify-content: center; margin: 0 auto; max-width: 1400px;">
      <!-- Employees Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-users fa-3x text-primary"></i>
        </div>
        <h3 class="text-center">إدارة الموظفين</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="employee/employees.php" class="btn btn-primary">عرض الموظفين</a>
          <a href="employee/addemployee.php" class="btn btn-success">إضافة موظف</a>
        </div>
      </div>

      <!-- Holidays Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-plane-departure fa-3x text-success"></i>
        </div>
        <h3 class="text-center">إدارة الإجازات</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="holday/holday.php" class="btn btn-primary">عرض الإجازات</a>
          <a href="holday/addholday.php" class="btn btn-success">إضافة إجازة</a>
        </div>
      </div>

      <!-- Documents Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-file-alt fa-3x text-info"></i>
        </div>
        <h3 class="text-center">إدارة الملفات</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="files/files.php" class="btn btn-primary">عرض الملفات</a>
          <a href="files/addfile.php" class="btn btn-success">إضافة ملف</a>
        </div>
      </div>

      <!-- Iqama Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-id-card fa-3x text-warning"></i>
        </div>
        <h3 class="text-center">إدارة الإقامات</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="iqama/iqama.php" class="btn btn-primary">عرض الإقامات</a>
          <a href="iqama/addiqama.php" class="btn btn-success">إضافة إقامة</a>
        </div>
      </div>

      <!-- Maintenance Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-tools fa-3x text-secondary"></i>
        </div>
        <h3 class="text-center">الصيانة</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="mentainance/mentainance.php" class="btn btn-primary">عرض الصيانة</a>
        </div>
      </div>

      <!-- Sales Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-chart-line fa-3x text-success"></i>
        </div>
        <h3 class="text-center">المبيعات</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="sales/sales.php" class="btn btn-primary">عرض المبيعات</a>
        </div>
      </div>

      <!-- Complaints Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-exclamation-circle fa-3x text-danger"></i>
        </div>
        <h3 class="text-center">الشكاوى</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="complaints.php" class="btn btn-primary">عرض الشكاوى</a>
        </div>
      </div>

      <!-- Archive Card -->
      <div class="card"
        style="padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <div class="text-center mb-3">
          <i class="fas fa-archive fa-3x text-dark"></i>
        </div>
        <h3 class="text-center">الأرشيف</h3>
        <div class="d-flex justify-content-around mt-3">
          <a href="archive/archive.php" class="btn btn-primary">عرض الأرشيف</a>
        </div>
      </div>
    </div>

    <!-- Initialize Charts -->
    <script>      // Nationality Distribution Chart
      new Chart(document.getElementById('nationalitiesChart'), {
        type: 'doughnut',
        data: {
          labels: <?php echo json_encode($nationalities); ?>,
          datasets: [{
            data: <?php echo json_encode($nat_counts); ?>,
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: window.innerWidth < 768 ? 'bottom' : 'right',
              labels: {
                boxWidth: window.innerWidth < 768 ? 10 : 40,
                font: {
                  size: window.innerWidth < 768 ? 10 : 12
                }
              }
            }
          }
        }
      });

      // Employee Trend Chart
      new Chart(document.getElementById('employeeTrendChart'), {
        type: 'line',
        data: {
          labels: <?php echo json_encode(array_reverse($months)); ?>,
          datasets: [{
            label: 'موظفون جدد',
            data: <?php echo json_encode(array_reverse($new_employees)); ?>,
            borderColor: '#36A2EB',
            tension: 0.1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1
              }
            }
          }
        }
      });
    </script>
  </div>
</body>

</html>