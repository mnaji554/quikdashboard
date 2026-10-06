<?php include("../header.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
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

    .panzoom {
        cursor: grab;
    }

    .panzoom:active {
        cursor: grabbing;
    }
</style>
<div class="nvm" style="margin-bottom: 20px;margin-left: 0%;">
    <div class="card"
        style="padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
        <nav class="navbar">
            <ul class="navbar-menu"
                style="display: flex; list-style: none; padding: 0; margin: 0; justify-content: flex-start;">
                <li class="navbar-item" style="margin-right: 20px;margin-left: 20px;margin-top: 10px;">
                    <a href="employees.php" style="all: unset; cursor: pointer;font-weight:bold;font-size: 25px;">
                        الملفات</a>
                </li>
                <li class="navbar-item" style="margin-right: 30px;margin-left: 20px;margin-top: 15px;">
                    <a id="openModal" style="all: unset; cursor: pointer;"><i class="fas fa-user-plus"></i>
                        اضافة ملف</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFileModalLabel">إضافة ملف جديد</h5>
                <button type="button" style="position: absolute;left: 15px;" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fileForm" method="post" action="" enctype="multipart/form-data">
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
                    <button type="submit" name="addfile" style="width: -webkit-fill-available;"
                        class="send btn-primary">إضافة ملف</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateFileModal" tabindex="-1" aria-labelledby="updateFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateFileModalLabel">تحديث ملف</h5>
                <button type="button" style="position: absolute;left: 15px;" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateFileForm" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" id="update_id" name="update_id">
                    <div class="mb-3">
                        <label for="update_employee_id" class="form-label">رقم الموظف</label>
                        <select class="form-control" id="update_employee_id" name="update_employee_id" required>
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
                    <div class="mb-3">
                        <label for="update_filename" class="form-label">اسم الملف</label>
                        <input type="text" class="form-control" id="update_filename" name="update_filename" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_fimage" class="form-label">صورة الملف</label>
                        <input type="file" class="form-control" id="update_fimage" name="update_fimage"
                            accept="image/*">
                    </div>
                    <button type="submit" name="updatefile" class="send btn-primary">تحديث ملف</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                <button type="button" class="btn-close" style="position: absolute;left: 15px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="panzoom-container">
                    <img id="modalImage" src="" alt="صورة الملف" class="img-fluid panzoom">
                </div>
                <div class="mt-3">
                    <button id="zoomIn" class="btn btn-primary"><i class="fas fa-search-plus"></i></button>
                    <button id="zoomOut" class="btn btn-primary"><i class="fas fa-search-minus"></i></button>
                    <button id="rotateLeft" class="btn btn-primary"><i class="fas fa-undo"></i></button>
                    <button id="rotateRight" class="btn btn-primary"><i class="fas fa-redo"></i></button>
                    <a id="downloadImage" class="btn btn-primary" download><i class="fas fa-download"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div >
    <div class="row">
        <div class="col-lg info-body" style="margin-top: 0% !important; margin: 10px !important;">
            <div class="col" id="res" style="display: flex; flex-wrap: wrap; width:94%; justify-content: center;">
                <?php
                if (isset($_POST['addfile'])) {
                    $employee_id = $_POST['employee_id'];
                    $filename = $_POST['filename'];
                    $fimage = $_FILES['fimage']['name'];
                    $target_dir = "uploads/";
                    $target_file = "../".$target_dir . basename($fimage);

                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES['fimage']['tmp_name'], $target_file)) {
                        $query = "INSERT INTO empfiles (id, filename, fimage, created_at) VALUES ('$employee_id', '$filename', '$target_file', NOW())";
                        mysqli_query($conn, $query); ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'تم اضافة ملف جديد',
                                text: 'تم تحميل الملف وإدخال البيانات بنجاح.',
                                confirmButtonText: 'حسناً'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('fileForm').reset();
                                    window.location.href = window.location.href;
                                }
                            });
                        </script>; <?php
                    } else { ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ',
                                text: 'عذراً، حدث خطأ أثناء تحميل الملف.',
                                confirmButtonText: 'حسناً'
                            });
                        </script> <?php
                    }
                }

                if (isset($_POST['updatefile'])) {
                    $update_id = $_POST['update_id'];
                    $update_employee_id = $_POST['update_employee_id'];
                    $update_filename = $_POST['update_filename'];
                    $update_fimage = $_FILES['update_fimage']['name'];
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($update_fimage);

                    if ($update_fimage) {
                        // Move the uploaded file to the target directory
                        if (move_uploaded_file($_FILES['update_fimage']['tmp_name'], $target_file)) {
                            $query = "UPDATE empfiles SET id='$update_employee_id', filename='$update_filename', fimage='$target_file' WHERE idm='$update_id'";
                        } else {
                            echo "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطأ',
                                        text: 'عذراً، حدث خطأ أثناء تحميل الملف.',
                                        confirmButtonText: 'حسناً'
                                    });
                                </script>";
                            exit;
                        }
                    } else {
                        $query = "UPDATE empfiles SET id='$update_employee_id', filename='$update_filename' WHERE idm='$update_id'";
                    }

                    mysqli_query($conn, $query);
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'تم تحديث الملف',
                                text: 'تم تحديث الملف بنجاح.',
                                confirmButtonText: 'حسناً'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = window.location.href;
                                }
                            });
                        </script>";
                }

                // Fetch data from empfiles table
                $query = "SELECT * FROM empfiles";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='card' style='width: 18rem; margin: 10px;height: fit-content;'>";
                    ?>
                    <a href="javascript:void(0);" onclick="openUpdateModal(<?php echo $row['id']; ?>)"
                        style="position: absolute; top: 10px; left: 10px; color: #000;">
                        <i class="fas fa-edit"></i></a>

                    </a>
                    <a href="anotherpage1.php?id=<?php echo $row['id']; ?>"
                        style="position: absolute; top: 40px; left: 10px; color: #000;">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="javascript:void(0);" class="showimage" data-image="<?php echo $row['fimage']; ?>"
                        data-filename="<?php echo basename($row['fimage']); ?>"
                        style="position: absolute; top: 65px; left: 10px; color: #000;">
                        <i class="fas fa-eye"></i>
                    </a>
                    <?php
                    echo "<img src='" . $row['fimage'] . "' class='card-img-top' alt='" . $row['filename'] . "' style='height: 250px;width:auto;'>";
                    echo "<div class='card-body' style='width: 95%;margin-bottom: 10px;'>";
                    echo "<h5 class='card-title'>" . $row['filename'] . "</h5>";
                    echo "<p class='card-text'>رقم الموظف: " . $row['id'] . "</p>";
                    echo "<p class='card-text'>تاريخ الإنشاء: " . $row['created_at'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#openModal').on('click', function () {
            var myModal = new bootstrap.Modal(document.getElementById('addFileModal'), {
                keyboard: false
            });
            myModal.show();
        });

        // Initialize Tom Select for the employee_id select tag
        var employeeSelect = new TomSelect('#employee_id', {
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: 'اختر موظف',
            allowClear: true
        });

        // Initialize Tom Select for the update_employee_id select tag
        var updateEmployeeSelect = new TomSelect('#update_employee_id', {
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: 'اختر موظف',
            allowClear: true
        });

        // Show image in modal
        $('.showimage').on('click', function () {
            var imageUrl =  $(this).data('image');
            var imageFilename = $(this).data('filename');
            $('#modalImage').attr('src', imageUrl);
            $('#downloadImage').attr('href', imageUrl).attr('download', imageFilename);
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {
                keyboard: false
            });
            imageModal.show();
        });

        // Initialize Panzoom for the image
        const panzoom = Panzoom(document.querySelector('#modalImage'), {
            maxScale: 5,
            contain: 'outside'
        });

        // Zoom in button
        document.getElementById('zoomIn').addEventListener('click', panzoom.zoomIn);

        // Zoom out button
        document.getElementById('zoomOut').addEventListener('click', panzoom.zoomOut);

        // Rotate left button
        document.getElementById('rotateLeft').addEventListener('click', function () {
            const img = document.getElementById('modalImage');
            const currentRotation = img.style.transform.match(/rotate\((\d+)deg\)/);
            const newRotation = currentRotation ? parseInt(currentRotation[1]) - 90 : -90;
            img.style.transform = `rotate(${newRotation}deg)`;
        });

        // Rotate right button
        document.getElementById('rotateRight').addEventListener('click', function () {
            const img = document.getElementById('modalImage');
            const currentRotation = img.style.transform.match(/rotate\((\d+)deg\)/);
            const newRotation = currentRotation ? parseInt(currentRotation[1]) + 90 : 90;
            img.style.transform = `rotate(${newRotation}deg)`;
        });
    });

    function openUpdateModal(id) {
        $.ajax({
            url: 'get_empfile.php',
            type: 'GET',
            data: { id: id },
            success: function (response) {
                var data = JSON.parse(response);
                $('#update_id').val(data.idm);
                $('#update_employee_id')[0].tomselect.setValue(data.id);
                $('#update_filename').val(data.filename);
                $('#updateFileModal').modal('show');
            }
        });
    }
</script>
</body>

</html>