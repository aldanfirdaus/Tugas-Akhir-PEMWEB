<?php  
  include('koneksi.php');
  session_start();
  if (!isset($_SESSION["login"])) {
    header("location: login_admin.php");
    exit;
  }
  $data = mysqli_query($koneksi,'select * from histori order by id ASC');

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="index.css">
  <script type="text/javascript" src="Chart.js"></script>
  <script src="https://kit.fontawesome.com/9a065f2d64.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="index.css">

</head>
<body>
<!-- navbar samping -->
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

<div class="row no-gutters mt-5">
  <div class="col-md-2 bg-dark mt-2 pr-3 pt-4" style="padding-bottom: 100vh">
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
    <h3><i class="fas fa-history"></i> History</h3><hr>
    <!-- tabel history -->
    <table class="table table-bordered table-striped" style="text-align: center;">
      <tr>
        <th class="col-md-2">Nama</th>
        <th class="col-md-2">NPM</th>
        <th class="col-md-2">Jurusan</th>
        <th class="col-md-2">Tanggal Waktu</th>
        <th class="col-md-2">Aktivitas</th>
      </tr>

      <?php $no=1; ?>
        <?php foreach($data as $row) :?>
       <tr>
            <td class="col-md-2"><?php echo $row['nama_user'];?></td>
            <td class="col-md-2"><?php echo $row['npm_user'];?></td>
            <td class="col-md-2"><?php echo $row['jurusan'];?></td>
            <td class="col-md-2"><?php echo $row['tanggal_waktu'];?></td>
            <td class="col-md-2"><?php echo $row['aktivitas_user'];?></td>
      </tr>
      <?php $no++ ;?>
        <?php endforeach?>
    </table>
  </div>
</div>
</body>
</html>
