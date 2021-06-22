<?php include('koneksi.php');
  session_start();
  if (!isset($_SESSION["masuk"])) {
    header("location: login.php");
    exit;
  }
  $npm = $_SESSION['login'];
  $npm = (int)$npm;
  $data = mysqli_query($koneksi,"select * from kandidat order by no_urut ASC");
  $query = mysqli_query($koneksi,"select * from akun where npm = $npm ");
  $data1= mysqli_fetch_assoc($query);
  $nama = $data1['nama'];
  $pass = $data1['password'];

 
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
      <a class="navbar-brand" href="#">PEMIRA FASILKOM 2021</a>
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
        <a class="nav-link text-white" href="index.php"><i class="far fa-check-circle"></i><strong> Pilih</strong></a><hr class="bg-secondary">
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
    <h3><i class="far fa-check-circle"></i> Pilih Presiden dan Wakil Presiden BEM FASILKOM</h3><hr>

    <!-- memilih dan update vote kandidat -->
    <?php 
     $status_vote = mysqli_query($koneksi,"select status_vote from akun where npm = $npm ");
     $status_vote = mysqli_fetch_assoc($status_vote);
      $status_vote = $status_vote['status_vote'];
      $status_vote = (int)$status_vote;
      $password = '1234';
      if (isset($_POST['submit'])) {
        if (isset($_POST['radio'])) {
          if (password_verify($password, $data1['password'])) {
            ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Ganti password anda terlebih dahulu!</strong> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> 
            <?php
          }
          else{
            if ($status_vote === 1) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Anda telah memilih, kesempatan memilih hanya satu kali</strong> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php }
          else{ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Terimakasih sudah memilih</strong> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
            $pilihan = $_POST['radio'];
            $query = mysqli_query($koneksi,"select * from kandidat where no_urut = $pilihan ");
            $query = mysqli_fetch_assoc($query);
            $query = $query['jumlah_vote'];
            $query = (int)$query;
            $vote_sekarang = $query ;
            $vote_setelah = $query + 1 ;

            $update = "UPDATE kandidat SET jumlah_vote = $vote_setelah WHERE no_urut = $pilihan";
            mysqli_query($koneksi,$update);
            // update status vote
            $update = "UPDATE akun SET status_vote = 1 WHERE npm = $npm";
            mysqli_query($koneksi,$update);
            // menyatakan sudah memilih
            $akun = mysqli_query($koneksi,"select * from akun where npm = $npm ");
            $akun = mysqli_fetch_assoc($akun);
            $npm = $akun['npm'];
            $nama = $akun['nama'];
            $jurusan = $akun['jurusan'];
            $kirim = "INSERT INTO sudah_memilih VALUES('',$npm,'$nama','$jurusan',$pilihan)";
            mysqli_query($koneksi,$kirim);
            // kirim data ke histori      
            date_default_timezone_set('Asia/Jakarta');
            $jam = date("h:i:sa");
            $tanggal1= mktime(date("m"),date("d"),date("Y"));
            $tanggal = date("d-M-Y", $tanggal1). ' ' .$jam;
            $aktivitas =  "Telah Memilih";

            $insert = "INSERT INTO histori VALUES('','$nama','$npm','$jurusan','$tanggal','$aktivitas')";
            mysqli_query($koneksi,$insert);
          }
          }
          
        }
      }
     ?>
    <form method="post" enctype="multipart/form-data">
    <div class="row d-flex justify-content-around">
      <?php foreach ($data as $row) : ?>
        <div class="card mb-3 bg-light" style="width: 18rem;">
        <div class="card-header text-center bg-warning">
           <strong><?php echo $row['no_urut']; ?></strong>
        </div>
        <div class="card-body">
          <img src="../img/<?php echo $row["foto_calon"]; ?>" class="card-img-top img-thumbnail" alt="">
          <div class="align-items-start flex-column">
            <h5 class="card-title"><?php echo $row["nama_pasangan"]; ?></h5>
            <p class="card-text"><?php echo $row["deskripsi_calon"] ?></p>
            <span class="fs-4">
            <input class="form-check-input" name="radio" type="radio" value="<?php echo $row['no_urut']; ?>">
            <label class="form-check-label" for="radio">
             Pilih
          </label></span>
          </div>
          
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-center mt-1"><input type="submit" class="btn btn-success col-md-2 mt-2 fs-4" name="submit" value="SIMPAN"></div>
    
    </form>
  </div>
</div>
</body>
</html>
