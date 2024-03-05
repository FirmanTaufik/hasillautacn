<?php
include_once "../config/+connection.php"; 
            $idSupplier = mysqli_real_escape_string($conn,$_POST['supplier']);
            $dateDari =  mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']);
            $date = mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateDari .= " 00:00:00";
            $dateHingga .= " 23:59:00";
            
            $dateDari2 = mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga2 = mysqli_real_escape_string($conn,$_POST['dateHingga']); 

            $daftarTransaksi =array();
            $query =null;
            if ($idSupplier!=0) { 
              if ($dateDari==" 00:00:00") { 
                  $query ="SELECT tb_barang_masuk.* ,  tb_suplier.idSupplier,  
                  tb_suplier.namaSupplier, t1.jumlah, t2.telahBayar
                  FROM tb_barang_masuk 
                  LEFT JOIN (SELECT  tb_list_masuk.idList,  idMasuk, SUM(qtyMasuk*hargaBeliPcs) AS jumlah
                  FROM tb_list_masuk GROUP BY idMasuk ) t1 ON tb_barang_masuk.idMasuk = t1.idMasuk
                  LEFT JOIN (SELECT tb_history_bayar.idHistory, idMasuk, SUM(telahBayar) telahBayar 
                          FROM tb_history_bayar GROUP BY idMasuk) t2 ON tb_barang_masuk.idMasuk = t2.idMasuk
                  LEFT JOIN tb_suplier
                  ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier 
                  WHERE tb_barang_masuk.idSupplier !=0 AND tb_barang_masuk.idSupplier = '$idSupplier'  
                  GROUP BY tb_barang_masuk.idMasuk DESC ";
              }else{
                  $query ="SELECT tb_barang_masuk.* ,  tb_suplier.idSupplier,  
                  tb_suplier.namaSupplier, t1.jumlah, t2.telahBayar
                  FROM tb_barang_masuk 
                  LEFT JOIN (SELECT  tb_list_masuk.idList,  idMasuk, SUM(qtyMasuk*hargaBeliPcs) AS jumlah
                  FROM tb_list_masuk GROUP BY idMasuk ) t1 ON tb_barang_masuk.idMasuk = t1.idMasuk
                  LEFT JOIN (SELECT tb_history_bayar.idHistory, idMasuk, SUM(telahBayar) telahBayar 
                          FROM tb_history_bayar GROUP BY idMasuk) t2 ON tb_barang_masuk.idMasuk = t2.idMasuk
                  LEFT JOIN tb_suplier
                  ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier 
                  WHERE tb_barang_masuk.idSupplier !=0 AND tb_barang_masuk.idSupplier = '$idSupplier' 
                  AND tb_barang_masuk.tanggalMasuk BETWEEN '$dateDari' AND '$dateHingga'
                  GROUP BY tb_barang_masuk.idMasuk DESC ";
              }
              
            }else{

              $query ="SELECT tb_barang_masuk.* ,  tb_suplier.idSupplier,  
              tb_suplier.namaSupplier, t1.jumlah, t2.telahBayar
              FROM tb_barang_masuk 
              LEFT JOIN (SELECT  tb_list_masuk.idList,  idMasuk, SUM(qtyMasuk*hargaBeliPcs) AS jumlah
              FROM tb_list_masuk GROUP BY idMasuk ) t1 ON tb_barang_masuk.idMasuk = t1.idMasuk
              LEFT JOIN (SELECT tb_history_bayar.idHistory, idMasuk, SUM(telahBayar) telahBayar 
                      FROM tb_history_bayar GROUP BY idMasuk) t2 ON tb_barang_masuk.idMasuk = t2.idMasuk
              LEFT JOIN tb_suplier
              ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier 
              WHERE tb_barang_masuk.idSupplier !=0  
              AND tb_barang_masuk.tanggalMasuk BETWEEN '$dateDari' AND '$dateHingga'
              GROUP BY tb_barang_masuk.idMasuk DESC ";
            }
            $transaksi =    mysqli_query($conn , $query);
                  while ($row = mysqli_fetch_object($transaksi)) { 

                    $idMasuk =$row ->idMasuk;
                    $dis= $row->jumlah; 
                    $k= mysqli_query($conn , "SELECT * FROM `tb_discount`  WHERE idMasuk ='$idMasuk'
                    ORDER BY idDiscount ASC "); 
                    while ($u = mysqli_fetch_object($k)) {  ;
                    
                        $dis = $dis - ($dis*($u->discount/100));

                    }
                    $ppn = $dis * $row->ppn/100 ;
                    array_push($daftarTransaksi, array('idMasuk' =>  $idMasuk , 
                                            'tanggalMasuk'=>$row->tanggalMasuk,
                                            'idSupplier'=> $row ->idSupplier,
                                            'namaSupplier'=> $row ->namaSupplier,
                                            'noRef'=> $row ->noRef,
                                            'jumlahTransaksi' => round($ppn+$dis),
                                             'telahBayar'=> round($row->telahBayar),
                                            'sisa'=>round(($ppn+$dis)- $row->telahBayar)     ));
                  } 
                  echo json_encode($daftarTransaksi);

        ?>  


        