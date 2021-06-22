<?php  
  include('koneksi.php');
  session_start();
  if (!isset($_SESSION["login"])) {
    header("location: login_admin.php");
    exit;
  }
  $data = mysqli_query($koneksi,'select * from admin');
  $data = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script type="text/javascript" src="Chart.js"></script>
  <script src="https://kit.fontawesome.com/9a065f2d64.js" crossorigin="anonymous"></script>
  <style type="text/css">
    body{
      overflow-x: hidden;
      overflow-y: hidden;
    }
  </style>
</head>
<body>
<!-- navbar atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fs-3" href="">Halaman Admin</a>
        <!-- <form class="d-flex ml-auto my-2 my-lg-0">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
        
        <div class="icon ml-4">
          <img src="logo.png" width="50px" height="50px">
        </div>
    </div>
</nav>
<script type="text/javascript">
  $("body").css("overflow-x", "hidden");
</script>
<!-- navbar samping -->
<div class="row no-gutters mt-5" >
  <div class="col-md-2 bg-dark mt-2 pr-3 pt-4" id="navbar_samping" style="padding-bottom: 100vh">
    <ul class="nav flex-column ml-3 mb-5">
      <li class="nav-item">
        <a class="nav-link text-white" href="home.php"><i class="fas fa-home"></i> Home</a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="history.php"><i class="fas fa-history"></i> History</a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="lanjutan.php"><i class="far fa-edit"></i> Lanjutan</a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="logout.php"><i class="fas fa-sign-out-alt mr-3"></i> Logout</a><hr class="bg-secondary">
      </li>
    </ul>
  </div>
  <div class="col-sm-10 p-5 pt-5">
    <!-- kembali -->
    <a href="lanjutan.php" class="nav-link col-sm-2" style="text-decoration: none;"><i class="fas fa-chevron-left"></i> Kembali</a>
    <h3><i class="fas fa-key"></i> Ganti Password Admin</h3><hr>
    <div class="d-flex justify-content-center">
      <!-- card ganti password -->
      <div class="card col-md-6 mt-3">
        <form method="post" id="form" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-grup">
              <label class="control-panel" for="pas_lama">Masukkan Password Lama</label>
              <input type="password" name="pas_lama" class="form-control" id="pas_lama" required="">
            </div><br>
            <div class="form-grup">
              <label class="control-panel" for="pas_baru">Masukkan Password Baru</label>
              <input type="password" name="pas_baru" class="form-control" id="pas_baru" required="">
            </div><br>
            <div class="form-grup" align="center">
              <input type="submit" data-target="submit" class="btn btn-primary" name="submit" id="submit" value="Simpan">
            </div>
          </div>
          <?php 
        if (@$_POST['submit']) {
          $passwordlama = $_POST['pas_lama'];
          $passwordbaru = $_POST['pas_baru'];
          if ($passwordlama == $data['password']) {
            $update = "UPDATE admin SET password = '$passwordbaru' WHERE id=1";
            mysqli_query($koneksi,$update);
            ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil ganti password</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php
          }
          else{
            ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal ganti password</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php
          }
        }
     ?>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
