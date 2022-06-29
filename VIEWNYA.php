<div class="content-wrapper">
    
    <section class="content">
        <div class="row">
        <div class="col-md-6">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $header; ?> DATA INVOICE FARMASI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>        
        
        <tr><td width='200'>Jenis Transaksi</td><td>
            <div class="input-group">
          <div class="input-group-btn">
               <a data-toggle="modal" data-target="#tambah-jenis" class="btn btn-success">Tambah </a>
               </div>
  <select name="id_akun" id="id_akun" style="width: 250px" class="form-control">
                <option value="">--Pilih--</option>
                <?php
                $list = $this->db->query("SELECT * FROM tb_jenis_transaksi");
                foreach($list->result() as $t){
                ?>
                  <option value="<?php echo $t->id_jenis_transaksi ?>" <?php if($id_akun== "$t->id_jenis_transaksi"){ echo 'selected'; } ?>><?php echo $t->nama_transaksi ?></option>
                  <?php 
                  } 
                  ?>
                </select>
                              </td></tr></div>
         <input type="hidden" class="form-control" name="no_invoice" id="no_invoice" oneyup="load()" placeholder="No Invoice" value="<?php echo $no_invoice; ?>" />

        <tr><td width='200'>No Invoice</td><td><input type="text" class="form-control" name="kode_no_inv" id="kode_no_inv" onclick="load()" placeholder="No Invoice" value="<?php echo kodeInvoiceFOtomatis(); ?>" readonly /></td></tr>

        <tr><td width='200'>Tgl Invoice <?php echo form_error('tgl_invoice') ?></td><td><div class="input-group">
          <div class="input-group-btn"><input type="date" class="form-control datepicker" name="tgl_invoice" id="tgl_invoice" placeholder="Tgl Invoice" value="<?php echo $tgl_invoice; ?>" /></td></tr></div></div>

        <tr><td width='200'>Tgl Bayar Terakhir <?php echo form_error('lama_waktu') ?></td><td> <div class="input-group">
          <div class="input-group-btn"><input type="date" class="form-control datepicker" name="lama_waktu" id="lama_waktu" placeholder="Lama Waktu" value="<?php echo $lama_waktu; ?>" /></td></tr></div></div>
                              
        <tr><td width='200'>Distributor <?php echo form_error('id_distributor') ?></td><td>
        <div class="input-group">
          <div class="input-group-btn">
            <button data-toggle="modal" data-target="#modal_distributor" type="button" class="btn btn-primary ">CARI</button>
          </div>
          <input type="text" name="id_distributor" id="id_distributor" class="form-control" placeholder="Distributor" value="<?php echo $id_distributor; ?>">
        </div></td></tr>
         
             
        <tr><td width='200'>Untuk Keperluan <?php echo form_error('deskripsi_inv') ?></td><td> <textarea class="form-control" rows="1" name="deskripsi_inv" id="deskripsi_inv" placeholder="Keperluan Inv"><?php echo $deskripsi_inv; ?></textarea></td></tr>
        
      <input type="hidden" name="status_prf" value="<?php echo $status_prf ?>" />
        <input type="hidden" name="status_jurnal" value="<?php echo $status_jurnal ?>" />
        <input type="hidden" name="status_aktif_inv" value="<?php echo $status_aktif_inv ?>" />
        <input type="hidden" id="inv_status" name="inv_status" value="<?php echo ('Farmasi') ?>" class="form-control" />
        
        <tr><td width='200'>Kode PO<?php echo form_error('id_po') ?></td><td>
          <div class="input-group">
            <select name="id_po" id="id_po" style="width: 150px" class="form-control">
                <option value="">--Pilih--</option>
                <?php
                $list = $this->db->query("SELECT * FROM tb_po");
                foreach($list->result() as $t){
                ?>
                  <option value="<?php echo $t->id_po ?>" <?php if($id_po== "$t->id_po"){ echo 'selected'; } ?>><?php echo $t->kode_po ?></option>
                  <?php } ?>
                </select>
            <!-- <input type="text" class="form-control" style="width: 150px" name="id_po" id="id_po" placeholder="Kode PO" value="<?php echo $id_po; ?>" /> -->

                                  <!-- <button data-toggle="modal" onclick="datapo()" data-target="#modal_po" type="button" class="btn btn-primary">Tampilkan</button>   -->
                                </div></td></tr>
                                
        <tr><td width='200'>Nomor RCV<?php echo form_error('id_rcv') ?></td><td>
          <div class="input-group">
            <select name="id_rcv" id="id_rcv" onchange="datapo();" style="width: 150px" class="form-control">
                <option value="">--Pilih--</option>
                <?php
                $list = $this->db->query("SELECT * FROM tb_rcv");
                foreach($list->result() as $t){
                ?>
                  <option value="<?php echo $t->id_rcv ?>" <?php if($id_rcv== "$t->id_rcv"){ echo 'selected'; } ?>><?php echo $t->kode_rcv ?></option>
                  <?php } ?>
                </select></div></td></tr>
                                
 <tr><td width='200'>Total Keseluruhan <?php echo form_error('total_keseluruhan') ?></td><td>
     <div class="input-group">
          <div class="input-group-btn">
