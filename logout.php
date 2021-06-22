<?php 
include('koneksi.php');
session_start();
//meyakinkan agar session ilang
// mengirim histori
$npm = $_GET['npm'];
$data = mysqli_query($koneksi,"select * from akun where npm = $npm");
$data = mysqli_fetch_assoc($data);
$nama = $data['nama'];
$jurusan = $data['jurusan'];
date_default_timezone_set('Asia/Jakarta');
$jam = date("h:i:sa");
$tanggal1= mktime(date("m"),date("d"),date("Y"));
$tanggal = date("d-M-Y", $tanggal1). ' ' .$jam;
$aktivitas =  "Logout";

$insert = "INSERT INTO histori VALUES('','$nama', $npm,'$jurusan','$tanggal','$aktivitas')";
mysqli_query($koneksi,$insert);
$_SESSION = [];
session_unset();
session_destroy();

header("location: login.php");
exit;


 ?>