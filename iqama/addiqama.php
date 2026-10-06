<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1;">
  <meta charset="utf-8" />
  <link href="../assets/css/fontawesome.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/editor.dataTables.min.css" rel="stylesheet">
  <link href="../assets/css/jquery-ui.theme.min.css" rel="stylesheet">
  <link href="../assets/css/jquery-ui.min.css" rel="stylesheet">
  <link href="../assets/css/solid.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <title>تعديل الاقامة</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="../assets/js/AutoLightbox.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/js/tom-select.complete.min.js"></script>
  <script src="../assets/js/jquery-ui.min.js"></script>
</head>
<style>

        .ts-control {
            /* height: 28px !important; */
            border: none !important;
            padding: 0 !important;
        }

        .ts-dropdown {
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .panzoom {
            cursor: grab;
        }

        .panzoom:active {
            cursor: grabbing;
        }
    </style>

<body>
  <?php
  include("../config.php");
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
      $id = mysqli_real_escape_string($conn, $_POST['id']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
      $passport = mysqli_real_escape_string($conn, $_POST['passport']);
      $passexpired = mysqli_real_escape_string($conn, $_POST['passexpired']);
      $idexpired = mysqli_real_escape_string($conn, $_POST['idexpired']);
      $sql = "INSERT INTO `employee` (`id`, `name`, `Occupation`, `passport`, `DOPE`, `DOIDE`, `idexpired`) 
    VALUES ('$id','$name' ,'$occupation','$passport','$passexpired','$idexpired')";
      $result = mysqli_query($conn, $sql);
      // // If result matched $myusername and $mypassword, table row must be 1 row
      if ($result) {
        printf("Record inserted successfully.<br />");
        header("Refresh:2; url=iqama.php", true, 303);
      } else {
        printf("Could not insert record into table: %s<br />", mysqli_error($conn));
      }
    }
  }
  ?>
  <div class="col-lg-6 col-sm-12 col-xs-12 col-md-12 card-body">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <div class="text-center">
          <h1 class="card-title">إضافة </h1>
        </div>
      </div>
      <hr />
      <input type="text" class="form-control" name="idp" hidden>
      <div class="inputs mb-2">
        <select class="form-control" id="id" name="id" required>
          <option value="">اختر موظف</option>
          <?php
          $query = "SELECT id, name FROM employee";
          $result = mysqli_query($conn, $query);
          while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['name'] . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="inputs mb-2">
        <label for="name" class="pb-2">الاسم</label>
        <input type="text" class="form-control" required name="name">
      </div>
      <div class="inputs mb-2">
        <label for="name" class="pb-2">المهنة</label>
        <input type="text" class="form-control" required name="occupation">
      </div>
      <div class="inputs mb-2">
        <label for="name" class="pb-2">رقم الجواز</label>
        <input type="text" class="form-control" required name="passport">
      </div>
      <div class="inputs mb-10">
        <label for="traveldate" class="pb-2">تاريخ انتهاء الجواز </label>
        <input type="date" class="form-control" required name="passexpired">
      </div>
      <div class="inputs mb-10">
        <label for="backdate" class="pb-2">تاريخ انتهاء الاقامة</label>
        <input type="date" class="form-control" required name="idexpired">
      </div>
      <div class="msend mb-3">
        <button type="submit" class="send btn-block w-100 mt-4" role="button">
          إرسال
        </button>
      </div>
    </form>
  </div>
  <script>
    var employeeSelect = new TomSelect('#id', {
                create: true,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                placeholder: 'اختر موظف',
                allowClear: true
            });

  </script>
</body>

</html>