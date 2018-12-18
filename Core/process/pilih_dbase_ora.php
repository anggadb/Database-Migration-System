<!DOCTYPE html>
<html>
<head>
	<title>PROJECT KP</title>
</head>
<body>
<?php
session_start();
	$con = new mysqli("localhost","root","","test");
	if($con->connect_error){
		die("Koneksi anda bermasalah : ".$con->connect_error);
	}
	if(!isset($_POST['nip'])){
		echo "<script> alert('AKSES DITOLAK'); window.location.href='../index.php'</script>";
	}
	$nip = $_POST['nip'];
	$pass = $_POST['pwd'];
	$sql = "SELECT * FROM admin WHERE nip = '$nip' AND password = '$pass'";
	$query = $con->query($sql);
	if($query->num_rows == 1){
		$_SESSION['nip'] = $nip;
		echo "<form action='proses_home_admin.php?access=true' method='POST'>";
		echo "<table>";
		echo "<tr>";
		echo "<label for='schm'>Masukkan Schema/Nama Pengguna Oracle</label>";
		echo "<input type='text' id='host' placeholder='SCHEMA' name='schm'>";
		echo "&nbsp;<label for='pwd'>Masukkan Password Oracle</label>";
		echo "<input type='password' id='pwd' placeholder='PASSWORD' name='pwd'>";
		echo "&nbsp;<label for='hst'>Masukkan Host Oracle Pada Server</label>";
		echo "<input type='text' id='hst' placeholder='contoh : //localhost/XE' name='host'>";
		echo "<br>";
		echo "<label for='mysql_host'>Masukkan Host MYSQL Pada Server</label>";
		echo "<input type='text' id='mysql_host' placeholder='contoh : localhost' name='m_host'>";
		echo "&nbsp;<label for='mysql_username'>Masukkan Username MYSQL</label>";
		echo "<input type='text' id='mysql_username' placeholder='contoh : root' name='m_user'>";
		echo "&nbsp;<label for='mysql_pwd'>Masukkan Password MYSQL</label>";
		echo "<input type='text' id='hst' placeholder='Password' name='m_pwd'>";
		echo "<br>";
		echo "<label for='mysql_db'>Masukkan Database MYSQL</label>";
		echo "<input type='text' id='mysql_db' placeholder='Nama Database' name='m_db'>";
		echo "<br>";
		echo "<button type='submit'>SUBMIT</button>";
	} else {
		echo "<script>alert('ID atau Kata Kunci Anda Salah'); window.location.href='../index.php'</script>";
	}
?>
</body>
</html>