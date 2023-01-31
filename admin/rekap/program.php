<?php

session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='admin'){
  header("location:../../index.php");
}

include "../../koneksi.php";
//program
$id = $_GET["id"];
if(strlen($id) == 8){
    $id_skpd = substr($id,0,7);
    $id_tem = substr($id,-1);
    $id_tema = intval($id_tem);
    //program
    $sql = "SELECT * FROM program WHERE ID_SKPD='$id_skpd'";
    $hasil = mysqli_query($conn, $sql);
    $sql5 = "SELECT SUM(ANGGARAN_TEMA_PERSUBKEGIATAN) AS Total_Anggaran_pertema FROM transaksi WHERE ID_SKPD = '$id_skpd' AND ID_TEMA = $id_tema";
    $hasil5 = mysqli_query($conn, $sql5);
    $row5 = mysqli_fetch_array($hasil5);
    $sql7 = "SELECT SUM(REALISASI_ANGGARAN) AS Total_Realisasi FROM transaksi WHERE ID_SKPD = '$id_skpd' AND ID_TEMA = $id_tema";
    $hasil7 = mysqli_query($conn, $sql7);
    $row7 = mysqli_fetch_array($hasil7);
    $sql8 = "SELECT (SUM(ANGGARAN_TEMA_PERSUBKEGIATAN))-(SUM(REALISASI_ANGGARAN)) AS Sisa_Anggaran FROM transaksi WHERE ID_SKPD = '$id_skpd' AND ID_TEMA = $id_tema";
    $hasil8 = mysqli_query($conn, $sql8);
    $row8 = mysqli_fetch_array($hasil8);
    $sql9 = "SELECT KECAMATAN, DESA FROM transaksi WHERE ID_SKPD = '$id_skpd' AND ID_TEMA = $id_tema";
    $hasil9 = mysqli_query($conn, $sql9);
    $hasil9_1 = mysqli_query($conn, $sql9);
}else{
    $id_program = substr($id,0,10);
    $id_tem = substr($id,-1);
    $id_tema = intval($id_tem);
    //program
    $sql1 = "SELECT * FROM program WHERE ID_PROGRAM='$id_program'";
    $hasil1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_array($hasil1);
    $id = $row1['ID_SKPD'];
    $sql = "SELECT * FROM program WHERE ID_SKPD='$id'";
    $hasil = mysqli_query($conn, $sql);
    $sql5 = "SELECT SUM(ANGGARAN_TEMA_PERSUBKEGIATAN) AS Total_Anggaran_pertema FROM transaksi WHERE ID_SKPD = '$id' AND ID_TEMA = $id_tema";
    $hasil5 = mysqli_query($conn, $sql5);
    $row5 = mysqli_fetch_array($hasil5);
    $sql7 = "SELECT SUM(REALISASI_ANGGARAN) AS Total_Realisasi FROM transaksi WHERE ID_SKPD = '$id' AND ID_TEMA = $id_tema";
    $hasil7 = mysqli_query($conn, $sql7);
    $row7 = mysqli_fetch_array($hasil7);
    $sql8 = "SELECT (SUM(ANGGARAN_TEMA_PERSUBKEGIATAN))-(SUM(REALISASI_ANGGARAN)) AS Sisa_Anggaran FROM transaksi WHERE ID_SKPD = '$id' AND ID_TEMA = $id_tema";
    $hasil8 = mysqli_query($conn, $sql8);
    $row8 = mysqli_fetch_array($hasil8);
    $sql9 = "SELECT KECAMATAN, DESA FROM transaksi WHERE ID_SKPD = '$id' AND ID_TEMA = $id_tema";
    $hasil9 = mysqli_query($conn, $sql9);
    $hasil9_1 = mysqli_query($conn, $sql9);
}

