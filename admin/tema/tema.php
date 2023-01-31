<?php

session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='admin'){
  header("location:../../index.php");
}

include "../../koneksi.php";
//tema
$sql = "SELECT * FROM tema";
$hasil = mysqli_query($conn, $sql);

$sql2 = "SELECT COUNT(*) as jumlah_baris FROM tema";
$hasil2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($hasil2);
if($row2['jumlah_baris'] == 0){
    $kosong1 = true;
}else{
    $kosong2 = false;
}

if (isset($_POST["submit"])) {
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    $tema = $_POST["tema"];

    $query = "INSERT INTO tema VALUE
              ('','$tema','$bulan','$tahun')";
    mysqli_query($conn, $query);
    if(mysqli_affected_rows($conn) > 0) {
        echo "
        <script>
        alert('Anda telah berhasil melakukan penambahan tema!');
        document.location.href='tema.php';   
        </script>   
        ";
    } else {
    echo "
        <script>
        alert('Anda gagal melakukan penambahan tema, silahkan coba kembali :(');
        document.location.href='tema.php';   
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
    <title>Tema &mdash; SIMPEL Sumenep</title>

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
                    <a href="tema.php">
                        <span class="icon">
                            <i class="lni lni-pencil-alt text-bold"></i>
                        </span>
                        <span class="text">Isu Strategis</span>
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
                                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
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
                                <h2>Isu Strategis</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper mb-30">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">
                                            <a href="tema.php">Isu Strategis</a>
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
                                <div class="title d-flex justify-content-between align-items-center">
                                    <h6>Tambah Isu Strategis</h6>
                                </div>
                                <div class="content">
                                    <form action="" method="post">
                                        <div class="user-details">
                                            <div class="input-box">
                                                <span class="details">Bulan</span>
                                                <select name="bulan" id="bulan" class="form-select" style="width: 100%; height:45px;" required>
                                                    <option value="Januari">Januari</option>
                                                    <option value="Febuari">Febuari</option>
                                                    <option value="Maret">Maret</option>
                                                    <option value="April">April</option>
                                                    <option value="Mei">Mei</option>
                                                    <option value="Juni">Juni</option>
                                                    <option value="Juli">Juli</option>
                                                    <option value="Agustus">Agustus</option>
                                                    <option value="September">September</option>
                                                    <option value="Oktober">Oktober</option>
                                                    <option value="November">November</option>
                                                    <option value="Desember">Desember</option>
                                                </select>
                                            </div>
                                            <div class="input-box">
                                                <span class="details">Tahun</span>
                                                <input type="text" name="tahun" placeholder="Masukkan tahun" maxlength="4" required />
                                            </div>
                                            <div class="input-box">
                                                <span class="details">Isu Strategis</span>
                                                <input type="text" name="tema" placeholder="Masukkan Isu Strategis" required />
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" name="submit">Tambah</button>
                                    </form>
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
                                    <h6>Isu Strategis Aktif</h6>
                                </div>
                                <?php if(isset($kosong1)) : ?>
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
                                <?php if(isset($kosong2)) :?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Isu Strategis</th>
                                                    <th>Bulan</th>
                                                    <th>Tahun</th>
                                                </tr>
                                                <!-- end table row-->
                                            </thead>
                                            <tbody>
                                                <?php while($row = mysqli_fetch_array($hasil)) : ?>
                                                    <tr>
                                                        <td>
                                                            <li><?=$row['TEMA']?></li>
                                                        </td>
                                                        <td><?=$row['BULAN']?></td>
                                                        <td><?=$row['TAHUN']?></td>
                                                    </tr>
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
                <!-- ========== tables-wrapper 2 end ========== -->
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