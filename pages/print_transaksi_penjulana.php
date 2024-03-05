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
    <center>    <h2>Toko Hasil Laut ACN</h2>
        <h3>Transaksi Kredit</h3> </center>
    <body style="  margin: 0; ">
        <?php 
            $idTransaksi= $_GET['id'];   
            $h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tb_transaksi.idTransaksi, 
                tb_transaksi.tanggalTransaksi,tb_transaksi.hDiscount,  tb_pelanggan.* 
            FROM tb_transaksi 
            LEFT  JOIN tb_pelanggan ON  tb_pelanggan.idPelanggan =  tb_transaksi.idPelanggan
            WHERE idTransaksi = '$idTransaksi'
            GROUP BY idTransaksi"));       
        ?>
        <table >
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td width="230"><?php echo $h['namaPelanggan'];?></td>  

                <td>No KK</td>
                <td>:</td>
                <td><?php echo $h['noKk'];?></td>  
            </tr>
            <tr>
                <td>No Telpon</td>
                <td>:</td>
                <td><?php echo $h['noTelponPelanggan'];?></td>  
                
                <td>No KTP</td>
                <td>:</td>
                <td><?php echo $h['noKtp'];?></td>  
            </tr>
            <tr>
                <td>No Telpon Alternatif</td>
                <td>:</td>
                <td><?php echo $h['noTelponPelangganAlternatif'];?></td>  

                <td>Alamat</td>
                <td>:</td>
                <td><?php echo $h['alamatPelanggan'];?></td>  
            </tr>
        </table> 
        <hr>
            <h3>Riwayat Pembayaran</h3>
        <hr>
        <table id="" class="table  example table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jatuh Tempo</th> 
                                <th>Telah Bayar</th>  
                            </tr>
                        </thead>
                        <tbody class="datafetch" id="tbody">
                        <?php $totalByar =0;
                                $no=1;
                                $d = mysqli_query($conn , "SELECT *FROM tb_kredit_bayar WHERE idTransaksi= '$idTransaksi' "); 
                                while ($row = mysqli_fetch_object($d)) {  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td style="text-align:center; "><?php echo dateChange($row->tanggalBayar)  ; ?></td>  
                                    <td><?php echo c($row->telahBayar); ?></td>    
                                </tr>

                                <?php       
                                    $totalByar = $row->telahBayar +$totalByar;         
                                    }
                                ?>
                                <tr>        
                                <td></td> 
                                <td style="text-align:right;border-top: solid 1px ;"> <b style="float:right;" >Total Pembayaran</b> </td>
                                <td  style="border-top: solid 1px ;">  <b  id="totalBiaya"><?php echo convert_to_rupiah($totalByar); ?></b>  </td> 
                                <td></td> 
                            </tr> 
                        </tbody> 
                        
                    </table>
        <hr>
        <h3>Detail Transaksi</h5>
        <hr>
        <table id="" class="table example table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Qty</th> 
                                <th>Harga Satuan</th> 
                                <th>Harga Jual</th> 
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
                            $w=0;
                            $r=1;
                            $o = mysqli_query($conn , "SELECT tb_jual.* ,tb_barang.idBarang, 
                            tb_barang.namaBarang, tb_barang.jenis
                            FROM tb_jual
                            left JOIN tb_barang ON tb_jual.idBarang = tb_barang.idBarang
                            WHERE tb_jual.idTransaksi = '$idTransaksi'
                            GROUP BY tb_jual.idJual "); 
                            while ($p = mysqli_fetch_object($o)) {  ?>
                              <tr>
                                  <td><?php echo $r++; ?></td>
                                  <td><?php echo $p->idBarang; ?></td>
                                  <td><?php echo $p->namaBarang; ?></td>
                                  <td><?php if ($p->jenis==1) {
                                        echo "Furniture";
                                    }else{ echo "Elektronik"; } ?></td>
                                  <td><?php echo $p->qty; ?></td> 
                                  <td><?php echo $p->hargaSatuan; ?></td> 
                                  <?php $totH = $p->hargaSatuan*$p->qty ?>
                                  <td><?php echo c($totH); ?></td>  
                                  <td><?php echo  $p->discount; ?>%</td>  

                                  <?php $total = $totH - ($totH*$p->discount/100); 
                                     $w = $total + $w;
                                  ?>
                                  
                                  <td><?php echo  c($total); ?></td>
                              </tr>      
                       
                            

                        <?php    
                         
                        }
                             
                        ?>
                        
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;">   Biaya </td>
                                <td style=" border-top: solid 1px ;"><b  ><?php echo   c($w ); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;"> Discount </td>
                                <td style=" border-top: solid 1px ;"><b  ><?php echo  $h['hDiscount'] ."%" ; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td  ><b  style="float:right;">  Jumlah Biaya </td>
                                <?php  $tot = $w - ($w*$h['hDiscount']/100);  ?>
                                <td  ><b  ><?php echo  c($tot); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td   ><b  style="float:right;"> Telah di Bayar </td> 
                                <td  ><b  ><?php echo  c($totalByar); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td></td> 
                                <td style=" border-top: solid 1px ;"  ><b  style="float:right;"> Sisa Yang Harus di Bayar	 </td> 
                                <td style=" border-top: solid 1px ;"><b  ><?php echo  c($tot-$totalByar); ?></td>
                            </tr>
                        </tbody> 
                    </table>
    </body>
</html>
  
<?php
 function dateChange(  $original_dateTime )
{
    $newDate = date("Y-m-d", strtotime($original_dateTime));
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