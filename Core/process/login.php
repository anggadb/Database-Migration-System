<?php
	session_start();
	$m_host = $_SESSION['m_host'];
	$m_user = $_SESSION['m_user'];
	$m_pwd = $_SESSION['m_pwd'];
	$m_db = $_SESSION['m_db'];
	$con = new mysqli($m_host, $m_user, $m_pwd, $m_db);
	if($con->connect_error){
		die("Koneksi anda bermasalah : ".$con->connect_error);
	}
	if(!isset($_POST['nip'])){
		echo "<script> alert('Maaf, anda tidak dapat mengakses halaman ini (ACCESS DENIED)'); window.location.href='../index.php'</script>";
	}
	$nip = $_POST['nip'];
	$pass = $_POST['pwd'];
	$sql = "SELECT * FROM admin WHERE nip = '$nip' AND password = '$pass'";
	$query = $con->query($sql);
	if($query->num_rows == 1){
		$_SESSION['nip'] = $nip;
		header("location: ../admin/home_admin.php");
	} else {
		echo "<script>alert('ID atau Kata Kunci Anda Salah'); window.location.href='../index.php'</script>";
	}
?>