<input type="text" class="form-control" name="total_keseluruhan" id="total_keseluruhan" placeholder="Total Keseluruhan" value="<?php echo $total_keseluruhan; ?>" style="width: 150px" readonly /></div>
 <span  id="jumlah_pajak_rp" style='margin-left: 5px'></span></div></td></tr>

<!-- <tr><td></td><td> <input type="hidden" name="waktu" id="waktu" class="form-control" readonly value="<?php echo date('h:i:s') ?>" /></td></tr> -->

                         <tr><td></td><td>
                           <button type="submit" onclick="return confirm('Apakah Anda Yakin Menyimpan Data ?');"  class="btn btn-success btn-sm">Simpan</button> 
                    <a href="<?php echo site_url('invoicesupplierf/batal/'.$no_invoice); ?>" onclick="return confirm('Apakah Yakin Batal Menambah Data ?');" class="btn btn-default btn-sm">Kembali </a>
                </table></form>
</div></div>
                <div class="col-md-6">
                    <div class="row" style="margin-right: 2px">
                    <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">DATA OBAT </h3>
                 </div>
                                <div id="form-search" style="margin-left: 350px">
                                    <label><input type="text" onkeyup="datapo()"  name="search" id="search" class="search" placeholder="Search Data"> </label>
                                </div>

            <table class='table table-bordered'>
              <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode RCV</th>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Qty</th>
<!--                         <th>Total</th> -->
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody id="list_po">
               
                </tbody>
            <!-- <tr><td></td><td>
                                <input type="hidden" id="deskripsidet_supplier" readonly class="form-control" />
                                <input type="hidden" id="qty_po" placeholder="Qty PO" readonly class="form-control" />
                              </td></tr>
                              <tr><td width='200'> PO Obat</td><td>
                                <div class="input-group">
          <div class="input-group-btn">
            
            <button data-toggle="modal" onclick="datapo()" data-target="#modal_po" type="button" class="btn btn-primary">CARI</button>
          </div><input type="text" id="id_obat" name="id_obat" readonly placeholder="Nama Item" class="form-control" />
      </div>
                                <span  id="format"></span><input type="text" id="harga_satuan" name="harga_satuan" placeholder="Harga" class="form-control" onkeypress="totalbayar();" />
                                <input type="text" id="qty" placeholder="Qty" name="qty" class="form-control" onkeyup="totalbayar();" />
                                <input type="text" id="total" name="total" placeholder="Total" class="form-control" />
                              </td></tr>
                              <tr><td></td><td>
                              <button type="button" class="btn btn-success" onclick="add()">Tambah</button>
                              <button type="reset" class="btn btn-danger" value="Reset">Reset </button>
                            </td></tr>
 -->
        </table>

