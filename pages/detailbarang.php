<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
if ($_GET['act'] == ''){

    
 ?>

<section class="content-header"> 
    <?php $idBarang= $_GET['id']; ?>
    <div class="card">
        <!-- <div class="card-header">
            <h3 class="card-title">History Masuk Barang <?php  $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_barang WHERE  idBarang  = '$idBarang' "));  echo "<b>". $h['namaBarang']  ."</b>";?></h3>
           

        </div> -->
        <div class="card-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th> 
                        <th>Tanggal Masuk</th>  
                        <th>Jumlah Masuk</th> 
                        <th>Supplier</th>  
                        <th>Harga Beli</th> 
                        <th>Telah Bayar</th> 
                        <th>Sisa Harus Bayar</th> 
                        <th>Action</th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php
                    $no=1;
                    $d = mysqli_query($conn , "SELECT tb_barang_masuk.*, tb_barang.namaBarang , tb_suplier.namaSupplier,tb_barang.hargaJual, t1.telahBayar
                    FROM tb_barang_masuk 
                    LEFT JOIN tb_barang ON tb_barang_masuk.idBarang = tb_barang.idBarang
                    LEFT JOIN tb_suplier ON tb_suplier.idSupplier = tb_barang_masuk.idSupplier
                    LEFT JOIN (SELECT tb_barang_masuk.*, IFNULL(SUM(tb_history_bayar.telahBayar),0) AS telahBayar
                    FROM tb_barang_masuk 
                    LEFT JOIN tb_history_bayar ON 
                    tb_barang_masuk.idMasuk = tb_history_bayar.idMasuk
                    GROUP BY idMasuk)  t1 ON t1.idMasuk= tb_barang_masuk.idMasuk
                    WHERE tb_barang_masuk.idBarang = '$idBarang'
                    GROUP BY idMasuk DESC"); 
                    while ($row = mysqli_fetch_object($d)) {  ?>
                     <tr>
                        <td><?php echo $no++; ?></td> 
                        <td><?php echo $row->tanggalMasuk; ?></td>  
                        <td><?php echo $row->qtyMasuk; ?> Pcs</td>
                        <td><?php echo $row->namaSupplier; ?></td> 
                        <td><?php echo convert_to_rupiah($row->hargaBeliPcs*$row->qtyMasuk); ?></td>
                        <td><?php echo convert_to_rupiah($row->telahBayar); ?></td>
                        <td><?php  $total = $row->hargaBeliPcs*$row->qtyMasuk-$row->telahBayar; if ($total==0) {
                           echo "<span style='margin-left:20px;' class='badge bg-success '>Lunas</span>";
                        } else {
                           
                             echo convert_to_rupiah($total); 
                        }?>
                        </td>
                        <td> 
                            <a href="?page=historybayar&idMasuk=<?php echo $row ->idMasuk ;?>">
                                <button class="btn btn-success btn-sm"  ><i class="fas fa-eye"></i></button>
                            </a>
                            <button  data-toggle="modal" data-target="#modal-edit<?php echo $row ->idMasuk;  ?>" class="btn btn-primary  btn-sm"  ><i class="fas fa-edit"></i></button>
                            <a href="?page=detailbarang&id=<?php echo $idBarang; ?>&act=del&idMasuk=<?php echo $row ->idMasuk;?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
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
    $d = mysqli_query($conn , "SELECT tb_barang_masuk.*, tb_barang.namaBarang , tb_suplier.namaSupplier
    FROM tb_barang_masuk 
    LEFT JOIN tb_barang ON tb_barang_masuk.idBarang = tb_barang.idBarang
    LEFT JOIN tb_suplier ON tb_suplier.idSupplier = tb_barang_masuk.idSupplier
    WHERE tb_barang_masuk.idBarang = '$idBarang'
    GROUP BY idMasuk"); 
    while ($row = mysqli_fetch_object($d)) {  ?>
<div class="modal fade" id="modal-edit<?php echo $row ->idMasuk;  ?>">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="#my-form" action="" method="post" enctype="multipart/form-data"  >
            <div class="modal-header">
            <h4 class="modal-title">Edit Barang Masuk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">     
                <input value="<?php echo $row ->idMasuk;  ?>" type="hidden" name="idMasuk" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>  
                 <div class="form-group">
                  <label>Supplier</label>
                    <select id="supplier" name="supplier" class="form-control    " style="width: 100%;"  >
                        <option selected="selected"  value="0">Pilih Supplier</option>
                        <?php 
                         $d3 = mysqli_query($conn , "SELECT * FROM  tb_suplier"); 
                         while ($row3 = mysqli_fetch_object($d3)) {  ?>
                        <option  <?php if ($row ->idSupplier == $row3 ->idSupplier) { echo "selected"; } ?> value="<?php echo $row3 ->idSupplier;  ?>"> <?php echo $row3 ->namaSupplier ?></option> 
                        <?php } ?>
                    </select>
                </div> 
                    <label for="exampleInputEmail1">Qty Masuk  Per Pcs</label>   
                <div class="form-group input-group mb-3">                         
                    <input value="<?php echo $row ->qtyMasuk;  ?>" type="number" name="qtyMasuk" class="form-control" id="exampleInputEmail1" placeholder="Masukan Jumlah" required> 
                    <!-- <div class="input-group-append">
                        <span class="input-group-text">Dus</span>
                    </div> -->
                </div> 
                <div class="form-group">
                    <label for="hargaBeli">  Harga Beli Per Pcs</label>                        
                    <input value="<?php echo $row ->hargaBeliPcs;  ?>" type="number" name="hargaBeliPcs" class="form-control" id="hargaBeliPcs" placeholder="Masukan Harga Beli" required> 
                </div>   
            </div>
            <div class="modal-footer justify-content-between"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="edit" class="float-right btn btn-primary" value="Simpan"  > 
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
    $idMasuk = mysqli_real_escape_string($conn, $_POST['idMasuk']);  
    $supplier = mysqli_real_escape_string($conn, $_POST['supplier']);  
    $qtyMasuk = mysqli_real_escape_string($conn, $_POST['qtyMasuk']); 
    $hargaBeliPcs = mysqli_real_escape_string($conn, $_POST['hargaBeliPcs']);   

    $s = mysqli_query($conn, "UPDATE tb_barang_masuk SET   idSupplier='$supplier',qtyMasuk='$qtyMasuk',hargaBeliPcs='$hargaBeliPcs' 
                             WHERE idMasuk = '$idMasuk' ");

                            echo $hargaJual;

    if ($s) { 
        echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=detailbarang&id=$idBarang';
        </script>";
    }else{
        echo "<script>
            alert('proses gagal');
            window.location.href='?page=detailbarang&id=$idBarang';
        </script>";
    }
}

?>

<?php
  
} else if ($_GET['act'] == 'del') {
       
        $id =  $_GET['idMasuk']; 
        $idBarang =  $_GET['id']; 
        $e = mysqli_query($conn, "DELETE  FROM tb_barang_masuk WHERE  idMasuk = '$id'");
            if ($e) {
            
                echo "<script>
                alert('Succes di hapus');
                window.location.href='?page=detailbarang&id=$idBarang';
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
        return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
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