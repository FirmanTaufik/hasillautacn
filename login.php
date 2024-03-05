<?php
ob_start();
session_start();
include_once "config/+connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Hasil Laut ACN| Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition  " style="background:url('dist/img/background/background-login.jpg');   background-repeat: no-repeat;overflow-x: hidden;"  >
<div class="row">
    <div class="col-lg-7">
      
    </div>
    <div class="col-lg-5  login-page" style=" background: transparent; "> 
    <div class="login-box">
      <div class="card   card-primary">
        <div class="card-header text-center">
          <a   class="h1"><b>Toko Hasil </b>Laut ACN</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Silahkan Masukan Username dan Password Yang di Berikan Oleh Admin</p>
          <form action="" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="username" placeholder="Username">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password"  placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <input type="submit" name="login" value="Login" class="btn btn-primary btn-block"> 
              </div>
              <!-- /.col -->
            </div>
          </form>
          <?php
            if (isset($_POST['login'])) {
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
            

                $record = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM tb_user WHERE username = '$username' AND password = '$password'"));
                
                if ($record ==1) {
                    $result = mysqli_query($conn, "SELECT*FROM tb_user WHERE username = '$username' AND password = '$password'");
                    while ($row = mysqli_fetch_array($result)) {
                        $_SESSION['username'] = $row['username']; 
                        $_SESSION['level'] = $row['level'];
                        $_SESSION['idUser'] = $row['idUser'];
                    }

                  //   header("location:  ?page=transaksi");
                    echo "<script>
                    alert('Succes to Login');
                    window.location.href='/?page=transaksi';
                    </script>";
                } else {
                    echo "<script>
                    alert('Failed to Login');
                    window.location.href='login.php?status=failed';
                    </script>";
                    // header('location:login.php?status=failed');
                }
                
            }
          ?>

          <p class="mt-3 mb-1"> 
          </p>
        </div>
    <!-- /.login-card-body -->
  </div>
</div>
      </div>
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
