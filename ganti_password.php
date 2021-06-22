<?php include('koneksi.php');
  session_start();
  if (!isset($_SESSION["masuk"])) {
    header("location: login.php");
    exit;
  }
  $npm = $_SESSION['login'];
  $npm = (int)$npm;
  $data = mysqli_query($koneksi,"select * from akun where npm = $npm ");
  $data = mysqli_fetch_assoc($data);
  $nama = $data['nama'];
 
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/9a065f2d64.js" crossorigin="anonymous"></script>
  <style type="text/css">
    body{
      overflow-x: hidden;
    }
    .card{
      margin-left: 20px;
    }
    .nav-link:hover{
  background-color: grey;
}
  </style>
</head>
<body>

<!-- navbar samping -->
<nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="">PEMIRA FASILKOM 2021</a>
        <!-- <form class="d-flex ml-auto my-2 my-lg-0">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
        
        <div class="icon ml-4">
          <img src="logo.png" width="50px" height="50px">
        </div>
    </div>
</nav>

<div class="row no-gutters mt-5">
  <div class="col-md-2 bg-dark mt-2 pr-3 pt-4" style="padding-bottom: 100vh">
    <ul class="nav flex-column ml-3 mb-5">
      <li class="nav-item">
        <div class="d-flex  justify-content-center pt-2">
          <p class="text-white"><i class="fas fa-user fa-4x"></i></p>
        </div>
        <div class="d-flex justify-content-center">
          <span class="fs-6 text-white"><img src="green.png" style="width: 8px; height: 8px"> online</span>
        </div>
        <div class="d-flex  justify-content-center">
          <h5 class="text-white "><?php echo $nama; ?></h5>
        </div>
        <div class="d-flex  justify-content-center">
          <h4 class="text-white"><?php echo $npm; ?></h4>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="my.php"><i class="far fa-check-circle"></i><strong> Pilih</strong></a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="ganti_password.php"><i class="fas fa-key"></i> Ganti Password</a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="logout.php?npm=<?php echo $npm; ?>"><i class="fas fa-sign-out-alt mr-3"></i> Logout</a><hr class="bg-secondary">
      </li>
    </ul>
  </div>
  <div class="col-sm-10 p-5 pt-5">
    <h3><i class="fas fa-key"></i> Ganti Password</h3><hr> 
    <!-- card untuk ganti password -->
    <div class="d-flex justify-content-center">
      
    <!-- card ganti password -->
    <div class="card col-md-6 mt-3">
      <div class="card-header" align="center">
        <i class="fas fa-key"></i> Ganti Password 
      </div>
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
      </form>
      <?php 
        if (@$_POST['submit']) {
          $passwordlama = $_POST['pas_lama'];
          $passwordbaru = $_POST['pas_baru'];
          $passwordbaru = password_hash($passwordbaru, PASSWORD_DEFAULT);
          if (password_verify($passwordlama, $data['password'])) {
            $update = "UPDATE akun SET password = '$passwordbaru' WHERE npm = $npm";
            mysqli_query($koneksi,$update);
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Password berhasil diubah</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            $jurusan = $data['jurusan'];
            date_default_timezone_set('Asia/Jakarta');
            $jam = date("h:i:sa");
            $tanggal1= mktime(date("m"),date("d"),date("Y"));
            $tanggal = date("d-M-Y", $tanggal1). ' ' .$jam;
            $aktivitas =  "Ganti Password";

            $insert = "INSERT INTO histori VALUES('','$nama', $npm,'$jurusan','$tanggal','$aktivitas')";
            mysqli_query($koneksi,$insert);
          }
          else{ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Password yang anda masukkan salah!</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         <?php }
        }
     ?>
      
    </div>
    </div>
  </div>
</div>
</body>
</html>
