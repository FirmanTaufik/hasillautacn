<?php
include_once "../config/+connection.php"; 
            $dateDari =  mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']); 
            $d = array();

             $queryawal ="SELECT  tb_list_masuk.idList, tb_barang_masuk.tanggalMasuk, tb_list_masuk.idMasuk,   tb_barang_masuk.noRef, tb_suplier.namaSupplier,  tb_barang.idBarang, tb_barang.namaBarang,   IFNULL(t2.masuk,0) qtyMasuk, tb_list_masuk.hargaBeliPcs
             FROM tb_list_masuk
             LEFT JOIN
              tb_barang ON tb_list_masuk.idBarang = tb_barang.idBarang
              LEFT JOIN 
               (SELECT tb_barang_masuk.idSupplier, tb_list_masuk.idList,tb_barang_masuk.noRef, tb_barang_masuk.tanggalMasuk, tb_list_masuk.idBarang, SUM(tb_list_masuk.qtyMasuk) as masuk 
   FROM tb_list_masuk
   LEFT JOIN 
   tb_barang_masuk ON tb_list_masuk.idMasuk = tb_barang_masuk.idMasuk
   GROUP BY tb_list_masuk.idList)t2 ON tb_list_masuk.idList = t2.idList
               LEFT JOIN 
             tb_barang_masuk ON tb_list_masuk.idMasuk =  tb_barang_masuk.idMasuk
              LEFT JOIN 
              tb_suplier ON tb_barang_masuk.idSupplier = tb_suplier.idSupplier
             
   WHERE tb_barang_masuk.tanggalMasuk 
   BETWEEN '$dateDari 00:00:00' AND '$dateHingga 23:59:00'
                  GROUP BY idList
                 ORDER BY tanggalMasuk ASC ";
 
            $arrayName = array( );
            $show = mysqli_query($conn,$queryawal);
            while ($data = mysqli_fetch_object($show)) { 
                

                $old_date =$data->tanggalMasuk;
                $newDate= date("Y-m-d", strtotime($old_date));

                $querydua = "SELECT  tb_barang_masuk.tanggalMasuk, tb_list_masuk.idList, tb_list_masuk.idBarang, IFNULL(SUM(tb_list_masuk.qtyMasuk),0) as awal 
                FROM tb_list_masuk
                LEFT JOIN 
                tb_barang_masuk ON tb_list_masuk.idMasuk = tb_barang_masuk.idMasuk
                                  WHERE tb_barang_masuk.tanggalMasuk 
                                  < '$newDate 00:00:00' AND idBarang = '$data->idBarang'
                GROUP BY tb_list_masuk.idList";
                $s = mysqli_query($conn,$querydua);
                $row = mysqli_fetch_assoc($s);
                $j = mysqli_num_rows($s);
                 
                if ($j==0) {
                   
                    array_push( $arrayName,array( 'idList' =>  $data->idList,
                    'tanggalMasuk' =>  $data->tanggalMasuk,
                    'idMasuk' =>  $data->idMasuk,
                    'noRef' =>  $data->noRef,
                    'namaSupplier' =>  $data->namaSupplier,
                    'idBarang' =>  $data->idBarang,
                    'namaBarang' =>  $data->namaBarang,
                    'qtyMasuk' =>  $data->qtyMasuk,
                    'hargaBeliPcs' => $data->hargaBeliPcs,
                    'awal' => '0' )) ;
                } else {
                    
                    array_push( $arrayName,array( 'idList' =>  $data->idList,
                    'tanggalMasuk' =>  $data->tanggalMasuk,
                    'idMasuk' =>  $data->idMasuk,
                    'noRef' =>  $data->noRef,
                    'namaSupplier' =>  $data->namaSupplier,
                    'idBarang' =>  $data->idBarang,
                    'namaBarang' =>  $data->namaBarang,
                    'qtyMasuk' =>  $data->qtyMasuk,
                    'hargaBeliPcs' => $data->hargaBeliPcs,
                    'awal' =>  $row['awal'] )) ;
                }
                
            }

            echo json_encode($arrayName);

?>  


        