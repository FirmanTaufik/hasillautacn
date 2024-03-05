<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
if ($_GET['act'] == ''){

    
 ?>

<section class="content-header">  
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="" class="table  example table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Bayar</th> 
                                <th>Telah Bayar</th>  
                                <th>Action</th>  
                            </tr>
                        </thead>
                        <tbody class="datafetch" id="tbody">
                        <?php $total =0;
                                $no=1;
                                $d = mysqli_query($conn , "SELECT *FROM tb_history_bayar WHERE idMasuk= '$idMasuk' "); 
                                while ($row = mysqli_fetch_object($d)) {  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td style="text-align:center; "><?php echo dateChange($row->tanggalBayar)  ; ?></td>  
                                    <td><?php echo c($row->telahBayar); ?></td> 
                                    <td> 
                                        <button  data-toggle="modal" data-target="#modal-edit<?php echo $row ->idHistory;  ?>" class="btn btn-primary  btn-sm"  ><i class="fas fa-edit"></i></button>
                                        <a href="?page=historybayar&act=del&id=<?php echo $row ->idHistory;?>&idMasuk=<?php echo $idMasuk; ?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
                                            <button class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i></button>
                                        </a> 
                                    </td>   
                                </tr>

                                <?php       
                                    $total = $row->telahBayar +$total;         
                                    }
                                ?>
                                <tr>        
                                <td></td> 
                                <td style="text-align:right;border-top: solid 1px ;"> <b style="float:right;" >Total Pembayaran</b> </td>
                                <td  style="border-top: solid 1px ;">  <b  id="totalBiaya"><?php echo convert_to_rupiah($total); ?></b>  </td> 
                                <td></td> 
                            </tr> 
                        </tbody>
                        <tfoot>   
                            <!-- <tr>        
                                <td></td> 
                                <td style="text-align:right;border-top: solid 1px ;"> <b style="float:right;" >Total Pembayaran</b> </td>
                                <td  style="border-top: solid 1px ;">  <b  id="totalBiaya"><?php echo convert_to_rupiah($total); ?></b>  </td>
                            </tr>  -->
                        </tfoot>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="" class="table example table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Keuntungan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
                            $w=0;
                            $r=1;
                            $o = mysqli_query($conn , "SELECT  tb_list_masuk.*, tb_barang.namaBarang, tb_barang.hargaJual, 
                            SUM(tb_list_masuk.hargaBeliPcs*tb_list_masuk.qtyMasuk) as total
                            FROM tb_list_masuk
                            LEFT JOIN
                             tb_barang ON tb_list_masuk.idBarang = tb_barang.idBarang
                             WHERE idMasuk ='$idMasuk'
                             GROUP BY idList "); 
                            while ($p = mysqli_fetch_object($o)) {  ?>
                              <tr>
                                  <td><?php echo $r++; ?></td>
                                  <td><?php echo $p->idBarang; ?></td>
                                  <td><?php echo $p->namaBarang; ?></td>
                                  <td><?php echo $p->qtyMasuk; ?></td>
                                  <td><?php echo c($p->hargaBeliPcs); ?></td>
                                  <td><?php echo c($p->hargaJual); ?></td>
                                  <td><?php echo c($p->hargaJual-$p->hargaBeliPcs); ?></td>
                                  <td><?php echo  c($p->qtyMasuk* $p->hargaBeliPcs); ?></td>
                              </tr>      
                       
                            

                        <?php   
                         $w= $p->qtyMasuk * $p->hargaBeliPcs+$w;
                         
                        }
                             
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;">Biaya</td>
                                <td style=" border-top: solid 1px ;"><b  ><?php echo c( $w); ?></td>
                            </tr>
                            <?php 
                                $dis= $w;
                                $b=0;
                                $k= mysqli_query($conn , "SELECT * FROM `tb_discount`  WHERE idMasuk ='$idMasuk'
                                ORDER BY idDiscount ASC "); 
                                while ($u = mysqli_fetch_object($k)) { $b++ ;
                                
                                    $dis = $dis - ($dis*($u->discount/100));
                                
                                ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;"><?php if($b==1){echo"Discount";} ?> </td>
                                <td style=" border-top: solid 1px ;"><b  ><?php echo  $u->discount ."%" ; ?></td>
                            </tr>

                            <?php
                                }
                                ?>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td  ><b  style="float:right;">PPN</td>
                                <?php $ppn = $dis * $jmlPPN/100 ; ?>
                                <td><b  ><?php echo $jmlPPN."%"; ?></td>
                            </tr> 
                            
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td  ><b  style="float:right;">Jumlah Biaya</td>
                                <td><b  ><?php echo c(round($ppn+$dis)); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td  ><b  style="float:right;">Telah di Bayar</td>
                                <td><b  ><?php echo c($total); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"> <b  style="float:right;">Sisa Yang Harus di Bayar</b> </td>
                                <?php $h = $ppn+$dis-$total; ?>
                                <td  style="border-top: solid 1px ;">  <b  id="totalBiaya"><?php echo convert_to_rupiah(round($h)); ?>  </td>
                            </tr>
                        </tbody> 
                    </table>
                </div>
            </div>

        </div>

    </div>
</section>
 
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="modal-header">
            <h4 class="modal-title">Tambah Pembayaran</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">    
                <div class="form-group">
                    <label for="exampleInputEmail1">Tanggal Bayar</label>                        
                    <input type="date" name="tanggalBayar" class="form-control" id="exampleInputEmail1" placeholder="Masukan Tanggal Bayar" required> 
                </div>   
                <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah Bayar</label>
                    <input type="number" name="telahBayar" class="form-control" id="exampleInputEmail1" placeholder="Masukan Jumlah Bayar" required>
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
$d = mysqli_query($conn , "SELECT *FROM tb_history_bayar WHERE idMasuk= '$idMasuk' "); 
 while ($row = mysqli_fetch_object($d)) {  ?>

<div class="modal fade" id="modal-edit<?php echo $row ->idHistory;  ?>">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="modal-header">
            <h4 class="modal-title">Edit Pembayaran</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">   
                <input value="<?php echo $row->idHistory ; ?>" type="text" name="idHistory" class="form-control" id="exampleInputEmail1" placeholder="Masukan Tanggal Bayar" required>  
                <div class="form-group">
                    <label for="exampleInputEmail1">Tanggal Bayar</label>                        
                    <input value="<?php echo $row->tanggalBayar; ?>" type="date" name="tanggalBayar" class="form-control" id="exampleInputEmail1" placeholder="Masukan Tanggal Bayar" required> 
                </div>   
                <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah Bayar</label>
                    <input value="<?php echo $row->telahBayar; ?>"  type="number" name="telahBayar" class="form-control" id="exampleInputEmail1" placeholder="Masukan Jumlah Bayar" required>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="edit" class="float-right btn btn-primary" value="Simpan"> 
            </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php } ?>

<?php


if (isset($_POST['edit'])) { 
    $idHistory = mysqli_real_escape_string($conn, $_POST['idHistory']); 
    $tanggalBayar = mysqli_real_escape_string($conn, $_POST['tanggalBayar']); 
    $telahBayar = mysqli_real_escape_string($conn, $_POST['telahBayar']);  

    $s = mysqli_query($conn, "UPDATE tb_history_bayar SET  tanggalBayar='$tanggalBayar', telahBayar='$telahBayar' WHERE idHistory ='$idHistory' ");

    if ($s) { 
        echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=historybayar&idMasuk=$idMasuk';
        </script>";
    }else{
        echo "<script>
            alert('proses gagal');
            window.location.href='?page=historybayar&idMasuk=$idMasuk';
        </script>";
    }
}

 if (isset($_POST['save'])) { 
    $tanggalBayar = mysqli_real_escape_string($conn, $_POST['tanggalBayar']); 
    $telahBayar = mysqli_real_escape_string($conn, $_POST['telahBayar']);  
    $id = mysqli_real_escape_string($conn, $idMasuk);  

    
    $s =  mysqli_query($conn, "INSERT INTO tb_history_bayar VALUES ('', '$id', '$tanggalBayar', '$telahBayar') ");

    if ($s) { 
        echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=historybayar&idMasuk=$idMasuk';
        </script>";
    }else{
        echo "<script>
            alert('proses gagal');
            window.location.href='?page=historybayar&idMasuk=$idMasuk';
        </script>";
    }
        
}


?> 
 
   
 

<?php
  
} else if ($_GET['act'] == 'del') {
       
        $id =  $_GET['id']; 
        $idMasuk =  $_GET['idMasuk']; 
        $b = mysqli_query($conn, "DELETE  FROM tb_history_bayar WHERE  idHistory  = '$id'"); 
        if ($b) {
            echo "<script>
            alert('Succes di hapus');
            window.location.href='?page=historybayar&idMasuk=$idMasuk';
            </script>";
        } else {
            alert('gagal di hapus');
            echo "<script>alert('Error');window.history.go(-1);</script>";
        }   
        
    }
 
?>



<?php
 function dateChange(  $original_dateTime )
{
    $newDate = date("Y-m-d", strtotime($original_dateTime));
    return $newDate;
}
    function c($angka)
    {
        return strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
    

function convert_to_rupiah($angka)
{
    return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
}
?> 

    
 <script>
     var judulTabel = '<?php  echo '<span  > <h3 id="judul" style="margin-left:50px;"> <b>Tanggal Transaksi :  '.  $judul.'</b> </h3> ';?>';
 </script>