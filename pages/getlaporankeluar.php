<?php
include_once "../config/+connection.php"; 
            $dateDari =  mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']);
            $date = mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateDari .= " 00:00:00";
            $dateHingga .= " 23:59:00";
            
            $dateDari2 = mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga2 = mysqli_real_escape_string($conn,$_POST['dateHingga']);
            $d = array();

            $no = 1;
            $show = mysqli_query($conn,"SELECT tb_barang.idBarang,tb_barang.namaBarang, IFNULL(t2.awal,0) as awal, IFNULL(t1.keluar,0) as keluar ,
            IFNULL(t1.totalHarga,0) as totalHarga, 
            IFNULL(t1.keuntungan,0) as keuntungan  
            FROM tb_barang 
            LEFT JOIN ( SELECT tb_jual.idBarang, IFNULL(SUM(tb_jual.qty),0) as keluar, IFNULL(SUM(tb_jual.totalHarga),0) as totalHarga,		 				
                    SUM(tb_jual.totalHarga - (tb_jual.hargaBeliPcs*tb_jual.qty)  ) as keuntungan
                    FROM tb_jual 
            LEFT JOIN 
              tb_transaksi  
              trans on trans.idTransaksi = tb_jual.idTransaksi 
              WHERE tanggalTransaksi 
            BETWEEN ' $dateDari' AND '$dateHingga'
            GROUP BY idBarang)
            t1 on t1.idBarang = tb_barang.idBarang
            left JOIN (
            SELECT tb_list_masuk.idBarang, IFNULL(SUM(tb_list_masuk.qtyMasuk),0) as awal
            FROM tb_list_masuk 
            LEFT JOIN 
              tb_barang_masuk  
              masuk on masuk.idMasuk = tb_list_masuk.idMasuk 
              WHERE masuk.tanggalMasuk <='$dateHingga2 23:59:00'
            GROUP BY idBarang)  t2 ON tb_barang.idBarang = t2.idBarang
            GROUP BY idBarang");
            while ($data = mysqli_fetch_object($show)) { 
                $d[]= $data;
        }
        echo json_encode($d);

        ?>  


        