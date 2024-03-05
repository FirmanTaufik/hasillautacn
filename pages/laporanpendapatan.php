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
                <th>Tanggal Transaksi</th>
                <th>Kode Penjualan</th>  
                <th>Nama Barang</th> 
                <th>Harga Jual Satuan</th> 
                <th>Qty Jual</th> 
                <th>Discount</th> 
                <th>Total Harga Jual</th> 
                <th>Harga Beli Per Pcs</th> 
                <th>Pendapatan</th>  
            </tr>
            </thead>
            <tbody class="datafetch" id="tbody">
            <?php $total =0;
                    $no=1;
                    $d = mysqli_query($conn , "SELECT tb_transaksi.tanggalTransaksi, 
                    tb_transaksi.idTransaksi, tb_jual.*  , tb_barang.namaBarang
                    FROM tb_jual
                    LEFT JOIN 
                    tb_transaksi ON tb_jual.idTransaksi = tb_transaksi.idTransaksi
                    LEFT JOIN
                    tb_barang ON tb_jual.idBarang = tb_barang.idBarang 
                    GROUP BY idJual ORDER BY tanggalTransaksi DESC"); 
                    while ($row = mysqli_fetch_object($d)) {  ?>
                     <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo dateChange($row->tanggalTransaksi)  ; ?></td>
                        <td><?php echo $row->idTransaksi; ?></td>
                        <td><?php echo $row->namaBarang; ?></td>
                        <td><?php echo c($row->hargaSatuan); ?></td>  
                        <td><?php echo $row->qty; ?> Pcs</td>  
                        <td><?php echo $row->discount; ?>  %</td>    
                        <td><?php echo c($row->totalHarga); ?></td>  
                        <td><?php echo c($row->hargaBeliPcs); ?></td>  
                        <td><?php $hasil = $row->qty*$row->hargaBeliPcs; echo c($row->totalHarga-$hasil); ?> </td>   
                    </tr>

                    <?php       
                        $total = $row->totalHarga-$hasil +$total;         
                        }
                    ?>
            </tbody>
        <tfoot>   
            <tr>     
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="border-top: solid 1px ;"> <h5 style="float-right;" ><b style="float:left;" >Total </b></h5></td>
                <td  style="border-top: solid 1px ;"> <h5><b  id="totalBiaya"><?php echo convert_to_rupiah($total); ?></b></h5>  </td>
            </tr> 
        </tfoot>
            
        </table>
        </div>
              <!-- /.card-body -->
    </div>
            <!-- /.card -->
</section> 

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

<!-- jQuery --> 
<script type="text/javascript">
  function load_click(){ 
    var id = 1;
    var m = 2; 
    var t = $('#example').DataTable();
    t.clear();
    var counter = 1;
    var total=0;

    var dateDari=$('#dateDari').val();  

    var dateHingga=$('#dateHingga').val();  

    $.ajax({   
            type: "POST",
            url: "pages/getlaporanpendapatan.php",
            data: {dateDari:dateDari,dateHingga:dateHingga}, 
            dataType: "json",  
            success: function(data){  
              if ( data.length>0) {
                console.log( 'panjangdata'+ data.length);
                  for (var i = 0; i < data.length; i++) { 
                      var pen = data[i].qty*data[i].hargaBeliPcs;
                      t.row.add( [
                              counter ,
                              formatDate(data[i].tanggalTransaksi),
                              data[i].idTransaksi,
                              data[i].namaBarang,
                              cj(data[i].hargaSatuan),
                              data[i].qty +' Pcs',
                              data[i].discount +' %',
                              cj(data[i].totalHarga),
                              cj(data[i].hargaBeliPcs),
                              cj(data[i].totalHarga-pen)
                              ] ).draw( false );

                          counter++;
                    total =parseFloat(data[i].totalHarga-pen)+ total;
                      
                  }  
                  console.log('dataa'+data);
                
                  $('#totalBiaya').text(convertToRupiah(total));
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
        return  rupiah.split('',rupiah.length-1).reverse().join('');
      } 

  function convertToRupiah(angka)
      {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      } 
 
  function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}
 
 
  
</script>
 

