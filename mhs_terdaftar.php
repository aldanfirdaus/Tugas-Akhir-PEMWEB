<?php
  ob_start();  
  include('koneksi.php');
  session_start();
  if (!isset($_SESSION["login"])) {
    header("location: login_admin.php");
    exit;
  }
  $data = mysqli_query($koneksi,'select * from akun order by npm ASC');
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
    }
  </style>
</head>
<body>
<!-- navbar samping -->
<nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fs-3 fw-normal" href="">Halaman Admin</a>
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
        <a class="nav-link text-white" href="index.php"><i class="fas fa-home"></i> Home</a><hr class="bg-secondary">
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
    <a href="home.php" id="kembali" class="nav-link col-md-2 mb-1" style="text-decoration: none;"><i class="fas fa-chevron-left"></i> Kembali</a>
    <h3 style="margin-left: 20px"><i class="fas fa-address-book"></i> Mahasiswa Terdaftar</h3><hr>
    <!-- button tambah akun mahasiswa -->
    <button type="button" class="btn btn-primary mt-4 mb-3" data-bs-toggle="modal" data-bs-target="#tambahdata" style="float: right;">
    <i class="fas fa-plus-square"></i> Tambah Akun Mahasiswa
    </button>

    <!-- tempat alert -->
    <?php 
    if(@$_POST['tambahdata']) {
      $npm = htmlspecialchars($_POST['npm']);
      $npmada = mysqli_query($koneksi,"SELECT npm FROM akun WHERE npm = '$npm'");
      if (mysqli_num_rows($npmada) == 1) { ?>
        <div class="alert alert-warning alert-dismissible fade show col-md-5" role="alert">
   NPM yang anda masukkan sudah ada
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
        <?php  }
         
      else { ?>
        <div class="alert alert-success alert-dismissible fade show col-md-5" role="alert">
   Akun mahasiswa berhasil ditambahkan
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
      <?php 
      $nama = htmlspecialchars($_POST['nama']);
                $jurusan = htmlspecialchars($_POST['jurusan']);
                $status_vote = 0;
                $pass = '1234';
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $query =  "INSERT INTO akun VALUES('$npm',  '$pass', '$nama','$jurusan','$status_vote')";
                mysqli_query($koneksi,$query);
              } } ?>
    <!-- modal untuk tambah data -->
    <div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahdata">Tambah Akun Mahasiswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="form" name="form" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <label class="control-panel" for="npm">NPM</label>
              <input type="number" name="npm" class="form-control" id="npm" required="">
            </div>
            <div class="modal-body">
              <label class="control-panel" for="nama">Nama Mahasiswa</label>
              <input type="text" name="nama" class="form-control" id="nama" required="">
            </div>
            <div class="modal-body">
              <label class="control-panel" for="jurusan">Pilih Jurusan</label>
              <select class="form-control" name="jurusan" id="jurusan" required="">
                <option value="">Pilih</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sitem Informasi</option>
                <option value="Sains Data">Sains Data</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-danger">Reset</button>
              <input type="submit" class="btn btn-success" name="tambahdata" value="Simpan">
            </div>
          </form>
          
          
    </div>
  </div>
</div>
    <!-- tabel mahasiswa terdaftar -->
    <table class="table table-bordered table-striped" style="text-align: center;">
      <tr>
        <th class="col-md-1">No.</th>
        <th class="col-md-1">NPM</th>
        <th class="col-md-2">Nama</th>
        <th class="col-md-2">Jurusan</th>
        <th class="col-md-1">Status Vote</th>
        <th class="col-md-2">Aksi</th>
      </tr>

      <?php $no=1; ?>
        <?php foreach($data as $row) :?>
       <tr> 
            <td class="col-md-1"><?php echo $no;?></td>
            <td class="col-md-1"><?php echo $row['npm'];?></td>
            <td class="col-md-2"><?php echo $row['nama'];?></td>
            <td class="col-md-2"><?php echo $row['jurusan'];?></td>
            <td class="col-md-1"><?php echo $row['status_vote'];?></td>
            <td align="center">
              <a href="hapus_mhs.php?npm=<?php echo $row['npm'];?>" class="btn btn-sm bg-danger text-white">Hapus</a>
            </td>
      </tr>
      <?php $no++ ;?>
        <?php endforeach?>
    </table>
  
  </div>
</div>
</body>
</html>
