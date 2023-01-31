<?php

session_start();

include "koneksi.php";

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $cek_akun_login = mysqli_query($conn, "SELECT * FROM user WHERE USERNAME='$username'");
    //cek username
    if (mysqli_num_rows($cek_akun_login) == 1) {
      //cek password
      $row = mysqli_fetch_assoc($cek_akun_login);
      if($password == $row["PASSWORD"]) {
        //set session
        if($row['LEVEL']=='admin'){
          $_SESSION['login'] = true;
          $_SESSION['USERNAME'] = $username;
          $_SESSION['POSISI'] = $row['POSISI'];
          $_SESSION['LEVEL'] = $row['LEVEL'];
          echo "
            <script>   
                document.location.href='admin/tema/tema.php';  
            </script>   
            ";
          exit;
        }else if($row['LEVEL']=='user'){
          $_SESSION["login"] = true;
          $_SESSION['USERNAME'] = $username;
          $_SESSION['POSISI'] = $row['POSISI'];
          $_SESSION['LEVEL'] = $row['LEVEL'];
          echo "
            <script>
              document.location.href='user/capaian/capaian.php';   
            </script>   
            ";
          exit;
        }
      }
    }
    $eror = true;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="img/logo/favicon.ico" type="image/x-icon">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <title>Login &mdash; SIMPEL Sumenep</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/lineicons.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>

<body>
    <!-- ========== signin-section start ========== -->
    <section class="signin-section">
        <section class="section">
            <div class="container-fluid">
                <div class="row g-0 auth-row">
                    <div class="col-lg-6">
                        <div class="auth-cover-wrapper bg-primary-100">
                            <div class="auth-cover">
                                <div class="title text-center">
                                    <h1 class="text-primary mb-10">Selamat Datang</h1>
                                    <p class="text-medium">
                                        Sistem Informasi Manajemen Pengendalian, Evaluasi, dan Pelaporan Pembangunan Daerah (SIMPEL) Kabupaten Sumenep
                                    </p>
                                </div>
                                <div class="cover-image text-center">
                                    <img src="img/illustration/data.svg" alt="Background" />
                                </div>
                                <div class="shape-image">
                                    <img src="img/illustration/shape.svg" alt="Shape" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-6">
                        <div class="signin-wrapper">
                            <div class="form-wrapper">
                                <?php if(isset($eror)) : ?>
                                <div class="alert-box danger-alert">
                                    <div class="alert">
                                        <p class="text-medium">
                                            <span class="icon"><i class="lni lni-warning me-2"></i></span>
                                            USERNAME atau PASSWORD salah.
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <span class="status-btn active-btn">Tahun 2023</span>
                                </div>
                                <h6 class="mb-15">Log In</h6>
                                <p class="text-sm mb-25">
                                    Silakan login terlebih dahulu. Kirimkan e-mail ke bappeda.sumenepkab@gmail.com apabila Anda belum memiliki akun.
                                </p>
                                <form method="post" action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-style-3">
                                                <input type="text" placeholder="Username" name="username">
                                                <span class="icon"><i class="lni lni-user"></i></span>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="input-style-3">
                                                <input type="password" placeholder="Password" name="password" id="password">
                                                <span class="icon"><i class="lni lni-key"></i></span>
                                                <span class="icon-right"><i class="lni lni-eye" onclick="showPassword()"></i></span>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                            <div class="form-check checkbox-style mb-30">
                                                <input class="form-check-input" type="checkbox" name="remember" />
                                                <label class="form-check-label" for="checkbox-remember">
                                                    Ingat saya</label>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                            <div
                                                class="text-start text-md-end text-lg-start text-xxl-end mb-30">
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center" name="login">
                                                    Log In
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
<script src="js/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function(){
            if($errors==first('username'))
                $("input[name='username']").focus();
            else if($errors==first('password'))
                $("input[name='password']").focus();
            else
                $("input[name='username']").focus();
            endif
        });

        function showPassword() {
            var x = document.getElementById('password');
            if (x.type === 'password') {
                x.type = 'text';
            } else {
                x.type = 'password';
            }
        }
    </script>
</body>

</html>
