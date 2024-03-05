<section class="content-header"> 

</sction>

        <?php 
                $row = mysqli_fetch_assoc(mysqli_query($conn ,"SELECT * FROM tb_user  "));  
            ?>
<div class="card"> 
    <div class="card-body">
        <form id="#my-form" action="" method="post" enctype="multipart/form-data"  onsubmit="return validate();">
            <div class="form-group row">
                <label for="inputName" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="u" placeholder="Name" value="<?php echo  $row['username']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label">Password Baru</label>
                <div class="col-sm-10">
                <input type="password" class="form-control"  placeholder="Password Baru" id="pw">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputName2" class="col-sm-2 col-form-label">Ketik Ulang Password Baru</label>
                <div class="col-sm-10">
                <input type="password" class="form-control " placeholder="Ketik Ulang Password Baru" id="pw1">
                </div>
            </div> 
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                <input type="submit" class="btn btn-success" value="Simpan ">  
                </div>
            </div>
        </form>
    </div>
</div>        

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="#my-form" action="" method="post" enctype="multipart/form-data"  >
            <div class="modal-header">
            <h4 class="modal-title">Konfirmasi Pergantian Usernam atau Password</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">  
                <input type="hidden" name="username" class="form-control" id="username" placeholder="Masukan Harga Beli" required> 
                <input type="hidden" name="passwordBaru" class="form-control" id="passwordBaru" placeholder="Masukan Harga Beli" required>    
                <div class="form-group">
                    <label for="exampleInputEmail1">Silahkan Masukan Password Untuk Merubah</label>                        
                    <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Masukan Password" required> 
                </div> 
            </div>
            <div class="modal-footer justify-content-between"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="save" class="float-right btn btn-primary" value="Simpan"  > 
            </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
if (isset($_POST['save'])) { 

    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
    $jml =  mysqli_num_rows(mysqli_query($conn, "SELECT*FROM tb_user WHERE password = '$password' "));
    if ($jml==1) {
        
        $username = mysqli_real_escape_string($conn, $_POST['username']); 
        $passwordBaru =hash('md5',mysqli_real_escape_string($conn, $_POST['passwordBaru'])); 

        $s = mysqli_query($conn, "UPDATE tb_user SET  username='$username', password='$passwordBaru'  ");

            if ($s) { 
            echo "<script>
                alert('sukses menyimpan');
                window.location.href='?page=user';
                </script>";
            }else{
                echo "<script>
                alert('proses gagal');
                window.location.href='?page=user';
                </script>";
            }
    } else {
        echo "<script>
            alert('proses gagal password salah');
            window.location.href='?page=user';
        </script>";
    }
    


}

?>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<script>

     function validate() {        
         var u = $('#u').val();
         var password = $('#pw').val();
         var password1 = $('#pw1').val();
         var pswlen = password.length;
         if (pswlen ==0) {
             alert('password tidak boleh kosong');
                 return false;
         }else{
            console.log(password+password1);
             if (password == password1) { 
                //  alert('continue'); 
                    $('#username').val(u);
                    $('#passwordBaru').val(password);
                 $('#modal-add').modal('show');
                 return false;
             }
             else {
                 alert('password tidak sama');
                 $('#pw1').addClass('is-invalid');
                 return false;
             }
         } 
     }
    
</script>