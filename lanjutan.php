<?php 
  ob_start(); 
  include('koneksi.php');
  session_start();
  if (!isset($_SESSION["login"])) {
    header("location: login_admin.php");
    exit;
  }
  $data1 = mysqli_query($koneksi,'select * from kandidat');
  $data1 = mysqli_fetch_assoc($data1);

  $data2 = mysqli_query($koneksi,'select * from kandidat');
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
<!-- nav samping -->
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
    <h3><i class="far fa-edit"></i> Lanjutan</h3><hr>
    <div class="card col-sm-4">
      <div class="card-header">
        <i class="fas fa-key"></i> Ganti Password Admin
      </div>
    <div class="card-body">
      <p class="card-text">Ganti password admin agar lebih aman</p>
      <a href="gantiPassword_admin.php" class="btn btn-primary">Ganti password</a>
    </div>
    </div>

    <?php
            $error_jumlah = '';  
            if(@$_POST['tambahdata']){
              $jumlah = mysqli_num_rows($data2);
              if ($jumlah <= 5) {
                $no_urutlama = htmlspecialchars($_POST['no_urut']);
                $no_urut = mysqli_query($koneksi, "select no_urut from kandidat where no_urut = $no_urutlama");
                if (mysqli_num_rows($no_urut) === 1) {
                  ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Nomor urut sudah ada</strong> 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  <?php
              }
                else{
                  $nama_pasangan = htmlspecialchars($_POST['nama_pasangan']);
                  $deskripsi = htmlspecialchars($_POST['deskripsi']);

                  $ekstensi_foto = explode(".", $_FILES['foto']['name']);
                  $foto = "foto-".round(microtime(true)).".".end($ekstensi_foto);
                  $sumber = $_FILES['foto']['tmp_name'];
                  $upload = move_uploaded_file($sumber, "img/".$foto);
                  $jumlah_vote = 0;
                  if ($upload) {
                    $query = "INSERT INTO kandidat VALUES('',$no_urutlama,'$nama_pasangan','$deskripsi','$foto',$jumlah_vote)";
                    header("Location: ?page=lanjutan"); 
                    mysqli_query($koneksi,$query); //query data
                  } else{
                    echo "<script>alert('Tambah data gagal !')</script>";
                  }
                }
            }
            else{
                ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Data maksimal 6</strong> 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php
              }
            }
          ?>
    <span style="color: #FF0000; margin-top: 30px;"><?php echo $error_jumlah; ?></span>
    <!-- button untuk tambah data -->
    <button type="button" class="btn btn-primary mt-4 mb-3" data-bs-toggle="modal" data-bs-target="#tambahdata" style="float: right;">
    <i class="fas fa-plus-square"></i> Tambah Calon Pasangan
    </button>
    <!-- Modal -->
    <div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahdata">Tambah Data Calon Pasangan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <label class="control-panel" for="no_urut">Nomor Urut</label>
              <input type="number" name="no_urut" class="form-control" id="no_urut" required="">
            </div>
            <div class="modal-body">
              <label class="control-panel" for="nama_pasangan">Nama Calon Pasangan</label>
              <input type="text" name="nama_pasangan" class="form-control" id="nama_pasangan" required="">
            </div>
            <div class="modal-body">
              <label class="control-panel" for="deskripsi">Deskripsi Calon Pasangan</label>
              <input type="text" name="deskripsi" class="form-control" id="deskripsi" required="">
            </div>
            <div class="modal-body">
              <label class="control-panel" for="foto">Gambar Calon Pasangan</label>
              <input type="file" name="foto" class="form-control" id="foto" required="">
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-danger">Reset</button>
              <input type="submit" class="btn btn-success" name="tambahdata" value="Simpan">
            </div>
          </form>
          
    </div>
  </div>
