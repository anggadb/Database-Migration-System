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
<body background="img/line-police.png">
		<div class="container">
		<div id="login_home" style="border: 2px solid black;background-color: #34495e;color: #E4F1FE;width: 300px;height: 200px;margin:0 auto; margin-top: 260px;line-height: -10px">
			<form action="process/pilih_dbase_ora.php" class="form-horizontal" method="POST">
				<div class="form-group" style="margin:0 auto;width: 200px">
					<div class="text-center">
						<label for="nip">Masukkan NIP Anda</label>
						<input type="text" name="nip" class="form-control input-sm" id="nip" placeholder="NIP">
					</div>
				</div>
				<div class="form-group" style="margin:0 auto;width: 200px;line-height: -5px;">
					<div class="text-center">
						<label for="password">Masukkan Kata Kunci Anda</label>
						<input type="password" name="pwd" class="form-control input-sm" id="password" placeholder="Kata Kunci">
					</div>
				</div>
				<div class="text-center" style="margin-top: 3px">
					<button type="submit" class="btn btn-default btn-sm">MASUK</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>