<?php include('koneksi.php');
  session_start();
  $_SESSION["voting"] = true;
?>
<!DOCTYPE html>
<html>
<head>
	<title>PEMIRA 2021</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<style type="text/css">
		html,body{height: 100%;}
		.bg{
			background-image: url('upn.png');
			background-size: cover;
			background-position: center;
			text-align: center;
			height: 100%;
	         width: 100%;
	         display: table;
	         vertical-align: middle;
	         margin-top: -110px; 
		}
         .konten{
         display: table-cell;
         vertical-align: middle;
         }
	</style>
</head>
<body>
	<!-- navbar -->
	<nav class="navbar navbar-light bg-transparant">
  <div class="container-fluid m-2">
  	
    <a id="judul" class="navbar-brand ml-auto fs-3 fw-bolder">PEMIRA 2K21</a>
    
    	<img src="logo.png" width="80px">
    
  </div>
</nav>
<div class="bg">
	<div class="konten">
			<h1 class="fw-bold">Jangan Lupa !</h1>
			<h2 class="fw-bold">Pilih Presiden dan Wakil Presiden BEM FASILKOM 2021</h2><br>
			<a href="user/login.php" class="btn btn-warning btn-lg fs-4" tabindex="-1" role="button" aria-disabled="true">Login Mahasiswa</a>
	<a href="login_admin.php" class="btn btn-secondary btn-lg fs-4" tabindex="-1" role="button" aria-disabled="true">Login Admin</a>
	</div>
</div>

</body>
</html>