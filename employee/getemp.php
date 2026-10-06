<?php

include("../config.php");
$output = '';
if (isset($_POST["query"])) {

	$search = mysqli_real_escape_string($conn, $_POST["query"]);

	$query = "SELECT *, DATEDIFF(DOIDE,CURDATE()) as expire FROM employee where id LIKE '%" . $search . "%' limit 1";
}
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {

	while ($row = mysqli_fetch_array($result)) {
?>

		<div class='col-6'>
			<div class='line-body'> الإسم : <span class='class'><?php echo $row['name']; ?></span></div>
			<div class='line-body'> الجنس : <?php echo $row['gender']; ?></div>
			<div class='line-body'> اسم المنشأة : <?php echo $row['company']; ?></div>
			<div class='line-body'> المهنة بالتأشيرة : <?php echo $row['Occupation']; ?></div>
			<div class='line-body'> تاريح الالتحاق : <?php echo $row['DOW']; ?></div>
			<div class='line-body'> الراتب الحالي : <?php echo $row['salnow']; ?></div>
			<div class='line-body'> تاريح انتهاء الاقامة ميلادي : <?php echo $row['DOIDE']; ?></div>
			<div class='line-body'> المتبقى على انتهاء الاقامة : <?php echo $row['expire']; ?></div>
			<div class='line-body'> رقم الحدود : <?php echo $row['border']; ?></div>
			<div class='line-body'> تأريخ الميلاد : <?php echo $row['DOB']; ?></div>
			<div class='line-body'> حالةالتأمين : <?php echo $row['INSSTATE']; ?></div>

		</div>
		<div class='col-6'>
			<div class='line-body'> رقم الاقامة : <?php echo $row['id']; ?></div>
			<div class='line-body'> الجنسية : <?php echo $row['nat']; ?></div>
			<div class='line-body'> رقم الجوال : <?php echo $row['phone']; ?></div>
			<div class='line-body'> النشاط الفعلي : <?php echo $row['workplace']; ?></div>
			<div class='line-body'> الراتب بداية الالتحاق : <?php echo $row['Salbe']; ?></div>
			<div class='line-body'> تاريخ اصدار الاقامة : <?php echo $row['DOID']; ?></div>
			<div class='line-body'> تاريخ انتهاء الاقامة هجري : <?php echo $row['DOIDEH']; ?></div>
			<div class='line-body'> رقم الجواز : <?php echo $row['passport']; ?></div>
			<div class='line-body'> تاريخ انتهاء الجواز : <?php echo $row['DOPE']; ?></div>
			<div class='line-body'> اسم شركة التأمين : <?php echo $row['INSCAM']; ?> </div>
			<div class='line-body'> تأريخ انتهاء التأمين : <?php echo $row['DOINSE']; ?></div>
		</div>




	<?php
	}
	?>


<?php


} else {
	echo '<div class="alert alert-danger">لا يوجد اي موظف برقم الاقامة هذا</div>';
}
?>