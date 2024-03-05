   
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
                        <th>Nama Satuan</th>
                        <th>Jumlah Barang</th>  
                        <th  width="100px">Action</th>
                    </tr>
                </thead>
            
                <tbody> 
                    <?php
                     $no=1;
                        $data =  mysqli_query($conn , "SELECT tb_satuan_barang.* , ifnull(COUNT(tb_barang.idSatuanBarang),0) jml
                        FROM tb_satuan_barang
                        left JOIN tb_barang ON
                        tb_satuan_barang.id = tb_barang.idSatuanBarang
                        GROUP BY tb_satuan_barang.id asc");
                        while ($row = mysqli_fetch_object($data)) {  

                         
                    ?>
                     <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row->namaSatuan; ?></td> 
                        <td><?php echo $row->jml; ?></td> 
                        <td> 
                            <button  data-toggle="modal" data-target="#modal-edit<?php echo $row->id ; ?>" class="btn btn-primary  btn-sm"  ><i class="fas fa-edit"></i></button>
                            <a href="?page=satuanbarang&act=del&id=<?php echo $row ->id ;?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
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
      
</section>
   
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="modal-header">
            <h4 class="modal-title">Tambah Satuan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">     
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Satuan </label>
                    <input type="text" name="nama" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama Satuan" required>
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
    $d = mysqli_query($conn , "SELECT * FROM `tb_satuan_barang`     "); 
    while ($row = mysqli_fetch_object($d)) {  ?>

    <div class="modal fade" id="modal-edit<?php echo $row->id; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                <h4 class="modal-title">Edit Satuan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">    
                    <input type="hidden" name="id" value="<?php echo $row->id; ?>" id=""> 
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Satuan </label>
                        <input value="<?php echo $row->namaSatuan; ?>" type="text" name="nama" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama Satuan" required>
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
<?php
}
?>

<?php

  
if (isset($_POST['edit'])) { 
    $nama = mysqli_real_escape_string($conn, $_POST['nama']); 
    $id = mysqli_real_escape_string($conn, $_POST['id']);  

        
    $row = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM tb_satuan_barang WHERE namaSatuan = '$nama' "));

    if ($row==0) { 

        $s = mysqli_query($conn, "UPDATE `tb_satuan_barang` SET  `namaSatuan`='$nama' WHERE id= '$id' ");

        if ($s) { 
            echo "<script>
                alert('sukses menyimpan');
                window.location.href='?page=satuanbarang';
            </script>";
        }else{
            echo "<script>
                alert('proses gagal');
                window.location.href='?page=satuanbarang';
            </script>";
        }
    } else {
        echo "<script>
                    alert('nama sudah di pakai');
                    window.location.href='?page=satuanbarang';
                </script>";
    }
    
} 

  if (isset($_POST['save'])) { 
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);   

        
        $row = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM tb_satuan_barang WHERE namaSatuan = '$nama' "));

        if ($row==0) { 

            $s = mysqli_query($conn, "INSERT INTO tb_satuan_barang VALUES ('',   '$nama'   )  ");

            if ($s) { 
                echo "<script>
                    alert('sukses menyimpan');
                    window.location.href='?page=satuanbarang';
                </script>";
            }else{
                echo "<script>
                    alert('proses gagal');
                    window.location.href='?page=satuanbarang';
                </script>";
            }
        } else {
            echo "<script>
                        alert('nama sudah di pakai');
                        window.location.href='?page=satuanbarang';
                    </script>";
        }
            
    }
?>

<?php
}else if ($_GET['act'] == 'del') {
       
    $id =  $_GET['id']; 
    $e = mysqli_query($conn, "DELETE  FROM tb_satuan_barang WHERE  id = '$id'");
    if ($e) {
    
        echo "<script>
        alert('Succes di hapus');
        window.location.href='?page=satuanbarang';
        </script>";
    } else {
        alert('gagal di hapus');
        echo "<script>alert('Error');window.history.go(-1);</script>";
    }
}
?>