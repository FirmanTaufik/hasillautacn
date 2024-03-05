<section class="content-header">  

</section>   

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12"> 
            <?php
                $idMasuk = $_GET['id'];
                $row = mysqli_fetch_assoc(mysqli_query($conn ,"SELECT * FROM `tb_barang_masuk`"));  
            ?>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <!-- <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i>  MaurieJMart
                    <table class="float-right">
                        <tr>
                            <td><small> No</small></td>
                            <td>:</td>
                            <td><small><?php  echo  $id;  ?></small></td>
                        </tr>
                        <tr>
                            <td><small>Tanggal</small></td>
                            <td>:</td>
                            <td><small><?php echo $row['tanggalTransaksi']; ?></small></td>
                        </tr>
                    </table> 
                  </h4>
                    <span class="float-left" style="margin-left: 30px;"><h5>Alamat Toko</h5></span>
                </div> 
              </div> -->
              <!-- info row --> 
              <div class="row invoice-info"> 
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    <table>
                        <tr>
                            <td> <b>No</b></td>
                            <td> : </td>
                            <td> <?php echo $id; ?></td>
                        </tr> 
                        <tr>
                            <td> <b>No Refrensi</b></td>
                            <td> : </td>
                            <td> <?php echo $row['noTelponPelanggan']; ?></td>
                        </tr> 
                        <tr>
                            <td> <b>Tanggal</b></td>
                            <td> : </td>
                            <td> <?php echo $row['tanggalTransaksi']; ?></td>
                        </tr> 
                    
                    </table>
                </div> 
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    <table>
                    <tr>
                            <td> <b>Nama Supplier</b></td>
                            <td> : </td>
                            <td> <?php echo $row['namaPelanggan']; ?></td>
                        </tr> 
                        <tr>
                            <td> <b>Alamat</b></td>
                            <td> : </td>
                            <td> <?php echo $row['alamatPelanggan']; ?></td>
                        </tr> 
                        <tr>
                            <td> <b>No Telpon</b></td>
                            <td> : </td>
                            <td> <?php echo $row['noTelponPelanggan']; ?></td>
                        </tr> 
                    </table>
                </div> 
                <!-- /.col -->
              </div>
              <br>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table  ">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>QTY</th>
                        <th>Harga Satuan</th>
                        <th>Discount</th>
                        <th>Jumlah</th> 
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $total =0;
                        $w=0;
                        $j = mysqli_query($conn, "SELECT    tb_barang.namaBarang, tb_jual.*
                        FROM tb_jual 
                        LEFT JOIN tb_barang ON tb_jual.idBarang =  tb_barang.idBarang
                        WHERE idTransaksi = '$id'");
                        while ($data = mysqli_fetch_object($j)) {   $w++; 
                            $total = $data->totalHarga+$total;   
                            ?>  
                         <tr>
                            <td><?php echo $w .".";?></td>
                            <td>  <?php echo $data->namaBarang; ?>   </td> 
                            <td>  <?php echo $data->qty; ?>   </td> 
                            <td>  <?php echo c($data->hargaSatuan); ?>   </td> 
                            <td>  <?php echo $data->discount; ?>  % </td> 
                            <td>  <?php echo c($data->totalHarga); ?>   </td> 
                        </tr> 

                    <?php
                        } ?>
                    </tbody>
                    <tr> 
                        <td colspan="5"><b style="float:right;">Total Biaya:</b></td>
                        <td><b><?php echo  c($total); ?></b></td>
                    </tr>
                      <tr> 
                          <td   colspan="5"><b style="float:right;">Uang:</b></td>
                            <td><b><?php echo   c($uangPel) ; ?></b></td>
                      </tr>
                      <tr> 
                            <td   colspan="5"><b style="float:right;">Kembali:</b></td>
                            <td><b><?php echo convert_to_rupiah( $uangPel-$total); ?></b></td>
                        </tr>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
                    <div class="col-7">

                    </div>
                    <div class="col-5">
                  <!-- <p class="lead">Amount Due 2/22/2014</p> -->

                    <!-- <div class="table-responsive">
                        <table class="table">
                            <tr> 
                                <th>Total Biaya:</th>
                                <td><b><?php echo $total; ?></b></td>
                            </tr>
                            <tr> 
                                <th>Uang:</th>
                                <td><b><?php echo  $uangPel ; ?></b></td>
                            </tr>
                            <tr> 
                                <th>Kembali:</th>
                                <td><b><?php echo convert_to_rupiah( $uangPel-$total); ?></b></td>
                            </tr>
                        </table>
                    </div> -->
                    </div> 
              </div>
 

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                    <br> 
                    <br>
                    <!-- <a onclick="popupwindow(<?php echo $id ?>)" rel="noopener" target="_blank" class="float-right btn btn-default"><i class="fas fa-print"></i> Print</a> 
                     -->
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content --> 

    <?php
    function convert_to_rupiah($angka)
    {
        return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
?>    
 

<script type="text/javascript">
function popupwindow(id) {
  var w = 600;
  var h=800;
  var left = (screen.width/2)-(600/2);
  var top = (screen.height/2)-(800/2);
  return window.open('http://hasillautacn.my.id/pages/print.php?id='+id+'', 'dads', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 

</script>


<?php
    function c($angka)
    {
        return strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
?>   