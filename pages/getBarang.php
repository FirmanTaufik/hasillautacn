<?php
include_once "../config/+connection.php";  
            $jenis =  mysqli_real_escape_string($conn,$_POST['jenis']); 
            $d = array();

            if ($jenis==0) {
                $queryawal ="SELECT t1.idBarang , t1.barKode, t1.jenis, t1.namaBarang,
             t1.hargaBeliPcs,  t1.hargaJual,
                   t3.masuk,
                   t2.keluar 
            FROM tb_barang t1
            LEFT JOIN
            (
                SELECT tb_barang.idBarang, tb_barang.barKode, IFNULL(SUM(tb_jual.qty),0) AS keluar
                FROM tb_barang
              LEFT JOIN tb_jual ON tb_barang.idBarang = tb_jual.idBarang
                GROUP BY tb_barang.idBarang
            ) t2
                ON t1.idBarang = t2.idBarang
            LEFT JOIN
            (
                SELECT tb_barang.idBarang,  IFNULL(SUM(tb_list_masuk.qtyMasuk),0) AS masuk
                FROM tb_barang
              LEFT JOIN tb_list_masuk ON tb_barang.idBarang = tb_list_masuk.idBarang
                GROUP BY tb_barang.idBarang
            ) t3
                ON t1.idBarang = t3.idBarang                      
                
                    GROUP BY  idBarang
                ORDER BY idBarang DESC ";
  
            $show = mysqli_query($conn,$queryawal);
             
            while ($data = mysqli_fetch_object($show)) { 
                $d[]= $data;
        }
            }else{
                $queryawal ="SELECT t1.idBarang , t1.barKode, t1.jenis, t1.namaBarang,
                t1.hargaBeliPcs,  t1.hargaJual,
                      t3.masuk,
                      t2.keluar 
               FROM tb_barang t1
               LEFT JOIN
               (
                   SELECT tb_barang.idBarang, tb_barang.barKode, IFNULL(SUM(tb_jual.qty),0) AS keluar
                   FROM tb_barang
                 LEFT JOIN tb_jual ON tb_barang.idBarang = tb_jual.idBarang
                   GROUP BY tb_barang.idBarang
               ) t2
                   ON t1.idBarang = t2.idBarang
               LEFT JOIN
               (
                   SELECT tb_barang.idBarang,  IFNULL(SUM(tb_list_masuk.qtyMasuk),0) AS masuk
                   FROM tb_barang
                 LEFT JOIN tb_list_masuk ON tb_barang.idBarang = tb_list_masuk.idBarang
                   GROUP BY tb_barang.idBarang
               ) t3
                   ON t1.idBarang = t3.idBarang                      
                    where t1.jenis = '$jenis'
                       GROUP BY  idBarang
                   ORDER BY idBarang DESC ";
     
               $show = mysqli_query($conn,$queryawal);
                
               while ($data = mysqli_fetch_object($show)) { 
                   $d[]= $data;
           }
            }

            
            echo json_encode($d);

?>  


        