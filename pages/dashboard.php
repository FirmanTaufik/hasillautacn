
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content justify-content-center">
    <h3 class="text-center">Hallo <?php echo $_SESSION['username'];  ?>, Akses Kamu Adalah Seorang <?php  if (  $_SESSION['level']=='1') { echo 'Manager';  }else if (  $_SESSION['level']=='2') { echo 'Admin';  } else {  echo 'Marketing';  }  ?> </h3>
    <br> 
    <div class="row">
          <h1>ini dashboard</h1>
     

    </section>
    <!-- /.content -->