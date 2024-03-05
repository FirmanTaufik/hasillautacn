<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
if ($_GET['act'] == ''){

    
 ?>

<section class="content-header">  
    <div class="row">
        <div class="col-lg-12">

            <?php 
                $idTransaksi= $_GET['id'];   
                $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.*, 
                IFNULL(t1.jumlah,0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                FROM tb_transaksi 
                                LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
(tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                           FROM tb_jual GROUP BY  tb_jual.idTransaksi ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                           FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                               
                WHERE tb_transaksi.idTransaksi = '$idTransaksi'
                GROUP BY idTransaksi"));       
            ?>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?php echo $h['namaPelanggan'];?></td>  

                            <td>No KK</td>
                            <td>:</td>
                            <td><?php echo $h['noKk'];?></td>  
                        </tr>
                        <tr>
                            <td>No Telpon</td>
                            <td>:</td>
                            <td><?php echo $h['noTelponPelanggan'];?></td>  
                            
                            <td>No KTP</td>
                            <td>:</td>
                            <td><?php echo $h['noKtp'];?></td>  
                        </tr>
                        <tr>
                            <td>No Telpon Alternatif</td>
                            <td>:</td>
                            <td><?php echo $h['noTelponPelangganAlternatif'];?></td>  

                            <td>Alamat</td>
                            <td>:</td>
                            <td><?php echo $h['alamatPelanggan'];?></td>  
                        </tr>
                        <tr>
                            <td>Tendor Kredit</td>
                            <td>:</td>
                            <td><?php echo $h['jenisTransaksi'];?> Bulan</td>  

                            <td>Perbulan</td>
                            <td>:</td>
                            <?php $total = $h['jumlah']- ($h['jumlah']*$h['hDiscount']/100); ?>

                            <td><?php echo c($total/ $h['jenisTransaksi']);?></td>  
                        </tr>
                    </table> 
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="" class="table  example table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jatuh Tempo</th> 
                                <th>Telah Bayar</th>  
                                <th>Action</th>  
                            </tr>
                        </thead>
                        <tbody class="datafetch" id="tbody">
                        <?php $totalByar =0;
                                $no=1;
                                $d = mysqli_query($conn , "SELECT *FROM tb_kredit_bayar WHERE idTransaksi= '$idTransaksi' "); 
                                while ($row = mysqli_fetch_object($d)) {  ?>

                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td style="text-align:center; "><?php echo dateChange($row->tanggalBayar)  ; ?></td>  
                                    <td><?php echo c($row->telahBayar); ?></td> 
                                    <td> 
                                    <button onclick="popupwindow(<?php echo $idTransaksi;?>,<?php echo  $row->tanggalBayar; ?>,<?php echo $row ->idKredit;?>,<?php echo $no; ?>)" class="btn btn-success btn-sm"><i class="fas fa-print"></i></button>
 
                                        <button  data-toggle="modal" data-target="#modal-edit<?php echo $row ->idKredit;  ?>" class="btn btn-primary  btn-sm"  ><i class="fas fa-edit"></i></button>
                                        <a href="?page=detailtransaksi&act=del&id=<?php echo $row ->idKredit ;?>&idTransaksi=<?php echo $idTransaksi; ?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
                                            <button class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i></button>
                                        </a> 
                                    </td>   
                                </tr>

                                <?php      
                                    $no++; 
                                    $totalByar = $row->telahBayar +$totalByar;         
                                    }
                                ?>
                                <tr>        
                                <td></td> 
                                <td style="text-align:right;border-top: solid 1px ;"> <b style="float:right;" >Total Pembayaran</b> </td>
                                <td  style="border-top: solid 1px ;">  <b  id="totalBiaya"><?php echo convert_to_rupiah($totalByar); ?></b>  </td> 
                                <td></td> 
                            </tr> 
                        </tbody> 
                        
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
                                <th>Jenis</th>
                                <th>Qty</th> 
                                <th>Harga Satuan</th> 
                                <th>Harga Jual</th> 
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
                            $w=0;
                            $r=1;
                            $o = mysqli_query($conn , "SELECT tb_jual.* ,tb_barang.idBarang, 
                            tb_barang.namaBarang, tb_barang.jenis
                            FROM tb_jual
                            left JOIN tb_barang ON tb_jual.idBarang = tb_barang.idBarang
                            WHERE tb_jual.idTransaksi = '$idTransaksi'
                            GROUP BY tb_jual.idJual "); 
                            while ($p = mysqli_fetch_object($o)) {  ?>
                              <tr>
                                  <td><?php echo $r++; ?></td>
                                  <td><?php echo $p->idBarang; ?></td>
                                  <td><?php echo $p->namaBarang; ?></td>
                                  <td><?php if ($p->jenis==1) {
                                echo "Furniture";
                            }else{ echo "Elektronik"; } ?></td>
                                  <td><?php echo $p->qty; ?></td> 
                                  <td><?php echo $p->hargaSatuan; ?></td> 
                                  <?php $totH = $p->hargaSatuan*$p->qty ?>
                                  <td><?php echo c($totH); ?></td>  
                                  <td><?php echo  $p->discount; ?>%</td>  

                                  <?php $total = $totH - ($totH*$p->discount/100); 
                                     $w = $total + $w;
                                  ?>
                                  
                                  <td><?php echo  c($total); ?></td>
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
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;">   Biaya </td>
                                <td style=" border-top: solid 1px ;"><b  ><?php echo   c($w ); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;"> Discount </td>
                                <td style=" border-top: solid 1px ;"><b  ><?php echo  $h['hDiscount'] ."%" ; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td  ><b  style="float:right;">  Jumlah Biaya </td>
                                <?php  $tot = $w - ($w*$h['hDiscount']/100);  ?>
                                <td  ><b  ><?php echo  c($tot); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td   ><b  style="float:right;"> Telah di Bayar </td> 
                                <td  ><b  ><?php echo  c($totalByar); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;"> Sisa Yang Harus di Bayar	 </td> 
                                <td style=" border-top: solid 1px ;"><b  ><?php echo  c($tot-$totalByar); ?></td>
                            </tr>
                        </tbody> 
                    </table>
                </div>
            </div>

        </div>

    </div>
</section>
<script type="text/javascript">
    function popupwindow(id,tgl, idKredit, ke) {
        var w = 600;
        var h=800;
        var left = (screen.width/2)-(600/2);
        var top = (screen.height/2)-(800/2); 
        return window.open('https://hasillautacn.my.id/pages/print_kwitansi_tagihan.php?id='+id+'&idBayar='+idKredit+'&iuranke='+ke+'&jt='+tgl+' ', 'dads', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

    } 

</script>
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
$d = mysqli_query($conn , "SELECT *FROM tb_kredit_bayar WHERE idTransaksi= '$idTransaksi' "); 
 while ($row = mysqli_fetch_object($d)) {  ?>

<div class="modal fade" id="modal-edit<?php echo $row ->idKredit;  ?>">
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
                <input value="<?php echo $row->idKredit; ?>" type="hidden" name="idKredit" class="form-control" id="exampleInputEmail1" placeholder="Masukan Tanggal Bayar" required>  
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
    $id = mysqli_real_escape_string($conn, $_POST['idKredit']); 
    $tanggalBayar = mysqli_real_escape_string($conn, $_POST['tanggalBayar']); 
    $telahBayar = mysqli_real_escape_string($conn, $_POST['telahBayar']);  

    $s = mysqli_query($conn, "UPDATE tb_kredit_bayar SET  tanggalBayar='$tanggalBayar', telahBayar='$telahBayar' WHERE idKredit ='$id' ");

   
    if ($s) { 
        echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=detailtransaksi&id=$idTransaksi';
        </script>";
    }else{
        echo "<script>
            alert('proses gagal');
            window.location.href='?page=detailtransaksi&id=$idTransaksi';
        </script>";
    }
}

 if (isset($_POST['save'])) { 
    $id = mysqli_real_escape_string($conn, $idTransaksi);  
    $tanggalBayar = mysqli_real_escape_string($conn, $_POST['tanggalBayar']); 
    $telahBayar = mysqli_real_escape_string($conn, $_POST['telahBayar']);  
    $s =  mysqli_query($conn, "INSERT INTO tb_kredit_bayar VALUES ('', '$id', '$tanggalBayar', '$telahBayar') ");

    if ($s) { 
        echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=detailtransaksi&id=$id';
        </script>";
    }else{
        echo "<script>
            alert('proses gagal');
            window.location.href='?page=detailtransaksi&id=$id';
        </script>";
    }
        
}


?> 
 
   
 

<?php
  
} else if ($_GET['act'] == 'del') {
       
        $id =  $_GET['id']; 
        $idTransaksi =  $_GET['idTransaksi']; 
        $b = mysqli_query($conn, "DELETE  FROM tb_kredit_bayar WHERE  idKredit  = '$id'"); 
        if ($b) {
            echo "<script>
            alert('Succes di hapus');
            window.location.href='?page=detailtransaksi&id=$idTransaksi';
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