<?php

session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='admin'){
  header("location:../../index.php");
}

include "../../koneksi.php";
//bidang
$id = $_GET["id"];
if(strlen($id) == 4){
    $sql = "SELECT * FROM skpd WHERE ID_BIDANG='$id'";
    $hasil = mysqli_query($conn, $sql);
}else{
    $sql1 = "SELECT * FROM skpd WHERE ID_SKPD='$id'";
    $hasil1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_array($hasil1);
    $id = $row1['ID_BIDANG'];
    $sql = "SELECT * FROM skpd WHERE ID_BIDANG='$id'";
    $hasil = mysqli_query($conn, $sql);
}
//tema
$sql2 = "SELECT * FROM tema";
$hasil2 = mysqli_query($conn, $sql2);
//excel
if(isset($_POST["excel"])) {
    $id_tema = $_POST["tema"];
    $id_triwulan = $_POST["triwulan"];
    echo "
    <script>
      document.location.href='excel.php?id=$id_tema$id_triwulan';   
    </script>   
    ";
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
    <title>Rencana &mdash; SIMPEL Sumenep</title>

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
</html>
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
                <li class="nav-item active">
                    <a href="rencana.php">
                        <span class="icon">
                            <i class="lni lni-database text-bold"></i>
                        </span>
                        <span class="text">Rencana</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../rekap/rekap.php">
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
                                <h2>Rencana</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper mb-30">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="rencana.php">Rencana</a>
                                        </li>
                                        <li class="breadcrumb-item" aria-current="page">
                                            <a href="bidang.php?id=<?=$id?>">Bidang</a> 
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            SKPD
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
                                <a href="bidang.php?id=<?=$id?>" class="mb-4"><i class="lni lni-chevron-left"></i>Kembali</a>
                                <div class="title d-flex justify-content-between align-items-center">
                                    <h6>SKPD</h6>
                                </div>
                                <p class="text-sm">
                                    Beberapa SKPD (Satuan Kerja Perangkat Daerah) :
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
                                            <?php while($row = mysqli_fetch_array($hasil)) : ?>
                                                <tr>
                                                    <td>
                                                        <p>
                                                            <a href="program.php?id=<?=$row['ID_SKPD']?>"><?=  $row["ID_SKPD"], " ", $row["SKPD"]; ?></a>
                                                        </p>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <!-- end table -->
                                </div>
                                <!-- end table wrapper -->
                                <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong"><i class="lni lni-printer"></i> Excel</button>
                                <!-- Popup -->
                                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="application" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Pilih Tema </h5>
                                    </div>
                                    <form action="" method="post">
                                    <div class="modal-body">
                                        <select name="tema" id="tema" class="form-select" style="width: 100%; height:45px;" required>
                                            <?php while($row2 = mysqli_fetch_array($hasil2)) : ?>
                                                <option value="<?=$row2['ID_TEMA']?>"><?=$row2['TEMA']?></option>
                                            <?php endwhile;  ?>
                                        </select>   
                                    </div>
                                    <div class="modal-body">
                                        <select name="triwulan" id="triwulan" class="form-select" style="width: 100%; height:45px;" required>
                                            <option value="1">Triwulan 1 (Januari - Maret)</option>
                                            <option value="2">Triwulan 2 (April - Juni)</option>
                                            <option value="3">Triwulan 3 (Juli - September)</option>
                                            <option value="4">Triwulan 4 (Oktober - Desember)</option>
                                        </select>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="excel" style="background-color: rgb(33,115,70);"><i class="lni lni-printer"></i> Excel</button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
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

    <!-- ========= Tambahan untuk Pop Up ======== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>