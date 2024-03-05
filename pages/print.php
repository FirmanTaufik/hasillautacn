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
        <title>Receipt  </title>
      
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
        <div style=" " class="ticket">
            <div style="float: left; width:50%;">
                <h2> Toko Hasil Laut ACN</h2>
                <label for=""><b>Jl Bandengan Slt 43 Bl K/12 Pejagalan, Dki Jakarta </b>
                    <br><b> T: (0266)123546564</b>
                </label>
              </div>
            <div style="float: right;">
            <br>
            <br>
            
            <?php
                $id = $_GET['id'];
                $row = mysqli_fetch_assoc(mysqli_query($conn ,"SELECT tb_transaksi.*, tb_pelanggan.* 
                FROM tb_transaksi
                LEFT JOIN tb_pelanggan ON tb_transaksi.idPelanggan = tb_pelanggan.idPelanggan  WHERE idTransaksi  = '$id' ")); 
             ?>
            <table>
                <tr>
                    <td><b>No Transaksi</b></td>
                    <td><b>:</b></td>
                    <td><b><?php echo $id; ?></b></td>
                </tr>
                <tr>
                    <td><b>Tanggal</b></td>
                    <td><b>:</b></td>
                    <td><b><?php echo  date("d-m-Y", strtotime($row['tanggalTransaksi'])); ?></b></td>
                </tr>
                <tr>
                    <td><b>Konsumen</b></td>
                    <td><b>:</b></td>
                    <td><b><?php echo $row['namaPelanggan']; ?></b></td>
                </tr>
            </table> 

            <br> 
            </div>
            <table>
                <thead>
                    <tr style="border-top:1px solid;"> 
                        <th>No</th>
                        <th  >Nama  </th>
                        <th  >QTY</th>
                        <th  >Harga  </th>
                        <th>Discount</th>
                        <th >Jumlah</th> 
                    </tr>
                </thead>
                <tbody>
                <?php
                      $total =0;
                        $w=0;
                        $no=1;
                        $j = mysqli_query($conn, "SELECT    tb_barang.namaBarang, tb_jual.*
                        FROM tb_jual 
                        LEFT JOIN tb_barang ON tb_jual.idBarang =  tb_barang.idBarang
                        WHERE idTransaksi = '$id'");
                        while ($data = mysqli_fetch_object($j)) {   $w++; 
                            $total = $data->totalHarga+$total;   
                            ?>  
                         <tr> 
                             <td style="text-align: center;"><b> <?php echo $no++; ?> </b> </td> 
                            <td  style="text-align: center;"> <b> <?php echo $data->namaBarang; ?>  </b> </td> 
                            <td  style="text-align: center;">  <?php echo $data->qty; ?> </b>  </td> 
                            <td  style="text-align: center;"> <b> <?php echo c($data->hargaSatuan); ?>   </b></td> 
                            <td class="price" style="text-align: center;"> <b> <?php echo $data->discount; ?>  %</b> </td> 
                            <td  style="text-align: center;"> <b> <?php echo c($data->totalHarga); ?>  </b> </td> 
                        </tr> 

                    <?php
                        } ?>
                    <?php
                        $id = $_GET['id'];
                        $row = mysqli_fetch_assoc(mysqli_query($conn ,"SELECT tb_transaksi.*, tb_pelanggan.* 
                        FROM tb_transaksi
                        LEFT JOIN tb_pelanggan ON tb_transaksi.idPelanggan = tb_pelanggan.idPelanggan  WHERE idTransaksi  = '$id' ")); 
                        $uangPel =  $row['uangPelanggan'];
                        $hDiscount =  $row['hDiscount'];
                    ?>
                    <tr style="border-top:1px solid;">                     
                        <td style="text-align: right;" colspan="5"><b>  Biaya:</b></td>
                        <td style="text-align: center;"><b><?php echo $total; ?></b></td>
                     </tr>
                   <tr  > 
                         <td style="text-align: right;" colspan="5"><b>Discount:</b></td>
                         <td style="text-align: center;"><b><?php echo $hDiscount; ?>%</b></td> 
                    </tr>
                   <tr  style="border-top:1px solid;">      
                        <?php $t = $total - ($total*$hDiscount/100) ?>
                         <td style="text-align: right;"  colspan="5"><b>Total Biaya:</b></td>
                         <td style="text-align: center;"><b><?php echo $t; ?></b></td> 
                    </tr>
                    <tr> 
                        <td style="text-align: right;" colspan="5"><b>Tunai:</b></td>
                        <?php  $id=  $_GET['id'] ;  
                            $result = mysqli_query($conn, "SELECT  * FROM `tb_kredit_bayar`
                            WHERE idTransaksi  = '$id'  LIMIT 1");
                            $z = mysqli_fetch_assoc($result);  
                        ?>
                        <td style="text-align: center;"><b><?php echo $z['telahBayar']; ?></b></td>
                    </tr>
                    <tr style="border-top:1px solid;">
                        <td  colspan="6"></td>
                    </tr>
                    <tr> 
                        <td style="text-align: right;"  colspan="5"><b>Sisa Harus Bayar:</b></td>
                        <td style="text-align: center;"><b><?php echo c($t- $z['telahBayar']); ?></b></td>
                    </tr>

                    <!-- <tr style="border-top:1px solid;">
                        <td></td>
                    </tr>
                    <tr style="border-top:1px solid;">
                        <td colspan="5"><b> Tanggal: <?php echo $row['tanggalTransaksi']; ?></b></td>
                    </tr> -->
                </tbody>
               
                <tfoot>
                    
                </tfoot>
            </table>
            
        </div> 
        <script src="script.js"></script>
    </body>
</html>

<?php
    function c($angka)
    {
        return strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }
?>    
<script>
  window.addEventListener("load", window.print());
  setTimeout(function () { window.close(); }, 100);
</script>