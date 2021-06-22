<?php 
include('koneksi.php');
if ($_GET["npm"] != 0) {
    $npm = $_GET["npm"];
    mysqli_query($koneksi, "DELETE FROM akun WHERE npm = $npm");
    if (mysqli_affected_rows($koneksi)>0) {
    # code...
    echo "
    <script>
            document.location.href='mhs_terdaftar.php';
        </script>";
    }
    else{
        echo 
        "<script>
                alert('data gagal dihapus');
                document.location.href='mhs_terdaftar.php';
            </script>";
    }
}
?>