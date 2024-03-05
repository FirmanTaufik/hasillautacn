<?php 
ob_start();
session_start();
 if (empty($_SESSION['username'])) {
   header("location:   /login.php");
 exit;

 }
include_once "config/+connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Hasil Laut ACN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <style>
  .select2-selection__rendered {
    line-height: 30px !important;
    }
    .select2-container .select2-selection--single {
        height: 40px !important;  
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
    table.dataTable td {
      padding:3px;
    }
    
    @media print {
                .hidden-print,
                .hidden-print * {
                    display: none !important;
                }
            }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
   <?php  include "pages/navbar.php";?>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Toko Hasil Laut ACN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex"  data-toggle="modal" data-target="#modal-defaultProfil">
        <div class="image"> 
          <img src="dist/img/user/admin.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username'];?> </a>
        </div>
      </div> 
 

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library --> 
            <li class="nav-item">
            <a href="?page=transaksi" class="nav-link <?php if($_GET['page']=="transaksi") {echo "active";} ?>">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Transaksi Penjualan
              </p>
            </a> 
          </li>
            <li class="nav-item">
            <a href="?page=transaksipembelian" class="nav-link <?php if($_GET['page']=="transaksipembelian") {echo "active";} ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                 Transaksi Pembelian 
              </p>
            </a> 
          </li> 
          </li>
            <li class="nav-item">
            <a href="?page=barang" class="nav-link <?php if($_GET['page']=="barang") {echo "active";} ?>">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Data Barang
              </p>
            </a> 
          </li> 
          </li>
            <li class="nav-item">
            <a href="?page=satuanbarang" class="nav-link <?php if($_GET['page']=="satuanbarang") {echo "active";} ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Satuan Barang
              </p>
            </a> 
          </li> 
            <li class="nav-item">
            <a href="?page=supplier" class="nav-link <?php if($_GET['page']=="supplier") {echo "active";} ?>">
              <i class="nav-icon fas fa-truck-moving"></i>
              <p>
                Supplier 
              </p>
            </a> 
          </li> 
            <li class="nav-item">
            <a href="?page=pelanggan" class="nav-link <?php if($_GET['page']=="pelanggan") {echo "active";} ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Pelanggan 
              </p>
            </a> 
          <li class="nav-item <?php if($_GET['page']=="laporan"||$_GET['page']=="jatuhtempo"||$_GET['page']=="laporanpembelian"||$_GET['page']=="stockbarang"  ||$_GET['page']=="laporanmasuk" || $_GET['page']=="laporankeluar"|| $_GET['page']=="laporanpendapatan") {echo "menu-open";} ?> ">
            <a href="#" class="nav-link  <?php if($_GET['page']=="laporan"||$_GET['page']=="laporanpembelian"||$_GET['page']=="stockbarang"  ||$_GET['page']=="laporanmasuk" || $_GET['page']=="laporankeluar"|| $_GET['page']=="laporanpendapatan") {echo "active";} ?>">
              <i class="nav-icon far fa-file-archive"></i>
              <p>
                Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=jatuhtempo" class="nav-link  <?php if($_GET['page']=="jatuhtempo") {echo "active";} ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Jatuh Tempo </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=laporan" class="nav-link  <?php if($_GET['page']=="laporan") {echo "active";} ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Pembelian </p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="?page=laporankeluar" class="nav-link  <?php if($_GET['page']=="laporankeluar") {echo "active";} ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Penjualan</p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="?page=stockbarang" class="nav-link  <?php if($_GET['page']=="stockbarang") {echo "active";} ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Stock Barang  </p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="?page=laporanmasuk" class="nav-link  <?php if($_GET['page']=="laporanmasuk") {echo "active";} ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Barang Masuk</p>
                </a>
              </li>-->
              <!-- <li class="nav-item">
                <a href="?page=laporanpembelian" class="nav-link  <?php if($_GET['page']=="laporanpembelian") {echo "active";} ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Pembelian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=laporanpendapatan" class="nav-link  <?php if($_GET['page']=="laporanpendapatan") {echo "active";} ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Penjualan</p>
                </a>
              </li> -->
            </ul>
          </li>
          </li>
            <li class="nav-item">
            <a href="?page=user" class="nav-link <?php if($_GET['page']=="user") {echo "active";} ?>">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                User Management 
              </p>
            </a> 
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i> 
              <p>
                Logout 
              </p>
            </a> 
          </li> 
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
      
        switch ($_GET['page']) {
          case'': 
          case 'transaksi':            
            include "pages/transaksi.php";
          //  echo "dakndakn";
            break;
          case 'supplier':            
            include "pages/supplier.php";
            break;
          case 'barang':            
              include "pages/barang.php";
            break; 
          case 'detailbarang':            
              include "pages/detailbarang.php";
            break; 
          case 'transaksibaru':            
              include "pages/transaksibaru.php";
            break; 
          case 'pelanggan':            
              include "pages/pelanggan.php";
            break; 
          case 'edittransaksi':            
              include "pages/edittransaksi.php";
            break; 
          case 'laporanmasuk':            
              include "pages/laporanmasuk.php";
            break; 
          case 'laporankeluar':            
              include "pages/laporankeluar.php";
            break; 
          case 'laporanpendapatan':            
              include "pages/laporanpendapatan.php";
            break; 
          case 'laporanpembelian':            
              include "pages/laporanpembelian.php";
            break; 
          case 'detailtransaksi':            
              include "pages/detailtransaksi.php";
            break; 
          case 'historybayar':            
              include "pages/historybayar.php";
            break; 
          case 'user':            
              include "pages/user.php";
            break; 
          case 'stockbarang':            
              include "pages/stockbarang.php";
            break; 
          case 'detailsupplier':            
              include "pages/detailsupplier.php";
            break; 
          case 'transaksipembelian':            
              include "pages/transaksipembelian.php";
            break; 
          case 'pembelianbaru':            
              include "pages/pembelianbaru.php";
            break; 
          case 'editpembelian':            
              include "pages/editpembelian.php";
            break; 
          case 'detailpembelian':            
              include "pages/detailpembelian.php";
            break; 
          case 'laporan':            
              include "pages/laporan.php";
            break; 
          case 'detailtransaksicash':            
              include "pages/detailtransaksicash.php";
            break; 
          case 'jatuhtempo':            
              include "pages/jatuhtempo.php";
            break; 
          case 'satuanbarang':            
              include "pages/satuanbarang.php";
            break;            
        }
      
        

      ?>
  </div>
  <!-- /.content-wrapper -->

    <!-- modal profil -->
 
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- AdminLTE App -->
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script> 
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script> 
   
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>   
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>  


<script src="plugins/select2/js/select2.full.min.js"></script>
<script>
 $(function () {
  $('.select2').select2();
  
  $('#example3').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ]
    } );
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "paging":false,"bInfo": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  
  $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true },
            { extend: 'print', footer: true }
        ]
    } );

    $('.example').DataTable( {
        dom: 'Bfrtip',
      "ordering": false,
      "searching": false, 
      "paging": false,
        buttons: [
            { extend: 'copyHtml5',title: 'dad', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true },
            { extend: 'print', footer: true }
        ] 
    } );

    // $('.example').DataTable( {
    //     dom: 'Bfrtip',
    //   "ordering": false,
    //   "searching": false,
    //   "tittle":"fafa",
    //   "paging": false,
    //     buttons: [
    //         { extend: 'copyHtml5', footer: true },
    //         { extend: 'excelHtml5', footer: true },
    //         { extend: 'csvHtml5', footer: true },
    //         { extend: 'pdfHtml5', footer: true },
    //         { extend: 'print', footer: true }
    //     ],
    //     "dom": '<"toolbar">frtip'
    // } );
} );

