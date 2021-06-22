<?php 
include('koneksi.php');
require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$query = mysqli_query($koneksi,"select * from kandidat");
$html = '<center><h3>Hasil PEMIRA Presiden dan Wakil Presiden BEM FASILKOM 2021</h3></center><hr/><br/>';
$html .= '<table border="1" cellspacing="0" width="100%">
	<tr>
	<th>No</th>
	<th>Nomor Urut</th>
	<th>Nama Calon Pasangan</th>
	<th>Deskripsi</th>
	<th>Jumlah Vote</th>
	</tr>';
$no = 1;
while ($row = mysqli_fetch_array($query)) {
	$html .= "<tr>
	<td>".$no."</td>
	<td>".$row['no_urut']."</td>
	<td>".$row['nama_pasangan']."</td>
	<td>".$row['deskripsi_calon']."</td>
	<td>".$row['jumlah_vote']."</td>
	</tr>";
	$no++;
}
$html .= "</html>";
$dompdf->loadHtml($html);
//setting ukuran dan orientasi kertas
$dompdf->setPaper('A4','landscape');
//Rendering dari HTML ke PDF
$dompdf->render();
//melakukan output file ke pdf
$dompdf->stream('Hasil PEMIRA BEM FASILKOM 2021.pdf');
 ?>