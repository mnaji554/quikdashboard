<?php include("../header.php");
 ?>
<style>
  .title {
    text-align: center;
    display: block;
    width: 100%;
  }

  .ts-control {
    /* height: 28px !important; */
    border: none !important;
    padding: 0 !important;
  }

  .ts-dropdown {
    border: 1px solid #ced4da;
    border-radius: 4px;
  }
</style>
<?php
include("../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['id']) && isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['reason'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $sql = "INSERT INTO `holday` (`id`, `start_date`, `end_date`, `reason`) VALUES ('$id','$start_date','$end_date','$reason')";
    $result = mysqli_query($conn, $sql);
    // // If result matched $myusername and $mypassword, table row must be 1 row
    if ($result){ 
      // header("Refresh:2; url=holday.php", true, 303);?>
    
      <script>
        Swal.fire({
          icon: 'success',
          title: 'تم اضافة بيانات الاجازة بنجاح',
          text: 'سيتم تحويلك الى صفحة الاجازات',
          confirmButtonText: 'حسناً'
        }) .then(() => {
        window.location.href = 'holday.php';
    });
        </script>
      <?php
    
    } else{ ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'خطأ',
          text: 'عذراً، حدث خطأ أثناء تحميل الملف.',
          confirmButtonText: 'حسناً'
        });
      </script><?php
      printf("Could not insert record into table: %s<br />", mysqli_error($conn));
    }
  }
}
?>
<div class="col-lg-6 col-sm-12 col-xs-12 col-md-12 card-body">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <div class="text-center">
        <h1 class="card-title">إضافة إجازة </h1>
      </div>
    </div>
    <hr />
    <input type="text" class="form-control" name="idp" hidden>
    <div class="inputs mb-2">
      <label for="id" class="pb-2"> رقم الاقامة</label>
      <select id="id" name="id" class="form-control" required>
        <option value="">اختر موظف</option>
        <?php
        $query = "SELECT id, name FROM employee";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['name'] . "</option>";
        }
        ?>
      </select>
    </div>
    <div class="inputs mb-10">
      <label for="start_date" class="pb-2">تاريخ السفر </label>
      <input type="date" class="form-control" required name="start_date">
    </div>
    <div class="inputs mb-10">
      <label for="end_date" class="pb-2">تاريخ العودة</label>
      <input type="date" class="form-control" required name="end_date">
    </div>
    <div class="inputs mb-2">
      <label for="reason" class="pb-2">سبب الاجازة</label>
      <input type="text" class="form-control" required name="reason">
    </div>
    <div class="msend mb-3">
      <button type="submit" class="send btn-block w-100 mt-4" role="button">
        إرسال
      </button>
    </div>
  </form>
</div>
<script>
  new TomSelect("#id", {
    create: false,
    sortField: {
      field: "text",
      direction: "asc"
    },
    placeholder: "اختر موظف"
  });
</script>
</body>

</html>