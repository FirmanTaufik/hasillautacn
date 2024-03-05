<?php
include_once "../config/+connection.php"; 
            $dateDari =mysqli_real_escape_string($conn, $_POST['dateDari']);
            $dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']);
            $d = array();

            $no = 1;
            $show = mysqli_query($conn,"SELECT tb_barang.idBarang, tb_barang.namaBarang,   t3.awal,  IFNULL(SUM(masuk.qtyMasuk),0) AS masuk
            FROM tb_barang                   
           INNER JOIN
        (
          SELECT tb_barang.idBarang, tb_barang.namaBarang, IFNULL(SUM(tb_barang_masuk.qtyMasuk),0) AS awal
            FROM tb_barang
          LEFT JOIN tb_barang_masuk   on tb_barang.idBarang = tb_barang_masuk.idBarang 
          AND tb_barang_masuk.tanggalMasuk <'$dateDari'
          GROUP BY idBarang
        ) t3
         ON tb_barang.idBarang  = t3.idBarang
         LEFT JOIN tb_barang_masuk as masuk ON masuk.idBarang  = tb_barang.idBarang
          AND masuk.tanggalMasuk BETWEEN '$dateDari' AND '$dateHingga'
            GROUP BY idBarang");
            while ($data = mysqli_fetch_object($show)) { 
                $d[]= $data;
        }
        echo json_encode($d);

        ?>  


        