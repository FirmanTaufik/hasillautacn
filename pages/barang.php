  <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

    if ($_GET['act'] == '') {


    ?>
      <section class="content-header">
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title p-3">Filter Berdasarkan Jenis Barang</h3>
                  <div class="row float-right">
                      <table>
                          <tbody>
                              <tr>
                                  <td class="p-3">Jenis Barang </td>
                                  <td>
                                      <select name="jenis" id="jenis" class="form-control">
                                          <option value="0">Semua</option>
                                          <option value="1">Furniture</option>
                                          <option value="2">Elektronik</option>
                                      </select>
                                  </td>
                                  <td class="p-2">
                                      <a id="wew" onclick="load_click()">
                                          <button type="button" class="btn btn-success btn-sm text-white"><i class="me-2 mdi mdi-message-reply-text"> </i> Filter Barang</button>
                                      </a>
                                  </td>
                              </tr>
                          </tbody>
                      </table>

                  </div>

              </div>
              <div class="card-body">
                  <table id="example3" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Kode </th>
                              <th>Barcode </th>
                              <th>Nama Barang</th>
                              <th>Jumlah Stock</th>
                              <th>Satuan</th>
                              <th>Harga Beli </th>
                              <th>Harga Jual </th>
                              <th>Keuntungan</th>
                              <th>Action</th>
                          </tr>
                      </thead>

                      <tbody>
                          <?php
                            $no = 1;
                            $d = mysqli_query($conn, "SELECT t1.idBarang , t1.barKode, tb_satuan_barang.namaSatuan, t1.namaBarang,
                            t1.hargaBeliPcs,  t1.hargaJual,
                                  t3.masuk,
                                  t2.keluar 
                           FROM tb_barang t1
                           left JOIN tb_satuan_barang ON tb_satuan_barang.id = t1.idSatuanBarang
                                               
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
                               ORDER BY idBarang DESC");
                            while ($row = mysqli_fetch_object($d)) {  ?>
                              <tr>
                                  <td><?php echo $no++; ?></td>
                                  <td><?php echo $row->idBarang; ?></td>
                                  <td><?php echo $row->barKode; ?></td>
                                  <td><?php echo $row->namaBarang; ?></td>
                                  <td><?php echo $row->masuk - $row->keluar; ?>  </td>
                                  <td><?php echo $row->namaSatuan; ?></td>
                                  <td><?php echo convert_to_rupiah($row->hargaBeliPcs); ?></td>
                                  <td><?php echo convert_to_rupiah($row->hargaJual); ?></td>
                                  <td><?php echo convert_to_rupiah($row->hargaJual - $row->hargaBeliPcs); ?></td>
                                  <td>
                                      <!-- <a href="?page=detailbarang&id=<?php echo $row->idBarang; ?>"  >
                                <button class="btn btn-success btn-sm" ><i class="fas fa-eye"></i></button>
                            </a> -->
                                      <button onClick="onEdit(<?php echo $row->idBarang;  ?>)" data-toggle="modal" data-target="#modal-edit<?php echo $row->idBarang;  ?>" class="btn btn-primary  btn-sm"><i class="fas fa-edit"></i></button>
                                      <a href="?page=barang&act=del&id=<?php echo $row->idBarang; ?>" onclick="return confirm('Apakah Anda Benar Benar Ingin Menghapus?')">
                                          <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                      </a>
                                  </td>
                              </tr>

                          <?php
                            }
                            ?>

                      </tbody>
                  </table>
              </div>
          </div>
      </section>


      <div class="modal fade  " id="modal-add">
          <div class="modal-dialog  ">
              <div class="modal-content">
                  <form id="#my-form" action="" method="post" enctype="multipart/form-data">
                      <div class="modal-header">
                          <h4 class="modal-title">Tambah Barang</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">

                          <div class="row">
                              <div class="col-lg-12">
                                  <table class="table table-borderless">
                                      <tr>
                                          <td>Barcode</td>
                                          <td><input autofocus value="" type="text" name="barKode" id="barKode" class="form-control" onkeypress="return event.keyCode != 13;"></td>
                                      </tr>
                                      <tr>
                                          <td>Nama Barang </td>
                                          <td><input type="text" name="namaBarang" class="form-control" id=""></td>
                                      </tr>
                                      <tr>
                                          <td>Satuan Barang </td>
                                          <td>
                                               <select class="form-control" name="idSatuanBarang" id="">
                                                   <?php
                                                    $w = mysqli_query($conn , "SELECT * FROM `tb_satuan_barang`     "); 
                                                    while ($row = mysqli_fetch_object($w)) {  ?>                                                    
                                                        <option value="<?php echo $row->id; ?>"> <?php echo $row->namaSatuan; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                               </select>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>Harga Jual Pcs </td>
                                          <td><input type="number" name="hargaJual" class="form-control" id=""></td>
                                      </tr>
                                      <tr>
                                          <td>Harga Beli Pcs </td>
                                          <td><input type="number" name="hargaBeliPcs" class="form-control" id=""></td>
                                      </tr>
                                  </table>
                              </div>

                          </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit" name="save" class="float-right btn btn-primary" value="Simpan">
                      </div>
                  </form>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>

      <?php
        $no = 1;
        $d = mysqli_query($conn, "SELECT   *FROM tb_barang ");
        while ($row = mysqli_fetch_object($d)) {  ?>

          <div class="modal fade  " id="modal-edit<?php echo $row->idBarang; ?>">
              <div class="modal-dialog  ">
                  <div class="modal-content">
                      <form id="#my-form" action="" method="post" enctype="multipart/form-data">
                          <div class="modal-header">
                              <h4 class="modal-title">Edit Barang</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">

                              <div class="row">
                                  <div class="col-lg-12">
                                      <table class="table table-borderless">
                                          <tr>
                                              <td>Barcode</td>
                                              <td><input id="barKode<?php echo $row->idBarang; ?>" value="<?php echo $row->barKode; ?>" type="text" name="barKode" class="form-control" id=""></td>
                                          </tr> 
                                          <tr>
                                              <input value="<?php echo $row->idBarang; ?>" type="hidden" name="idBarang" class="form-control" id="">
                                              <td>Nama Barang </td>
                                              <td><input value="<?php echo $row->namaBarang; ?>" type="text" name="namaBarang" class="form-control" id=""></td>
                                          </tr>
                                          
                                        <tr>
                                            <td>Satuan Barang </td>
                                            <td>
                                                <select class="form-control" name="idSatuanBarang" id="">
                                                    <?php
                                                        $w = mysqli_query($conn , "SELECT * FROM `tb_satuan_barang`  "); 
                                                        while ($row1 = mysqli_fetch_object($w)) {  ?>                                                    
                                                            <option <?php if($row1->id == $row->idSatuanBarang) { echo "selected";} ?> value="<?php echo $row1->id; ?>"> <?php echo $row1->namaSatuan; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                </select>
                                            </td>
                                        </tr>
                                          <tr>
                                              <td>Harga Jual Pcs </td>
                                              <td><input value="<?php echo $row->hargaJual; ?>" type="number" name="hargaJual" class="form-control" id=""></td>
                                          </tr>
                                          <tr>
                                              <td>Harga Beli Pcs </td>
                                              <td><input value="<?php echo $row->hargaBeliPcs; ?>" type="number" name="hargaBeliPcs" class="form-control" id=""></td>
                                          </tr>
                                      </table>
                                  </div>

                              </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <input type="submit" name="edit" class="float-right btn btn-primary" value="Simpan">
                          </div>
                      </form>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
          </div>

      <?php } ?>

      <!-- jQuery -->
      <script src="plugins/jquery/jquery.min.js"></script>
      <script type="text/javascript">
          function onEdit(params) {
              setTimeout(function() {
                  console.log('dada');
                  $("#barKode" + params).focus();
              }, 1000);

          }
          $(document).ready(function() {
              $("#mdladd").click(function() {
                  setTimeout(function() {
                      $("#barKode").focus();
                  }, 1000);

              });


          });
      </script>
      <?php

        if (isset($_POST['edit'])) {
            $id = mysqli_real_escape_string($conn, $_POST['idBarang']);
            $barKode = mysqli_real_escape_string($conn, $_POST['barKode']);
            $idSatuanBarang = mysqli_real_escape_string($conn, $_POST['idSatuanBarang']);
            $nama = mysqli_real_escape_string($conn, $_POST['namaBarang']);
            $hargaJual = mysqli_real_escape_string($conn, $_POST['hargaJual']);
            $hargaBeliPcs = mysqli_real_escape_string($conn, $_POST['hargaBeliPcs']);

            $s = mysqli_query($conn, "UPDATE  tb_barang SET barKode='$barKode', idSatuanBarang='$idSatuanBarang', namaBarang='$nama',hargaJual='$hargaJual' ,hargaBeliPcs='$hargaBeliPcs'  WHERE idBarang = '$id' ");

            if ($s) {
                echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=barang';
        </script>";
            } else {
                echo "<script>
            alert('proses gagal');
            window.location.href='?page=barang';
        </script>";
            }
        }


        if (isset($_POST['save'])) {
            $barKode = mysqli_real_escape_string($conn, $_POST['barKode']);
            $idSatuanBarang = mysqli_real_escape_string($conn, $_POST['idSatuanBarang']);
            $namaBarang = mysqli_real_escape_string($conn, $_POST['namaBarang']);
            $hargaJual = mysqli_real_escape_string($conn, $_POST['hargaJual']);
            $hargaBeliPcs = mysqli_real_escape_string($conn, $_POST['hargaBeliPcs']);


            $s = mysqli_query($conn, "INSERT INTO tb_barang VALUES ('', '$barKode','$idSatuanBarang', '$namaBarang', '$hargaJual',  '$hargaBeliPcs') ");
            if ($s) {
                echo "<script>
            alert('sukses menyimpan');
            window.location.href='?page=barang';
        </script>";
            } else {
                echo "<script>
            alert('proses gagal');
            window.location.href='?page=barang';
        </script>";
                // echo mysqli_error($conn);
            }
        }
        ?>
  <?php

    } else if ($_GET['act'] == 'del') {

        $id =  $_GET['id'];
        $e = mysqli_query($conn, "DELETE  FROM tb_barang WHERE  idBarang = '$id'");
        if ($e) {

            echo "<script>
            alert('Succes di hapus');
            window.location.href='?page=barang';
            </script>";
        } else {
            alert('gagal di hapus');
            echo "<script>alert('Error');window.history.go(-1);</script>";
        }
    }

    ?>

  <!-- jQuery -->
  <script type="text/javascript">
      function load_click() {
          var t = $('#example3').DataTable();
          t.clear();

          var jenis = $('#jenis').val();

          var counter = 1;

          $.ajax({
              type: "POST",
              url: "pages/getBarang.php",
              data: {
                  jenis: jenis
              },
              dataType: "json",
              success: function(data) {
                  t.clear().draw();
                  console.log(data);
                  for (var i = 0; i < data.length; i++) {
                      var m = parseFloat(data[i].awal) + parseFloat(data[i].masuk) - parseFloat(data[i].keluar);
                    $jenif = "Elektronik";
                    if (  data[i].jenis==1) {
                        $jenif = "Furniture";
                    }

                      t.row.add([
                          counter,
                          data[i].idBarang,
                          data[i].barKode,
                          $jenif,
                          data[i].namaBarang,
                          data[i].masuk-data[i].keluar +" Pcs",
                          convertToRupiah(data[i].hargaBeliPcs),
                          convertToRupiah(data[i].hargaJual),
                          convertToRupiah(data[i].hargaJual -data[i].hargaBeliPcs),
                         getBut( data[i].idBarang)
                      ]).draw(false);
                        counter++;
                  }
              }

          })

      }

      function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }

      function getBut(params) {
      return "    <button onClick='onEdit("+params+")' data-toggle='modal' data-target='#modal-edit"+params+"' class='btn btn-primary btn-sm'  ><i class='fas fa-edit'></i></button> <a href='?page=barang&act=del&id="+params+"' onclick='return confirm('Apakah Anda Benar Benar Ingin Menghapus?')'><button class='btn btn-danger btn-sm' ><i class='fas fa-trash'></i></button> </a> "
  }
  </script>


  <?php
    function convert_to_rupiah($angka)
    {
        return 'Rp. ' . strrev(implode('.', str_split(strrev(strval($angka)), 3)));
    }
    ?>