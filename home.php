<?php  
  include('koneksi.php');
  session_start();
  if (!isset($_SESSION["login"])) {
    header("location: login_admin.php");
    exit;
  }
  $data = mysqli_query($koneksi,"select * from kandidat");
    while($row = mysqli_fetch_array($data)){
      $vote[] = $row['jumlah_vote'];
      $nama[] = $row['nama_pasangan'];
    }
  
  $akun = mysqli_query($koneksi,'select * from akun');
  $jumlah_akun = mysqli_num_rows($akun);
  $mhs_memilih = mysqli_query($koneksi, 'select * from sudah_memilih');
  $mhs_memilih = mysqli_num_rows($mhs_memilih);
  $mhs_blm_memilih = $jumlah_akun - $mhs_memilih;
  $total_pemilih = ($mhs_memilih / $jumlah_akun) * 100;
  $total_pemilih = ceil($total_pemilih);
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
    <h3><i class="fas fa-home"></i> Home</h3><hr>
    <div class="row text-white">
      <div class="card bg-info" style="width: 16rem;">
        <div class="card-body">
          <div class="card-body-icon">
            <i class="fas fa-user-graduate mr-2"></i>
          </div>
          <h7 class="card-title">Mahasiswa sudah memilih</h7>
          <div class="display-4"><?php echo $mhs_memilih; ?></div> 
          <a href="mhs_sdh_memilih.php" class="btn btn-primary">Detail <i class="fas fa-info-circle"></i></a>
        </div>
      </div>

       <div class="card bg-success ml-3" style="width: 16rem;">
        <div class="card-body">
          <div class="card-body-icon2">
            <i class="fas fa-user-slash"></i>
          </div>
          <h7 class="card-title">Mahasiswa belum memilih</h7>
          <div class="display-4"><?php echo $mhs_blm_memilih; ?></div> 
          <a href="mhs_blm_memilih.php" class="btn btn-primary">Detail <i class="fas fa-info-circle"></i></a>
        </div>
      </div>

      <div class="card bg-secondary ml-3" style="width: 16rem;">
        <div class="card-body">
          <div class="card-body-icon">
            <i class="fas fa-address-book"></i>
          </div>
          <h7 class="card-title">Mahasiswa terdaftar</h7>
          <div class="display-4"><?php echo $jumlah_akun; ?></div> 
          <a href="mhs_terdaftar.php" class="btn btn-primary">Detail <i class="fas fa-info-circle"></i></a>
        </div>
      </div>

      <div class="card bg-danger" style="width: 16rem;">
        <div class="card-body">
          <div class="card-body-icon4">
            <i class="fas fa-chart-pie"></i>
          </div>
          <h7 class="card-title">Total pemilih</h7>
          <div class="display-4" style="margin-top: 18px"><?php echo $total_pemilih ?>%</div> 
        </div>
      </div>
    </div>
    <!-- tempat untuk chart -->
    <div class="d-flex justify-content-center mt-3">

      <div id="canvas-holder" style="width:40rem; height: 20rem;; ">
        <canvas id="chart-area1" style="height: 16rem; width: 40rem;"></canvas>
      </div>
      <div id="canvas-holder" style="width:30rem; height: 20rem; ">
        <canvas id="chart-area" style="height: 16rem; width: 30rem; "></canvas>
      </div>
    </div>
    

    <script  type="text/javascript">
    var ctx = document.getElementById("chart-area1").getContext("2d");
    var data = {
              labels:<?php echo json_encode($nama); ?>,
              datasets: [
              {
                label: "Perolehan Vote",
                data:<?php echo json_encode($vote); ?>,
                borderColor: 'rgba(240, 181, 19, 1)',
          borderWidth: 3
              }
              ]
              };

    var myPieChart = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                      responsive: false
                  }
                });

        var ctx = document.getElementById("chart-area").getContext("2d");
    var data = {
              labels:<?php echo json_encode($nama); ?>,
              datasets: [
              {
                label: "Perolehan Vote",
                data:<?php echo json_encode($vote); ?>,
                backgroundColor: [
                  '#29B0D0',
                  '#2A516E',
                  '#F07124',
                  '#CBE0E3',
                  '#979193',
                  '#7FFF00',
                  '#B8860B',
                  '#FF1493',
                  '#FFD700',
                  '#7CFC00'
                ]
              }
              ]
              };

    var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                      responsive: false
                  }
                });

  </script>
  <!-- tombol ekspor -->
    <div class="d-flex justify-content-center">
      <div class="col-md-2 mr-3">
        <a href="exportpdf.php" class="btn btn-danger"><i class="far fa-file-pdf"></i> Export ke PDF</a>
      </div>
      
      <a href="exportexcel.php" class="btn btn-success"><i class="far fa-file-excel"></i> Export ke Excel</a>  
    </div>
  </div>
</div>
</body>
</html>
