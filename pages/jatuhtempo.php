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
                <th>Jatuh Tempo</th>
                <th>Nama Pelanggan</th> 
                <th>Nama Barang</th>  
                <th>Iuran </th>  
                <th>Tendor</th>   
            </tr>
            </thead>
            <tbody class="datafetch" id="tbody">
            <?php
                $no=1;
                $d = mysqli_query($conn , "SELECT tb_kredit_bayar.idTransaksi, tb_kredit_bayar.tanggalBayar as jatuh_tempo, t1.*
                FROM tb_kredit_bayar
                left JOIN ( SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                               t1.namaBarang,  floor( floor( IFNULL(t1.jumlah,0) - ( IFNULL(t1.jumlah,0)*tb_transaksi.hDiscount/100)   ) /tb_transaksi.jenisTransaksi) iuran
                                                FROM tb_transaksi 
                                                LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                                LEFT JOIN (SELECT tb_jual.idTransaksi, tb_barang.namaBarang, tb_jual.hargaSatuan * tb_jual.qty as harga , 
                (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                                           FROM tb_jual                                            
                                                           left JOIN tb_barang ON tb_jual.idBarang = tb_barang.idBarang
                                                           GROUP BY  tb_jual.idTransaksi ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                                  
                                                WHERE tb_transaksi.idPelanggan !=0 ORDER BY tb_transaksi.idTransaksi DESC) t1 ON t1.idTransaksi =tb_kredit_bayar.idTransaksi
                                                WHERE t1.jenisTransaksi!=0
                GROUP BY tb_kredit_bayar.idKredit "); 
                while ($row = mysqli_fetch_object($d)) {  ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row->jatuh_tempo ?></td>
                    <td><?php echo $row->namaPelanggan ?></td>
                    <td><?php echo $row->namaBarang ?></td>
                    <td><?php echo c($row->iuran) ?></td>
                    <td><?php echo $row->jenisTransaksi ?> Bulan</td>
                </tr>

                <?php       
                      
                    }
                ?>
            </tbody>
        <!-- <tfoot>   
            <tr>       
                <td></td>
                <td></td>
                <td style="border-top: solid 1px ;"> <h5 style="float-right;" ><b style="float:left;" >Total </b></h5></td>
                <td  style="border-top: solid 1px ;"> <h5><b  id="totalStockAwal">0</b></h5>  </td>
                <td  style="border-top: solid 1px ;"> <h5><b  id="totalHarga"><?php echo c($totalHarga); ?></b></h5>  </td> 
                <td  style="border-top: solid 1px ;"> <h5><b  id="totalMasuk"><?php echo $totalMasuk; ?></b></h5>  </td>
                <td  style="border-top: solid 1px ;"> <h5><b  id="totalKeluar"><?php echo $totalKeluar; ?></b></h5>  </td>
                <td  style="border-top: solid 1px ;"> <h5><b  id="totalStockAkhir"><?php echo $totalStockAkhir; ?></b></h5>  </td>
                <td  style="border-top: solid 1px ;"> <h5><b  id="totalHargaStock"><?php echo c($hargaStock); ?></b></h5>  </td>

            </tr> 
        </tfoot> -->
            
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

    var dateDari=$('#dateDari').val();  

    var dateHingga=$('#dateHingga').val();  

    $.ajax({   
            type: "POST",
            url: "pages/gettendor.php",
            data: {dateDari:dateDari,dateHingga:dateHingga}, 
            dataType: "json",  
            success: function(data){  
                t.clear().draw();
              if ( data.length>0) {
                  console.log(data);
                  for (var i = 0; i < data.length; i++) { 
                  t.row.add( [
                              counter , 
                              data[i].jatuh_tempo,
                              data[i].namaPelanggan, 
                             data[i].namaBarang,  
                              cj(data[i].iuran) ,
                              data[i].jenisTransaksi +" Bulan"
                              ] ).draw( false );

                          counter++;
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
 

