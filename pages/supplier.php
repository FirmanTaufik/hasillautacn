  
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
if ($_GET['act'] == ''){

    
 ?>

<section class="content-header">    

    <div class="card"> 
        <div class="card-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Suplier</th>
                        <th>Nama Supplier</th>
                        <th>No Telepon</th> 
                        <th>Alamat</th>   
                        <th>Total Pembelian</th>  
                        <th>Total Pembayaran</th>  
                        <th>Sisa Harus Bayar</th>  
                        <th  width="100px">Action</th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php 
                    $daftarTransaksi =array();
                    $transaksi =    mysqli_query($conn , "SELECT tb_barang_masuk.* ,  tb_suplier.idSupplier,  
                        tb_suplier.namaSupplier, t1.jumlah, t2.telahBayar
                        FROM tb_barang_masuk 
                        LEFT JOIN (SELECT  tb_list_masuk.idList,  idMasuk, SUM(qtyMasuk*hargaBeliPcs) AS jumlah
                        FROM tb_list_masuk GROUP BY idMasuk ) t1 ON tb_barang_masuk.idMasuk = t1.idMasuk
                        LEFT JOIN (SELECT tb_history_bayar.idHistory, idMasuk, SUM(telahBayar) telahBayar 
                                FROM tb_history_bayar GROUP BY idMasuk) t2 ON tb_barang_masuk.idMasuk = t2.idMasuk
                        LEFT JOIN tb_suplier
                        ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier 
                        WHERE tb_barang_masuk.idSupplier !=0
                        GROUP BY tb_barang_masuk.idMasuk DESC ");
                          while ($row = mysqli_fetch_object($transaksi)) { 

                            $idMasuk =$row ->idMasuk;
                            $dis= $row->jumlah; 
                            $k= mysqli_query($conn , "SELECT * FROM `tb_discount`  WHERE idMasuk ='$idMasuk'
                            ORDER BY idDiscount ASC "); 
                            while ($u = mysqli_fetch_object($k)) {  ;
                            
                                $dis = $dis - ($dis*($u->discount/100));
    
                            }
                            $ppn = $dis * $row->ppn/100 ;
                            array_push($daftarTransaksi, array('idMasuk' =>  $idMasuk , 
                                                    'idSupplier'=> $row ->idSupplier,
                                                    'jumlahTransaksi' => round($ppn+$dis),
                                                     'telahBayar'=> $row->telahBayar,
                                                    'sisa'=>round(($ppn+$dis)- $row->telahBayar)     ));
                          }  

                    $no=1;
                    $d = mysqli_query($conn , "SELECT tb_suplier.*, IFNULL(t1.jmlTelahBayar,0) jmlTelahBayar 
                    FROM tb_suplier
                    LEFT JOIN
                    (SELECT tb_history_bayar.idHistory, tb_barang_masuk.idSupplier,
                     SUM(tb_history_bayar.telahBayar) as jmlTelahBayar
                    FROM tb_history_bayar
                    LEFT JOIN tb_barang_masuk
                    ON tb_history_bayar.idMasuk = tb_barang_masuk.idMasuk
                    GROUP BY idSupplier) t1  on tb_suplier.idSupplier = t1.idSupplier 
                    GROUP BY idSupplier "); 
                    while ($row = mysqli_fetch_object($d)) {  ?>
                     <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row->idSupplier; ?></td>
                        <td><?php echo $row->namaSupplier; ?></td>
                        <td><?php echo $row->noTelponSupplier; ?></td>
                        <td><?php echo $row->alamatSupplier; ?></td>
                        <td><?php echo convert_to_rupiah(getTotalPem($row->idSupplier,$daftarTransaksi)) ; ?></td>
                        <td><?php echo  convert_to_rupiah($row->jmlTelahBayar); ?></td>  

                        <td><?php  $total= $row->jmlHarusBayar-$row->jmlTelahBayar;    if (getTotalPem($row->idSupplier,$daftarTransaksi)-$row->jmlTelahBayar==0) {
                           echo "<span style='margin-left:20px;' class='badge bg-success '>Tidak Ada</span>";
                        } else {
                           
                             echo convert_to_rupiah(getTotalPem($row->idSupplier,$daftarTransaksi)-$row->jmlTelahBayar); 
                        }?>
                        </td>
                        <td>
                            
                            <a href="?page=detailsupplier&id=<?php echo $row ->idSupplier;?>"  >
                                <button class="btn btn-success btn-sm" ><i class="fas fa-eye"></i></button>
                            </a>
                            <button  data-toggle="modal" data-target="#modal-edit<?php echo $row->idSupplier; ?>" class="btn btn-primary  btn-sm"  ><i class="fas fa-edit"></i></button>
                            <a href="?page=supplier&act=del&id=<?php echo $row ->idSupplier;?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
                                <button class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i></button>
                            </a> 
                        </td>
                    </tr>

                    <?php                
                        }
                    ?>
                
                </tbody>
             </table>   

             <?php
            // print_r($daftarTransaksi);
             ?>
        </div>
    </div>
      
</section>
 
<?php 
    $d = mysqli_query($conn , "SELECT * FROM tb_suplier ORDER BY idSupplier DESC  "); 
    while ($row = mysqli_fetch_object($d)) {  ?>
        <div class="modal fade" id="modal-edit<?php echo $row->idSupplier; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data" >
                    <div class="modal-header">
                    <h4 class="modal-title">Tambah Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    
                    <input type="hidden" value="<?php echo $row->idSupplier; ?>" name="id" class="form-control"  >
                    <div class="modal-body">     
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Supplier </label>
                            <input type="text" value="<?php echo $row->namaSupplier; ?>" name="nama" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama Supplier" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telpon</label>                        
                            <input type="text" name="noTelpon" value="<?php echo $row->noTelponSupplier; ?>" class="form-control" id="exampleInputEmail1" placeholder="Masukan No Telpon" required> 
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea class="form-control"  name="alamat" id="" cols="30" rows="5" placeholder="Masukan Alamat"  id="exampleInputEmail1"> <?php echo $row->alamatSupplier; ?></textarea> 
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between"> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         <input type="submit" name="edit" class="float-right btn btn-primary" value="Simpan Perubahan"> 
                    </div>
                </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

<?php
}
?>


<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="modal-header">
            <h4 class="modal-title">Tambah Supplier</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">     
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Supplier </label>
                    <input type="text" name="nama" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama Supplier" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">No Telpon</label>                        
                    <input type="text" name="noTelpon" class="form-control" id="exampleInputEmail1" placeholder="Masukan No Telpon" required> 
                </div> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Alamat</label>
                    <textarea class="form-control" name="alamat" id="" cols="30" rows="5" placeholder="Masukan Alamat"  id="exampleInputEmail1"></textarea> 
                </div>
            </div>
            <div class="modal-footer justify-content-between"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="save" class="float-right btn btn-primary" value="Simpan"> 
            </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php

  
if (isset($_POST['edit'])) { 
    $id = mysqli_real_escape_string($conn, $_POST['id']); 
    $nama = mysqli_real_escape_string($conn, $_POST['nama']); 
    $noTelpon = mysqli_real_escape_string($conn, $_POST['noTelpon']); 
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);  

    $s = mysqli_query($conn, "UPDATE  tb_suplier SET  namaSupplier='$nama',`noTelponSupplier`='$noTelpon',`alamatSupplier`='$alamat' WHERE 
                            idSupplier = '$id' ");

    if ($s) { 
        echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=supplier';
        </script>";
    }else{
        echo "<script>
            alert('proses gagal');
            window.location.href='?page=supplier';
        </script>";
    }
        
}
    if (isset($_POST['save'])) { 
        $nama = mysqli_real_escape_string($conn, $_POST['nama']); 
        $noTelpon = mysqli_real_escape_string($conn, $_POST['noTelpon']); 
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);  

        
        $row = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM tb_suplier WHERE namaSupplier = '$nama' "));

        if ($row==0) { 

            $s = mysqli_query($conn, "INSERT INTO tb_suplier VALUES ('',   '$nama',   '$noTelpon', '$alamat')  ");

            if ($s) { 
                echo "<script>
                    alert('sukses menyimpan');
                    window.location.href='?page=supplier';
                </script>";
            }else{
                echo "<script>
                    alert('proses gagal');
                    window.location.href='?page=supplier';
                </script>";
            }
        } else {
            echo "<script>
                        alert('nama sudah di pakai');
                        window.location.href='?page=supplier';
                    </script>";
        }
            
    }

?>

 
<?php
  
} else if ($_GET['act'] == 'del') {
       
        $id =  $_GET['id']; 
        $del = mysqli_query($conn, "DELETE FROM tb_barang_masuk WHERE idSupplier ='$id' ");
        if ($del) {
            
            $e = mysqli_query($conn, "DELETE  FROM tb_suplier WHERE  idSupplier = '$id'");
            if ($e) {
            
                echo "<script>
                alert('Succes di hapus');
                window.location.href='?page=supplier';
                </script>";
            } else {
                alert('gagal di hapus');
                echo "<script>alert('Error');window.history.go(-1);</script>";
            }
        }
    }
 
?>

<?php
    function convert_to_rupiah($angka)
    {
        return  strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
    
  function getTotalPem($key,$array)
  {
      $jml = 0;
     for ($i=0; $i <count($array) ; $i++) { 
         if ($array[$i]['idSupplier']==$key) {
            $jml= $jml+$array[$i]['jumlahTransaksi'];
         }
     }
       return  $jml;
  }
?> 