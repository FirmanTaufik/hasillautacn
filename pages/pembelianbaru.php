
<?php
if ( $_SESSION['idMasuk']==null) {
  echo "<script> 
        window.location.href='?page=transaksi';
    </script>";
}
?>
<script>
     var products = [];
</script>
<section class="content-header">
    <?php  $idMasuk=  $_SESSION['idMasuk'] ;  
         $result = mysqli_query($conn, "SELECT * FROM tb_barang_masuk WHERE idMasuk  = '$idMasuk' ");
         $row = mysqli_fetch_assoc($result); 
      ?> 

    <div class="card">
         <form action="" method="post" onsubmit="return validate();">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Pembelian</label>
                            <input type="disable" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php  echo  $_SESSION['idMasuk'] ;  ?> " disabled>
                        </div> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal</label>
                            <!-- <input type="datetime-local" class="form-control" id="exampleInputEmail1"    value="<?php echo $row['tanggalMasuk']; ?>"> -->
                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                <input value="<?php echo $row['tanggalMasuk']; ?>" name="tanggalMasuk"  type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Refrensi</label> 
                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                <input value="<?php echo $row['noRef']; ?>" name="noRef"  type="text" class="form-control  "/>
                                
                            </div>
                        </div>  

                        <div class="form-group">
                            <label>Nama Supplier</label> 
                            <select  id="idSupplier"  name="idSupplier"  class="form-control  "   >
                                    <option  value="0">Pilih Supplier</option>
                                    <?php 
                                        $d = mysqli_query($conn , "SELECT *FROM tb_suplier "); 
                                        while ($row1 = mysqli_fetch_object($d))  {  ?>
                                        <option  value="<?php echo $row1 ->idSupplier;  ?>"> <?php echo $row1 ->namaSupplier; ?></option> 
                                    <?php } ?> 
                                </select>
                        </div>
                         
                    </div>

                    <div class=" col-lg-9 table-responsive">
                                     
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-primary">Barcode</button>
                            </div>
                            <!-- /btn-group -->
                            <input  name="barKode" type="text" class="form-control" id="barKode" placeholder="Barcode Barang" onkeypress="return event.keyCode != 13;" >
                        </div>
                         <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th style="width: 200px">Nama Barang</th>
                                    <th>QTY Masuk</th>
                                    <th>Harga Beli Satuan</th> 
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                    <tr id="tr1">
                                        <td>1.</td>
                                        <td>  
                                            <!-- <input type="text" name="keterangan[]" class="form-control"  placeholder="Keterangan Keperluan" required> -->
                                            <select id="nmBarang1" name="keterangan[]"   class="form-control  " onchange="youBarang('1');" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                                <option  value="0">Pilih Barang</option>
                                                <?php 
                                                    $d = mysqli_query($conn , "SELECT  *FROM tb_barang"); 
                                                    while ($row = mysqli_fetch_object($d)) {  
                                                        echo "<script> products.push('".$row->barKode."') </script>";
                                                      ?>
                                                    <option  data-barKode="<?php echo $row->barKode; ?>"  value="<?php echo $row ->idBarang;  ?>"> <?php echo $row ->namaBarang;  ?>   </option> 
                                                <?php  }?> 
                                            </select>
                                        </td> 
                                        <td> 
                                            <input id="qty1" name="qt[]"  type="number"   max="" class="btnQty form-control"  placeholder="Jumlah Qty" onchange="youFunction('1');"
                                                    onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                        </td>
                                        <td> 
                                            <input id="hargaSatuan1" name="satuanBiaya[]" type="number" class="form-control"  placeholder="Harga Satuan"  required    onchange="youFunction('1');"
                                                    onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                            <!--HARGA BELI PC-->
                                            <input id="hargaBeliPcs1" name="hargaBeliPcs[]" type="hidden" class="form-control"  placeholder="Harga beli Satuan"  required     >
                                        </td> 
                                        <td> 
                                            <input id="jumlah1" type="text" name="jumlah[]" class="form-control"  placeholder="Total Harga" readonly  >  
                                        </td>
                                        <td> 
                                            <button class="btn btn-danger btn-sm" onClick="delTr(1)" ><i class="fas fa-trash"></i></button>  
                                        </td>
                                    </tr> 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"><b class="float-right"> Biaya   </b></td>
                                        <td> <input id="totalBiaya" class="form-control" type="text" readonly  > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b class="float-right">Discount   </b></td>
                                        <td  colspan="2" > 
                                            <div id="divDiscount">     
                                                <div class="row" id="divIn1">
                                                    <div class=" col-8 " >
                                                        <input value="0" id="discount1"  name="discount[]" class="form-control" type="number"    >    
                                                        
                                                    </div>           
                                                    <div class="col-4 "  >
                                                        <button class="btn btn-danger btn-sm " onClick="delDis(1)" ><i class="fas fa-trash"></i></button>  
                                                    </div> 
                                                </div>
                                                                               
                                               
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="4"><b class="float-right">PPN   </b></td>
                                        <td> <input id="jmlPPN" name="jmlPPN" class="form-control" type="text"    value="0" > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b class="float-right">Jumlah Biaya   </b></td>
                                        <td> <input id="jumlahBiaya" name="jumlahBiaya" class="form-control" type="text"   readonly > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b class="float-right">Uang   </b></td>
                                        <td> <input id="uang" name="telahBayar" class="form-control" type="text"    > </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="4"><b class="float-right">Sisa Bayar   </b></td>
                                        <td> <b  id="kembali"></b>   </td>
                                    </tr>
                                    <tr>

                                    </tr>
                                </tfoot>
                            </table>
                            
                            <div class="clearfix p-3"> 
                                <input style="margin-right: 5px;"  type="submit" name="submit" class="float-right btn btn-success" value="Simpan">
                                <button type="button" style="margin-right: 5px;" class="float-right float-right  text-right btn btn-primary"  onClick="addDiscount()">Tambah Discount</button> 
                                <button style="margin-right: 5px;" class="float-right float-right  text-right btn btn-primary"  onClick="addTr()">Tambah Rincian</button> 
                                
                                
                            </div>
                    </div>
                </div>
            </div>
        </form>
    </div>  
      
