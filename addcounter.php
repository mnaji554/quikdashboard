<!DOCTYPE html>

<html >

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1;">
  <meta charset="utf-8" />
  <link href="./assets/css/fontawesome.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>




  <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/css/editor.dataTables.min.css" rel="stylesheet">
  <link href="./assets/css/jquery-ui.theme.min.css" rel="stylesheet">
  <link href="./assets/css/jquery-ui.min.css" rel="stylesheet">

  <link href="./assets/css/solid.css" rel="stylesheet">
  <link href="./assets/css/style.css" rel="stylesheet">

  <title>الاضافة</title>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="./assets/js/AutoLightbox.js"></script>

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

  <script src="./assets/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/main.js"></script>
  <script src="./assets/js/jquery-ui.min.js"></script>



</head>

<body>
  <?php
  include("./config.php");
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if( isset($_POST['idnum']) && isset($_POST['name']) && isset($_POST['workstart']) ){
    $idnum = mysqli_real_escape_string($conn, $_POST['idnum']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $workstart = mysqli_real_escape_string($conn, $_POST['workstart']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    // $link = mysqli_real_escape_string($conn,$_GET['link']); 
    $sql = "INSERT INTO `hcounter` (`id`, `idnum`, `name`, `workstart`, `notes`) VALUES (NULL,'$idnum' ,'$name' ,'$workstart', '$note')";
    $result = mysqli_query($conn,$sql);
  



    // // If result matched $myusername and $mypassword, table row must be 1 row
  
    if($result) {
  
     

      printf("Record inserted successfully.<br />");
      header( "Refresh:2; url=hcounter.php", true, 303);

 
    }else {
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

      <input type="text" class="form-control"   name="idp" hidden>
      <div class="inputs mb-2">
        <label for="sitename" class="pb-2"> رقم الاقامة</label>
        <input type="text" class="form-control" required name="idnum" >
      </div>
      <div class="inputs mb-2">
        <label for="name" class="pb-2">الاسم</label>
        <input type="text" class="form-control" required  name="name" >
      </div>
      <div class="inputs mb-10">
        <label for="workstart" class="pb-2">بداية العمل</label>
        <input type="date" class="form-control" required name="workstart" >
      </div>
      <div class="inputs mb-2">
        <label for="note" class="pb-2">ملاحظات</label>
        <input type="text" class="form-control" required  name="note" >
      </div>








      <div class="msend mb-3">
        <button type="submit" class="send btn-block w-100 mt-4" role="button">
          إرسال
        </button>
      </div>
    </form>
  </div>
</body>

</html>