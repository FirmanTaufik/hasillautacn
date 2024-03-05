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
 
            $query ="SELECT tb_kredit_bayar.idTransaksi, tb_kredit_bayar.tanggalBayar as jatuh_tempo, t1.*
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
                                            WHERE  tb_kredit_bayar.tanggalBayar  BETWEEN '$dateDari' AND '$dateHingga' AND t1.jenisTransaksi!=0
            GROUP BY tb_kredit_bayar.idKredit ";
            
            $show = mysqli_query($conn,$query);
            while ($data = mysqli_fetch_object($show)) { 
                $d[]= $data;
            }
        echo json_encode($d);

?>  


        