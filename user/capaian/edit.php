<?php

session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='user'){
    header("location:../../index.php");
}

include "../../koneksi.php";
//mengmabil id_subkegiatan dan id_tema
$id = $_GET["id"];
$id_subkegiatan = substr($id,0,16);
$id_tem = substr($id,-1);
$id_tema = intval($id_tem);

//subkegiatan
$sql = "SELECT * FROM transaksi WHERE ID_SUBKEGIATAN='$id_subkegiatan' AND ID_TEMA = $id_tema";
$hasil = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($hasil);
//tema
$sql2 = "SELECT * FROM tema WHERE ID_TEMA=$id_tema";
$hasil2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($hasil2);
//klik tombol edit
if(isset($_POST["edit"])) {
    $id_transaksi = $_POST["id_transaksi"];
    //triwulan
    $bulan = $_POST["bulan"];
    if ($bulan == 'January' || $bulan == 'February' || $bulan == 'March'){
        $triwulan = '1';
    }else if ($bulan == 'April' || $bulan == 'May' || $bulan == 'June'){
        $triwulan = '2';
    }else if ($bulan == 'July' || $bulan == 'August' || $bulan == 'September'){
        $triwulan = '3';
    }else if ($bulan == 'October' || $bulan == 'November' || $bulan == 'December'){
        $triwulan = '4';
    }
    $subkegiatan = $row["SUBKEGIATAN"];
    $indikator = $_POST["indikator"];
    $volume = $_POST["volume"];
    $kelompok_sasaran = $_POST["kelompok_sasaran"];
    //kecamatan
    $id_kecamatan = $_POST["kecamatan"];
    $sql3 = "SELECT * FROM kecamatan WHERE ID_KEC=$id_kecamatan";
    $hasil3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_array($hasil3);
    $kecamatan = $row3['KECAMATAN'];
    //desa
    $desa = $_POST["desa"];
    $tagging = $_POST["tagging"];
    $prioritas = $_POST["prioritas"];
    $alokasi_anggaran = $row["ALOKASI_ANGGARAN"];
    $anggaran_tema_persubkegiatan = $_POST["anggaran_tema_persubkegiatan"];
    $realisasi_anggaran = $_POST["realisasi_anggaran"];
    $sumber_anggaran = $_POST["sumber_anggaran"];
    //transaksi
    $query = "UPDATE transaksi SET
              SUBKEGIATAN = '$subkegiatan',
              INDIKATOR = '$indikator', 
              VOLUME = '$volume', 
              KELOMPOK_SASARAN = '$kelompok_sasaran', 
              KECAMATAN = '$kecamatan', 
              DESA = '$desa', 
              TAGGING = '$tagging', 
              PRIORITAS = '$prioritas', 
              ALOKASI_ANGGARAN = '$alokasi_anggaran',
              ANGGARAN_TEMA_PERSUBKEGIATAN = '$anggaran_tema_persubkegiatan',
              REALISASI_ANGGARAN = '$realisasi_anggaran',
              SUMBER_ANGGARAN = '$sumber_anggaran',
              TRIWULAN = '$triwulan'
              WHERE ID_SUBKEGIATAN = '$id_subkegiatan' AND ID_TEMA = $id_tema";
  mysqli_query($conn, $query);
  if(mysqli_affected_rows($conn) > 0) {
    echo "
    <script>
      alert('Data telah diperbarui!');
      document.location.href='subkegiatan.php?id=".$row['ID_KEGIATAN']."';   
    </script>   
    ";
  } else {
    echo "
    <script>
      alert('Gagal melakukan pembaruan data');
      document.location.href='edit.php?id=".$row['ID_SUBKEGIATAN'],$id_tema."';
    </script>
    ";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../../img/logo/favicon.ico" type="image/x-icon">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <title>Capaian &mdash; SIMPEL Sumenep</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/lineicons.css" />
    <link rel="stylesheet" href="../../css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="../../css/fullcalendar.css" />
    <link rel="stylesheet" href="../../css/morris.css" />
    <link rel="stylesheet" href="../../css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../../css/flash.css">
    <link rel="stylesheet" href="../../css/main.css" />
    <link rel="stylesheet" href="../../css/form.css" />
</head>

<body>
    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo">
            <a href="http://bappeda.sumenepkab.go.id/simpel/">
                <img src="../../img/logo/logo.png" width="50%" alt="Logo" />
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item active">
                    <a href="capaian.php">
                        <span class="icon">
                            <i class="lni lni-stats-up"></i>
                        </span>
                        <span class="text">Capaian</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        <header class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-6">
                        <div class="header-left d-flex align-items-center">
                            <div class="menu-toggle-btn mr-20">
                                <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-chevron-left"></i>
                                </button>
                            </div>
                            <span class="status-btn active-btn">Tahun&nbsp;2023</span>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-6">
                        <div class="header-right">
                            <div class="notification-box ml-15 d-none d-md-flex">
                                <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="lni lni-alarm"></i>
                                    <span>0</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                                    <li>
                                        <a>
                                            <div class="content">
                                                <h6>
                                                    SIMPEL
                                                </h6>
                                                <p class="mt-10">
                                                    Tidak ada info terbaru.
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- profile start -->
                            <div class="profile-box ml-15">
                                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-info">
                                        <div class="info">
                                            <h6>User</h6>
                                            <div class="image">
                                                <img src="../../img/avatar/user.png" alt="Avatar" />
                                                <span class="status"><i class="lni lni-checkmark-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <i class="lni lni-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                    <li>
                                        <a href="../../logout.php"><i class="lni lni-exit"></i>Log Out</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- profile end -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <!-- ========== title-wrapper start ========== -->
        <section class="section">
            <div class="container-fluid">
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="titlemb-30">
                                <h2>Capaian</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper mb-30">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                            <a href="capaian.php">Capaian</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a>Program</a> 
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a>Kegiatan</a> 
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="subkegiatan.php?id=<?=$row['ID_KEGIATAN']?>">Subkegiatan</a> 
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Edit
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== title-wrapper end ========== -->

                <!-- ========== tables-wrapper start ========== -->
                <div class="tables-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <a href="subkegiatan.php?id=<?=$row['ID_KEGIATAN']?>" class="mb-4"><i class="lni lni-chevron-left"></i>Kembali</a>
                                <div class="title d-flex justify-content-between align-items-center">
                                    <h6>Edit Detail Subkegiatan</h6>
                                </div>
                                <p class="text-sm">
                                    Isi semua dengan benar dan sesuai :
                                </p>
                                <div class="content">
                                <form action="" method="post">
                                <div class="user-details">
                                    <input type="hidden" name="id_transaksi" value="<?= $row["ID_TRANSAKSI"]; ?>" />
                                    <input type="hidden" name="bulan" value="<?= date('F') ?>" />
                                    <div class="input-box">
                                        <span class="details">Nama Subkegiatan</span>
                                        <input type="text" name="subkegiatan" placeholder="Masukkan nama subkegiatan" value="<?= $row["SUBKEGIATAN"]?>" disabled required />
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Indikator</span>
                                        <input type="text" name="indikator" placeholder="Masukkan indikator" required />
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Volume</span>
                                        <input type="text" name="volume" placeholder="Masukkan volume" required />
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Kelompok Sasaran</span>
                                        <input type="text" name="kelompok_sasaran" placeholder="Masukkan kelompok sasaran" required />
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Kecamatan</span>
                                        <select name="kecamatan" id="kecamatan" class="form-select" style="width: 100%; height:45px;" required>
                                            <?php $tampil=$conn->query("SELECT * FROM kecamatan ORDER BY ID_KEC ASC");
                                                while($t=mysqli_fetch_array($tampil)){
                                                    echo "<option value='$t[ID_KEC]'>$t[KECAMATAN]</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Desa</span>
                                        <select name="desa" id="desa" class="form-select" style="width: 100%; height:45px;" required>
                                            <option value=""></option>                                        
                                        </select>
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Tagging <?= $row2['TEMA']?></span>
                                        <select name="tagging" id="tagging" class="form-select" style="width: 100%; height:45px;" required>
                                            <option value="0"><strong>0</strong> Tidak Berhubungan</option>
                                            <option value="1"><strong>1</strong> Spesifik</option>
                                            <option value="2"><strong>2</strong> Sensitif</option>
                                            <option value="3"><strong>3</strong> Koordinatif</option>
                                        </select>
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Prioritas</span>
                                        <select name="prioritas" id="prioritas" class="form-select" style="width: 100%; height:45px;" required>
                                            <option value="0"><strong>0</strong> TIDAK Prioritas</option>
                                            <option value="1"><strong>1</strong> Prioritas</option>
                                        </select>
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Alokasi Anggaran</span>
                                        <input type="number" name="alokasi_anggaran" placeholder="Masukkan alokasi anggaraan" value="<?= $row["ALOKASI_ANGGARAN"]?>" disabled required />
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Anggararan Tema Persubkegiatan</span>
                                        <input type="number" name="anggaran_tema_persubkegiatan" placeholder="Masukkan anggaran tema persubkegiatan" required />
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Realisasi Anggaran</span>
                                        <input type="number" name="realisasi_anggaran" placeholder="Masukkan reaalisasi anggaran" required />
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Sumber Anggaran</span>
                                        <select name="sumber_anggaran" id="sumber_anggaran" class="form-select" style="width: 100%; height:45px;" required>
                                            <option value="DAU">DAU</option>
                                            <option value="DBH CHT">DBH CHT</option>
                                            <option value="Pajak Rokok">Pajak Rokok</option>
                                            <option value="BK Provinsi">BK Provinsi</option>
                                            <option value="DAK Non Fisik">DAK Non Fisik</option>
                                            <option value="DAK Fisik">DAK Fisik</option>
                                            <option value="DID">DID</option>
                                            <option value="BLUD">BLUD</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="edit">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
                                </form>
                                <!-- end table wrapper -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== tables-wrapper end ========== -->
                <script>
                    $('table').DataTable({
                        'bLengthChange': false,
                        'bFilter': true,
                        'bInfo': false,
                        'bAutoWidth': false
                    });
                </script>
            </div>
        </section>
        <!-- ========== section end ========== -->

        <!-- ========== footer start =========== -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 order-last order-md-first">
                        <div class="copyright text-center text-md-start">
                            <p class="text-sm">
                                &copy; Bappeda Kabupaten Sumenep. 2023.
                            </p>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6">
                        <div
                            class="terms d-flex justify-content-center justify-content-md-end">
                            <p class="text-sm">
                                2.5.0
                            </p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </footer>
        <!-- ========== footer end =========== -->
    </main>
    
    <!-- ========= All Javascript files linkup ======== -->
    <script src="../../js/jquery-3.6.0.min.js"></script>
    <script src="../../js/jquery.mask.min.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/Chart.min.js"></script>
    <script src="../../js/dynamic-pie-chart.js"></script>
    <script src="../../js/moment.min.js"></script>
    <script src="../../js/fullcalendar.js"></script>
    <script src="../../js/jvectormap.min.js"></script>
    <script src="../../js/world-merc.js"></script>
    <script src="../../js/polyfill.js"></script>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="../../js/dataTables.bootstrap5.min.js"></script>
    <script src="../../js/pace.min.js"></script>
    <script src="../../js/main.js"></script>

    <!-- ======== main-wrapper end =========== -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#kecamatan').change(function(){
      	var kec_id = $(this).val();
          	$.ajax({
                type: 'POST',
              	url: "desa.php",
              	data: 'id_kec='+kec_id,
              	success: function(response){
                  $('#desa').html(response);
                }
            });
        });
    });
    </script>

</body>

</html>