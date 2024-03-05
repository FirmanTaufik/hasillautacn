<section class="content-header">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title p-3">Filter Berdasarkan Tanggal</h3>
            <div class="row float-right">
                <table>
                    <tr>
                        <td class="p-3">Dari Tanggal </td>
                        <td><input type="date" id="dateDari" class="form-control"></td>
                        <td class="p-3">Hingga Tanggal </td>
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
                        <th>Stock Awal</th>
                        <th>Harga Barang </th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Stock Akhir</th>
                        <th>Total Harga Stock</th>
                        <!-- <th>Total Harga Beli</th> -->
                    </tr>
                </thead>
                <tbody class="datafetch" id="tbody">
                    <?php $totalStockAkhir = 0;
                    $totalHarga = 0;
                    $totalMasuk = 0;
                    $totalKeluar = 0;
                    $hargaStock = 0;
                    $hargaBeli = 0;
                    $no = 1;
                    $d = mysqli_query($conn, "SELECT tb_barang.idBarang,tb_barang.namaBarang,IFNULL(tb_list_masuk.qtyMasuk,0) as awal,
                     tb_barang.hargaJual,tb_barang.hargaBeliPcs,
                    IFNULL(t3.masuk,0) as masuk,  IFNULL(t1.keluar,0) as keluar
                    FROM tb_barang 
                    LEFT JOIN ( 
                    SELECT tb_jual.idBarang, IFNULL(SUM(tb_jual.qty),0) as keluar
                    FROM tb_jual 
                    LEFT JOIN 
                      tb_transaksi  
                      trans on trans.idTransaksi = tb_jual.idTransaksi  
                    GROUP BY idBarang	)
                    t1 on t1.idBarang = tb_barang.idBarang
                    LEFT JOIN 
                    (SELECT tb_barang.idBarang, IFNULL(SUM(tb_list_masuk.qtyMasuk),0) as masuk
                        FROM tb_barang 
                    LEFT JOIN tb_list_masuk ON tb_barang.idBarang = tb_list_masuk.idBarang 
                    GROUP BY idBarang) 
                    t3 ON t3.idBarang = tb_barang.idBarang 
                    LEFT JOIN tb_list_masuk   on tb_barang.idBarang = tb_list_masuk.idBarang    
                    GROUP BY idBarang ");
                    while ($row = mysqli_fetch_object($d)) {  ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row->idBarang; ?></td>
                            <td><?php echo $row->namaBarang; ?></td>
                            <td>0 </td>
                            <td><?php echo  c($row->hargaJual); ?> </td>
                            <td><?php echo $row->masuk; ?> </td>
                            <td><?php echo $row->keluar; ?> </td>
                            <td><?php echo $row->masuk - $row->keluar; ?> </td>
                            <!-- <td><?php echo  c($row->hargaJual * ($row->masuk - $row->keluar)); ?> </td> -->
                            <td><?php echo  c($row->hargaBeliPcs * ($row->masuk - $row->keluar)); ?> </td>
                        </tr>

                    <?php
                        $totalStockAkhir = $row->masuk - $row->keluar + $totalStockAkhir;
                        $totalHarga = $row->hargaJual + $totalHarga;
                        $totalMasuk = $row->masuk + $totalMasuk;
                        $totalKeluar = $row->keluar + $totalKeluar;
                        $hargaStock =   $row->hargaJual * ($row->masuk - $row->keluar) + $hargaStock;
                        $hargaBeli =   $row->hargaBeliPcs * ($row->masuk - $row->keluar) + $hargaBeli;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="border-top: solid 1px ;">
                            <h5 style="float-right;"><b style="float:left;">Total </b></h5>
                        </td>
                        <td style="border-top: solid 1px ;">
                            <h5><b id="totalStockAwal">0</b></h5>
                        </td>
                        <td style="border-top: solid 1px ;">
                            <h5><b id="totalHarga"><?php echo c($totalHarga); ?></b></h5>
                        </td>
                        <td style="border-top: solid 1px ;">
                            <h5><b id="totalMasuk"><?php echo $totalMasuk; ?></b></h5>
                        </td>
                        <td style="border-top: solid 1px ;">
                            <h5><b id="totalKeluar"><?php echo $totalKeluar; ?></b></h5>
                        </td>
                        <td style="border-top: solid 1px ;">
                            <h5><b id="totalStockAkhir"><?php echo $totalStockAkhir; ?></b></h5>
                        </td>
                        <!-- <td style="border-top: solid 1px ;">
                            <h5><b id="totalHargaStock"><?php echo c($hargaStock); ?></b></h5>
                        </td> -->
                        <td style="border-top: solid 1px ;">
                            <h5><b id="totalHargaBeli"><?php echo c($hargaBeli); ?></b></h5>
                        </td>

                    </tr>
                </tfoot>

            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>


<?php
function dateChange($original_dateTime)
{
    $newDate = date("Y-m-d", strtotime($original_dateTime));
    return $newDate;
}
function c($angka)
{
    return strrev(implode('.', str_split(strrev(strval($angka)), 3)));
}


function convert_to_rupiah($angka)
{
    return 'Rp. ' . strrev(implode('.', str_split(strrev(strval($angka)), 3)));
}
?>

<!-- jQuery -->
<script type="text/javascript">
    function load_click() {
        var id = 1;
        var m = 2;
        var t = $('#example').DataTable();
        t.clear();
        var counter = 1;
        var totalStockAkhir = 0;
        var totalHarga = 0;
        var totalMasuk = 0;
        var totalKeluar = 0;
        var totalStockAwal = 0;
        var hargaStock = 0;
        var hargaBeli = 0;


        var dateDari = $('#dateDari').val();

        var dateHingga = $('#dateHingga').val();

        $.ajax({
            type: "POST",
            url: "pages/getstockbarang.php",
            data: {
                dateDari: dateDari,
                dateHingga: dateHingga
            },
            dataType: "json",
            success: function(data) {
                t.clear().draw();
                if (data.length > 0) {
                    console.log('panjangdata' + data.length);
                    for (var i = 0; i < data.length; i++) {
                        var m = parseFloat(data[i].awal) + parseFloat(data[i].masuk) - parseFloat(data[i].keluar);
                        t.row.add([
                            counter,
                            data[i].idBarang,
                            data[i].namaBarang,
                            data[i].awal,
                            cj(data[i].hargaJual),
                            data[i].masuk,
                            data[i].keluar,
                            m,
                            // cj(m * data[i].hargaJual),
                            cj(m * data[i].hargaBeliPcs)
                        ]).draw(false);

                        counter++;
                        totalStockAkhir = parseFloat(m) + totalStockAkhir;
                        totalHarga = parseFloat(data[i].hargaJual) + totalHarga;
                        totalMasuk = parseFloat(data[i].masuk) + totalMasuk;
                        totalKeluar = parseFloat(data[i].keluar) + totalKeluar;
                        totalStockAwal = parseFloat(data[i].awal) + totalStockAwal;
                        hargaStock = (m * data[i].hargaJual) + hargaStock;
                        hargaBeli = (m * data[i].hargaBeliPcs) + hargaBeli;


                    }
                    console.log('dataa' + hargaStock);

                    $('#totalHarga').text(cj(totalHarga));
                    $('#totalStockAkhir').text(cj(totalStockAkhir));
                    $('#totalMasuk').text(totalMasuk);
                    $('#totalKeluar').text(totalKeluar);
                    $('#totalStockAwal').text(totalStockAwal);
                    // $('#totalHargaStock').text(cj(hargaStock));
                    $('#totalHargaBeli').text(cj(hargaBeli));
                } else {
                    $(document).Toasts('create', {
                        autohide: true,
                        position: 'bottomRight',
                        class: 'bg-danger',
                        title: 'Pemberitahuan',
                        icon: 'far fa-danger',
                        body: 'Tidak Ada Data Pada Tanggal Tersebut'
                    })
                }
            }

        })

    }

    function cj(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
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