</div></div></div>

    <div class="col-md-12">
    <div class="row" style="margin-left: 2px; margin-right: 2px; ">
    <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">DETAIL INVOICE SUPPLIER (<button type="button" class="btn btn-primary btn-xs" onclick="load()">LIHAT DETAIL</button>)</h3>
            </div>
            <table class='table table-bordered'>  
            <div id="list">

            </div>
        </table>
                    </div>
                </div>
        </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>


<div class="modal fade" id="modal_distributor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:800px">
                <div class="modal-content">
                     <div class="row" style="margin-left: 2px; margin-right: 2px; ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cari Nama Distributor</h4>
                    </div>
                    <div class="modal-body">
            <table id="xdistributor" class="table table-bordered table-hover table-striped">
        <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Distributor</th>
                        <th>Alamat Distributor</th>
                        <th>Telepon </th>
                        <th>Nomor Rekening</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 0;
                    $distributor =  $this->db->query("SELECT * FROM tb_perusahaan WHERE status_kepemilikan='Farmasi'AND status_perusahaan='Aktif'");
                    foreach($distributor->result() as $d1){
                        $no++;
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $d1->nama_perusahaan ?></td>
                        <td><?php echo $d1->alamat_perusahaan ?></td>
                        <td><?php echo $d1->no_telp_perusahaan ?></td>
                        <td><?php echo $d1->nomor_rekening ?></td>
                        <td><button class="btn btn-danger btn-xs" onclick="pilih('<?php echo $d1->nama_perusahaan ?>','<?php echo $d1->alamat_perusahaan ?>','<?php echo $d1->no_telp_perusahaan ?>','<?php echo $d1->nomor_rekening ?>')" data-dismiss="modal">PILIH</button></td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
              </table>
            </div>
          </div>
      </div>
  </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="tambah-jenis" class="modal fade">
    <div class="modal-dialog">
        <section class="content">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">TAMBAH JENIS TRANSAKSI</h3>
                </div>
                <form id="resetform_j" class="form-horizontal" class="form-horizontal" action="<?php echo site_url('invoicesupplierf/create_action1'); ?>" method="post" enctype="multipart/form-data" role="form">
                    <table class='table table-bordered'> 
                    <tr><td width='200'>Nama Transaksi</td><td><input type="text" style="width: 300px" class="form-control" name="nama_transaksi" id="nama_transaksi" placeholder="Nama Transaksi"/></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_jenis_transaksi" id="id_jenis_transaksi" /> 
                    <button type="submit" class="btn btn-success btn-sm">Simpan</button> 
                    <button type="button" onclick ="kosong()" data-dismiss="modal" class="btn btn-default btn-sm">Kembali</button></td></tr>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>

<!-- <div class="modal fade" id="modal_po" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cari PO</h4>
                    </div>
                    <div class="modal-body">
            <table id="xpo" class="table table-bordered table-hover table-striped">
        <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode PO</th>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Qty Belum</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody id="list_po">
               
                </tbody>
              </table>
            </div>
          </div>
      </div>
  </div>
</div> -->


<script type="text/javascript">
 $(function () {
    $("#xdistributor").dataTable();
  });
   </script>
   <script type="text/javascript">
 $(function () {
    $("#xpo").dataTable();
  });
   </script>
   <script type="text/javascript">
  function pilih(nama){
    $("#id_distributor").val(nama);
  }
  </script>
  <script type="text/javascript">
  function pilih1(kode,item,qty,id,harga){
    $("#id_po").val(kode);
    $("#deskripsidet_supplier").val(id);
    $("#qty_po").val(qty);
    $("#id_obat").val(item);
    $("#harga_satuan").val(harga);
  }
  </script>

 <!-- <script type="text/javascript">
        function totalbayar() {
        var harga_satuan = document.getElementById('harga_satuan').value;
        var qty = document.getElementById('qty').value;
        var total = harga_satuan*qty;
        document.getElementById('total').value = total;
      }

    </script> -->

           
     <script type="text/javascript">
        
function formatCurrency(harga_satuan) {
harga_satuan = harga_satuan.toString().replace(/\$|\,/g,'');
if(isNaN(harga_satuan))
harga_satuan = "0";
sign = (harga_satuan == (harga_satuan = Math.abs(harga_satuan)));
harga_satuan = Math.floor(harga_satuan*100+0.50000000001);
cents = harga_satuan%100;
harga_satuan = Math.floor(harga_satuan/100).toString();
if(cents<10)
cents = "0" + cents;
for (var i = 0; i < Math.floor((harga_satuan.length-(1+i))/3); i++)
harga_satuan = harga_satuan.substring(0,harga_satuan.length-(4*i+3))+'.'+
harga_satuan.substring(harga_satuan.length-(4*i+3));
return (((sign)?'':'-') + 'Rp.' + harga_satuan + ',' + cents);
}
</script>

 <script type="text/javascript">
function formatCurrency(total_keseluruhan) {
total_keseluruhan = total_keseluruhan.toString().replace(/\$|\,/g,'');
if(isNaN(total_keseluruhan))
total_keseluruhan = "0";
sign = (total_keseluruhan == (total_keseluruhan = Math.abs(total_keseluruhan)));
total_keseluruhan = Math.floor(total_keseluruhan*100+0.50000000001);
cents = total_keseluruhan%100;
total_keseluruhan = Math.floor(total_keseluruhan/100).toString();
if(cents<10)
cents = "0" + cents;
for (var i = 0; i < Math.floor((total_keseluruhan.length-(1+i))/3); i++)
total_keseluruhan = total_keseluruhan.substring(0,total_keseluruhan.length-(4*i+3))+'.'+
total_keseluruhan.substring(total_keseluruhan.length-(4*i+3));
return (((sign)?'':'-') + 'Rp.' + total_keseluruhan + ',' + cents);
}
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#form-search").css("display","none");
       
    });
    
    function datapo(){
    var search = $("#search").val();
    var id_rcv = $("#id_rcv").val();

    if (search=="") {
        $.ajax({
            url:"<?php echo base_url() ?>index.php/invoicesupplierf/list_po",
            data:"id_rcv="+id_rcv ,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                  isi_tabel+=`
                    <tr>
                      <td>`+ (index+1) +`</td>
                      <td>`+ item.kode_rcv +`</td>
                      <td>`+ item.nama_obat +`</td>
                      <td>`+ item.harga_beli +`</td>
                      <td>`+ item.qty_obat +`</td>
                      
                      <td><button class="btn btn-tambah btn-danger btn-xs" onclick="add('`+ item.id_rcv +`','`+ item.nama_obat +`','`+ item.id_obat +`','`+ item.qty_obat +`','`+ item.harga_beli +`')" data-dismiss="modal">PILIH</button></td>
                    </tr>
                  `;
              });              
              $('#list_po').html(isi_tabel);
              $("#form-search").slideDown("fast");
            }
        });

    } else {


        $.ajax({
            url:"<?php echo base_url() ?>index.php/invoicesupplierf/list_search",
            data:"search="+search+"&id_rcv="+ id_rcv ,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                  isi_tabel+=`
                    <tr>
                      <td>`+ (index+1) +`</td>
                      <td>`+ item.kode_rcv +`</td>
                      <td>`+ item.nama_obat +`</td>
                      <td>`+ item.harga_beli +`</td>
                      <td>`+ item.qty_obat +`</td>
                      
                      <td><button class="btn btn-tambah btn-danger btn-xs" onclick="add('`+ item.id_rcv +`','`+ item.nama_obat +`','`+ item.id_obat +`','`+ item.qty_obat +`','`+ item.harga_beli +`')" data-dismiss="modal">PILIH</button></td>
                    </tr>
                  `;
              });              
              $('#list_po').html(isi_tabel);
            }
        });
            }
      }
