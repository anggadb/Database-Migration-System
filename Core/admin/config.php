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
			if(!isset($_SESSION['nip'])){
				echo "<script> alert('Maaf, anda harus masuk/login untuk dapat mengakses halaman ini');
				window.location.href='../index.php'</script>";
			}
			$nip = $_SESSION['nip'];
			$conn = new mysqli("localhost","root","","test");
			$query = "SELECT * FROM admin WHERE nip = '$nip'";
			$sql = $conn->query($query);
			$result = $sql->fetch_array(MYSQLI_ASSOC);
			if($result['foto'] == ''){
				$isfoto = false;
			} else {
				$isfoto = true;
			}
		?>
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
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Pilih Fungsi <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="../process/exp_csv.php?exp=">Export ke CSV</a></li>
									<li><a href="#">Export ke XLXS</a></li>
								</ul>
							</li>
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Migrasi <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="migration.php">Load Data ke Oracle</a></li>
									<li><a href="#">Load Data ke MySQL</a></li>
								</ul>
							</li>
							<li><a href="#">Bantuan</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="config.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Akun Saya</a></li>
							<li><a href="../process/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<table style="margin-top: 75px">
				<thead>
					<tr>
						<th><?php if($isfoto){ echo '<img src="../img/user.png" class="img-circle" width="70px" height="70px" style="border:2px solid black">';}?></th>
						<th><?php echo "&nbsp;".$result['nama'].""; ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><button type="submit">UPLOAD FOTO</button></td>
						<td></td>
						<td hidden>TEST</td>
					</tr>
					<tr>
						<td>Password : </td>
						<td><?php echo "&nbsp;".$result['password'].""; ?></td>
						<td><?php echo "<button type='submit'>Ganti</button>" ?></td>
					</tr>
				</tbody>
			</table>
			<nav class="navbar navbar-default navbar-fixed-bottom" style="position: fixed;bottom: 0px;width: 100%">
				<p class="text-center" style="color: #E4F1FE;margin-top: 17px;"><span class="glyphicon glyphicon-copyright-mark"></span> Angga Bachtiar, 2017</p>
			</nav>	
		</div>
	</body>
</html>