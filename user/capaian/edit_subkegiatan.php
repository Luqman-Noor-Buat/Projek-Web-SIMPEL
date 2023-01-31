<?php

session_start();
//cek login level admin
if(!isset($_SESSION["login"]) || $_SESSION['LEVEL']!='user'){
  header("location:../../index.php");
}

include "../../koneksi.php";

//subkegiatan
$id = $_GET["id"];
$sql1 = "SELECT * FROM subkegiatan WHERE ID_KEGIATAN='$id'";
$hasil1 = mysqli_query($conn, $sql1);

$sql21 = "SELECT * FROM transaksi WHERE ID_KEGIATAN='$id'";
$hasil21 = mysqli_query($conn, $sql21);

$hasil3 = mysqli_query($conn, $sql1);
$row3 = mysqli_fetch_array($hasil3);
//tema
$sql2 = "SELECT * FROM tema";
$hasil2 = mysqli_query($conn, $sql2);

if(isset($_POST["pilih"])) {
    $id_subkegiatan = $_POST["subkegiatan"];
    $id_tema = $_POST["tema"];
    foreach ($id_subkegiatan as $isi){
        //subkegiatan
        $sql10 = "SELECT * FROM subkegiatan WHERE ID_SUBKEGIATAN='$isi'";
        $hasil10 = mysqli_query($conn, $sql10);
        $row10 = mysqli_fetch_array($hasil10);
        $subkegiatan = $row10['SUBKEGIATAN'];
        $id_kegiatan = $row10['ID_KEGIATAN'];
        $alokasi_anggaran = $row10['ALOKASI_ANGGARAN'];
        //kegiatan
        $sql11 = "SELECT * FROM kegiatan WHERE ID_KEGIATAN='$id_kegiatan'";
        $hasil11 = mysqli_query($conn, $sql11);
        $row11 = mysqli_fetch_array($hasil11);
        $id_program = $row11['ID_PROGRAM'];
        //program
        $sql12 = "SELECT * FROM program WHERE ID_PROGRAM='$id_program'";
        $hasil12 = mysqli_query($conn, $sql12);
        $row12 = mysqli_fetch_array($hasil12);
        $id_skpd = $row12['ID_SKPD'];

        //cek id_subkegiatan sudah ada atau belum
        $cek_id_subkegiatan = mysqli_query($conn, "SELECT ID_TEMA, ID_SUBKEGIATAN FROM transaksi WHERE ID_TEMA = $id_tema AND ID_SUBKEGIATAN = '$isi'");
        if(mysqli_fetch_assoc($cek_id_subkegiatan)) {
        echo "
            <script>
                alert('ID_SUBKEGIATAN $isi dengan ID_TEMA $id_tema telah ada, silahkan pilih ID lain!')
                document.location.href='edit_subkegiatan.php?id=$id';
            </script>";
            return false;}
        $query = "INSERT INTO transaksi VALUE
                ('',$id_tema, '$id_skpd', '$id_program', '$id_kegiatan', '$isi', '$subkegiatan',
                NULL, NULL, NULL, NULL, NULL, NULL, NULL, $alokasi_anggaran, NULL, NULL, NULL, NULL)";
        mysqli_query($conn, $query);
    }
    
    if(mysqli_affected_rows($conn) > 0) {
      echo "
      <script>
        alert('Data telah diperbarui!');
        document.location.href='subkegiatan.php?id=$id';   
      </script>   
      ";
    } else {
      echo "
      <script>
        alert('Data gagal diperbarui!');
        document.location.href='edit_subkegiatan.php?id=$id';   
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
                                            <a href="subkegiatan.php?id=<?=$row3['ID_KEGIATAN']?>">Subkegiatan</a> 
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Edit Subkegiatan
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

                <!-- ========== tables-wrapper 2 start ========== -->
                <div class="tables-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <a href="subkegiatan.php?id=<?=$row3['ID_KEGIATAN']?>" class="mb-4"><i class="lni lni-chevron-left"></i>Kembali</a>
                                <div class="title d-flex justify-content-between align-items-center">
                                    <h6>Tema</h6>
                                </div>
                                <form action="" method="post">
                                <div class="user-details">
                                    <div class="input-box">
                                        <p class="text-sm">Pilih Tema</p>
                                        <select name="tema" id="tema" class="form-select" style="width: 100%; height:45px;" required>
                                            <?php while($row2 = mysqli_fetch_array($hasil2)) : ?>
                                                <option value="<?=$row2['ID_TEMA']?>"><?=$row2['TEMA']?></option>
                                            <?php endwhile;  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="title d-flex justify-content-between align-items-center mt-5">
                                    <h6>Edit Subkegiatan</h6>
                                </div>
                                <p class="text-sm">Beberapa Subkegiatan :</p>
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
                                            <?php $urutan = 1;?>
                                            <?php while($row = mysqli_fetch_array($hasil1)) : ?>
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="<?=$row["ID_SUBKEGIATAN"]?>" id="subkegiatan<?=$urutan?>" name="subkegiatan[]">
                                                            <label class="form-check-label" for="subkegiatan<?=$urutan?>">
                                                                <p><a><?=  $row["ID_SUBKEGIATAN"], " ", $row["SUBKEGIATAN"]; ?></a></p>
                                                                <?php $urutan++; ?>
                                                            </label>
                                                        </div>                    
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <!-- end table -->
                                </div>
                                <button class="btn btn-primary" type="submit" name="pilih">&nbsp;Pilih&nbsp;</button>
                                </form>
                                <!-- end table wrapper -->
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