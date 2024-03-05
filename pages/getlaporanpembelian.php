<?php
include_once "../config/+connection.php"; 
$dateDari = mysqli_real_escape_string($conn,$_POST['dateDari']);
$dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']);
$d = array(); 
$no = 1;
$show = mysqli_query($conn,"SELECT tb_barang_masuk.idMasuk, tb_barang_masuk.tanggalMasuk,tb_barang_masuk.idBarang,
tb_barang_masuk.idSupplier,tb_barang_masuk.qtyMasuk, tb_barang_masuk.qtyMasuk*tb_barang_masuk.hargaBeliPcs as hargaBeli,     tb_barang.namaBarang , tb_suplier.namaSupplier,tb_barang.hargaJual, t1.telahBayar
                    FROM tb_barang_masuk 
                    LEFT JOIN tb_barang ON tb_barang_masuk.idBarang = tb_barang.idBarang
                    LEFT JOIN tb_suplier ON tb_suplier.idSupplier = tb_barang_masuk.idSupplier
                    LEFT JOIN (SELECT tb_barang_masuk.*, IFNULL(SUM(tb_history_bayar.telahBayar),0) AS telahBayar
                    FROM tb_barang_masuk 
                    LEFT JOIN tb_history_bayar ON 
                    tb_barang_masuk.idMasuk = tb_history_bayar.idMasuk
                    GROUP BY idMasuk)  t1 ON t1.idMasuk= tb_barang_masuk.idMasuk 
                    WHERE tb_barang_masuk.tanggalMasuk BETWEEN '$dateDari' AND '$dateHingga'
                    GROUP BY idMasuk DESC");

    while ($data = mysqli_fetch_object($show)) { 
        
        $d[]= $data;

    }

    echo json_encode($d);

?>  


        