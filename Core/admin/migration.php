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
	if(!isset($_SESSION['nip'])){
		echo "<script> alert('Maaf, anda harus masuk/login untuk dapat mengakses halaman ini');
		window.location.href='../index.php'</script>";
	}
	$acc_nip = $_SESSION['nip'];
	$schema = $_SESSION['ora_schema'];
	$password = $_SESSION['ora_pwd'];
	$host = $_SESSION['ora_host'];
	$m_host = $_SESSION['m_host'];
	$m_user = $_SESSION['m_user'];
	$m_pwd = $_SESSION['m_pwd'];
	$m_db = $_SESSION['m_db'];
	$con = new mysqli($m_host, $m_user, $m_pwd, $m_db);
	$sql = "SELECT nama FROM admin WHERE nip = '$acc_nip'";
	$result = $con->query($sql);
	$array = $result->fetch_array(MYSQLI_ASSOC);
	$nama_acc = $array['nama'];
	$ora_con = oci_connect($schema,$password,$host);
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
						<li class="active"><a href="migration.php">Migrasi</a></li>
						<li><a href="helper.php">Bantuan</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#" <?php echo 'title="'.$acc_nip.'"'; ?> data-toggle="popover" data-trigger="hover" <?php echo 'data-content="'.$nama_acc.'"';?> data-placement="left"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Akun Saya</a></li>
						<li><a href="../process/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h3 class="text-center" style="margin-top: 20px">MIGRASI KE : </h3>
		<div style="padding: 5px;margin:0 auto;width: 100%;float: 0px;">
		<form class="text-center" action="../import/imp_mysql.php" method="POST" style="margin-top: 5px">
			<div class="form-group">
				<label for="db_1">Pilih salah satu :</label>
				<select class="form-control" id="db_1" name="pilih_db">
					<?php
						$sql2 = oci_parse($ora_con, "SELECT table_name FROM ALL_TABLES WHERE OWNER = '$schema'");
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
			<div id="upload" style="margin-top: 5px;padding: 5px;width: 350px;margin: 0 auto">
                <div class="form-group row">
                    <label class="col-md-6 control-label" for="filebutton">Masukkan Nama File </label>
                        <div class="col-md-4">
                            <input type="text" name="file" id="file" class="input-large" placeholder="Contoh : ind_audit.csv">
                        </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-6">IMPORT</label>
                    	<div class="col-xs-4">
                         	<button type="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Mohon Tunggu...">SUBMIT</button>
                    	</div>
				</div>
			</div>
        </form>
		</div>
		<nav class="navbar navbar-default navbar-fixed-bottom" style="position: fixed;bottom: 0px;width: 100%">
			<p class="text-center" style="color: #E4F1FE;margin-top: 17px;"><span class="glyphicon glyphicon-copyright-mark"></span> Angga Bachtiar, 2017</p>
		</nav>
	</div>
</body>
</html>