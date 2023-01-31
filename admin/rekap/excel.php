<?php
session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='admin'){
  header("location:../../index.php");
}
// Load file koneksi.php
include "../../koneksi.php";
// Load file autoload.php
require '../../phpspreadsheet/vendor/autoload.php';
//transaksi
$id = $_GET["id"];
$id_tem = substr($id,0,1);
$id_tema = intval($id_tem);
$triwulan = substr($id,-1);
$sql = "SELECT 
        tema.TEMA, skpd.ID_SKPD, skpd.SKPD, SUM(transaksi.ALOKASI_ANGGARAN) AS Total_Alokasi, 
        SUM(transaksi.ANGGARAN_TEMA_PERSUBKEGIATAN) AS Total_Anggaran_Pertema, SUM(transaksi.REALISASI_ANGGARAN) AS Total_Realisasi, 
        (SUM(transaksi.ANGGARAN_TEMA_PERSUBKEGIATAN))-(SUM(transaksi.REALISASI_ANGGARAN))  AS Sisa_Anggaran 
        FROM skpd
        LEFT JOIN program ON  skpd.ID_SKPD = program.ID_SKPD
        LEFT JOIN kegiatan ON program.ID_PROGRAM = kegiatan.ID_PROGRAM
        LEFT JOIN subkegiatan ON kegiatan.ID_KEGIATAN = subkegiatan.ID_KEGIATAN
        LEFT JOIN transaksi ON subkegiatan.ID_SUBKEGIATAN = transaksi.ID_SUBKEGIATAN
        LEFT JOIN tema ON transaksi.ID_TEMA = tema.ID_TEMA
        WHERE tema.ID_TEMA = $id_tema AND transaksi.TRIWULAN = '$triwulan';";
$hasil = mysqli_query($conn, $sql);

$sql1 ="SELECT * FROM tema WHERE ID_TEMA = $id_tema";
$hasil1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($hasil1);
$tema = $row1["TEMA"];


// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = [
    'font' => ['bold' => true], // Set font nya jadi bold
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];
// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];
$sheet->setCellValue('D1', "Laporan Rekap SKPD yang Mendukung Tema : $tema");
$sheet->mergeCells('D1:G1'); // Set Merge Cell pada kolom A1 sampai F1
$sheet->getStyle('D1')->getFont()->setBold(true); // Set bold kolom A1
$sheet->getStyle('D1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
// Buat header tabel nya pada baris ke 3
$sheet->setCellValue('A3', "No"); 
$sheet->setCellValue('B3', "Tema"); 
$sheet->setCellValue('C3', "Id SKPD"); 
$sheet->setCellValue('D3', "SKPD"); 
$sheet->setCellValue('E3', "Total Alokasi Anggaran"); 
$sheet->setCellValue('F3', "Total Anggaran Pertema"); 
$sheet->setCellValue('G3', "Total Realisasi Anggaran Triwulan $triwulan"); 
$sheet->setCellValue('H3', "Total Sisa Anggaran"); 

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$sheet->getStyle('A3')->applyFromArray($style_col);
$sheet->getStyle('B3')->applyFromArray($style_col);
$sheet->getStyle('C3')->applyFromArray($style_col);
$sheet->getStyle('D3')->applyFromArray($style_col);
$sheet->getStyle('E3')->applyFromArray($style_col);
$sheet->getStyle('F3')->applyFromArray($style_col);
$sheet->getStyle('G3')->applyFromArray($style_col);
$sheet->getStyle('H3')->applyFromArray($style_col);
// Set height baris ke 1, 2 dan 3
$sheet->getRowDimension('1')->setRowHeight(20);
$sheet->getRowDimension('2')->setRowHeight(20);
$sheet->getRowDimension('3')->setRowHeight(20);

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$row = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
while ($data = mysqli_fetch_array($hasil)) { // Ambil semua data dari hasil eksekusi $sql
    $sheet->setCellValue('A' . $row, $no);
    $sheet->setCellValue('B' . $row, $data['TEMA']);
    $sheet->setCellValue('C' . $row, $data['ID_SKPD']);
    $sheet->setCellValue('D' . $row, $data['SKPD']);
    $sheet->setCellValue('E' . $row, $data['Total_Alokasi']);
    $sheet->setCellValue('F' . $row, $data['Total_Anggaran_Pertema']);
    $sheet->setCellValue('G' . $row, $data['Total_Realisasi']);
    $sheet->setCellValue('H' . $row, $data['Sisa_Anggaran']);
    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $sheet->getStyle('A' . $row)->applyFromArray($style_row);
    $sheet->getStyle('B' . $row)->applyFromArray($style_row);
    $sheet->getStyle('C' . $row)->applyFromArray($style_row);
    $sheet->getStyle('D' . $row)->applyFromArray($style_row);
    $sheet->getStyle('E' . $row)->applyFromArray($style_row);
    $sheet->getStyle('F' . $row)->applyFromArray($style_row);
    $sheet->getStyle('G' . $row)->applyFromArray($style_row);
    $sheet->getStyle('H' . $row)->applyFromArray($style_row);
    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
    $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getRowDimension($row)->setRowHeight(20); // Set height tiap row
    $no++; // Tambah 1 setiap kali looping
    $row++; // Tambah 1 setiap kali looping
}
// Set width kolom
$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
$sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
$sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
$sheet->getColumnDimension('E')->setWidth(25); // Set width kolom E
$sheet->getColumnDimension('F')->setWidth(25); // Set width kolom F
$sheet->getColumnDimension('G')->setWidth(30); // Set width kolom G
$sheet->getColumnDimension('H')->setWidth(25); // Set width kolom H
// Set orientasi kertas jadi LANDSCAPE
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$sheet->setTitle("Laporan Rekap");
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Rekap.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>