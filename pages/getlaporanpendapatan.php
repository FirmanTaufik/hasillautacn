<?php
include_once "../config/+connection.php"; 
            $dateDari = mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']);
            $d = array();
            $dateDari .= " 00:00:00";
            $dateHingga .= " 23:59:00";
            $no = 1;
            $show = mysqli_query($conn,"SELECT tb_transaksi.tanggalTransaksi, 
            tb_transaksi.idTransaksi, tb_jual.*  , tb_barang.namaBarang
            FROM tb_jual
            LEFT JOIN 
            tb_transaksi ON tb_jual.idTransaksi = tb_transaksi.idTransaksi
            LEFT JOIN
            tb_barang ON tb_jual.idBarang = tb_barang.idBarang
            WHERE  tanggalTransaksi BETWEEN '$dateDari' AND '$dateHingga' 
            GROUP BY idJual ORDER BY tanggalTransaksi DESC");
            while ($data = mysqli_fetch_object($show)) { 
                $d[]= $data;
        }
        echo json_encode($d);

        ?>  


        