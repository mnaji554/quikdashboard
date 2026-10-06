<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1;">
    <meta charset="utf-8" />
    <link href="../assets/css/fontawesome.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/solid.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <title>لوحة تحكم محطة تركي العامر</title>
    <script src="../assets/js/bootstrap.bundle.js.map"></script>
    <script src="../assets/js/jquery-3.6.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/js/tom-select.complete.min.js"></script>
    <style>
     
        .ts-control {
            height: 28px !important;
            border: none !important;
       
        }
     
        .ts-dropdown {
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
      
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg info-body">
                <div class="mb-3">
                    <label class="pb-2 title" style="font-size:30px;font-weight: bold;">اضافة ملف جديد</label>
                </div>
                <div class="col" id="res" style="display: flex; width:95%;justify-content: center;">
                    <div class='col-6'>
                        <div class='line-body' style="justify-content: center;">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">رقم الموظف</label>
                                    <select class="form-control" id="employee_id" name="employee_id" required>
                                        <option value="">اختر موظف</option>
                                        <?php
                                        include("../config.php");
                                        $query = "SELECT id, name FROM employee";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="filename" class="form-label">اسم الملف</label>
                                    <input type="text" class="form-control" id="filename" name="filename" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fimage" class="form-label">صورة الملف</label>
                                    <input type="file" class="form-control" id="fimage" name="fimage" accept="image/*" required>
                                </div>
                                <button type="submit" name="addfile" class="send btn-primary">إضافة ملف</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
if (isset($_POST['addfile'])) {
    $employee_id = $_POST['employee_id'];
    $filename = $_POST['filename'];
    $fimage = $_FILES['fimage']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($fimage);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['fimage']['tmp_name'], $target_file)) {
        $query = "INSERT INTO empfiles (id, filename, fimage, created_at) VALUES ('$employee_id', '$filename', '$target_file', NOW())";
        mysqli_query($conn, $query);
        echo "File uploaded and data inserted successfully.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<script>
    $(document).ready(function() {
        // Initialize Tom Select for the employee_id select tag
        new TomSelect('#employee_id', {
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: 'اختر موظف',
            allowClear: true
        });
    });
</script>
</body>
</html>