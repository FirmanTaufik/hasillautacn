
 <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

    if ($_GET['act'] == '') {


?>
<section class="content-header">
    <div class="card">
        <div class="card-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>No Telpon</th>
                        <th>No Telpon Alternatif</th>
                        <th>No KTP</th>
                        <th>No KK</th>
                        <th>Alamat</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    $d = mysqli_query($conn, "SELECT * FROM tb_pelanggan   ");
                    while ($row = mysqli_fetch_object($d)) {  ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row->namaPelanggan; ?></td>
                            <td><?php echo $row->noTelponPelanggan; ?></td>
                            <td><?php echo $row->noTelponPelangganAlternatif; ?></td>
                            <td><?php echo $row->noKtp; ?></td>
                            <td><?php echo $row->noKk; ?></td>
                            <td><?php echo $row->alamatPelanggan; ?></td>
                            <td>
                                <button data-toggle="modal" data-target="#modal-edit<?php echo $row->idPelanggan;  ?>" class="btn btn-primary  btn-sm"><i class="fas fa-edit"></i></button>
                                <button data-toggle="modal" data-target="#modal-delete<?php echo $row->idPelanggan;  ?>" class="btn btn-danger  btn-sm"><i class="fas fa-trash"></i></button>

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

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="#my-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pelanggan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input value=" " type="hidden" name="id" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Pelanggan </label>
                        <input value=" " type="text" name="nama" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No Telpon</label>
                        <input value=" " type="text" name="noTelpon" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No Telepon Alternatif</label>
                        <input value=" " type="text" name="noTelponPelangganAlternatif" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No KTP</label>
                        <input value=" " type="text" name="noKtp" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No KK</label>
                        <input value=" " type="text" name="noKk" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat</label>
                        <textarea class="form-control" name="alamat" id="" cols="30" rows="5"> </textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="simpan" class="float-right btn btn-primary" value="Simpan">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
$d = mysqli_query($conn, "SELECT * FROM `tb_pelanggan`  ");
while ($row = mysqli_fetch_object($d)) {  ?>

<div class="modal fade" id="modal-delete<?php echo $row->idPelanggan;  ?>" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content"> 
      <div class="modal-body">
       <center><i style="color:orange" class="fa fa-exclamation-circle fa-5x"  ></i> <h3>Melakukan Penghapusan Pelanggan Mungkin Akan Berdampak ke Data Yang Lain!!</h3></center>
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="?page=pelanggan&act=del&id=<?php echo $row->idPelanggan; ?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
        <button type="button" class="btn btn-danger">Lanjutkan Hapus</button>
                                      </a>
      
      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="modal-edit<?php echo $row->idPelanggan;  ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="#my-form" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Pelanggan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input value="<?php echo $row->idPelanggan;  ?>" type="hidden" name="id" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pelanggan </label>
                            <input value="<?php echo $row->namaPelanggan;  ?>" type="text" name="nama" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telpon</label>
                            <input value="<?php echo $row->noTelponPelanggan;  ?>" type="text" name="noTelpon" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telepon Alternatif</label>
                            <input value="<?php echo $row->noTelponPelangganAlternatif;  ?>" type="text" name="noTelponPelangganAlternatif" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No KTP</label>
                            <input value="<?php echo $row->noKtp;  ?>" type="text" name="noKtp" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No KK</label>
                            <input value="<?php echo $row->noKk;  ?>" type="text" name="noKk" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea class="form-control" name="alamat" id="" cols="30" rows="5"><?php echo $row->alamatPelanggan;  ?></textarea>
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


} else if ($_GET['act'] == 'del') {

    $id =  $_GET['id'];
    $e = mysqli_query($conn, "DELETE  FROM tb_pelanggan WHERE  idPelanggan  = '$id'");
    if ($e) {

        echo "<script>
        alert('Succes di hapus');
        window.location.href='?page=pelanggan';
        </script>";
    } else {
        alert('gagal di hapus');
        echo "<script>alert('Error');window.history.go(-1);</script>";
    }
} 

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $noTelpon = mysqli_real_escape_string($conn, $_POST['noTelpon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $noTelponPelangganAlternatif = mysqli_real_escape_string($conn, $_POST['noTelponPelangganAlternatif']);
    $noKtp = mysqli_real_escape_string($conn, $_POST['noKtp']);
    $noKk = mysqli_real_escape_string($conn, $_POST['noKk']);

    $row = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM tb_pelanggan WHERE namaPelanggan = '$nama' "));

    if ($row == 0) {

        $s = mysqli_query($conn, "INSERT INTO tb_pelanggan VALUES ('',   '$nama',   '$noTelpon',
                    '$noTelponPelangganAlternatif', '$noKtp', '$noKk', '$alamat')  ");

        if ($s) {
            echo "<script>
                alert('sukses menyimpan');
                window.location.href='?page=pelanggan';
            </script>";
        } else {
            echo "<script>
                alert('proses gagal');
                window.location.href='?page=pelanggan';
            </script>";
        }
    } else {
        echo "<script>
                    alert('nama sudah di pakai');
                    window.location.href='?page=pelanggan';
                </script>";
    }
}
if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $noTelpon = mysqli_real_escape_string($conn, $_POST['noTelpon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $noTelponPelangganAlternatif = mysqli_real_escape_string($conn, $_POST['noTelponPelangganAlternatif']);
    $noKtp = mysqli_real_escape_string($conn, $_POST['noKtp']);
    $noKk = mysqli_real_escape_string($conn, $_POST['noKk']);

    $s = mysqli_query($conn, "UPDATE tb_pelanggan SET noTelponPelangganAlternatif='$noTelponPelangganAlternatif',noKtp='$noKtp',noKk='$noKk',
             namaPelanggan='$nama',noTelponPelanggan='$noTelpon',alamatPelanggan= '$alamat' 
                    WHERE idPelanggan ='$id' ");

    if ($s) {
        echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=pelanggan';
        </script>";
    } else {
        echo "<script>
            alert('proses gagal');
            window.location.href='?page=pelanggan';
        </script>";
    }
}
?>