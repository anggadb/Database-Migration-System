<!DOCTYPE html>
<html lang="id">
<head>
	<title>PROJECT KP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Angga Bachtiar">
	<link rel="stylesheet" href="../bs/flatly.min.css">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<?php
		session_start();
		error_reporting(0);
		if(!isset($_SESSION['nip'])){
			echo "<script> alert('Maaf, anda harus masuk/login untuk dapat mengakses halaman ini');
			window.location.href='../index.php'</script>";
		}
		if($_SESSION['ora_schema'] == ''){
			echo "<script> alert('Silahkan pilih databasenya terlebih dahulu');
			window.location.href='../process/pilih_dbase_ora.php'</script>";	
		}
		if(!isset($_REQUEST['db'])){
			$isdb = false;
		} else {
			$db = $_REQUEST['db'];
			$isdb = true;
		}
		if($_REQUEST['baris'] == ''){
			$isbaris = false;
		} else {
			$baris = $_REQUEST['baris'];
			$isbaris = true;
		}
		$schema = $_SESSION['ora_schema'];
		$ora_pwd = $_SESSION['ora_pwd'];
		$ora_host = $_SESSION['ora_host'];
		$acc_nip = $_SESSION['nip'];
		$m_host = $_SESSION['m_host'];
		$m_user = $_SESSION['m_user'];
		$m_pwd = $_SESSION['m_pwd'];
		$m_db = $_SESSION['m_db'];
		$mysqlcon = new mysqli($m_host, $m_user, $m_pwd, $m_db);
		$sql = "SELECT nama FROM admin WHERE nip = '$acc_nip'";
		$result = $mysqlcon->query($sql);
		$array = $result->fetch_array(MYSQLI_ASSOC);
		$nama_acc = $array['nama'];
		$con = oci_connect($schema,$ora_pwd,$ora_host);
	?>
	<script>
		$(document).ready(function(){
    		$('[data-toggle="popover"]').popover(); 
		});
	</script>
	<div class="container-fluid">
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbargue">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="home_admin.php" class="navbar-brand">SIMBADA</a>
				</div>
				<div class="collapse navbar-collapse" id="navbargue">
					<ul class="nav navbar-nav">
						<li><a href="home_admin.php">Beranda</a></li>
						<li><a href="migration.php">Migrasi</a></li>
						<li class="active"><a href="helper.php">Bantuan</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#" <?php echo 'title="'.$acc_nip.'"'; ?> data-toggle="popover" data-trigger="hover" <?php echo 'data-content="'.$nama_acc.'"';?> data-placement="left"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Akun Saya</a></li>
						<li><a href="../process/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h3 class="text-center" style="margin-top: 75px;color: #446CB3">F.A.Q</h3>
		<div class="panel-group" id="panelgue">
    		<div class="panel panel-default">
      			<div class="panel-heading">
        			<h4 class="panel-title">
          				<a data-toggle="collapse" data-parent="#panelgue" href="#collapse1">Bagaimana cara membuat akun ?</a>
        			</h4>
      			</div>
      			<div id="collapse1" class="panel-collapse collapse in">
        			<div class="panel-body" style="background-color: #F22613; color: #F2F1EF">Silahkan tambahkan data pada <i>database</i> yang terhubung atau hubungi <i>administrator database</i>, pembuatan akun secara dinamis tidak tersedia.</div>
      			</div>
    		</div>
    		<div class="panel panel-default">
      			<div class="panel-heading">
        			<h4 class="panel-title">
          				<a data-toggle="collapse" data-parent="#panelgue" href="#collapse2">Jika saya lupa <i>password</i> akun saya, bagaimana saya membuat <i>password</i> yang baru ?</a>
        			</h4>
      			</div>
      			<div id="collapse2" class="panel-collapse collapse">
        			<div class="panel-body" style="background-color: #F22613; color: #F2F1EF">Silahkan edit data pada <i>database</i> yang terhubung atau hubungi <i>administrator database</i>.</div>
      			</div>
    		</div>
    		<div class="panel panel-default">
      			<div class="panel-heading">
        			<h4 class="panel-title">
          				<a data-toggle="collapse" data-parent="#panelgue" href="#collapse3">Ketika saya memilih fungsi <i>export</i> ke CSV, saya akan otomatis men-<i>download</i>-nya dimana saya akan menaruh <i>file</i> tersebut ?</a>
        			</h4>
      			</div>
      			<div id="collapse3" class="panel-collapse collapse">
        			<div class="panel-body" style="background-color: #F22613; color: #F2F1EF">Silahkan menaruhnya kedalam "xampp\htdocs\mbs_pro\core\import".</div>
        		</div>
    		</div>
    		<div class="panel panel-default">
      			<div class="panel-heading">
        			<h4 class="panel-title">
          				<a data-toggle="collapse" data-parent="#panelgue" href="#collapse4">Saya ingin migrasi, apakah pengetikkan nama <i>file</i>-nya harus sesuai dengan nama <i>file</i> di <i>directory</i> ?</a>
        			</h4>
      			</div>
      			<div id="collapse4" class="panel-collapse collapse">
        			<div class="panel-body" style="background-color: #F22613; color: #F2F1EF">Ya, karena bersifat <i>case sensitive</i>.</div>
    		</div>
    		</div>
    		<div class="panel panel-default">
      			<div class="panel-heading">
        			<h4 class="panel-title">
          				<a data-toggle="collapse" data-parent="#panelgue" href="#collapse5">Saya ingin mengeksplorasi <i>source code</i> pada <i>website</i> ini, tapi ada masalah yang ingin saya tanyakan. Adakah kontak <i>developer</i>-nya yang dapat saya hubungi ?</a>
        			</h4>
      			</div>
      			<div id="collapse5" class="panel-collapse collapse">
        			<div class="panel-body" style="background-color: #F22613; color: #F2F1EF">Line : @anggatiar.</div>
    		</div>
  		</div> 
	 	<nav class="navbar navbar-default navbar-fixed-bottom">
			<p class="text-center" style="color: #E4F1FE;margin-top: 17px;"><span class="glyphicon glyphicon-copyright-mark"></span> Angga Bachtiar, 2017</p>
		</nav>
	 </div>
</body>
</html>