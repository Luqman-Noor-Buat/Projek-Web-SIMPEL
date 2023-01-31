<?php

session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='user'){
  header("location:../../index.php");
}

include "../../koneksi.php";
//subkegiatan
$id = $_GET["id"];
$id_subkegiatan = substr($id,0,16);
$id_tem = substr($id,-1);
$id_tema = intval($id_tem);

$sql = "SELECT * FROM transaksi WHERE ID_TEMA = $id_tema AND ID_SUBKEGIATAN='$id_subkegiatan'";
$hasil = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($hasil);
//tema
$sql2 = "SELECT * FROM tema WHERE ID_TEMA=$id_tema";
$hasil2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($hasil2);
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
                                            Detail
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
                                    <h6>Detail</h6>
                                </div>
                                <p class="text-sm">
                                    Detail Kegiatan :
                                </p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h6>Uraian</h6>
                                                </th>
                                            </tr>
                                            <!-- end table row-->
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td>
                                                        <?php if($row["ALOKASI_ANGGARAN"] != NULL) :?>
                                                        <p>
                                                            <a href="">Status : <strong style="color:red;">Terlaksana</strong></a>
                                                        </p>
                                                        <?php endif;?>
                                                        <?php if($row["ALOKASI_ANGGARAN"] == NULL) :?>
                                                        <p>
                                                            <a href="">Status : <strong style="color:red;">Tidak Terlaksana</strong></a>
                                                        </p>
                                                        <?php endif;?>
                                                        <p>
                                                            <a href="">Nama Subkegiatan : <span style="color:red;"><?= $row["SUBKEGIATAN"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Indikator : <span style="color:red;"><?= $row["INDIKATOR"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Volume : <span style="color:red;"><?= $row["VOLUME"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Kelompok Sasaran : <span style="color:red;"><?= $row["KELOMPOK_SASARAN"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Kecamatan : <span style="color:red;"><?= $row["KECAMATAN"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Desa : <span style="color:red;"><?= $row["DESA"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Tagging <?=$row2['TEMA']?> : <span style="color:red;"><?= $row["TAGGING"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Prioritas : <span style="color:red;"><?= $row["PRIORITAS"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Alokasi Anggaran : <span style="color:red;"><?= $row["ALOKASI_ANGGARAN"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Realisasi Anggaran : <span style="color:red;"><?= $row["REALISASI_ANGGARAN"]?></span></a>
                                                        </p>
                                                        <p>
                                                            <a href="">Sumber Anggaran : <span style="color:red;"><?= $row["SUMBER_ANGGARAN"]?></span></a>
                                                        </p>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                    <!-- end table -->
                                </div>
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
    <!-- ======== main-wrapper end =========== -->

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

</body>

</html>