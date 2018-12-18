<?php
    session_start();
//     ini_set('display_errors',1);
// error_reporting(E_ALL);
    if($_REQUEST['access'] == '' &&	 $_POST['schm'] == '' && $_POST['m_user'] == ''){
    	echo "<script> alert('AKSES DITOLAK');
			window.location.href='../index.php'</script>";
    }
	$schema = $_POST['schm'];
	$ora_pwd = $_POST['pwd'];
	$host = $_POST['host'];
	$test = $_REQUEST['access'];
	$m_host = $_POST['m_host'];
	$m_user = $_POST['m_user'];
	$m_pwd = $_POST['m_pwd'];
	$m_db = $_POST['m_db'];
	$con = oci_connect($schema, $ora_pwd, $host);
	$con2 = new mysqli($m_host,$m_user,$m_pwd,$m_db); 
	if($con){
		if(!$con2){
			echo "<script>alert('".$con2->connect_error."'); window.location.href='pilih_dbase_ora.php'</script>";
		} else {
			$_SESSION['ora_schema'] = $schema;
			$_SESSION['ora_pwd'] = $ora_pwd;
			$_SESSION['ora_host'] = $host;
			$_SESSION['m_host'] = $m_host;
			$_SESSION['m_user'] = $m_user;
			$_SESSION['m_pwd'] = $m_pwd;
			$_SESSION['m_db'] = $m_db;
			header("location: ../admin/home_admin.php");	
		}
	} else {
		echo "<script>alert('Database oracle anda tidak terdaftar'); window.location.href='pilih_dbase_ora.php'</script>";
	}
?>