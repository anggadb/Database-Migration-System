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
						<li class="active"><a href="home_admin.php">Beranda</a></li>
						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Pilih Fungsi <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php echo '<li><a href="../functions/exp_csv.php?nm_tb='.$db.'">Export ke CSV</a></li>';?>
								<?php echo '<li><a href="../functions/exp_xls.php?nm_tb='.$db.'">Export ke XLS</a></li>';?>
							</ul>
						</li>
						<li><a href="migration.php">Migrasi</a></li>
						</li>
						<li><a href="helper.php">Bantuan</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#" <?php echo 'title="'.$acc_nip.'"'; ?> data-toggle="popover" data-trigger="hover" <?php echo 'data-content="'.$nama_acc.'"';?> data-placement="left"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Akun Saya</a></li>
						<li><a href="../process/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h3 class="text-center" style="margin-top: 70px">SILAHKAN PILIH TABLE DATABASE</h3>
		<form class="text-center" action="../process/pilih_tabel_db.php" method="POST">
			<div class="form-group">
				<label for="db_1">Pilih salah satu :</label>
				<select class="form-control" id="db_1" name="pilih_db">
					<?php
						$sql2 = oci_parse($con, "SELECT table_name FROM ALL_TABLES WHERE OWNER = '$schema'");
						oci_execute($sql2);
						while($row1 = oci_fetch_array($sql2, OCI_ASSOC + OCI_RETURN_NULLS)){
							foreach ($row1 as $tabs) {
								print "<option value=".(htmlentities($tabs, ENT_QUOTES)).">".($tabs !== null ? htmlentities($tabs, ENT_QUOTES) : "&nbsp" )."</option>";
							}
						}
						oci_free_statement($sql2);
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="baris">Tampilkan Jumlah Data</label>
				<input type="number" name="baris" id="baris" <?php if(!$isbaris && !$isdb){echo"placeholder='Isi jumlah baris'";}elseif(!$isbaris){echo"placeholder='Baris ditampilkan default'";}else{echo"placeholder='Ditampilkan ".$baris." baris'";}?>>
			</div>
				<button type="submit" class="btn btn-md" style="margin-top: 5px">PILIH</button>
				<button type="submit" class="btn btn-danger btn-md" formaction="home_admin.php" style="margin-top: 5px">RESET</button>
		</form>
		<p class="text-center" <?php if(!$isdb){echo "hidden";}?> style="margin-top: 5px">DATABASE : <?php echo "<b>".$db."</b>";?></p>
		<table class="table table-bordered" border="1" <?php if(!$isdb){echo "hidden";} ?>>
		<?php
		if($isbaris){
			$sql = oci_parse($con, 'SELECT * FROM '.$db.' WHERE rownum <= '.$baris);
		} else {
			$sql = oci_parse($con, 'SELECT * FROM '.$db);
		}
		oci_execute($sql);
		$jum_kol = oci_num_fields($sql);
    	echo "<tr>\n";
    	for ($i = 1; $i <= $jum_kol; $i++) {
    	$nam_kol  = oci_field_name($sql, $i);
    	echo "<th class='text-center' style='background-color: #6C7A89;color: #F2F1EF'>$nam_kol</th>";}
    	echo "</tr>\n";
		while ($row = oci_fetch_array($sql, OCI_ASSOC+OCI_RETURN_NULLS)){
	 	print "<tr>\n";
	 	foreach ($row as $item) {
	 		print "<td>".($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp")."</td>\n";
	 	}
	 	print "</tr>\n";
	 	}
	 	print "</table>\n";
	 	oci_free_statement($sql);
	 	?>
	 	<nav class="navbar navbar-default navbar-fixed-bottom">
			<p class="text-center" style="color: #E4F1FE;margin-top: 17px;"><span class="glyphicon glyphicon-copyright-mark"></span> Angga Bachtiar, 2017</p>
		</nav>
	 </div>
</body>
</html>