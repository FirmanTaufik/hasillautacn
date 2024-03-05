<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_GET['act'] == '') {
?>

    <section class="content-header">
        <div class="card">
            <div class="card-header">
                <div class="row float-right">
                    <table>
                        <tr>
                            <td class="p-3">Jenis Transaksi </td>
                            <td>
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="0">Semua</option>
                                    <option value="1">Cash</option>
                                    <option value="2">Kredit</option>
                                </select>
                            </td>
                            <td class="p-3">Nama Pelanggan </td>
                            <td>
                                <select id="pelanggan" name="pelanggan" class="form-control  ">
                                    <option value="0">Pilih Pelanggan</option>
                                    <?php
                                    $d = mysqli_query($conn, "SELECT * FROM  tb_pelanggan");
                                    while ($row = mysqli_fetch_object($d)) {  ?>
                                        <option value="<?php echo $row->idPelanggan;  ?>" data-no="<?php echo $row->noTelponPelanggan;  ?>" data-alamat="<?php echo $row->alamatPelanggan;  ?>"> <?php echo $row->namaPelanggan ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="p-3">Dari Tanggal </td>
                            <td><input type="date" id="dateDari" class="form-control"></td>
                            <td class="p-3">Hingga Tanggal </td>
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
                            <th>Kode Penjualan</th>
                            <th>Jenis Transaksi</th>
                            <th>Nama Pelanggan</th>
                            <th>Jumlah Transaksi</th>
                            <th>Jumlah Bayar</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $totalA = 0;
                        $no = 1;
                        $d = mysqli_query($conn, "SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                FROM tb_transaksi 
                                LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
(tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                           FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                           FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                WHERE tb_transaksi.idPelanggan !=0 GROUP BY tb_transaksi.idTransaksi ORDER BY tb_transaksi.idTransaksi DESC ");
                        while ($row = mysqli_fetch_object($d)) {  ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row->tanggalTransaksi; ?></td>
                                <td><?php echo $row->idTransaksi; ?></td>
                                <td><?php if ($row->jenisTransaksi == 0) {
                                        echo "Cash";
                                    } else {
                                        echo "Kredit";
                                    } ?></td>
                                <td><?php echo $row->namaPelanggan; ?></td>
                                <?php $total = $row->jumlah - ($row->jumlah * $row->hDiscount / 100); ?>
                                <td><?php echo convert_to_rupiah($total); ?></td>
                                <td><?php echo convert_to_rupiah($row->bayar); ?></td>
                                <td><?php echo convert_to_rupiah($total - $row->bayar); ?></td>
                                <td><?php if ($total - $row->bayar == 0) {
                                        echo " <span class='badge badge-success'>Lunas</span> ";
                                    } else {
                                        echo " <span class='badge badge-danger'>Belum Lunas</span> ";
                                    } ?></td>
                                <td>
                                    <?php if ($row->jenisTransaksi == 0) {      ?>

                                        <a href="?page=detailtransaksicash&id=<?php echo $row->idTransaksi; ?>">
                                            <button class="btn btn-success btn-sm"><i class="fas fa-eye"></i></button>
                                        </a>
                                    <?php   } else { ?>

                                        <a href="?page=detailtransaksi&id=<?php echo $row->idTransaksi; ?>">
                                            <button class="btn btn-success btn-sm"><i class="fas fa-eye"></i></button>
                                        </a>
                                    <?php } ?>
                                    <a href="?page=edittransaksi&id=<?php echo $row->idTransaksi; ?>">
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                    </a>



                                    <a href="?page=transaksi&act=del&id=<?php echo $row->idTransaksi; ?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </a>
                                </td>
                            </tr>

                        <?php
                            $totalA = $totalA + $total - $row->bayar;
                        }
                        ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="border-top: solid 1px ;">
                                <h5><b id=""> Total </b></h5>
                            </th>
                            <th style="border-top: solid 1px ;">
                                <h5><b id="total"><?php echo c($totalA); ?></b></h5>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </section>


<?php

} else if ($_GET['act'] == 'del') {

    $id =  $_GET['id'];

    mysqli_query($conn, "DELETE  FROM tb_kredit_bayar WHERE  idTransaksi = '$id'");
    $j = mysqli_query($conn, "DELETE  FROM tb_jual WHERE  idTransaksi = '$id'");
    if ($j) {
        $e = mysqli_query($conn, "DELETE  FROM tb_transaksi WHERE  idTransaksi = '$id'");
        if ($e) {

            echo "<script>
                alert('Succes di hapus');
                window.location.href='?page=transaksi';
                </script>";
        } else {
            alert('gagal di hapus');
            echo "<script>alert('Error');window.history.go(-1);</script>";
        }
    }
}

?>


<?php
function convert_to_rupiah($angka)
{
    return strrev(implode('.', str_split(strrev(strval($angka)), 3)));
}
function c($angka)
{
    return strrev(implode('.', str_split(strrev(strval($angka)), 3)));
}
?>



<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery -->
<script type="text/javascript">
    function load_click() {
        var id = 1;
        var m = 2;
        var t = $('#example').DataTable();
        t.clear();
        var counter = 1;
        var total = 0;
        var totalkeuntungan = 0;

        var pelanggan = $('#pelanggan').val();
        var dateDari = $('#dateDari').val();

        var dateHingga = $('#dateHingga').val();
        var jenis = $('#jenis').val();

        $.ajax({
            type: "POST",
            url: "pages/gettransaksi.php",
            data: {
                dateDari: dateDari,
                dateHingga: dateHingga,
                pelanggan: pelanggan,
                jenis: jenis
            },
            dataType: "json",
            success: function(data) {
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        console.log('panjangdata' + pelanggan + data[i].tanggalTransaksi);
                        var j = data[i].jumlah - (data[i].jumlah * data[i].hDiscount / 100);
                        var jenis = "";
                        if (data[i].jenisTransaksi == 0) {
                            jenis = "Cash";
                        } else {
                            jenis = "Kredit";

                        }

                        var status = "";
                        if (j - data[i].bayar == 0) {
                            status = "<span class='badge badge-success'>Lunas</span>";
                        } else {
                            status = "<span class='badge badge-danger'>Belum Lunas</span>";

                        }
                        t.row.add([
                            counter,
                            data[i].tanggalTransaksi,
                            data[i].idTransaksi,
                            jenis,
                            data[i].namaPelanggan,
                            cj(j),
                            cj(data[i].bayar),
                            cj(j - data[i].bayar),
                            status,
                            getBut(data[i].idTransaksi)
                        ]).draw(false);

                        counter++;
                        total = parseFloat(j - data[i].bayar) + total;

                    }

                    $('#total').text(cj(total));
                    //   $('#totalKeuntungan').text(cj(totalkeuntungan));
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

    function getBut(params) {
        return " <a href='?page=detailtransaksi&id=" + params + " '><button class='btn btn-success btn-sm'  ><i class='fas fa-eye'></i></button> </a>  <a href='?page=edittransaksi&id=" + params + " '><button class='btn btn-primary btn-sm'  ><i class='fas fa-edit'></i></button> </a> <a href='?page=transaksi&act=del&id=" + params + "' onclick='return confirm('Apakah Anda Benar Benar Ingin Menghapus?')'><button class='btn btn-danger btn-sm' ><i class='fas fa-trash'></i></button> </a> "
    }

    function cj(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }
</script>