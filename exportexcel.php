<?php 
include('koneksi.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1','No');
$sheet->setCellValue('B1','Nomor Urut');
$sheet->setCellValue('C1','Nama Pasangan');
$sheet->setCellValue('D1','Deskripsi');
$sheet->setCellValue('E1','Jumlah Vote');

$query = mysqli_query($koneksi, "select * from kandidat");
$i = 2;
$no = 1;
while($row = mysqli_fetch_array($query))
{
	$sheet->setCellValue('A'.$i,$no++);
	$sheet->setCellValue('B'.$i,$row['no_urut']);
	$sheet->setCellValue('C'.$i,$row['nama_pasangan']);
	$sheet->setCellValue('D'.$i,$row['deskripsi_calon']);
	$sheet->setCellValue('E'.$i,$row['jumlah_vote']);
	$i++;
}

$styleArray = [
	'borders' => [
		'allBorders' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
	],
];
$i = $i - 1;
$sheet->getStyle('A1:AI'.$i)->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$writer->save('Hasil PEMIRA BEM FASILKOM 2021.xlsx');
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Export to Excel</title>	
 </head>
 <body>
 <?php 
 	header("location: index.php");
  ?>
 </body>
 </html>