</div>
    <!-- tabel untuk kandidat pasangan -->
    <table class="table table-bordered table-striped" style="text-align: center;">
      <tr>
        <th class="col-md-1">No.</th>
        <th class="col-md-2">Nomor Urut</th>
        <th class="col-md-2">Nama Pasangan</th>
        <th class="col-md-2">Deskripsi</th>
        <th class="col-md-2">Foto Pasangan</th>
        <th class="col-md-1">Jumlah Vote</th>
        <th class="col-md-2">Aksi</th>
      </tr>

      <?php $no=1; ?>
        <?php foreach($data2 as $row) :?>
       <tr> 
            <td class="col-md-1"><?php echo $no;?></td>
            <td class="col-md-1"><?php echo $row['no_urut'];?></td>
            <td class="col-md-2"><?php echo $row['nama_pasangan'];?></td>
            <td class="col-md-2"><?php echo $row['deskripsi_calon'];?></td>
            <td class="col-md-2"><img src="img/<?php echo $row["foto_calon"]; ?>" width="90"></td>
            <td class="col-md-1"><?php echo $row['jumlah_vote'];?></td>
            <td align="center">
              <button type="button" style="width: 50px" class="btn btn-sm bg-primary text-white editdata" data-bs-toggle="modal" name="edit" data-bs-target="#editdata" id="btn-edit" data-id="<?php echo $row['id']; ?>" data-nomor="<?php echo $row['no_urut'];?>" data-nama="<?php echo $row['nama_pasangan']; ?>" data-deskripsi="<?php echo $row['deskripsi_calon']; ?>" data-foto="<?php echo $row['foto_calon']; ?>">Edit</button> | <a href="hapus.php?id=<?php echo $row['id'];?>" class="btn btn-sm bg-danger text-white">Hapus</a>
            </td>
      </tr>
      <?php $no++ ;?>
        <?php endforeach?>
    </table>

    <!-- edit data -->
    <div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editdata">Edit Data Calon Pasangan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" id="form" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="id" id="id-calon">

              <div class="form-grup">
                <label class="control-panel" for="no_urut">Nomor Urut</label>
                <input type="number" name="no_urut" class="form-control" id="no_urut" required="">
              </div><br>
              <div class="form-grup">
                <label class="control-panel" for="nama_pasangan">Nama Calon Pasangan</label>
                <input type="text" name="nama_pasangan" class="form-control" id="nama_pasangan" required="">
              </div><br>
              <div class="form-grup">
                <label class="control-panel" for="deskripsi">Deskripsi Calon Pasangan</label>
                <input type="text" name="deskripsi" class="form-control" id="deskripsi" required="">
              </div><br>
              <div class="form-grup">
                <label class="control-panel" for="foto">Gambar Calon Pasangan</label>
                <img src="" id="gambar" width = "150">
                <input type="file" name="foto" class="form-control" id="foto" >
              </div><br>
              <div class="modal-footer">
                <input type="submit" class="btn btn-success" name="editdata" id="editdata" value="Simpan">
              </div>
             </div> 
          </form>
    </div>
  </div>
</div>
        <!-- code untuk ubah data -->
          <?php  
            if(@$_POST['editdata']){
              $id = $_POST['id'];
              $no_urut = htmlspecialchars($_POST['no_urut']);
              $nama_pasangan = htmlspecialchars($_POST['nama_pasangan']);
              $deskripsi = htmlspecialchars($_POST['deskripsi']);

              $pict = $_FILES['foto']['name'];
              $ekstensi_foto = explode(".", $_FILES['foto']['name']);
              $foto = "foto-".round(microtime(true)).".".end($ekstensi_foto);
              $sumber = $_FILES['foto']['tmp_name'];
              $upload = move_uploaded_file($sumber, "img/".$foto);
              $jumlah_vote = 0;

              if ($pict == '') {
                $query = "UPDATE kandidat SET no_urut = '$no_urut', nama_pasangan = '$nama_pasangan', deskripsi_calon = '$deskripsi' WHERE id = '$id'";
                header("Location: ?page=lanjutan"); 
                mysqli_query($koneksi,$query); //query data
              }
              else{
                $query = "UPDATE kandidat SET no_urut = '$no_urut', nama_pasangan = '$nama_pasangan', deskripsi_calon = '$deskripsi', foto_calon = '$foto' WHERE id = '$id'";
                header("Location: ?page=lanjutan"); 
                mysqli_query($koneksi,$query); //query data
              }
            }
          ?>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
  $(document).on('click', '#btn-edit', function(){
    $('.modal-body #id-calon').val($(this).data('id'));
    $('.modal-body #no_urut').val($(this).data('nomor'));
    $('.modal-body #nama_pasangan').val($(this).data('nama'));
    $('.modal-body #deskripsi').val($(this).data('deskripsi'));
    $('.modal-body #gambar').attr("src","img/"+ $(this).data('foto'));
  })
</script>
  </div>
</div>
</body>
</html>
