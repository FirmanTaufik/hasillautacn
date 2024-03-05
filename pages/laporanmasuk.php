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
        <table id="example" class="table table-bordered  table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>  
                <th>Stock Awal</th> 
                <th>Masuk</th>     
            </tr>
            </thead>
            <tbody class="datafetch" id="tbody">
            <?php
                    $no=1;
                    $d = mysqli_query($conn , "SELECT tb_barang.idBarang, tb_barang.namaBarang,   t3.awal,  IFNULL(SUM(masuk.qtyMasuk),0) AS masuk
                    FROM tb_barang                   
                   INNER JOIN
                (
                  SELECT tb_barang.idBarang, tb_barang.namaBarang, IFNULL(SUM(tb_barang_masuk.qtyMasuk),0) AS awal
                    FROM tb_barang
                  LEFT JOIN tb_barang_masuk   on tb_barang.idBarang = tb_barang_masuk.idBarang  
                  GROUP BY idBarang
                ) t3
                 ON tb_barang.idBarang  = t3.idBarang
                 LEFT JOIN tb_barang_masuk as masuk ON masuk.idBarang  = tb_barang.idBarang 
                    GROUP BY idBarang"); 
                    while ($row = mysqli_fetch_object($d)) {  ?>
                     <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row->idBarang  ; ?></td>
                        <td><?php echo $row->namaBarang; ?></td>
                        <td><?php echo $row->awal; ?> Pcs</td>  
                        <td><?php echo $row->masuk; ?> Pcs</td>  
                    </tr>

                    <?php                
                        }
                    ?>
            </tbody>
        <!-- <tfoot>
            <tr>    
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th> 
            </tr>
        </tfoot> -->
            
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
    t.clear();
    var counter = 1;
    var total=0;

    var dateDari=$('#dateDari').val();  

    var dateHingga=$('#dateHingga').val();  

    $.ajax({   
            type: "POST",
            url: "pages/getlaporanmasuk.php",
            data: {dateDari:dateDari,dateHingga:dateHingga}, 
            dataType: "json",  
            success: function(data){  
              if ( data.length>0) {
                console.log( 'panjangdata'+ data.length);
                  for (var i = 0; i < data.length; i++) { 
                      t.row.add( [
                              counter ,
                              +data[i].idBarang,
                              data[i].namaBarang,
                              data[i].awal +' Pcs',
                              data[i].masuk +' Pcs'
                              ] ).draw( false );

                          counter++;
                          total =parseFloat(data[i].jumlahKeterangan)+ total;
                      
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

 
 
 
  
</script>
 

