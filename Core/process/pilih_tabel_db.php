<?php
	session_start();
	if($_POST['pilih_db'] == ''){
		echo "<script> alert('Silahkan pilih database yang ingin di export');
			window.location.href='../admin/home_admin.php'</script>";
	} else {
	$db_pilih = $_POST['pilih_db'];
	$row = $_POST['baris'];
	if($row == ''){
		header("location: ../admin/home_admin.php?db=".$db_pilih);	
	} else {
		header("location: ../admin/home_admin.php?db=".$db_pilih."&baris=".$row);}}
?>