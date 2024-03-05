
<?php
if ( $_SESSION['idTransaksi']==null) {
  echo "<script> 
        window.location.href='?page=transaksi';
    </script>";
}
?>
<script>
     var products = [];
</script>
<section class="content-header">
    <?php  $id=  $_SESSION['idTransaksi'] ;  
         $result = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE idTransaksi  = '$id' ");
         $row = mysqli_fetch_assoc($result); 
      ?> 

    <div class="card">
        <!-- <div class="card-header">       
        </div> -->
        <form action="" method="post">
            <div class="card-body">
                
                 <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Penjualan</label>
                            <input type="disable" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php  echo  $_SESSION['idTransaksi'] ;  ?> " disabled>
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal</label>
                            <!-- <input type="datetime-local" class="form-control" id="exampleInputEmail1"    value="<?php echo $row['tanggalTransaksi']; ?>"> -->
                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                <input value="<?php echo $row['tanggalTransaksi']; ?>" name="tanggalTransaksi"  type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div> 
                            <label>Pelanggan</label>
                        <div class="row" style=" width:90%; margin: auto; "> 
                             
                            <div class="col-6">
                                    <input class="form-check-input" type="radio" name="jenisBarang" value="1" id="baru" checked>
                                    <label class="form-check-label">  Baru</label>
                            </div>
                            <div class="col-6">
                                    <input class="form-check-input" type="radio" name="jenisBarang" value="2" id="lama">
                                    <label class="form-check-label">  Lama</label>
                            </div> 
                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <label>Nama Pelanggan</label>
                            <input value="-" type="text" name="nama" id="nama" class="form-control" id="exampleInputEmail1" placeholder="Masukan Nama Pelanggan" required>
                            <select  id="nama2"  name="nama2"  class="form-control select2"   style="width: 100%;">
                                <option  value="0">Pilih Pelanggan</option>
                                <?php 
                                    $d = mysqli_query($conn , "SELECT * FROM  tb_pelanggan"); 
                                    while ($row = mysqli_fetch_object($d))  {  ?>
                                    <option value="<?php echo $row ->idPelanggan;  ?>"   data-noalter="<?php echo $row ->noTelponPelangganAlternatif;  ?>"   data-noktp="<?php echo $row ->noKtp;  ?>"    data-nokk="<?php echo $row ->noKk;  ?>"   data-no="<?php echo $row ->noTelponPelanggan;  ?>"  data-alamat="<?php echo $row ->alamatPelanggan;  ?>"> <?php echo $row ->namaPelanggan ?></option> 
                                <?php } ?> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telepon</label> 
                            <input value="-" name="noTelpon" type="text" class="form-control" id="transaksiNo" placeholder="No Telpon" value=" "  >
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telepon Alternatif</label> 
                            <input value="-" name="noTelponPelangganAlternatif" type="text" class="form-control" id="transaksiNoAlternatif" placeholder="No Telpon Alternatif" value=" "  >
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">No KTP</label> 
                            <input value="-" name="noKtp" type="text" class="form-control" id="transaksiNoKtp" placeholder="No KTP" value=" "  >
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">No KK</label> 
                            <input value="-" name="noKk" type="text" class="form-control" id="transaksiNoKk" placeholder="No KK" value=" "  >
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea   class="form-control" name="alamat" id="transaksiAlamat"  rows="3">-</textarea> 
                        </div>

                    </div>
                    <div style="margin-top:20px;" class="col-lg-9">
                            
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3"> 

                        <!-- Table row -->
                        <div" class="row"> 
                            <div class="col-12 table-responsive"> 
                                <div class="row">
                                    <div class="col-4">

                                        <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-primary">Barcode</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input  name="barKode" type="text" class="form-control" id="barKode" placeholder="Barcode Barang" onkeypress="return event.keyCode != 13;" >
                                        </div>
                                    </div>
                                    <div class="col-4" >
                                        
                                        <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-success">Jenis Transaksi</button>
                                        </div>
                                            <select id="isKredit" name="isKredit" class="form-control" name="" id="">
                                                <option value="0">Cash</option>
                                                <option value="1">Kredit</option> 
                                            </select>
                                        </div>
                                                
                                    </div>
                                    <div class="col-4" >
                                        
                                        <div class="input-group mb-3">
                                            <input value="0" name="jenisTransaksi" id="jenisTransaksi" readonly type="number" class="form-control">
                                            <span class="input-group-prepend">
                                                <button type="button" class="btn btn-success  ">Bulan</button>
                                            </span>
                                        </div>
                                                
                                    </div>
                                </div>
                            <!-- <input value="0" name="barKode" type="text" class="form-control" id="barKode" placeholder="barKode"   
                            onkeyup="barCodeFun();"> -->
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th style="width: 200px">Nama Barang</th>
                                    <th>QTY</th>
                                    <th>Harga Satuan</th>
                                    <!-- <th>Discount</th> -->
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                    <tr id="tr1">
                                        <td>1.</td>
                                        <td>  
                                            <!-- <input type="text" name="keterangan[]" class="form-control"  placeholder="Keterangan Keperluan" required> -->
                                            <select id="nmBarang1" name="keterangan[]"   class="form-control  " onchange="youBarang('1');" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                                <option  value="0">Pilih Barang</option>
                                                <?php 
                                                    $d = mysqli_query($conn , "SELECT t1.idBarang , t1.barKode, t1.namaBarang,
                                                    t1.hargaBeliPcs,  t1.hargaJual,
                                                          t3.masuk,
                                                          t2.keluar 
                                                   FROM tb_barang t1
                                                   LEFT JOIN
                                                   (
                                                       SELECT tb_barang.idBarang, IFNULL(SUM(tb_jual.qty),0) AS keluar
                                                       FROM tb_barang
                                                     LEFT JOIN tb_jual ON tb_barang.idBarang = tb_jual.idBarang
                                                       GROUP BY tb_barang.idBarang
                                                   ) t2
                                                       ON t1.idBarang = t2.idBarang
                                                   LEFT JOIN
                                                   (
                                                       SELECT tb_barang.idBarang,  IFNULL(SUM(tb_list_masuk.qtyMasuk),0) AS masuk
                                                       FROM tb_barang
                                                     LEFT JOIN tb_list_masuk ON tb_barang.idBarang = tb_list_masuk.idBarang
                                                       GROUP BY tb_barang.idBarang
                                                   ) t3
                                                       ON t1.idBarang = t3.idBarang
                                                       
                                                       
                                                           GROUP BY  idBarang
                                                       ORDER BY idBarang ASC"); 
                                                    while ($row = mysqli_fetch_object($d)) { if ($row->masuk- $row->keluar!=0) {
                                                        echo "<script> products.push('".$row->barKode."') </script>";
                                                      ?>
                                                    <option data-barKode="<?php echo $row->barKode; ?>"  data-hargabelipcs="<?php echo $row->hargaBeliPcs; ?>"   data-sisa="<?php echo $row->masuk- $row->keluar; ?>"  data-hargajual="<?php echo $row ->hargaJual; ?>" value="<?php echo $row ->idBarang;  ?>"> <?php echo $row ->namaBarang;  ?>   </option> 
                                                <?php } }?> 
                                            </select>
                                        </td> 
                                        <td> 
                                            <input id="qty1" name="qt[]"  type="number"   max="" class="btnQty form-control"  placeholder="Jumlah Satuan" onchange="youFunction('1');"
                                                    onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                        </td>
                                        <td> 
                                            <input id="hargaSatuan1" name="satuanBiaya[]" type="text" class="form-control"  placeholder="Harga Satuan"  required    onchange="youFunction('1');"
                                                    onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                            <!--HARGA BELI PC-->
                                            <input id="hargaBeliPcs1" name="hargaBeliPcs[]" type="hidden" class="form-control"  placeholder="Harga beli Satuan"  required  readonly  >
                                        </td>
                                        <td style="display: none;" class="input-group mb-3"> 
                                            <input id="discount1" type="number" name="discount[]" class="form-control"  placeholder="Discount" value="0"   onchange="youFunction('1');"
                                                    onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>
                                        <td> 
                                            <input id="jumlah1" type="text" name="jumlah[]" class="form-control"  placeholder="Total Harga" readonly  >  
                                        </td>
                                        <td> 
                                            <button class="btn btn-danger btn-sm" onClick="delTr(1)" ><i class="fas fa-trash"></i></button>  
                                        </td>
                                    </tr> 
                                </tbody>
                                <tfoot>
                                    <tr style="display:none">
                                        <td colspan="4"><b class="float-right">Discount   </b></td>
                                        <td class="input-group ">                                             
                                            <input id="discount" type="number" name=" " value="0" class="form-control"  placeholder="Discount"  >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:middle;" colspan="4"><b id="textTotalBiaya" class="float-right">Total Biaya   </b></td>
                                        <td> <input id="totalBiaya" class="form-control" type="text" readonly  > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b id="uwu" class="float-right">Uang   </b></td>
                                        <td> <input id="uangKonsumen" name="uangPelanggan" class="form-control" type="text"    > </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="4"><b class="float-right">Sisa Bayar   </b></td>
                                        <td> <b  id="kembali"></b>   </td>
                                    </tr>
                                    <tr>

                                    </tr>
                                </tfoot>
                            </table>
                            <div class="clearfix p-3"> 
                                <div id="beer">
                                <button type="button" class="float-right text-right btn btn-primary"  onClick="addTr()">Tambah Rincian</button>
                                        
                                <br>
                                <br>
                                <br>

                                </div> 
                                
                                <input type="submit" name="submit" class="float-right btn btn-primary" value="Simpan">
                                
                                <input style="margin-right: 5px;" type="submit" name="submitprint" class="float-right btn btn-success" value="Simpan dan Print">
                            </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row --> 

                    </div>
                 </div>

            </div>  
            
        </form> 
    </div>
</section>

<script type="text/javascript">
    function popupwindow(id,jenis, tgl, idKredit) {
        var w = 600;
        var h=800;
        var left = (screen.width/2)-(600/2);
        var top = (screen.height/2)-(800/2); 
        if (jenis>0) {
            return window.open('https://hasillautacn.my.id/pages/print_kwitansi_tagihan.php?id='+id+'&idBayar='+idKredit+'&iuranke=1&jt='+tgl+' ', 'dads', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

        } else {
            return window.open('https://hasillautacn.my.id/pages/print.php?id='+id+'', 'dads', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    
       }
    } 

</script>
<?php

if (isset($_POST['submitprint'])) { 
    $idTransaksi = mysqli_real_escape_string($conn,$_SESSION['idTransaksi']); 
    $jenisBarang = mysqli_real_escape_string($conn,$_POST['jenisBarang']); 
    $uangPelanggan = mysqli_real_escape_string($conn,$_POST['uangPelanggan']); 
    $tanggalTransaksi = mysqli_real_escape_string($conn,$_POST['tanggalTransaksi']); 
    $hdiscount = mysqli_real_escape_string($conn,$_POST['hdiscount']); 
    $jenisTransaksi = mysqli_real_escape_string($conn,$_POST['jenisTransaksi']); 

    $keterangan =$_POST['keterangan']; 
    $satuanBiaya = $_POST['satuanBiaya']; 
    $jumlah =$_POST['jumlah']; 
    $discount =$_POST['discount']; 
    $qt = $_POST['qt']; 
    $hargaBeliPcs = $_POST['hargaBeliPcs']; 

    $lastIdKredt=0;
        if ($jenisTransaksi>0 ) {
            mysqli_query($conn, "INSERT INTO tb_kredit_bayar VALUES ('', '$idTransaksi', '$tanggalTransaksi', '$uangPelanggan')");
            $lastIdKredt =  mysqli_insert_id($conn);
            $tgl = $tanggalTransaksi;
            $store_date = array();
            for ($i = 0; $i < $jenisTransaksi; $i++) {
                $tgl = $store_date[$i] = date('Y-m-d', strtotime($tgl . "+".$jenisTransaksi."  months"));
                mysqli_query($conn, "INSERT INTO tb_kredit_bayar VALUES ('', '$idTransaksi', '$tgl', '0')");

            } 
        }else{
            mysqli_query($conn, "INSERT INTO tb_kredit_bayar VALUES ('', '$idTransaksi', '$tanggalTransaksi', '$uangPelanggan')");

        }
        if ($jenisBarang=="1") {
            $nama = mysqli_real_escape_string($conn,$_POST['nama']); 
            if ($nama=="-") {
                $id = "1";
                $trans = mysqli_query($conn, "UPDATE tb_transaksi SET idPelanggan = '$id', tanggalTransaksi ='$tanggalTransaksi',  
                hDiscount ='$hdiscount', jenisTransaksi='$jenisTransaksi' WHERE idTransaksi ='$idTransaksi'   ");
                if ($trans) {
                    $length = count($keterangan);
    
                    for ($i = 0; $i < $length; $i++) { 
                        $k = $keterangan[$i];
                        $q = $qt[$i];
                        $s = $satuanBiaya[$i];
        
                        $d = $discount[$i];
                        $j = $jumlah[$i];
                     
                        $hb = $hargaBeliPcs[$i];
        
                        mysqli_query($conn, "INSERT INTO tb_jual VALUES ('', '$idTransaksi', '$k', '$q', '$s', '$d', '$j', '$hb')");
                    }
                    $idTrans = $_SESSION['idTransaksi'];
                    $_SESSION['idTransaksi'] =null;
                        echo "<script type='text/javascript'>
                            alert('sukses menyimpan');              
                           
                        popupwindow('$idTrans','$jenisTransaksi','$tanggalTransaksi','$lastIdKredt');      
                            window.location.href='?page=transaksi'; 
                        </script>";
                         
                } else {
                
                    $_SESSION['idTransaksi'] =null;
                        echo "<script>
                            alert('gagal menyimpan');
                            window.location.href='?page=transaksi';
                        </script>";
                }
            } else {
                
                $noTelpon = mysqli_real_escape_string($conn,$_POST['noTelpon']); 
                $alamat = mysqli_real_escape_string($conn,$_POST['alamat']); 
                $noTelponPelangganAlternatif = mysqli_real_escape_string($conn,$_POST['noTelponPelangganAlternatif']); 
                $noKtp = mysqli_real_escape_string($conn,$_POST['noKtp']); 
                $noKk = mysqli_real_escape_string($conn,$_POST['noKk']);  
                
                $pel =mysqli_query($conn, "INSERT INTO tb_pelanggan VALUES ('', '$nama','$noTelpon','$noTelponPelangganAlternatif','$noKtp','$noKk','$alamat')");
        
                
                if ($pel) {
                    $id = mysqli_insert_id($conn);
                    $trans = mysqli_query($conn, "UPDATE tb_transaksi SET idPelanggan = '$id', tanggalTransaksi ='$tanggalTransaksi',  
                    hDiscount ='$hdiscount', jenisTransaksi='$jenisTransaksi' WHERE idTransaksi ='$idTransaksi'   ");
                    if ($trans) {
                        $length = count($keterangan);
    
                        for ($i = 0; $i < $length; $i++) { 
                            $k = $keterangan[$i];
                            $q = $qt[$i];
                            $s = $satuanBiaya[$i];
            
                            $d = $discount[$i];
                            $j = $jumlah[$i];
                         
                            $hb = $hargaBeliPcs[$i];
            
                            mysqli_query($conn, "INSERT INTO tb_jual VALUES ('', '$idTransaksi', '$k', '$q', '$s', '$d', '$j', '$hb')");
                        }
                        $idTrans = $_SESSION['idTransaksi'];
                        $_SESSION['idTransaksi'] =null;
                            echo "<script type='text/javascript'>
                                alert('sukses menyimpan');  
                                popupwindow('$idTrans','$jenisTransaksi','$tanggalTransaksi','$lastIdKredt');          
                                window.location.href='?page=transaksi'; 
                            </script>"; 
                    } else {
                    
                        $_SESSION['idTransaksi'] =null;
                            echo "<script>
                                alert('gagal menyimpan');
                                window.location.href='?page=transaksi';
                            </script>";
                    }
                    
                }
            }
            
    
    
        } else {
            $id = mysqli_real_escape_string($conn,$_POST['nama2']); 
            $trans = mysqli_query($conn, "UPDATE tb_transaksi SET idPelanggan = '$id', tanggalTransaksi ='$tanggalTransaksi',  
            hDiscount ='$hdiscount', jenisTransaksi='$jenisTransaksi' WHERE idTransaksi ='$idTransaksi'   ");
             if ($trans) {
                $length = count($keterangan);
    
                for ($i = 0; $i < $length; $i++) { 
                    $k = $keterangan[$i];
                    $q = $qt[$i];
                    $s = $satuanBiaya[$i];
    
                    $d = $discount[$i];
                    $j = $jumlah[$i];
                 
                    $hb = $hargaBeliPcs[$i];
    
                    mysqli_query($conn, "INSERT INTO tb_jual VALUES ('', '$idTransaksi', '$k', '$q', '$s', '$d', '$j', '$hb')");
                }
    
                $idTrans = $_SESSION['idTransaksi'];
                $_SESSION['idTransaksi'] =null;
                    echo "<script type='text/javascript'>
                        alert('sukses menyimpan');                  
                        popupwindow('$idTrans','$jenisTransaksi','$tanggalTransaksi','$lastIdKredt');      
                        window.location.href='?page=transaksi';  
                    </script>"; 
             } else {
               
                $_SESSION['idTransaksi'] =null;
                    echo "<script>
                        alert('gagal menyimpan');
                        window.location.href='?page=transaksi';
                    </script>";
             }
        }
    
}
if (isset($_POST['submit'])) { 

    $idTransaksi = mysqli_real_escape_string($conn,$_SESSION['idTransaksi']); 
    $jenisBarang = mysqli_real_escape_string($conn,$_POST['jenisBarang']); 
    $uangPelanggan = mysqli_real_escape_string($conn,$_POST['uangPelanggan']); 
    $tanggalTransaksi = mysqli_real_escape_string($conn,$_POST['tanggalTransaksi']); 
    $hdiscount = mysqli_real_escape_string($conn,$_POST['hdiscount']); 
   $jenisTransaksi = mysqli_real_escape_string($conn,$_POST['jenisTransaksi']); 

    $keterangan =$_POST['keterangan']; 
    $satuanBiaya = $_POST['satuanBiaya']; 
    $jumlah =$_POST['jumlah']; 
    $discount =$_POST['discount']; 
    $qt = $_POST['qt']; 
    $hargaBeliPcs = $_POST['hargaBeliPcs']; 
   
    if ($jenisTransaksi>0 ) {
        mysqli_query($conn, "INSERT INTO tb_kredit_bayar VALUES ('', '$idTransaksi', '$tanggalTransaksi', '$uangPelanggan')");
        $tgl = $tanggalTransaksi;
        $store_date = array();
        for ($i = 0; $i < $jenisTransaksi; $i++) {
            $tgl = $store_date[$i] = date('Y-m-d', strtotime($tgl . "+".$jenisTransaksi."  months"));
            mysqli_query($conn, "INSERT INTO tb_kredit_bayar VALUES ('', '$idTransaksi', '$tgl', 0)");
        
        } 
    }else{
        mysqli_query($conn, "INSERT INTO tb_kredit_bayar VALUES ('', '$idTransaksi', '$tanggalTransaksi', '$uangPelanggan')");

    }

    if ($jenisBarang=="1") {
        $nama = mysqli_real_escape_string($conn,$_POST['nama']); 
        if ($nama=="-") { 
            $id = "1";
            $trans = mysqli_query($conn, "UPDATE tb_transaksi SET idPelanggan = '$id', tanggalTransaksi ='$tanggalTransaksi', 
            hDiscount ='$hdiscount', jenisTransaksi='$jenisTransaksi' WHERE idTransaksi ='$idTransaksi'   ");
            if ($trans) {
               $length = count($keterangan);

               for ($i = 0; $i < $length; $i++) { 
                $k = $keterangan[$i];
                $q = $qt[$i];
                $s = $satuanBiaya[$i];

                $d = $discount[$i];
                $j = $jumlah[$i];
             
                $hb = $hargaBeliPcs[$i];

                mysqli_query($conn, "INSERT INTO tb_jual VALUES ('', '$idTransaksi', '$k', '$q', '$s', '$d', '$j', '$hb')");
               }

               $_SESSION['idTransaksi'] =null;
                   echo "<script>
                       alert('sukses menyimpan');
                       window.location.href='?page=transaksi';
                   </script>";
            } else {
              
               $_SESSION['idTransaksi'] =null;
                   echo "<script>
                       alert('gagal menyimpan');
                       window.location.href='?page=transaksi';
                   </script>";
            }
        }else{
            $noTelpon = mysqli_real_escape_string($conn,$_POST['noTelpon']); 
            $alamat = mysqli_real_escape_string($conn,$_POST['alamat']); 

            $noTelponPelangganAlternatif = mysqli_real_escape_string($conn,$_POST['noTelponPelangganAlternatif']); 
            $noKtp = mysqli_real_escape_string($conn,$_POST['noKtp']); 
            $noKk = mysqli_real_escape_string($conn,$_POST['noKk']);  
            
            $pel =mysqli_query($conn, "INSERT INTO tb_pelanggan VALUES ('', '$nama','$noTelpon','$noTelponPelangganAlternatif','$noKtp','$noKk','$alamat')");
    
            if ($pel) {
                $id = mysqli_insert_id($conn);
                $trans = mysqli_query($conn, "UPDATE tb_transaksi SET idPelanggan = '$id', tanggalTransaksi ='$tanggalTransaksi', 
                hDiscount ='$hdiscount', jenisTransaksi='$jenisTransaksi' WHERE idTransaksi ='$idTransaksi'   ");
                 if ($trans) {
                    $length = count($keterangan);
    
                    for ($i = 0; $i < $length; $i++) { 
                        $k = $keterangan[$i];
                        $q = $qt[$i];
                        $s = $satuanBiaya[$i];
        
                        $d = $discount[$i];
                        $j = $jumlah[$i];
                     
                        $hb = $hargaBeliPcs[$i];
        
                        mysqli_query($conn, "INSERT INTO tb_jual VALUES ('', '$idTransaksi', '$k', '$q', '$s', '$d', '$j', '$hb')");
                    }
    
                    $_SESSION['idTransaksi'] =null;
                        echo "<script>
                            alert('sukses menyimpan');
                            window.location.href='?page=transaksi';
                        </script>";
                 } else {
                   
                    $_SESSION['idTransaksi'] =null;
                        echo "<script>
                            alert('gagal menyimpan');
                            window.location.href='?page=transaksi';
                        </script>";
                 }
                 
            }

        }

    } else {
        $id = mysqli_real_escape_string($conn,$_POST['nama2']); 
        $trans = mysqli_query($conn, "UPDATE tb_transaksi SET idPelanggan = '$id', tanggalTransaksi ='$tanggalTransaksi',  
        hDiscount ='$hdiscount', jenisTransaksi='$jenisTransaksi' WHERE idTransaksi ='$idTransaksi'   ");
         if ($trans) {
            $length = count($keterangan);

            for ($i = 0; $i < $length; $i++) { 
                $k = $keterangan[$i];
                $q = $qt[$i];
                $s = $satuanBiaya[$i];

                $d = $discount[$i];
                $j = $jumlah[$i];
             
                $hb = $hargaBeliPcs[$i];

                mysqli_query($conn, "INSERT INTO tb_jual VALUES ('', '$idTransaksi', '$k', '$q', '$s', '$d', '$j', '$hb')");
            }

            $_SESSION['idTransaksi'] =null;
                echo "<script>
                    alert('sukses menyimpan');
                    window.location.href='?page=transaksi';
                </script>";
         } else {
           
            $_SESSION['idTransaksi'] =null;
                echo "<script>
                    alert('gagal menyimpan');
                    window.location.href='?page=transaksi';
                </script>";
         }
    }
    

 
}


?>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
  

    <script type="text/javascript"> 
     $(window).on('load', function () {
        $('#isKredit').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            if (valueSelected>0) {
                $("b#uwu").text('Uang DP/Angsuran 1');
            //    $('#beer').hide();
                var rowCount = $('#tbody tr').length;
            // if (rowCount>1) {
            //     alert('gak boleh banyak');
            //  }

             $('input[name="satuanBiaya[]"]').prop('readonly', false);
             $('#jenisTransaksi').prop('readonly', false);
             $('#jenisTransaksi').val('3');
            }else{
                $("b#uwu").text('Uang');
                $('#beer').show();

           //     $('input[name="satuanBiaya[]"]').prop('readonly', true);
             $('#jenisTransaksi').prop('readonly', true);
             $('#jenisTransaksi').val('0');
            }

        });
    });
    $("#barKode").focus();
   
        var sisa ; 
         function youBarang(param1) {
            $("#nmBarang"+param1).change(function () {
             console.log(param1);
                var cntrol = $(this);
                // $("#transaksiNo").val(cntrol.find(':selected').data('no')); 
              //  $("#hargaSatuan"+param1).val(3000)
                 $("#hargaSatuan"+param1).val(parseFloat(cntrol.find(':selected').data('hargajual'))); 
                 sisa= parseFloat(cntrol.find(':selected').data('sisa') );
                 $("#qty"+param1).attr("max",parseFloat(cntrol.find(':selected').data('sisa') ));  
                 $("#hargaBeliPcs"+param1).val(parseFloat(cntrol.find(':selected').data('hargabelipcs'))); 

                 
                console.log("dadadad"+sisa);
                youFunction(param1);
                $(".btnQty").keydown(function(event) { 
                     return false;
                });
            });
         }

       

         
      function youFunction(param1) {
         console.log("zzzz"+param1); // 1 
          var hargaSatuan = document.getElementById("hargaSatuan"+param1).value
          var discountSatuan = document.getElementById("discount"+param1).value
          var qty = document.getElementById("qty"+param1).value

          var discount = discountSatuan/100*hargaSatuan*qty;
          var t = hargaSatuan*qty-discount;
          console.log("harga satuan"+hargaSatuan); // 1  
          document.getElementById("jumlah"+param1).value =t;

        }
    </script>


    <script type="text/javascript">
      window.setInterval('refresh()', 2000); 
      function refresh() {  
        var total=0;       
        var rows =document.getElementsByTagName("tbody")[0].rows;
        for(var i=0;i<rows.length;i++){
          var td = rows[i].getElementsByTagName("td")[5];
          var isi = td.getElementsByTagName("input")[0].value;

          
        //   var tddis = rows[i].getElementsByTagName("td")[4];
        //   var isidis = tddis.getElementsByTagName("input")[0].value;

        //   console.log("dissss "+isidis);
        //     var discount = parseFloat(isidis)/100;

          total = total+parseFloat(isi);
        }
          if (!Number.isNaN(total)) {
            
            //  console.log("hasil "+total);
            //   document.getElementById('totalBiaya').value = convertToRupiah(total);
                var discount  = document.getElementById('discount').value

                var tfoot = document.getElementsByTagName("tfoot")[0].rows[1];
                var uang=  document.getElementById('uangKonsumen').value;
                var t= total-(discount/100*total);
                var jenisTransaki = $('#jenisTransaksi').val();
                if (jenisTransaki>0) {
                    var cc = t/jenisTransaki
                    $("b#textTotalBiaya").text('Biaya Perbulan '+Number( ( cc).toFixed(1))  +' X '+jenisTransaki);
                    
                }else{
                    $("b#textTotalBiaya").text('Total Biaya')
                }
                document.getElementById('totalBiaya').value =t;
                var h =t-uang  ;

                document.getElementById('kembali').innerHTML = convertToRupiah( Number( ( h).toFixed(1) ) );
                console.log("tot "+t);
           //     var akhir =   total-;
          }
      }


      function convertToRupiah(angka)
      {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      }

      var i =1;
      
      $(document).ready(function () {
            console.log('array'+products[0]);
          console.log('readyyyyyyyyyyy');
                window.setInterval('barCodeFun()', 2000); 
       
        } ) 


    
      function barCodeFun() {  
            var selectvar = $('#barKode').val();  
            if (digitCount(selectvar)>11) { 
                    if (!checkAvailableBarcode(selectvar)) {
                        return
                    }     
                console.log('masuk ' );  
                    var pos = checking(selectvar);   
                    var divName = "#nmBarang"+pos+" "  ;       
                 if (pos==0) {
                     if (i==1) {
                         //JIKA HANYA ADA  1 TR
                         var c =  $("#nmBarang1").find(':selected').data('barkode');
                         if (c==selectvar) {
                            var qty =  $("#qty1")
                            var q = qty.val();
                            if (q==0) {
                                qty.val(1);
                            }else{
                                qty.val(parseFloat(q)+1);
                            }
                                setHarga('1');
                         }else{
                                var v = $( "#nmBarang1" ).val();
                             if (v==0) {
                                $("#nmBarang1 option[data-barkode='" + selectvar + "']").prop("selected", true); 
                                var tu=  $( "#nmBarang1" ).val();
                                if (tu!=0) {
                                    var qty =  $("#qty1")
                                    var q = qty.val();
                                    if (q==0) {
                                        qty.val(1);
                                    }else{
                                        qty.val(parseFloat(q)+1);
                                    }
                                    setHarga('1');
                                }
                              
                             }else{
                                 addTr()
                                 $("#nmBarang2 option[data-barkode='" + selectvar + "']").prop("selected", true); 
                                 var tu=  $( "#nmBarang2" ).val();
                                    if (tu!=0) { 
                                        var qty =  $("#qty2")
                                        var q = qty.val();
                                        if (q==0) {
                                            qty.val(1);
                                        }else{
                                            qty.val(parseFloat(q)+1);
                                        }
                                        console.log('addteer');
                                        setHarga('2')

                                    };
                             }
                           
                         }
                       
                     }else{
                         console.log('addteeruu');
                                 addTr()
                                 $("#nmBarang"+i+" option[data-barkode='" + selectvar + "']").prop("selected", true); 
                                    var qty =  $("#qty"+i)
                                    var q = qty.val();
                                    if (q==0) {
                                        qty.val(1);
                                    }else{
                                        qty.val(parseFloat(q)+1);
                                    }
                                    console.log('addteer');
                                    setHarga(i);
                         //JIKA LEBIH DARI 1 TR
                     }
                 }else{

                     //JIKA ADA
                     console.log('JIKA ADA');
                //      addTr()
                    var qty =  $("#qty"+pos)
                    var q = qty.val();
                    if (q==0) {
                        qty.val(1);
                    }else{
                        qty.val(parseFloat(q)+1);
                    }
                    setHarga(pos);
                  } 
                //  console.log('posss'+pos);
                $('#barKode').val('');  
            }
            
        }

        function checkAvailableBarcode(params) {
            for (var i = 0; i < products.length; i++) {
                if (products[i]==params) {
                    return true;
                }
                
            }
            return false;
        }

        function setHarga(param1) {  
            var cntrol = $("#nmBarang"+param1); 
            $("#hargaSatuan"+param1).val(parseFloat(cntrol.find(':selected').data('hargajual'))); 

                sisa= parseFloat(cntrol.find(':selected').data('sisa') );

                $("#qty"+param1).attr("max",parseFloat(cntrol.find(':selected').data('sisa') )); 

                $("#hargaBeliPcs"+param1).val(parseFloat(cntrol.find(':selected').data('hargabelipcs'))); 

                var qty = $("#qty"+param1).val();
                var satuan = $("#hargaBeliPcs"+param1).val();

             //   $("#jumlah"+param1).val(12345);
                 
            youFunction(param1);
            $(".btnQty").keydown(function(event) { 
                    return false;
            });
        }


        function checking(params) {
            for ( x = 1; x <= i; x++) { 
                var divName = "#nmBarang"+x+" "  ;
                if (divName!=null) {
                    var c =  $("#nmBarang"+x).find(':selected').data('barkode');
                    if (c==params) {
                        return x;
                    }
                }
            } 
            return 0;
        }

     
        function digitCount(num) {
            if(num === 0 ) return 1
            return Math.floor(Math.log10(Math.abs(num))) + 1
        }
 
      function delTr(params) {
        document.getElementById("tr"+params).remove();
      }

      function addTr() {
        i = i+1; 
        var baris1 = "<tr id='tr"+i+"'> <td>"+i+".</td>  ";
        var baris2 = "<td><select id='nmBarang"+i+"'  name='keterangan[]'  class='form-control'  onchange='youBarang("+i+");' onkeyup='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'>   <option >Pilih Barang"+getBarang(i);
        var baris3 = "<td> <input id='qty"+i+"' name='qt[]'    type='number' class='btnQty form-control'  placeholder='Jumlah Satuan' onchange='youFunction("+i+");'  onkeyup='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'>   </td>  ";
        var baris4 = "<td> <input id='hargaSatuan"+i+"' name='satuanBiaya[]' type='text' class='form-control'  placeholder='Harga Satuan' required  onchange='youFunction("+i+");' onkeyup='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'>  <input id='hargaBeliPcs"+i+"' type='hidden' name='hargaBeliPcs[]' type='text' class='form-control'  placeholder='Harga beli Satuan'  required  readonly  > </td>";
        var baris5 = "<td style='display:none;' class='input-group mb-3'> <input id='discount"+i+"' name='discount[]' type='text' class='form-control'  placeholder='Discount'  value='0' onchange='youFunction("+i+");' onkeyup='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'>  <div class='input-group-append'> <span class='input-group-text'>%</span> </div> </td> ";
        var baris6 = "<td> <input id='jumlah"+i+"' name='jumlah[]' type='text' class='form-control'  placeholder='Total Harga' readonly >   </td>  ";
        var baris7 = "<td> <button class='btn btn-danger btn-sm' onClick='delTr("+i+")'><i class='fas fa-trash'></i></button>  </td>  </tr>";
        var hasil = baris1+baris2+baris3+baris4+baris5+baris6+baris7;
        document.getElementById('tbody').insertAdjacentHTML('beforeend',hasil);
      //  console.log(i); // 1  

      }


    </script>

<?php
    $q="SELECT t1.idBarang , t1.barkode, t1.namaBarang,
    t1.hargaBeliPcs,  t1.hargaJual,
          t3.masuk,
          t2.keluar 
   FROM tb_barang t1
   LEFT JOIN
   (
       SELECT tb_barang.idBarang, IFNULL(SUM(tb_jual.qty),0) AS keluar
       FROM tb_barang
     LEFT JOIN tb_jual ON tb_barang.idBarang = tb_jual.idBarang
       GROUP BY tb_barang.idBarang
   ) t2
       ON t1.idBarang = t2.idBarang
   LEFT JOIN
   (
       SELECT tb_barang.idBarang,  IFNULL(SUM(tb_list_masuk.qtyMasuk),0) AS masuk
       FROM tb_barang
     LEFT JOIN tb_list_masuk ON tb_barang.idBarang = tb_list_masuk.idBarang
       GROUP BY tb_barang.idBarang
   ) t3
       ON t1.idBarang = t3.idBarang
       
       
           GROUP BY  idBarang
       ORDER BY idBarang ASC";
  echo '  <script>
    function getBarang(p) {
         return \'</option>';

        $d = mysqli_query($conn , $q); 
        while ($row = mysqli_fetch_object($d)) {  
            echo' <option value="'. $row ->idBarang.'"';  echo '  data-barkode="'.  $row->barkode.'"';   echo '  data-hargabelipcs="'.  $row->hargaBeliPcs.'"';  echo '  data-sisa="'.  $row->masuk- $row->keluar.'"'; echo '  data-hargajual="'. $row ->hargaJual.'" >';  echo $row ->namaBarang.'</option> ';
       }   
        
    echo'     </td>\';
        }

</script>';


   
?>


