<?php
include('koneksi.php');
$id = $_GET["id"]; //variabel untuk menampung id dari form dibawah

//melakukan query delete data
mysqli_query($koneksi, "DELETE FROM kandidat WHERE id= $id");
//mengecek jika data berhasil dihapus
if (mysqli_affected_rows($koneksi)>0) {
    # code...
    echo "
    <script>
            document.location.href='lanjutan.php';
        </script>";
}
else{
    echo 
    "<script>
            alert('data gagal dihapus');
            document.location.href='lanjutan.php';
    </script>";
    }
?>