if (mysqli_fetch_array($hasil5) && mysqli_fetch_array($hasil7) && mysqli_fetch_array($hasil8) == NULL){
    $tampil1 = true;
} else {
    $tampil2 = false;
} 
if (mysqli_fetch_array($hasil9_1) == NULL){
    $tampil3 = true;
} else {
    $tampil4 = false;
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
    <title>Rekap &mdash; SIMPEL Sumenep</title>

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
                <li class="nav-item">
                    <a href="../tema/tema.php">
                        <span class="icon">
                            <i class="lni lni-pencil-alt text-bold"></i>
                        </span>
                        <span class="text">Tema</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../rencana/rencana.php">
                        <span class="icon">
                            <i class="lni lni-database text-bold"></i>
                        </span>
                        <span class="text">Rencana</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="rekap.php">
                        <span class="icon">
                            <i class="lni lni-library"></i>
                        </span>
                        <span class="text">Rekap</span>
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
                                            <h6><?=$_SESSION['POSISI'] ?></h6>
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
                                <h2>Rekap</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper mb-30">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="rekap.php">Rekap</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Program
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

                <!-- ========== tables-wrapper 1 start ========== -->
                <div class="tables-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <a href="rekap.php" class="mb-4"><i class="lni lni-chevron-left"></i>Kembali</a>
                                <div class="title d-flex justify-content-between align-items-center">
                                    <h6>Program</h6>
                                </div>
                                <!-- end table wrapper -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <h6></h6>
                                                    </th>
                                                </tr>
                                                <!-- end table row-->
                                            </thead>
                                            <tbody>
                                                <?php while($row = mysqli_fetch_array($hasil)) : ?>
                                                    <tr>
                                                        <td>
                                                            <p>
                                                                <a href="kegiatan.php?id=<?=$row['ID_PROGRAM'],$id_tema?>"><?=$row['ID_PROGRAM']," ",$row['PROGRAM']?></a>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                <?php endwhile;  ?>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== tables-wrapper 1 end ========== -->

                <!-- ========== tables-wrapper 2 start ========== -->
                <div class="tables-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <div class="title d-flex justify-content-between align-items-center">
                                    <h6>Dana</h6>
                                </div>
                                <?php if(isset($tampil1)) : ?>
                                    <div class="text-center p-2">
                                        <img src="../../img/illustration/empty.svg" width="40%" alt="Empty">
                                        <h4 class="mb-10">
                                            Data tidak ditemukan
                                        </h4>
                                        <p>
                                            Tema masih kosong dan belum memiliki data.
                                        </p>
                                    </div>
                                <?php endif; ?>
                                <!-- end table wrapper -->
                                <?php if(isset($tampil2)) :?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <!-- end table row-->
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>
                                                            Total Anggaran Per SKPD
                                                        </td>
                                                        <td>
                                                            <?php if ($row5['Total_Anggaran_pertema'] != NULL) : ?>
                                                                <?=$row5['Total_Anggaran_pertema']?>
                                                            <?php else : ?>
                                                                0
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Total Realisasi Anggaran Per SKPD
                                                        </td>
                                                        <td>
                                                            <?php if ($row7['Total_Realisasi'] != NULL) : ?>
                                                                <?=$row7['Total_Realisasi']?>
                                                            <?php else : ?>
                                                                0
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong>Sisa Anggaran Per SKPD</strong>
                                                        </td>
                                                        <td>
                                                            <?php if ($row8['Sisa_Anggaran'] != NULL) : ?>
                                                                <strong><?=$row8['Sisa_Anggaran']?></strong>
                                                            <?php else : ?>
                                                                <strong>0</strong>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== tables-wrapper 2 end ========== -->

                <!-- ========== tables-wrapper 3 start ========== -->
                <div class="tables-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <div class="title d-flex justify-content-between align-items-center">
                                    <h6>Lokasi</h6>
                                </div>
                                <?php if(isset($tampil3)) : ?>
                                    <div class="text-center p-2">
                                        <img src="../../img/illustration/empty.svg" width="40%" alt="Empty">
                                        <h4 class="mb-10">
                                            Data tidak ditemukan
                                        </h4>
                                        <p>
                                            Tema masih kosong dan belum memiliki data.
                                        </p>
                                    </div>
                                <?php endif; ?>
                                <!-- end table wrapper -->
                                <?php if(isset($tampil4)) :?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <!-- end table row-->
                                            </thead>
                                            <tbody>
                                                <?php while($row9 = mysqli_fetch_array($hasil9)) : ?>
                                                    <?php if ($row9['KECAMATAN'] != NULL) :?>
                                                    <tr>
                                                        <td>
                                                            <?=$row9['KECAMATAN']?>
                                                        </td>
                                                        <td>
                                                            <?=$row9['DESA']?>
                                                        </td>
                                                    </tr>
                                                    <?php endif;  ?>
                                                <?php endwhile;  ?>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== tables-wrapper 3 end ========== -->

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
    <script src="../../js/polyfill.js"></script>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="../../js/dataTables.bootstrap5.min.js"></script>
    <script src="../../js/pace.min.js"></script>
    <script src="../../js/main.js"></script>

</body>

</html>