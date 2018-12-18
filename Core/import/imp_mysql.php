<?php
session_start();
$schema = $_SESSION['ora_schema'];
$password = $_SESSION['ora_pwd'];
$host = $_SESSION['ora_host'];
$m_host = $_SESSION['m_host'];
$m_user = $_SESSION['m_user'];
$m_pwd = $_SESSION['m_pwd'];
$m_db = $_SESSION['m_db'];
if($_POST['pilih_db'] == null || $_POST['file'] == null){
	echo "<script>alert('Anda belum memilih database atau belum memilih file'); window.location.href='../admin/migration.php'</script>";
} else {
	$db = $_POST['pilih_db'];
	$file = $_POST['file'];
	$con = oci_connect($schema,$password,$host);
	$cons= mysqli_connect($m_host, $m_user, $m_pwd, $m_db) or die (mysql_error());
	$sql = oci_parse($con, "SELECT * FROM $db");
	$exe = oci_execute($sql);
	$jmkl = oci_num_fields($sql);
	for ($i=1; $i < $jmkl; $i++) { 
		$nmkl[$i] = oci_field_name($sql, $i);
		$tpkl[$i] = oci_field_type($sql, $i);
		$pjgkl[$i] = oci_field_size($sql, $i);
	}
	$con_mysql = new mysqli("localhost","root","","test");
	$sql_tbl = "CREATE TABLE IF NOT EXISTS $db (";
  	for ($i = 1 ; $i < $jmkl; $i++) {
    	$sql_tbl .= "$nmkl[$i] $tpkl[$i]";
    	$sql_tbl.= "($pjgkl[$i])";
    	if(($i+1) != $jmkl){ 
    		$sql_tbl.=", "; }}
	$sql_tbl .= ")";
	$new_sql = str_replace("VARCHAR2","VARCHAR",$sql_tbl);
	$new_new_sql = str_replace(" NUMBER"," INT",$new_sql);
	$string = preg_replace('/ DATE.{3}/', ' VARCHAR(250)', $new_new_sql);
	$query = $con_mysql->query($string);
	// print($string);
	$result = mysqli_query($cons, 'LOAD DATA LOCAL INFILE "'.$file.'" INTO TABLE '.$db.' FIELDS TERMINATED by \',\' OPTIONALLY ENCLOSED BY \'"\' LINES TERMINATED BY \'\n\' IGNORE 1 LINES') or die (mysql_error());
	if($result){
		echo "<script>alert('Data berhasil di import'); window.location.href='../admin/migration.php'</script>";
	} else {
		echo "<script>alert('Data gagal di import'); window.location.href='../admin/migration.php'</script>";
	}}
?>