$(function () { 

    $('#reservationdatetime').datetimepicker({ 
            icons: { 
              time: 'far fa-clock' }, 
              use24hours: true,
              format: 'YYYY/MM/DD HH:mm:ss'  
              // date: new Date()
            });

    }); 

$(document).ready(function()   { 
  $(".select2-selection--single").css("display", "none"); 
        var myDiv = $(".dt-buttons")[1];
        $(myDiv).append(judulTabel)  ;
      //  $(myDiv).find('.dt-buttons').after(judulTabel);
       // console.log(judulTabel);
});
  
$("#nama2").hide();  
$("#baru").on("change", function(){
      $("#nama2").hide();  
       $("#nama").show().attr("required","");  
      $(".select2-selection--single").css("display", "none");
      $("#transaksiNo").removeAttr("disabled");   
      $("#transaksiAlamat").removeAttr("disabled");   
      $("#transaksiNo").val("");
      $("#transaksiAlamat").val("");
      $("#hargaJual").val("");

      
      $("#transaksiNoAlternatif").removeAttr("disabled");   
      $("#transaksiNoAlternatif").val("");
      $("#transaksiNoKtp").removeAttr("disabled");   
      $("#transaksiNoKtp").val("");
      $("#transaksiNoKk").removeAttr("disabled");   
      $("#transaksiNoKk").val("");
  });

$("#lama").on("change", function(){
    $("#nama").hide().removeAttr("required");  
      $("#nama2").show();   
      $(".select2-selection--single").css("display", "block");
       $("#transaksiNo").show().attr("disabled","");  
       $("#transaksiAlamat").show().attr("disabled","");  

       $("#transaksiNoAlternatif").show().attr("disabled","");  
       $("#transaksiNoKtp").show().attr("disabled","");  
       $("#transaksiNoKk").show().attr("disabled","");  

      $("#transaksiNo").val( $("#nama2").find(':selected').data('no')); 
      $("#transaksiAlamat").val( $("#nama2").find(':selected').data('alamat'));

      $("#transaksiNoAlternatif").val( $("#nama2").find(':selected').data('noalter'));
      $("#transaksiNoKtp").val( $("#nama2").find(':selected').data('noktp'));
      $("#transaksiNoKk").val( $("#nama2").find(':selected').data('nokk'));
 
      $("#hargaBeli").val("");
      $("#telahBayar").val("");
      $("#sisaBayar").val("");
});
</script>

<script type="text/javascript">
$(document).ready(function () {

    $("#nama2").change(function () {
      var cntrol = $(this);
      $("#transaksiNo").val(cntrol.find(':selected').data('no')); 
      $("#transaksiAlamat").val(cntrol.find(':selected').data('alamat'));
      $("#transaksiNoAlternatif").val( cntrol.find(':selected').data('noalter'));
      $("#transaksiNoKtp").val( cntrol.find(':selected').data('noktp'));
      $("#transaksiNoKk").val( cntrol.find(':selected').data('nokk'));
    //  control.val(false); 
  
      });

});
</script>
  

</body>
</html>
