<ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li> 
      <li  class="nav-item" style="margin-top:3px;"> 
        <h3> <?php
      
      switch ($_GET['page']) {
        case'': 
        case 'transaksi':            
          
          echo "Data Transaksi";
          break;
        case 'supplier':            
            echo "Data Supplier";
          break;
        case 'barang':           
            echo "Data Barang";
          break; 
        case 'detailbarang':            
            echo "Detail Barang ";
           $idBarang= $_GET['id'];  
            $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_barang WHERE  idBarang  = '$idBarang' "));  echo "<b>". $h['namaBarang']  ."</b>";
          break; 
        case 'transaksibaru':            
            echo "Tambah Transaksi";
          break; 
        case 'pelanggan':            
            echo "Data Pelanggan";
          break; 
        case 'edittransaksi':            
            echo "Edit Transaksi";
          break; 
        case 'laporanmasuk':           
            echo "Laporan Barang Masuk";
          break; 
        case 'laporankeluar':            
            echo "Laporan Barang Keluar";
          break; 
        case 'laporanpendapatan':            
            echo "Laporan Penjualan";
          break; 
        case 'laporanpembelian':            
            echo "Laporan Pembelian";
          break; 
        case 'detailtransaksi':    
          $idTransaksi= $_GET['id'];   
          $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tb_transaksi.idTransaksi, 
           tb_transaksi.tanggalTransaksi,tb_transaksi.hDiscount,  tb_pelanggan.namaPelanggan 
          FROM tb_transaksi 
          LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
          WHERE idTransaksi = '$idTransaksi'
          GROUP BY idTransaksi"));       
          echo "History Pembayaran Penjualan ";
          break; 
        case 'historybayar':    
          $idMasuk= $_GET['idMasuk'];  
           $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT  tb_barang_masuk.*, tb_suplier.namaSupplier
           from tb_barang_masuk
               LEFT JOIN 
                   tb_suplier ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier
                      WHERE idMasuk='$idMasuk'
                      GROUP BY idMasuk DESC"));  
             $judul =$h['tanggalMasuk'];        
             $jmlPPN =$h['ppn'];     
            echo "History Pembayaran Pembelian <b>".$h['namaSupplier']. " (".$h['tanggalMasuk']. ") </b>";
          break; 
        case 'user':            
            echo "Edit User Management";
          break; 
        case 'stockbarang':            
            echo "Stock Barang";
          break; 
        case 'detailsupplier':       
           $idSupplier= $_GET['id'];  
            $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM  tb_suplier WHERE idSupplier='$idSupplier'"));    
            echo "Detail Supplier <b> ".$h['namaSupplier']."</b>" ; 
          break; 
        case 'transaksipembelian':            
            echo "Transaksi Pembelian";
            break;  
        case 'pembelianbaru':            
            echo "Tambah Transaksi Pembelian";
            break;   
        case 'editpembelian':            
            echo "Edit Transaksi Pembelian";
            break;  
        case 'detailpembelian':            
            echo "Detail Transaksi Pembelian";
            break;
          case 'laporan':            
            echo "Laporan Pembelian";
            break;
          case 'detailtransaksicash':            
            echo "Detail Transaksi";
            break;
          case 'jatuhtempo':            
            echo "Laporan Jatuh Tempo";
            break;
          case 'satuanbarang':            
            echo "Data Satuan Barang";
            break;
        
        
      }
    
      

    ?></h3>
    </li>
</ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto"> 

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown" style="margin-top:3px;">
        <?php
         switch ($_GET['page']) {
          case 'satuanbarang':             
            echo "<button class='btn btn-lg   float-right btn-success btn-sm'   data-toggle='modal' data-target='#modal-add'> Tambah Satuan Barang </button> ";
          break; 
          case 'barang':             
            echo "<button class='btn btn-lg   float-right btn-success btn-sm' id='mdladd' data-toggle='modal' data-target='#modal-add'> Tambah Barang </button> ";
          break; 
          case 'pelanggan':            
            echo "<button class='btn btn-lg    float-right btn-success btn-sm' data-toggle='modal' data-target='#modal-add'> Tambah Pelanggan </button> ";
          break; 

          case 'supplier':            
              echo "<button class='btn btn-lg    float-right btn-success btn-sm' data-toggle='modal' data-target='#modal-add'> Tambah Supplier </button> ";
            break; 
          case'transaksi':
              echo "<form   method='post'>  <input type='submit' name='generate' class='btn btn-lg float-right btn-success btn-sm' value='Tambah Transaksi Penjualan'> ";

              break;
          case 'historybayar':             
            echo "<button class='btn btn-lg    float-right btn-success btn-sm' data-toggle='modal' data-target='#modal-add'> Tambah Pembayaran </button> ";
          break; 
          case'transaksipembelian':
              echo "<form   method='post'>  <input type='submit' name='generatebeli' class='btn btn-lg float-right btn-success btn-sm' value='Tambah Transaksi Pembelian'> ";
              break; 
        case 'detailtransaksi':   
          ?> 
          <a style="margin-left:10px;" href="https://yuliajayasupplier.com/pages/print_transaksi_penjulana.php?id=<?php echo $_GET['id'];?>" rel="noopener" target="_blank" class=" float-right btn btn-default"><i class="fas fa-print"></i> Print</a>
           <a class='btn     float-right btn-success btn-sm' data-toggle='modal' data-target='#modal-add'> Tambah Pembayaran </a>       
          
          <?php
          break;

         }?> 
      </li> 
      
      <li class="nav-item"> 
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
       
    </ul>

    <?php 
            
            if (isset($_POST['generatebeli'])) { 
                $eksekusi = mysqli_query($conn, "INSERT INTO tb_barang_masuk VALUES ('', NOW(), '0','0','0')");
                $id = mysqli_insert_id($conn);
                
                if ($eksekusi) {
                    $_SESSION['idMasuk'] = $id;
                    echo "<script>window.location.href='?page=pembelianbaru';
                    </script>";
                } else { 
                    echo mysqli_error($conn);
                }
            }
        ?>
    


            <?php 
            
                if (isset($_POST['generate'])) { 
                    $eksekusi = mysqli_query($conn, "INSERT INTO tb_transaksi VALUES ('', NOW(), '0','0','0')");
                    $id = mysqli_insert_id($conn);
                    
                    if ($eksekusi) {
                        $_SESSION['idTransaksi'] = $id;
                        echo "<script>window.location.href='?page=transaksibaru';
                        </script>";
                    } else { 
                        echo mysqli_error($conn);
                    }
                }
            ?>