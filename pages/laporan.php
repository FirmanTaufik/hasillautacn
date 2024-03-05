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
                <th>No Transaksi</th> 
                <th>No Refrensi</th> 
                <th>Nama Supplier</th> 
                <th>Kode Barang</th>  
                <th>Nama Barang</th>  
                <th>Jumlah Masuk </th> 
                <th>Harga Beli</th> 
                <th>Stock</th>  
            </tr>
            </thead>
            <tbody class="datafetch" id="tbody">
            <?php $total =0;
                    $no=1;
                    $d = mysqli_query($conn , "SELECT  tb_barang_masuk.tanggalMasuk,tb_list_masuk.idList, tb_list_masuk.idMasuk, tb_barang_masuk.noRef,
                    tb_suplier.namaSupplier,  tb_barang.idBarang, tb_barang.namaBarang,  
                    tb_list_masuk.qtyMasuk, tb_list_masuk.hargaBeliPcs
                   FROM tb_list_masuk
                   LEFT JOIN
                    tb_barang ON tb_list_masuk.idBarang = tb_barang.idBarang
                    LEFT JOIN 
                    tb_barang_masuk ON tb_list_masuk.idMasuk = tb_barang_masuk.idMasuk  
                    LEFT JOIN 
                    tb_suplier ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier
                    GROUP BY idList
                    ORDER BY tanggalMasuk asc"); 
                    while ($row = mysqli_fetch_object($d)) {  ?>
                     <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo dateChange($row->tanggalMasuk)  ; ?></td>
                        <td><?php echo $row->idMasuk; ?></td>
                        <td><?php echo $row->noRef; ?></td>
                        <td><?php echo $row->namaSupplier; ?></td>
                        <td><?php echo $row->idBarang; ?></td>
                        <td><?php echo $row->namaBarang; ?></td>
                        <td><?php echo $row->qtyMasuk; ?> Pcs</td>  
                        <td><?php echo c($row->hargaBeliPcs); ?></td>   
                        <td> 0</td>    
                    </tr>

                    <?php              
                        }
                    ?>
            </tbody> 
            
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
            url: "pages/getlaporan.php",
            data: {dateDari:dateDari,dateHingga:dateHingga}, 
            dataType: "json",  
            success: function(data){  
            t.clear().draw();
              if ( data.length>0) {
                console.log( 'panjangdata'+ data.length);
                  for (var i = 0; i < data.length; i++) { 
                      var pen = data[i].qty*data[i].hargaBeliPcs;
                      t.row.add( [
                              counter ,
                              formatDate(data[i].tanggalMasuk),
                              data[i].idMasuk,
                              data[i].noRef,
                              data[i].namaSupplier,
                             data[i].idBarang, 
                             data[i].namaBarang, 
                             data[i].qtyMasuk, 
                              cj(data[i].hargaBeliPcs) ,
                              parseFloat(data[i].awal)+ parseFloat(data[i].qtyMasuk)
                              ] ).draw( false );

                          counter++;
                    total =parseFloat(data[i].telahBayar)+ total;
                      
                  }   
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
 

