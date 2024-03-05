<section class="content-header">  
    <div class="card">
        <div class="card-header">
            <h3 class="card-title p-3">Filter Berdasarkan Tanggal</h3>
            <div class="row float-right" >
                <table>
                    <tr>
                        <td class="p-3">Dari Tanggal   </td>
                        <td><input type="date" id="dateDari" class="form-control"></td>
                        <td class="p-3">Hingga Tanggal  </td>
                        <td><input type="date" id="dateHingga" class="form-control"></td>
                        <td class="p-2"> 
                            <a id="wew" onclick="load_click()"> 
                                <button type="button" class="btn btn-success btn-sm text-white"><i class="me-2 mdi mdi-message-reply-text"> </i> Mulai Rekap</button> 
                            </a> 
                        </td>
                    </tr>
                </table>
            
            </div> 

        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table id="example" class="table  table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th> 
                <th>Kode Barang</th>
                <th>Nama Barang</th>  
                <!--<th>Stock Awal </th> -->
                <th>Keluar</th>      
                <th>Penjualan</th>      
                <th>Keuntungan</th>      
            </tr>
            </thead>
            <tbody class="datafetch" id="tbody">
            <?php
                    $total =0; 
                    $totalKeuntungan =0; 
                    $no=1;
                    $d = mysqli_query($conn , "SELECT tb_barang.idBarang,tb_barang.namaBarang, IFNULL(t2.awal,0) as awal, IFNULL(t1.keluar,0) as keluar ,
                    IFNULL(t1.totalHarga,0) as totalHarga, 
                    IFNULL(t1.keuntungan,0) as keuntungan  
                    FROM tb_barang 
                    LEFT JOIN (SELECT tb_jual.idBarang, IFNULL(SUM(tb_jual.qty),0) as keluar, IFNULL(SUM(tb_jual.totalHarga),0) as totalHarga,		 				
                    SUM(tb_jual.totalHarga - (tb_jual.hargaBeliPcs*tb_jual.qty)  ) as keuntungan
                    FROM tb_jual 
                    LEFT JOIN 
                      tb_transaksi  
                      trans on trans.idTransaksi = tb_jual.idTransaksi 
                    GROUP BY idBarang)
                    t1 on t1.idBarang = tb_barang.idBarang
                    left JOIN (
                    SELECT tb_list_masuk.idBarang, IFNULL(SUM(tb_list_masuk.qtyMasuk),0) as awal
                    FROM tb_list_masuk 
                    LEFT JOIN 
                      tb_barang_masuk  
                      masuk on masuk.idMasuk = tb_list_masuk.idMasuk 
                    GROUP BY idBarang)  t2 ON tb_barang.idBarang = t2.idBarang
                    GROUP BY idBarang"); 
                    while ($row = mysqli_fetch_object($d)) {  ?>
                     <tr>
                        <td><?php echo $no++; ?></td> 
                        <td><?php echo $row->idBarang  ; ?></td>
                        <td><?php echo $row->namaBarang; ?></td>
                        <!--<td><?php echo $row->awal; ?> Pcs</td>  -->
                        <td><?php echo $row->keluar; ?> Pcs</td>   
                        <td><?php echo c($row->totalHarga); ?>  </td>   
                        <td><?php  echo c(  $row->keuntungan ); ?> </td>   
                    </tr>

                    <?php  
                        $total = $total+$row->totalHarga; 
                        $totalKeuntungan = $totalKeuntungan+ $row->keuntungan;
                        }
                    ?>
            </tbody>
        <tfoot>
            <tr>    
                <th></th>
                <th></th>
                <th></th>
                <!--<th></th>-->
                <th  style="border-top: solid 1px ;"> <h5><b  id=""> Total  </b></h5>  </th>
                <th  style="border-top: solid 1px ;"> <h5><b  id="total"><?php echo c($total); ?></b></h5>  </th>
                <th  style="border-top: solid 1px ;"> <h5><b  id="totalKeuntungan"><?php echo c($totalKeuntungan); ?></b></h5>  </th>
            </tr>
        </tfoot>
            
        </table>
        </div>
              <!-- /.card-body -->
    </div>
            <!-- /.card -->
</section>


<!-- jQuery --> 
<script type="text/javascript">
  function load_click(){ 
    var id = 1;
    var m = 2; 
    var t = $('#example').DataTable();
    var counter = 1;
    var total=0;
    var totalkeuntungan=0;

    var dateDari=$('#dateDari').val();  

    var dateHingga=$('#dateHingga').val();  

    $.ajax({   
            type: "POST",
            url: "pages/getlaporankeluar.php",
            data: {dateDari:dateDari,dateHingga:dateHingga}, 
            dataType: "json",  
            success: function(data){  
                t.clear().draw();
              if ( data.length>0) {
                console.log( 'panjangdata'+ data.length);
                  for (var i = 0; i < data.length; i++) { 
                      t.row.add( [
                              counter,
                              data[i].idBarang,
                              data[i].namaBarang,
                            //   data[i].awal + ' Pcs',
                              data[i].keluar  + ' Pcs',
                              cj(data[i].totalHarga)  ,
                              cj( ( data[i].keuntungan  ))  
                              ] ).draw( false );

                          counter++;
                          total =parseFloat(data[i].totalHarga)+ total; 
                          totalkeuntungan =parseFloat( data[i].keuntungan)+ totalkeuntungan;
                      
                  }  
                
                  $('#total').text(cj(total));
                  $('#totalKeuntungan').text(cj(totalkeuntungan));
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
 
  function cj(angka)
      {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
      } 
</script>
 

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
