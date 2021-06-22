<?php 
include('koneksi.php');
session_start();



 ?>
<html lang="en">
<head>
    <title>Login Pemira FASILKOM 2021</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/9a065f2d64.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
</head>
<body class="text-center">
    <div class="col-sm-12">

    <a href="../index.php" id="kembali" class="nav-link col-sm-2 fs-5 fw-bold" style="text-decoration: none;"><i class="fas fa-chevron-left"></i> Kembali</a>
    <form class="form-signin" method="post">
        

        <img class="mb-4" src="logo.png" alt="" width="150" height="150">
        <h1 class="h3 mb-3 font-weight-normal">LOGIN MAHASISWA</h1>
        <label for="npm mb-2" class="sr-only">Masukkan NPM</label>
        <input type="number" id="npm" name="npm" class="form-control mb-3" placeholder="NPM" required autofocus>
        <label for="password" class="sr-only ">Masukkan Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
        <?php 
            if (isset($_POST["submit"])) {

    $npm =  mysqli_real_escape_string($koneksi, $_POST["npm"]);
    $password =  mysqli_real_escape_string($koneksi, $_POST["password"]);
    $result = mysqli_query($koneksi,"SELECT * FROM akun WHERE npm = '$npm'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            //set session
            $_SESSION["login"] = $row['npm'];
            $_SESSION["masuk"] = true;
            // membuat histori login
            $query = mysqli_query($koneksi,"SELECT * FROM akun WHERE npm = $npm ");
            $data = mysqli_fetch_assoc($query);
            
            $nama = $data['nama'];
            $jurusan = $data['jurusan'];
            
            date_default_timezone_set('Asia/Jakarta');
            $jam = date("h:i:sa");
            $tanggal1= mktime(date("m"),date("d"),date("Y"));
            $tanggal = date("d-M-Y", $tanggal1). ' ' .$jam;
            $aktivitas =  "login";

            $insert = "INSERT INTO histori VALUES('','$nama','$npm','$jurusan','$tanggal','$aktivitas')";
            mysqli_query($koneksi,$insert);
            header("Location: my.php");
            exit;
        }
        else{ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert mt-4 mb-1">
              <strong class="fs-6">Password salah!</strong> 
            </div>
        <?php }
    }else{ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert mt-4 mb-1">
         <strong class="fs-6">NPM salah!</strong> 
        </div>
    <?php }
    $error = true;
}
         ?>
        <p class="mt-5 mb-3 text-muted">© Pemira 2021</p>
    </form>
</div>
</body>
</html>