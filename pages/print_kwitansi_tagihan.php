<?php
  $id = $_GET['id'];
include_once "../config/+connection.php"; ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Toko Hasil Laut ACN </title>
        <style type="text/css">
            @print {
    @page :footer {
        display: none
    }
  
    @page :header {
        display: none
    }
}
            table,th, td{
                padding: 5px; 
            border-collapse: collapse; }
            table{ width: 100%; }
            th, td{   }
          </style>
    </head> 
    <body style="  margin: 0; ">
    
    <?php 
            $idTransaksi= $_GET['id'];   
            $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tb_transaksi.idTransaksi,tb_transaksi.hDiscount,tb_transaksi.jenisTransaksi, tb_transaksi.tanggalTransaksi, tb_pelanggan.*, 
            IFNULL(t1.jumlah,0) jumlah ,  IFNULL(t2.bayar,0) bayar
                            FROM tb_transaksi 
                            LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
                            LEFT JOIN (SELECT tb_jual.idTransaksi,  tb_jual.hargaSatuan * tb_jual.qty as harga , 
(tb_jual.hargaSatuan * tb_jual.qty) - FLOOR((tb_jual.hargaSatuan * tb_jual.qty)*tb_jual.discount/100 ) as jumlah
                                        FROM tb_jual GROUP BY  tb_jual.idTransaksi ORDER BY tb_jual.idTransaksi DESC ) t1 ON t1.idTransaksi =  tb_transaksi.idTransaksi
                            LEFT JOIN (SELECT tb_kredit_bayar.idTransaksi,IFNULL(SUM(tb_kredit_bayar.telahBayar),0)  AS bayar 
                                        FROM tb_kredit_bayar GROUP BY  tb_kredit_bayar.idTransaksi ) t2 ON t2.idTransaksi =  tb_transaksi.idTransaksi
                            
            WHERE tb_transaksi.idTransaksi = '$idTransaksi'
            GROUP BY idTransaksi"));       
        ?>
        <center>
            <h2>Toko Hasil Laut ACN</h2>
            <!-- <h3>Jl Bandengan Slt 43 Bl K/12 Pejagalan, Dki Jakarta <br>(0266)123546564	 </h3> -->
         </center>
        <hr>
        <h3>BUKTI PEMBAYARAN ANGSURAN</h3>
       <table>
       <tr>
            <td>NO TAGIHAN</td>
            <td>:</td>
            <td><?php echo $idTransaksi; ?></td>
        </tr>
        <tr>
            <td width="200">TELAH TERIMA DARI</td>
            <td width="10">:</td>
             <td><?php echo $h['namaPelanggan'];?></td>  
        </tr>
        <tr>
            <td>SEJUMLAH</td>
            <td>:</td>
            <?php $total = $h['jumlah']- ($h['jumlah']*$h['hDiscount']/100); ?>

            <td><?php echo convert_to_rupiah($total/ $h['jenisTransaksi']);?></td> 
        </tr>
        
        <tr>
            <td>ANGSURAN KE</td>
            <td>:</td>
 
            <td><?php echo $_GET['iuranke']; ?></td>  
        </tr>
       </table>
       <br>
       <div style="float:right">
            <label><b>Sukabumi, <?php echo dateChange($_GET['jt']); ?></b></label> 
            <center> <label><b>Kolektor</b></label>  
            <br>
            <br>
            <br>
            <br>
             <hr>
            </center>
            
        </div>
        <!-- <div>
            <br> 
            <h3 style="float:left; border:1px solid;">Rp. <hr> </h3>

        </div> -->
    </body>
</html>
  
<?php
 function dateChange(  $original_dateTime )
{
    $newDate = date("d-m-Y", strtotime($original_dateTime));
    return $newDate;
}
    function c($angka)
    {
        return strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
    

function convert_to_rupiah($angka)
{
    return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
}
?> 
<script>
  window.addEventListener("load", window.print()); 
</script>