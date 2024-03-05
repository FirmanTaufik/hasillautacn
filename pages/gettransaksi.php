<?php
include_once "../config/+connection.php"; 
            $jenis = mysqli_real_escape_string($conn,$_POST['jenis']);
            $idPelanggan = mysqli_real_escape_string($conn,$_POST['pelanggan']);
            $dateDari =  mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']);
            $date = mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateDari .= " 00:00:00";
            $dateHingga .= " 23:59:00";
            
            $dateDari2 = mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga2 = mysqli_real_escape_string($conn,$_POST['dateHingga']);
            $d = array();

            $query =null;


            if ($jenis==0) {
                if ($idPelanggan!=0) {

                    if ($dateDari==" 00:00:00") {
                        $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                        IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                        FROM tb_transaksi 
                                        LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                        LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
        (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                                   FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                        LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                                   FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                        WHERE tb_transaksi.idPelanggan ='$idPelanggan' GROUP BY tb_transaksi.idTransaksi ORDER BY tb_transaksi.idTransaksi DESC  ";
                    } else {
                    
                        $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                        IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                        FROM tb_transaksi 
                                        LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                        LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
        (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                                   FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                        LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                                   FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                       WHERE tb_pelanggan.idPelanggan = '$idPelanggan' AND tanggalTransaksi  BETWEEN '$dateDari' AND '$dateHingga'
                                                    AND tb_transaksi.idPelanggan !=0   GROUP BY idTransaksi 
                        ORDER BY tb_transaksi.idTransaksi DESC ";
                    }
                    
                } else {  
                    $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                    IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                    FROM tb_transaksi 
                                    LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                    LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
    (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                               FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                    LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                               FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                    WHERE   tanggalTransaksi  BETWEEN '$dateDari' AND '$dateHingga' AND tb_transaksi.idPelanggan !=0 
                             GROUP BY idTransaksi 
                    ORDER BY tb_transaksi.idTransaksi DESC ";
                }
            }else if ($jenis ==1) {
               
                if ($idPelanggan!=0) {

                    if ($dateDari==" 00:00:00") {
                        $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                        IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                        FROM tb_transaksi 
                                        LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                        LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
        (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                                   FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                        LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                                   FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                        WHERE tb_transaksi.idPelanggan ='$idPelanggan' AND tb_transaksi.jenisTransaksi =0  GROUP BY tb_transaksi.idTransaksi ORDER BY tb_transaksi.idTransaksi DESC  ";
                    } else {
                    
                        $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                        IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                        FROM tb_transaksi 
                                        LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                        LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
        (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                                   FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                        LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                                   FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                       WHERE tb_pelanggan.idPelanggan = '$idPelanggan' AND tanggalTransaksi  BETWEEN '$dateDari' AND '$dateHingga'
                                                    AND tb_transaksi.idPelanggan !=0 AND tb_transaksi.jenisTransaksi =0  GROUP BY idTransaksi 
                        ORDER BY tb_transaksi.idTransaksi DESC ";
                    }
                    
                } else {  
                    $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                    IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                    FROM tb_transaksi 
                                    LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                    LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
    (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                               FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                    LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                               FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                    WHERE   tanggalTransaksi  BETWEEN '$dateDari' AND '$dateHingga' AND tb_transaksi.idPelanggan !=0 AND tb_transaksi.jenisTransaksi =0
                             GROUP BY idTransaksi 
                    ORDER BY tb_transaksi.idTransaksi DESC ";
                }
            }else{
                if ($idPelanggan!=0) {

                    if ($dateDari==" 00:00:00") {
                        $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                        IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                        FROM tb_transaksi 
                                        LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                        LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
        (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                                   FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                        LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                                   FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                        WHERE tb_transaksi.idPelanggan ='$idPelanggan' AND tb_transaksi.jenisTransaksi >0 GROUP BY tb_transaksi.idTransaksi ORDER BY tb_transaksi.idTransaksi DESC  ";
                    } else {
                    
                        $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                        IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                        FROM tb_transaksi 
                                        LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                        LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
        (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                                   FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                        LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                                   FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                       WHERE tb_pelanggan.idPelanggan = '$idPelanggan' AND tanggalTransaksi  BETWEEN '$dateDari' AND '$dateHingga'
                                                    AND tb_transaksi.idPelanggan !=0 AND tb_transaksi.jenisTransaksi >0  GROUP BY idTransaksi 
                        ORDER BY tb_transaksi.idTransaksi DESC ";
                    }
                    
                } else {  
                    $query ="SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.namaPelanggan, 
                    IFNULL(sum(t1.jumlah),0) jumlah ,  IFNULL(t2.bayar,0) bayar
                                    FROM tb_transaksi 
                                    LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                                    LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
    (tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                               FROM tb_jual GROUP BY  tb_jual.idJual ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                                    LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                               FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                                    WHERE   tanggalTransaksi  BETWEEN '$dateDari' AND '$dateHingga' AND tb_transaksi.idPelanggan !=0 AND tb_transaksi.jenisTransaksi >0
                             GROUP BY idTransaksi 
                    ORDER BY tb_transaksi.idTransaksi DESC ";
                }
            }
            
            
            $show = mysqli_query($conn,$query);
            while ($data = mysqli_fetch_object($show)) { 
                $d[]= $data;
        }
        echo json_encode($d);
