<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
if ($_GET['act'] == ''){
?>
<section class="content-header"> 
    <div class="card">
        <!-- <div class="card-header">
            <h3 class="card-title">History Masuk Barang <?php  $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_barang WHERE  idBarang  = '$idBarang' "));  echo "<b>". $h['namaBarang']  ."</b>";?></h3>
           

        </div> -->
        <div class="card-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kode Transaksi</th> 
                        <th>No Refrensi</th>
                        <th>Jumlah Transaksi</th> 
                        <th>Telah di Bayar</th> 
                        <th>Sisa Harus di Bayar</th> 
                        <th width="100px;">Action</th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php
                       $totTrans= 0;
                       $totTel= 0;
                       $totSis= 0;
               $no=1;
               $d = mysqli_query($conn , "SELECT tb_barang_masuk.* ,  tb_suplier.idSupplier,  tb_suplier.namaSupplier, t1.jumlah, t2.telahBayar
               FROM tb_barang_masuk 
               LEFT JOIN (SELECT  tb_list_masuk.idList,  idMasuk, SUM(qtyMasuk*hargaBeliPcs) AS jumlah
               FROM tb_list_masuk GROUP BY idMasuk ) t1 ON tb_barang_masuk.idMasuk = t1.idMasuk
               LEFT JOIN (SELECT tb_history_bayar.idHistory, idMasuk, SUM(telahBayar) telahBayar 
                         FROM tb_history_bayar GROUP BY idMasuk) t2 ON tb_barang_masuk.idMasuk = t2.idMasuk
               LEFT JOIN tb_suplier
               ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier 
               WHERE tb_barang_masuk.idSupplier = $idSupplier
               GROUP BY tb_barang_masuk.idMasuk DESC "); 
                    while ($row = mysqli_fetch_object($d)) {  ?>
                     <tr>
                     <td><?php echo $no++; ?></td>
                        <td><?php echo $row->tanggalMasuk; ?></td>
                        <td><?php echo $row->idMasuk; ?></td>
                        <td><?php echo $row->noRef; ?></td>
                            <?php 
                            $idMasuk =$row ->idMasuk;
                            $dis= $row->jumlah; 
                            $k= mysqli_query($conn , "SELECT * FROM `tb_discount`  WHERE idMasuk ='$idMasuk'
                            ORDER BY idDiscount ASC "); 
                            while ($u = mysqli_fetch_object($k)) {  ;
                            
                                $dis = $dis - ($dis*($u->discount/100));

                            }
                            $ppn = $dis * $row->ppn/100 ;
                            $tt = $ppn+$dis;
                            ?>
                        <td><?php echo convert_to_rupiah(round($tt)); ?></td>
                        <td><?php echo convert_to_rupiah(round($row->telahBayar)); ?></td>
                        <td><?php echo convert_to_rupiah(round(($tt)- $row->telahBayar)); ?></td>
                        <td> 
                            <a href="?page=historybayar&idMasuk=<?php echo $row ->idMasuk ;?>">
                                <button class="btn btn-success btn-sm"  ><i class="fas fa-eye"></i></button>
                            </a>
                            <a href="?page=editpembelian&id=<?php echo $row ->idMasuk;?>">
                                <button class="btn btn-primary btn-sm"  ><i class="fas fa-edit"></i></button>
                            </a>
                            <a href="?page=detailsupplier&id=<?php echo $idSupplier; ?>&act=del&idMasuk=<?php echo $row ->idMasuk;?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
                                <button class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i></button>
                            </a> 
                        </td>
                    </tr>

                    <?php                
                        }
                    ?>
                
                </tbody>
             </table>   
        </div>
    </div>
</section>    
 

<?php
  
} else if ($_GET['act'] == 'del') {
       
        $id =  $_GET['id']; 
        $idMasuk =  $_GET['idMasuk'];  
    
        $j = mysqli_query($conn, "DELETE  FROM tb_barang_masuk WHERE  idMasuk = '$idMasuk'");
        if ($j) {
            
            echo "<script>
            alert('Succes di hapus');
            window.location.href='?page=detailsupplier&id=$id';
            </script>";
        } else {
            alert('gagal di hapus');
            echo "<script>alert('Error');window.history.go(-1);</script>";
        }
        
    }
 
?>

<?php
    function convert_to_rupiah($angka)
    {
        return  strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
?>    


<script src="plugins/jquery/jquery.min.js"></script>
 <script type="text/javascript">
         
  
 
            $("#telahBayar").change(function () {
                var hargaBeli = $('#hargaBeli').val();
                var telahBayar = $('#telahBayar').val();
                var total = parseFloat(hargaBeli)-parseFloat(telahBayar);
                $('#sisaBayar').val(total);

            });
 
    </script>

    