</script>

<!-- <script type="text/javascript"> 
function totalbayar(qty,harga_satuan){
 var qty = $(qty).val();
 var index_real = $(".qty").index($(qty));
 var harga_satuan = $(harga_satuan).val();
 var index_harga = $(".harga_satuan").index($(harga_satuan));
 let total = qty* harga_satuan;
 $(".total").eq(index_real).val(total);
}
<td><input type="text" placeholder="Total" class="form-control total" /></td>

 </script> -->

 <script type="text/javascript">
    function add(id_rcv,nama_obat,id_obat,qty_obat, harga_beli){
        var noinvoice = $("#no_invoice").val();
        var tanya = confirm("Apakah Anda Akan Menambah Data Ini ?");
       if(tanya === true) {
      $.ajax({
            url:"<?php echo base_url() ?>index.php/invoicesupplierf/add_ajax",
            data:"id_rcv="+ id_rcv+"&nama_obat="+ nama_obat+ "&harga_beli="+ harga_beli+"&qty_obat=" + qty_obat+"&noinvoice="+ noinvoice+"&id_obat="+ id_obat ,
            success: function(html)
            { 
                load();
                alert("Berhasil Menambahkan Data");
                datapo();
                rp();
            }
        });
      }else{

         }
    }
    
    function load(){
    var noinvoice = $("#no_invoice").val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/invoicesupplierf/list_detail_f",
            data:"noinvoice="+noinvoice ,
            success: function(html)
            {
                $("#list").html(html);
            }
        });

        var no_invoice = $("#no_invoice").val();
        $.ajax({
                url:"<?php echo base_url() ?>index.php/invoicesupplierf/total_invoice",
                data:"no_invoice="+no_invoice,
                method: 'post',
                dataType: 'json',
                success: function(data)
                {
                    $("#total_keseluruhan").val(data.totall);
                    console.log(data.totall)
                    rp();
                }
            });
    }
    
    function hapus(id,id_po,deskripsidet_supplier,qty){
      var tanya = confirm("Apakah Anda Akan Menghapus Data Ini ?");
       if(tanya === true) {
        $.ajax({
            url:"<?php echo base_url() ?>index.php/invoicesupplierf/hapus_ajax",
            data:"id_detail_invoicesupplier=" + id+"&id_po=" + id_po+"&deskripsidet_supplier=" + deskripsidet_supplier+"&qty=" + qty ,
            success: function(html)
            {
                load();
                alert("Berhasil Menghapus Data");
                datapo();
            }
        });
        }else{

         }
    }

    function rp(){
        var total_keseluruhan = $("#total_keseluruhan").val();
         if(total_keseluruhan=='') {
            $.ajax({
            url:"<?php echo base_url() ?>index.php/invoicesupplierf/rp",
            data:"total_keseluruhan="+ 0 ,
            success: function(html)
            { 
            $('#jumlah_pajak_rp').html(html);
            }
            });
         } else {
              $.ajax({
            url:"<?php echo base_url() ?>index.php/invoicesupplierf/rp",
            data:"total_keseluruhan="+ total_keseluruhan ,
            success: function(html)
            { 
            $('#jumlah_pajak_rp').html(html);
            }
            });
         }
     }
</script>

<script type="text/javascript">
    $(function() {
        //autocomplete
        $(document).ready(function() {
    $('#id_po').select2()
        });    
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).ready(function() {
    $('#id_akun').select2()
        });    
    });
</script>

<script type="text/javascript">
    $(function() {
        //autocomplete
        $(document).ready(function() {
    $('#id_rcv').select2()
        });    
    });
</script>
                                