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
<?php
include("../config.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT *, DATEDIFF(DOIDE,CURDATE()) as expire, 
        CASE 
            WHEN DOINSE IS NULL OR DOINSE = '' THEN 'غير مؤمن'
            WHEN STR_TO_DATE(DOINSE, '%Y-%m-%d') < CURDATE() THEN 'انتهى التأمين'
            ELSE 'مؤمن'
        END AS INSSTATE 
        FROM employee WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg info-body">
                    <div class="mb-3">
                        <label class="pb-2 title" style="font-size:30px;font-weight: bold;">بيانات الموظف</label>
                    </div>
                    <div class="col" id="res" style="display: flex; width:94%;">
                        <div class='col-6 empcol'>
                            <div class='line-body eminput'> الإسم : <?php echo $row['name']; ?></div>
                            <div class='line-body eminput'> الجنس : <?php echo $row['gender']; ?></div>
                            <div class='line-body eminput'> اسم المنشأة : <?php echo $row['company']; ?></div>
                            <div class='line-body eminput'> المهنة بالتأشيرة : <?php echo $row['Occupation']; ?></div>
                            <div class='line-body eminput'> تاريح الالتحاق : <?php echo $row['DOW']; ?></div>
                            <div class='line-body eminput'> الراتب : <?php echo $row['salary']; ?></div>
                            <div class='line-body eminput'> تاريح انتهاء الاقامة ميلادي : <?php echo $row['DOIDE']; ?></div>
                            <div class='line-body eminput'> المتبقى على انتهاء الاقامة : <?php echo $row['expire']; ?></div>
                            <div class='line-body eminput'> تأريخ الميلاد : <?php echo $row['DOB']; ?></div>
                            <div class='line-body eminput'> حالةالتأمين : <?php echo $row['INSSTATE']; ?></div>
                            <div class='line-body eminput'> تأريخ انتهاء التأمين : <?php echo $row['DOINSE']; ?></div>
                        </div>
                        <div class='col-6 empcol'>
                            <div class='line-body eminput'> رقم الاقامة : <?php echo $row['id']; ?></div>
                            <div class='line-body eminput'> الجنسية : <?php echo $row['nat']; ?></div>
                            <div class='line-body eminput'> رقم الجوال : <?php echo $row['phone']; ?></div>
                            <div class='line-body eminput'> النشاط الفعلي : <?php echo $row['workplace']; ?></div>
                            <div class='line-body eminput'> البريد الالكتروني : <?php echo $row['email']; ?></div>
                            <div class='line-body eminput'> تاريخ اصدار الاقامة : <?php echo $row['DOID']; ?></div>
                            <div class='line-body eminput'> تاريخ انتهاء الاقامة هجري : <?php echo $row['DOIDEH']; ?></div>
                            <div class='line-body eminput'> رقم الجواز : <?php echo $row['passport']; ?></div>
                            <div class='line-body eminput'> تاريخ انتهاء الجواز : <?php echo $row['DOPE']; ?></div>
                            <div class='line-body eminput'> اسم شركة التأمين : <?php echo $row['INSCAM']; ?> </div>

                        </div>
                    </div>
                    <div class="msend mb-3">
                        <button type="submit" id="search" class="send btn-block w-100 mt-4" role="button"
                            onclick="window.location.href='updemployed.php?id=<?php echo $row['id']; ?>'">
                            تعديل البيانات
                        </button>
                        <button type="button" class="send btn-secondary btn-block w-100 mt-2"
                            onclick="window.location.href='epmloyees.php'">
                            الرجوع للصفحة الرئيسية
                        </button>
                    </div>
                    <?php
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
                                $query = "UPDATE empfiles SET id='$update_employee_id', filename='$update_filename', fimage='$target_file' WHERE id='$update_id'";
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
                            $query = "UPDATE empfiles SET id='$update_employee_id', filename='$update_filename' WHERE id='$update_id'";
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
                    ?>
                    <div class="container" style="margin-right: 0;">
                        <div class="row" style="margin-left:calc(-6.5 * var(--bs-gutter-x));width: inherit;">
                            <div class="col-lg info-body">
                                <div class="col" id="res" style="display: flex; flex-wrap: wrap; width:94%;">
                                    <?php
                                    $query = "SELECT * FROM empfiles where id = $id";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($result->num_rows == 0) {
                                            echo "<div class='card-body' style='width: 23%; margin: 5px; background-color: #FFA500; position: relative;'>";
                                            echo "<div class='line-body1'>";
                                            echo "<span> لا يوجد ملفات لهذا الموظف </span>";
                                            echo "</div>";
                                            echo "</div>";
                                        } else {
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
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Update Modal -->
            <div class="modal fade" id="updateFileModal" tabindex="-1" aria-labelledby="updateFileModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateFileModalLabel">تحديث ملف</h5>
                            <button type="button" style="position: absolute;left: 15px;" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <input type="text" class="form-control" id="update_filename" name="update_filename"
                                        required>
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
                            <button type="button" class="btn-close" style="position: absolute;left: 15px;"
                                data-bs-dismiss="modal" aria-label="Close"></button>
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
        <?php }
} ?>
    <script>
        $(document).ready(function () {
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
                var imageUrl = $(this).data('image');
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
                url: '../files/get_empfile.php',
                type: 'GET',
                data: { id: id },
                success: function (response) {
                    var data = JSON.parse(response);
                    $('#update_id').val(data.id);
                    $('#update_employee_id')[0].tomselect.setValue(data.id);
                    $('#update_filename').val(data.filename);
                    $('#updateFileModal').modal('show');
                }
            });
        }
    </script>
    </body>

    </html>