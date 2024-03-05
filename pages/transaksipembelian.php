<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
if ($_GET['act'] == ''){
?>

<section class="content-header"> 
    <div class="card"> 
        
        <div class="card-header"> 
            <div class="row float-right" >
                <table>
                    <tr>
                        <td class="p-3">Nama Supplier     </td>
                        <td>
                            <select  id="supplier"  name="supplier"  class="form-control  " >
                                <option  value="0">Pilih Supplier</option>
                                <?php 
                                    $d = mysqli_query($conn , "SELECT * FROM  tb_suplier"); 
                                    while ($row = mysqli_fetch_object($d))  {  ?>
                                    <option value="<?php echo $row ->idSupplier;  ?>"> <?php echo $row ->namaSupplier; ?></option> 
                                <?php } ?> 
                            </select>
                        </td>
                        <td class="p-3">Dari   Tanggal  </td>
                        <td><input type="date" id="dateDari" class="form-control"></td>
                        <td class="p-3">Hingga  Tanggal  </td>
                        <td><input type="date" id="dateHingga" class="form-control"></td>
                        <td class="p-2"> 
                            <a id="wew" onclick="load_click()"> 
                                <button type="button" class="btn btn-success btn-sm text-white"><i class="me-2 mdi mdi-message-reply-text"> </i> Filter</button> 
                            </a> 
                        </td>
                    </tr>
                </table>
            
            </div> 
        </div>
        <div class="card-body">
            <table id="example" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Transaksi</th>
                    <th>Kode Transaksi</th>
                    <th>Nama Supplier</th> 
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
                WHERE tb_barang_masuk.idSupplier !=0
                GROUP BY tb_barang_masuk.idMasuk DESC "); 
                while ($row = mysqli_fetch_object($d)) {  ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row->tanggalMasuk; ?></td>
                    <td><?php echo $row->idMasuk; ?></td>
                    <td><?php echo $row->namaSupplier; ?></td>
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
                        <a href="?page=historybayar&idMasuk=<?php echo $row ->idMasuk;?>">
                            <button class="btn btn-success btn-sm"  ><i class="fas fa-eye"></i></button>
                        </a>  
                        <a href="?page=editpembelian&id=<?php echo $row ->idMasuk;?>">
                            <button class="btn btn-primary btn-sm"  ><i class="fas fa-edit"></i></button>
                        </a>
                        
                        <a href="?page=transaksipembelian&act=del&id=<?php echo $row ->idMasuk;?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
                            <button class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i></button>
                        </a> 
                    </td>
                </tr>
                
                <?php    
                    $totSis=$totSis+($tt)- $row->telahBayar;
                    $totTel= $totTel+$row->telahBayar;
                    $totTrans = $totTrans+$tt ;       
                }
                ?>

            </tbody>
            
            <tfoot>
                <tr>    
                    <th></th>
                    <th></th> 
                    <th></th>
                    <th></th>
                    <th  style="border-top: solid 1px ;"> <h5><b  id=""> Total  </b></h5>  </th>
                    <th  style="border-top: solid 1px ;"> <h5><b  id="totTrans"><?php echo c(round($totTrans)); ?></b></h5>  </th> 
                    <th  style="border-top: solid 1px ;"> <h5><b  id="totTel"><?php echo c(round($totTel)); ?></b></h5>  </th> 
                    <th  style="border-top: solid 1px ;"> <h5><b  id="totSis"><?php echo c(round( $totSis)); ?></b></h5>  </th> 
                </tr>
            </tfoot>
            </table>
        </div>

    </div>
</section>


<?php
  
} else if ($_GET['act'] == 'del') {
       
        $id =  $_GET['id']; 
    
        $j = mysqli_query($conn, "DELETE  FROM tb_barang_masuk WHERE  idMasuk = '$id'");
        if ($j) {
            
            echo "<script>
            alert('Succes di hapus');
            window.location.href='?page=transaksipembelian';
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
        return strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
    
    function c($angka)
    {
        return strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
?>   



<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery --> 
<script type="text/javascript">
  function load_click(){ 
    var id = 1;
    var m = 2; 
    var t = $('#example').DataTable();
    t.clear();
    var counter = 1;
    var totTrans=0;
    var totTel=0;
    var totSis=0;

    var supplier=$('#supplier').val();  
    var dateDari=$('#dateDari').val();  

    var dateHingga=$('#dateHingga').val();  

    $.ajax({   
            type: "POST",
            url: "pages/gettransaksipembelian.php",
            data: {dateDari:dateDari, dateHingga:dateHingga ,supplier:supplier }, 
            dataType: "json",  
            success: function(data){  
              if ( data.length>0) {
                  for (var i = 0; i < data.length; i++) { 
                console.log( 'panjangdata'+ data.length);
                    // var j = data[i].jumlah - (data[i].jumlah*data[i].hDiscount/100);
                  
                      t.row.add( [
                              counter,
                              data[i].tanggalMasuk,
                              data[i].idMasuk,
                              data[i].namaSupplier ,
                              data[i].noRef ,
                              cj(data[i].jumlahTransaksi) ,
                              cj(data[i].telahBayar) ,
                              cj(data[i].sisa) ,
                              getBut(data[i].idMasuk)
                              ] ).draw( false );

                          counter++;
                          totTrans =parseFloat(data[i].jumlahTransaksi)+ totTrans;  
                          totTel = totTel+data[i].telahBayar;
                          totSis = totSis+data[i].sisa;
                      
                  }  
                  
                   $('#totTrans').text(cj(totTrans));
                   $('#totTel').text(cj(totTel));
                   $('#totSis').text(cj(totSis));
              } else { 
                $(document).Toasts('create', {
                      autohide: true,
                      position: 'bottomRight',
                      class: 'bg-danger',
                      title: 'Pemberitahuan', 
                      icon: 'far fa-danger',
                      body:  'Tidak Ada Data Pada Tanggal Tersebut'
                    })
              }
            }

        })

  }

  function getBut(params) {
      return "<a href='?page=historybayar&idMasuk="+params+"'><button class='btn btn-success btn-sm'  ><i class='fas fa-eye'></i></button></a>  <a href='?page=editpembelian&id="+params+"'><button class='btn btn-primary btn-sm'  ><i class='fas fa-edit'></i></button></a><a href='?page=transaksipembelian&act=del&id="+params+"' onclick='return confirm('Apakah Anda Benar Benar Ingin Menghapus?')'><button class='btn btn-danger btn-sm' ><i class='fas fa-trash'></i></button></a> "
  }

  function cj(angka)
      {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
      } 
</script>