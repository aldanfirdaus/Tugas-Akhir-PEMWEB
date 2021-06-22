<?php 
include('koneksi.php');
session_start();


 ?>
<html lang="en">
<head>
    <title>Login Admin Pemira Presiden & Wakil Presiden BEM FASILKOM 2021</title>
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
    <link href="user/style.css" rel="stylesheet">
</head>
<body class="text-center">
    <div class="col-sm-12">

    <a href="index.php" id="kembali" class="nav-link col-sm-2 fs-5 fw-bold" style="text-decoration: none;"><i class="fas fa-chevron-left"></i> Kembali</a>
    <form class="form-signin" method="post">
        <img class="mb-4" src="logo.png" alt="" width="150" height="150">
        <h1 class="h3 mb-3 font-weight-normal">Login Admin Pemira Presbem & Wapresbem FASILKOM 2021</h1>
        <label for="npm mb-2" class="sr-only">Masukkan Username</label>
        <input type="text" id="username" name="username" class="form-control mb-3" placeholder="Username" required autofocus>
        <label for="password" class="sr-only ">Masukkan Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
        <?php 
            if (isset($_POST["submit"])) {

    $username=  mysqli_real_escape_string($koneksi, $_POST["username"]);
    $password =  mysqli_real_escape_string($koneksi, $_POST["password"]);
    $result = mysqli_query($koneksi,"SELECT * FROM admin WHERE username = '$username'");
    $passwordlama = mysqli_fetch_assoc($result);
    $passwordlama = $passwordlama['password'];

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password ==  $passwordlama) {
            
            $_SESSION["login"] = true;
            header("Location: home.php");
            exit;
        }
        else{ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert mt-4 mb-1">
              <strong class="fs-6">Password salah!</strong> 
            </div>
        <?php }
    }else{ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert mt-4 mb-1">
         <strong class="fs-6">Username salah!</strong> 
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