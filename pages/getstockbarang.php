<?php
include_once "../config/+connection.php"; 
            $dateDari =  mysqli_real_escape_string($conn,$_POST['dateDari']);
            $dateHingga = mysqli_real_escape_string($conn,$_POST['dateHingga']); 
            $d = array();

            $no = 1;
            $show = mysqli_query($conn,"SELECT tb_barang.idBarang,tb_barang.namaBarang,IFNULL(t4.awal,0) as awal, 
            tb_barang.hargaJual,tb_barang.hargaBeliPcs,
            IFNULL(t3.masuk,0) as masuk,  IFNULL(t1.keluar,0) as keluar
                  FROM tb_barang 
                  LEFT JOIN ( 
                  SELECT tb_jual.idBarang, IFNULL(SUM(tb_jual.qty),0) as keluar
                  FROM tb_jual 
                  LEFT JOIN 
                    tb_transaksi  
                    trans on trans.idTransaksi = tb_jual.idTransaksi 
                    WHERE tanggalTransaksi 
                  BETWEEN '$dateDari 00:00:00' AND '$dateHingga 23:59:00'
                  GROUP BY idBarang	)
                  t1 on t1.idBarang = tb_barang.idBarang
                  LEFT JOIN 
                  (SELECT  tb_barang_masuk.tanggalMasuk, tb_list_masuk.idBarang, SUM(tb_list_masuk.qtyMasuk) as masuk 
                  FROM tb_list_masuk
                  LEFT JOIN 
                  tb_barang_masuk ON tb_list_masuk.idMasuk = tb_barang_masuk.idMasuk
                  WHERE tb_barang_masuk.tanggalMasuk 
                  BETWEEN '$dateDari 00:00:00' AND '$dateHingga 23:59:00'
                  GROUP BY tb_list_masuk.idBarang) 
                  t3 ON t3.idBarang = tb_barang.idBarang 
                  LEFT JOIN (SELECT tb_barang.idBarang,tb_barang.namaBarang,  tb_barang.hargaBeliPcs,
            IFNULL(tm.masuk,0) -IFNULL(tk.keluar,0) as awal  
                  FROM tb_barang 
                  LEFT JOIN (  SELECT tb_jual.idBarang, tb_jual.idTransaksi, IFNULL(SUM(tb_jual.qty),0) as keluar
                  FROM tb_jual 
                  LEFT JOIN 
                    tb_transaksi  
                    trans on trans.idTransaksi = tb_jual.idTransaksi 
                    WHERE tanggalTransaksi 
                  < '$dateDari 00:00:00' 
                  GROUP BY idBarang	)
                  tk on tk.idBarang = tb_barang.idBarang
                  LEFT JOIN 
                  (SELECT  tb_barang_masuk.tanggalMasuk,  tb_list_masuk.idBarang, SUM(tb_list_masuk.qtyMasuk) as masuk 
FROM tb_list_masuk
LEFT JOIN 
tb_barang_masuk ON tb_list_masuk.idMasuk = tb_barang_masuk.idMasuk
                  WHERE tb_barang_masuk.tanggalMasuk 
                  < '$dateDari 00:00:00' 
GROUP BY tb_list_masuk.idBarang) 
                  tm ON tm.idBarang = tb_barang.idBarang  
                  GROUP BY idBarang ) t4 ON t4.idBarang = tb_barang.idBarang 
                  GROUP BY idBarang ");
            while ($data = mysqli_fetch_object($show)) { 
                $d[]= $data;
        }
        echo json_encode($d);