</section>


<?php
if (isset($_POST['submit'])) { 

    $idMasuk = mysqli_real_escape_string($conn,$_SESSION['idMasuk']); 
    $tanggalMasuk = mysqli_real_escape_string($conn,$_POST['tanggalMasuk']); 
    $noRef = mysqli_real_escape_string($conn,$_POST['noRef']); 
    $idSupplier = mysqli_real_escape_string($conn,$_POST['idSupplier']); 
    $telahBayar = mysqli_real_escape_string($conn,$_POST['telahBayar']); 
    $jmlPPN = mysqli_real_escape_string($conn,$_POST['jmlPPN']); 

    $keterangan =$_POST['keterangan']; 
    $satuanBiaya = $_POST['satuanBiaya']; 
    $jumlah =$_POST['jumlah'];  
    $qt = $_POST['qt']; 
    $hargaBeliPcs = $_POST['hargaBeliPcs']; 

    $discount = $_POST['discount']; 


    $trans = mysqli_query($conn, "UPDATE tb_barang_masuk SET tanggalMasuk ='$tanggalMasuk', noRef ='$noRef', idSupplier = '$idSupplier' , ppn = '$jmlPPN'
                    WHERE idMasuk ='$idMasuk'   ");
    
    echo mysqli_error($conn);
     if ($trans) { 

        $length = count($keterangan);

        for ($i = 0; $i < $length; $i++) { 
            $k = $keterangan[$i];
            $q = $qt[$i];
            $s = $satuanBiaya[$i]; 
 
            mysqli_query($conn, "INSERT INTO tb_list_masuk VALUES ('', '$idMasuk', '$k', '$q', '$s' )");
        }

        $le = count($discount);

        for ($i = 0; $i < $le; $i++) { 
            $dis= $discount[$i]; 
 
            mysqli_query($conn, "INSERT INTO tb_discount VALUES ('', '$idMasuk', '$dis') ");
        }


       $bayar =  mysqli_query($conn, "INSERT INTO tb_history_bayar VALUES ('', '$idMasuk', '$tanggalMasuk', '$telahBayar')");

       if ($bayar) {
            $_SESSION['idMasuk'] =null;
            echo "<script>
                alert('sukses menyimpan');
                window.location.href='?page=transaksipembelian';
            </script>";
       }
    }else{
        $_SESSION['idMasuk'] =null;
        echo "<script>
            alert('gagal menyimpan');
            window.location.href='?page=transaksipembelian';
        </script>";
    }
    

}
?>
 

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
  
    <script type="text/javascript"> 

    $("#barKode").focus();
    var countDiv=1;
    function addDiscount() { 
        countDiv++;
          var element = " <div style='margin-top:5px;' class='row' id='divIn"+countDiv+"'> <div class=' col-8 ' > <input style=' ' value='0' id='discount"+countDiv+"'  name='discount[]' class='form-control' type='number'  >  </div>  <div class='col-4 '  ><button class='btn btn-danger btn-sm ' onClick='delDis("+countDiv+")' ><i class='fas fa-trash'></i></button>  </div>  </div>  ";
         
         document.getElementById('divDiscount').insertAdjacentHTML('beforeend',element);
    }

    function delDis(params) {        
        document.getElementById("divIn"+params).remove();
        document.getElementById("divBut"+params).remove();
    }

        var sisa ; 
         function youBarang(param1) {
            // $("#nmBarang"+param1).change(function () {
            //     var cntrol = $(this);
            //     // $("#transaksiNo").val(cntrol.find(':selected').data('no')); 
            //   //  $("#hargaSatuan"+param1).val(3000)
            //      $("#hargaSatuan"+param1).val(parseFloat(cntrol.find(':selected').data('hargajual'))); 
            //      sisa= parseFloat(cntrol.find(':selected').data('sisa') );
            //      $("#qty"+param1).attr("max",parseFloat(cntrol.find(':selected').data('sisa') ));  
            //      $("#hargaBeliPcs"+param1).val(parseFloat(cntrol.find(':selected').data('hargabelipcs'))); 

                 
            //     console.log("dadadad"+sisa);
            //     youFunction(param1);
            //     $(".btnQty").keydown(function(event) { 
            //          return false;
            //     });
            // });
         }

         
      function youFunction(param1) {
        // console.log(param1); // 1 
          var hargaSatuan = document.getElementById("hargaSatuan"+param1).value 
          var qty = document.getElementById("qty"+param1).value
 
          var t = hargaSatuan*qty;
          console.log("harga satuan"+hargaSatuan); // 1  
          document.getElementById("jumlah"+param1).value =t;

        }

        
      var i =1;

      $(document).ready(function () {
            console.log('array'+products[0]);
          console.log('readyyyyyyyyyyy');
        window.setInterval('barCodeFun()', 2000); 
       
        } ) 


    
      function barCodeFun() {  
            var selectvar = $('#barKode').val();  
            if (digitCount(selectvar)>11) {   
                    if (!checkAvailableBarcode(selectvar)) {
                        return
                    }     
                    var pos = checking(selectvar);   
                    var divName = "#nmBarang"+pos+" "  ;       
                 if (pos==0) {
                     if (i==1) {
                         //JIKA HANYA ADA  1 TR
                         var c =  $("#nmBarang1").find(':selected').data('barkode');
                         if (c==selectvar) {
                            var qty =  $("#qty1")
                            var q = qty.val();
                            if (q==0) {
                                qty.val(1);
                            }else{
                                qty.val(parseFloat(q)+1);
                            }
                                setHarga('1');
                         }else{
                                var v = $( "#nmBarang1" ).val();
                             if (v==0) {
                                $("#nmBarang1 option[data-barkode='" + selectvar + "']").prop("selected", true); 
                                var tu=  $( "#nmBarang1" ).val();
                                if (tu!=0) {
                                    var qty =  $("#qty1")
                                    var q = qty.val();
                                    if (q==0) {
                                        qty.val(1);
                                    }else{
                                        qty.val(parseFloat(q)+1);
                                    }
                                    setHarga('1');
                                }
                              
                             }else{
                                 addTr()
                                 $("#nmBarang2 option[data-barkode='" + selectvar + "']").prop("selected", true); 
                                 var tu=  $( "#nmBarang2" ).val();
                                    if (tu!=0) { 
                                        var qty =  $("#qty2")
                                        var q = qty.val();
                                        if (q==0) {
                                            qty.val(1);
                                        }else{
                                            qty.val(parseFloat(q)+1);
                                        }
                                        console.log('addteer');
                                        setHarga('2')

                                    };
                             }
                           
                         }
                       
                     }else{
                         console.log('addteeruu');
                                 addTr()
                                 $("#nmBarang"+i+" option[data-barkode='" + selectvar + "']").prop("selected", true); 
                                    var qty =  $("#qty"+i)
                                    var q = qty.val();
                                    if (q==0) {
                                        qty.val(1);
                                    }else{
                                        qty.val(parseFloat(q)+1);
                                    }
                                    console.log('addteer');
                                    setHarga(i);
                         //JIKA LEBIH DARI 1 TR
                     }
                 }else{

                     //JIKA ADA
                     console.log('JIKA ADA');
                //      addTr()
                    var qty =  $("#qty"+pos)
                    var q = qty.val();
                    if (q==0) {
                        qty.val(1);
                    }else{
                        qty.val(parseFloat(q)+1);
                    }
                    setHarga(pos);
                  } 
            console.log('codeee '+selectvar);
            $('#barKode').val('');  
                //  console.log('posss'+pos);
            }
             
        }

        function checkAvailableBarcode(params) {
            for (var i = 0; i < products.length; i++) {
                if (products[i]==params) {
                    return true;
                }
                
            }
            return false;
        }

        function setHarga(param1) {  
            // var cntrol = $("#nmBarang"+param1); 
            // $("#hargaSatuan"+param1).val(parseFloat(cntrol.find(':selected').data('hargajual'))); 

            //     sisa= parseFloat(cntrol.find(':selected').data('sisa') );

            //     $("#qty"+param1).attr("max",parseFloat(cntrol.find(':selected').data('sisa') )); 

            //     $("#hargaBeliPcs"+param1).val(parseFloat(cntrol.find(':selected').data('hargabelipcs'))); 

            //     var qty = $("#qty"+param1).val();
            //     var satuan = $("#hargaBeliPcs"+param1).val();

            //     $("#jumlah"+param1).val(12345);
                 
             youFunction(param1);
            $(".btnQty").keydown(function(event) { 
                    return false;
            });
        }


        function checking(params) {
            for ( x = 1; x <= i; x++) { 
                var divName = "#nmBarang"+x+" "  ;
                if (divName!=null) {
                    var c =  $("#nmBarang"+x).find(':selected').data('barkode');
                    if (c==params) {
                        return x;
                    }
                }
            } 
            return 0;
        }

     
        function digitCount(num) {
            if(num === 0 ) return 1
            return Math.floor(Math.log10(Math.abs(num))) + 1
        }
      function delTr(params) {
        document.getElementById("tr"+params).remove();
      }
      function addTr() {
        i = i+1; 
        var baris1 = "<tr id='tr"+i+"'> <td>"+i+".</td>  ";
        var baris2 = "<td><select id='nmBarang"+i+"'  name='keterangan[]'  class='form-control'  onchange='youBarang("+i+");' onkeyup='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'>   <option >Pilih Barang"+getBarang(i);
        var baris3 = "<td> <input id='qty"+i+"' name='qt[]'    type='number' class='btnQty form-control'  placeholder='Jumlah Satuan' onchange='youFunction("+i+");'  onkeyup='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'>   </td>  ";
        var baris4 = "<td> <input id='hargaSatuan"+i+"' name='satuanBiaya[]' type='text' class='form-control'  placeholder='Harga Satuan' required  onchange='youFunction("+i+");' onkeyup='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'>   </td>";
        var baris6 = "<td> <input id='jumlah"+i+"' name='jumlah[]' type='text' class='form-control'  placeholder='Total Harga' readonly >   </td>  ";
        var baris7 = "<td> <button class='btn btn-danger btn-sm' onClick='delTr("+i+")'><i class='fas fa-trash'></i></button>  </td>  </tr>";
        var hasil = baris1+baris2+baris3+baris4+baris6+baris7;
        document.getElementById('tbody').insertAdjacentHTML('beforeend',hasil);
      //  console.log(i); // 1  

      }
      
    </script>



<script type="text/javascript">
    function validate() {        
            var u = $('#idSupplier').val();
            console.log(u);
            if (u==0) {
                alert('Supplier Belum di Pilih');
                 return false;  
            }         

    }
      window.setInterval('refresh()', 2000); 
      function refresh() { 
        var total=0;       
        var rows =document.getElementsByTagName("tbody")[0].rows;
        for(var i=0;i<rows.length;i++){
          var td = rows[i].getElementsByTagName("td")[4];
          var isi = td.getElementsByTagName("input")[0].value; 
          total = total+parseFloat(isi);
        }
          if (!Number.isNaN(total)) {
            
            //  console.log("hasil "+total);
               document.getElementById('totalBiaya').value =  total;
            //     document.getElementById('totalBiaya').value =total;

            //     var tfoot = document.getElementsByTagName("tfoot")[0].rows[1];
            //     var uang= tfoot.getElementsByTagName("input")[0].value;

            //     var h =uang -total  ;
            //     document.getElementById('kembali').innerHTML = convertToRupiah(h);
            //   console.log("uang "+h);

            var m = total;
              for (  i = 1; i <= countDiv; i++) { 
                  var idDiv = "discount"+i;
                    var varDis = document.getElementById(idDiv) 
                    if (varDis!=null) {

                        m= m - (m*(parseFloat(varDis.value)/100));
                        console.log(m);

                        // var jmlDiscount = varDis.value 
                        // var hasil = total (jmlDiscount)/100;
                    }
              }  
              var ppn =  document.getElementById('jmlPPN').value
              var appn = m * ppn/100 ;
            //  document.getElementById('jmlPPN').value = Number( ( ppn).toFixed(1) );  
              document.getElementById('jumlahBiaya').value =   Number( ( m+appn).toFixed(1) );          

              var g = m+appn
              var uang=   document.getElementById('uang').value;
              var h = parseFloat(uang) -g  ;
               
              if (!Number.isNaN(h)) { 
                    document.getElementById('kembali').innerHTML = convertToRupiah( Number( ( h).toFixed(1) ) );

              }
          }
      }

      function convertToRupiah(angka)
      {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      }
</script>


<?php
    $q="SELECT  *FROM tb_barang";
  echo '  <script>
    function getBarang(p) {
         return \'</option>';

        $d = mysqli_query($conn , $q); 
        while ($row = mysqli_fetch_object($d)) {   
            echo' <option  value="'. $row ->idBarang.'"'; echo '  data-barkode="'.  $row->barKode.'"   >';  echo $row ->namaBarang.'</option> ';
       }     
        
    echo'     </td>\';
        }

</script>';
