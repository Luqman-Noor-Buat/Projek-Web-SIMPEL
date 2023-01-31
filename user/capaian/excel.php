<?php
session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='user'){
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
$posisi = $_SESSION['POSISI'];
$sql = "SELECT 
        tema.TEMA, skpd.ID_SKPD, skpd.SKPD, program.ID_PROGRAM, program.PROGRAM, kegiatan.ID_KEGIATAN, kegiatan.KEGIATAN, 
        subkegiatan.ID_SUBKEGIATAN, subkegiatan.SUBKEGIATAN, transaksi.INDIKATOR, transaksi.VOLUME, transaksi.KELOMPOK_SASARAN,
        transaksi.KECAMATAN, transaksi.DESA, transaksi.TAGGING, transaksi.PRIORITAS, transaksi.ALOKASI_ANGGARAN,
        transaksi.ANGGARAN_TEMA_PERSUBKEGIATAN, transaksi.REALISASI_ANGGARAN, transaksi.SUMBER_ANGGARAN FROM skpd
        LEFT JOIN program ON  skpd.ID_SKPD = program.ID_SKPD
        LEFT JOIN kegiatan ON program.ID_PROGRAM = kegiatan.ID_PROGRAM
        LEFT JOIN subkegiatan ON kegiatan.ID_KEGIATAN = subkegiatan.ID_KEGIATAN
        LEFT JOIN transaksi ON subkegiatan.ID_SUBKEGIATAN = transaksi.ID_SUBKEGIATAN
        LEFT JOIN tema ON transaksi.ID_TEMA = tema.ID_TEMA
        WHERE skpd.SKPD = '$posisi' AND tema.ID_TEMA = $id_tema AND transaksi.TRIWULAN = '$triwulan';";
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
$sheet->setCellValue('I1', "Laporan Capaian $posisi Tema : $tema");
$sheet->mergeCells('I1:L1'); // Set Merge Cell pada kolom A1 sampai F1
$sheet->getStyle('I1')->getFont()->setBold(true); // Set bold kolom A1
$sheet->getStyle('I1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
// Buat header tabel nya pada baris ke 3
$sheet->setCellValue('A3', "Tema"); 
$sheet->setCellValue('B3', "Id SKPD"); 
$sheet->setCellValue('C3', "SKPD"); 
$sheet->setCellValue('D3', "Id Program"); 
$sheet->setCellValue('E3', "Program"); 
$sheet->setCellValue('F3', "Id Kegiatan"); 
$sheet->setCellValue('G3', "Kegiatan"); 
$sheet->setCellValue('H3', "Id Subkegiatan"); 
$sheet->setCellValue('I3', "Subkegiatan"); 
$sheet->setCellValue('J3', "Indikator"); 
$sheet->setCellValue('K3', "Volume"); 
$sheet->setCellValue('L3', "Kelompok Sasaran"); 
$sheet->setCellValue('M3', "Kecamatan"); 
$sheet->setCellValue('N3', "Desa"); 
$sheet->setCellValue('O3', "Tagging $tema"); 
$sheet->setCellValue('P3', "Prioritas"); 
$sheet->setCellValue('Q3', "Alokasi Anggaran"); 
$sheet->setCellValue('R3', "Anggaran Tema Persubkegiatan"); 
$sheet->setCellValue('S3', "Realisasi Anggaran Triwulan $triwulan"); 
$sheet->setCellValue('T3', "Sumber Anggaran"); 

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$sheet->getStyle('A3')->applyFromArray($style_col);
$sheet->getStyle('B3')->applyFromArray($style_col);
$sheet->getStyle('C3')->applyFromArray($style_col);
$sheet->getStyle('D3')->applyFromArray($style_col);
$sheet->getStyle('E3')->applyFromArray($style_col);
$sheet->getStyle('F3')->applyFromArray($style_col);
$sheet->getStyle('G3')->applyFromArray($style_col);
$sheet->getStyle('H3')->applyFromArray($style_col);
$sheet->getStyle('I3')->applyFromArray($style_col);
$sheet->getStyle('J3')->applyFromArray($style_col);
$sheet->getStyle('K3')->applyFromArray($style_col);
$sheet->getStyle('L3')->applyFromArray($style_col);
$sheet->getStyle('M3')->applyFromArray($style_col);
$sheet->getStyle('N3')->applyFromArray($style_col);
$sheet->getStyle('O3')->applyFromArray($style_col);
$sheet->getStyle('P3')->applyFromArray($style_col);
$sheet->getStyle('Q3')->applyFromArray($style_col);
$sheet->getStyle('R3')->applyFromArray($style_col);
$sheet->getStyle('S3')->applyFromArray($style_col);
$sheet->getStyle('T3')->applyFromArray($style_col);
// Set height baris ke 1, 2 dan 3
$sheet->getRowDimension('1')->setRowHeight(20);
$sheet->getRowDimension('2')->setRowHeight(20);
$sheet->getRowDimension('3')->setRowHeight(20);

$row = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
while ($data = mysqli_fetch_array($hasil)) { // Ambil semua data dari hasil eksekusi $sql
    $sheet->setCellValue('A' . $row, $data['TEMA']);
    $sheet->setCellValue('B' . $row, $data['ID_SKPD']);
    $sheet->setCellValue('C' . $row, $data['SKPD']);
    $sheet->setCellValue('D' . $row, $data['ID_PROGRAM']);
    $sheet->setCellValue('E' . $row, $data['PROGRAM']);
    $sheet->setCellValue('F' . $row, $data['ID_KEGIATAN']);
    $sheet->setCellValue('G' . $row, $data['KEGIATAN']);
    $sheet->setCellValue('H' . $row, $data['ID_SUBKEGIATAN']);
    $sheet->setCellValue('I' . $row, $data['SUBKEGIATAN']);
    $sheet->setCellValue('J' . $row, $data['INDIKATOR']);
    $sheet->setCellValue('K' . $row, $data['VOLUME']);
    $sheet->setCellValue('L' . $row, $data['KELOMPOK_SASARAN']);
    $sheet->setCellValue('M' . $row, $data['KECAMATAN']);
    $sheet->setCellValue('N' . $row, $data['DESA']);
    $sheet->setCellValue('O' . $row, $data['TAGGING']);
    $sheet->setCellValue('P' . $row, $data['PRIORITAS']);
    $sheet->setCellValue('Q' . $row, $data['ALOKASI_ANGGARAN']);
    $sheet->setCellValue('R' . $row, $data['ANGGARAN_TEMA_PERSUBKEGIATAN']);
    $sheet->setCellValue('S' . $row, $data['REALISASI_ANGGARAN']);
    $sheet->setCellValue('T' . $row, $data['SUMBER_ANGGARAN']);
    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $sheet->getStyle('A' . $row)->applyFromArray($style_row);
    $sheet->getStyle('B' . $row)->applyFromArray($style_row);
    $sheet->getStyle('C' . $row)->applyFromArray($style_row);
    $sheet->getStyle('D' . $row)->applyFromArray($style_row);
    $sheet->getStyle('E' . $row)->applyFromArray($style_row);
    $sheet->getStyle('F' . $row)->applyFromArray($style_row);
    $sheet->getStyle('G' . $row)->applyFromArray($style_row);
    $sheet->getStyle('H' . $row)->applyFromArray($style_row);
    $sheet->getStyle('I' . $row)->applyFromArray($style_row);
    $sheet->getStyle('J' . $row)->applyFromArray($style_row);
    $sheet->getStyle('K' . $row)->applyFromArray($style_row);
    $sheet->getStyle('L' . $row)->applyFromArray($style_row);
    $sheet->getStyle('M' . $row)->applyFromArray($style_row);
    $sheet->getStyle('N' . $row)->applyFromArray($style_row);
    $sheet->getStyle('O' . $row)->applyFromArray($style_row);
    $sheet->getStyle('P' . $row)->applyFromArray($style_row);
    $sheet->getStyle('Q' . $row)->applyFromArray($style_row);
    $sheet->getStyle('R' . $row)->applyFromArray($style_row);
    $sheet->getStyle('S' . $row)->applyFromArray($style_row);
    $sheet->getStyle('T' . $row)->applyFromArray($style_row);

    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
    $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('N' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('O' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('P' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('Q' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('R' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('S' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getStyle('T' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text left untuk kolom NIS
    $sheet->getRowDimension($row)->setRowHeight(20); // Set height tiap row
    $row++; // Tambah 1 setiap kali looping
}
// Set width kolom
$sheet->getColumnDimension('A')->setWidth(15); // Set width kolom A
$sheet->getColumnDimension('B')->setWidth(10); // Set width kolom B
$sheet->getColumnDimension('C')->setWidth(30); // Set width kolom C
$sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
$sheet->getColumnDimension('E')->setWidth(35); // Set width kolom E
$sheet->getColumnDimension('F')->setWidth(15); // Set width kolom F
$sheet->getColumnDimension('G')->setWidth(40); // Set width kolom G
$sheet->getColumnDimension('H')->setWidth(20); // Set width kolom H
$sheet->getColumnDimension('I')->setWidth(45); // Set width kolom I
$sheet->getColumnDimension('J')->setWidth(25); // Set width kolom J
$sheet->getColumnDimension('K')->setWidth(15); // Set width kolom K
$sheet->getColumnDimension('L')->setWidth(25); // Set width kolom L
$sheet->getColumnDimension('M')->setWidth(25); // Set width kolom M
$sheet->getColumnDimension('N')->setWidth(25); // Set width kolom N
$sheet->getColumnDimension('O')->setWidth(20); // Set width kolom O
$sheet->getColumnDimension('P')->setWidth(10); // Set width kolom P
$sheet->getColumnDimension('Q')->setWidth(20); // Set width kolom Q
$sheet->getColumnDimension('R')->setWidth(35); // Set width kolom R
$sheet->getColumnDimension('S')->setWidth(35); // Set width kolom S
$sheet->getColumnDimension('T')->setWidth(20); // Set width kolom T
// Set orientasi kertas jadi LANDSCAPE
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$sheet->setTitle("Laporan Capaian");
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Capaian Per SKPD.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>