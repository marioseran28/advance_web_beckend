formnya atau viewnya :
<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA MEMBER</h3>
            </div>
              <form id="form_member" action="<?php echo site_url('tb_member/create_action'); ?>" method="post" enctype="multipart/form-data" role="form" >
<table class='table table-bordered'>        
      <tr><td width='200'>Nama Member <?php echo form_error('nama_member') ?></td><td><input type="text" class="form-control" name="nama_member" id="nama_member" placeholder="Nama Member" value="<?php echo $nama_member; ?>" /></td></tr>
      <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td><textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Deskripsi Jaminan"><?php echo $alamat; ?></textarea></tr>
      <tr><td width='200'>No Hp <?php echo form_error('no_hp') ?></td><td><input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Hp" value="<?php echo $no_hp; ?>" /></td></tr>

<!--         <tr><td width='200'>Upload Foto </td><td> <input type="file" id="foto" name="foto" class="foto"></td></tr> -->
      <tr><td width='200'>Hobbi Member </td><td>
                  <?php
                $list = $this->db->query("SELECT * FROM tb_hobby");
                foreach($list->result() as $t){
                ?>
                <input type="checkbox" name="hobby[]" id="hobby[]" class="hobbies" value="<?php echo $t->nama_hobby ?>" />
                  <label><?php echo $t->nama_hobby ?></label><br>
                  <?php } ?>
         </td></tr>
         
         <!--  <tr><td>Pehitungan 
          <input type="type" style="width: 20px" name="tambah" id="tambah" value="+" readonly placeholder="+"/>
          <input type="type" style="width: 20px" name="kurang" id="kurang" value="-" readonly placeholder="-"/>
          <input type="type" style="width: 20px" name="kali" id="kali" value="x" readonly placeholder="x"/>
          <input type="type" style="width: 20px" name="bagi" id="bagi" value=":" readonly placeholder=":"/>
           <a id="reset_input" class="btn btn-info"> RESET</a>
        </td><td width='200'><input type="text" style="width: 170px" onkeyup="perhitungan()" class="form-control" name="angka1" id="angka1" placeholder="Input Angka pertama" /> </td>
            
            <td width='2px'><input type="text" style="width: 50px" class="form-control" name="perhitungannya" id="perhitungannya"  readonly /></td>

            <td width='200'><input type="text" onkeyup="perhitungan()" style="width: 170px" class="form-control" name="angka2" id="angka2" placeholder="Input Angka kedua" /></td>
             </tr>
          <td></td><td width='200'><input type="text"  style="width: 170px" class="form-control" name="hasil" id="hasil" placeholder="Hasil Perhitungan" /></td></tr> -->
      <tr><td></td><td><input type="hidden" name="id_member" id="id_member" value="<?php echo $id_member; ?>" /> 
     <!-- <button type="submit" onclick="return confirm('Apakah Anda Yakin Menyimpan Data ?');"  class="btn btn-success btn-sm">Simpan</button>  -->
    <button type="button" onclick="pilih()"  class="btn btn-success btn-sm">Simpann</button>
      <a href="<?php echo site_url('tb_member') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr></td></tr>
  </table></form></div>

<div class="col-md-12">
<div class="row">
    <div class="box box-warning box-solid">
<div class="box-header with-border">
                <h3 class="box-title">LIST MEMBER </h3>
</div>
<table class='table table-bordered'>
<div id="list_member">

</div>
        </table>
</div>
        </div>
        </div>

</selection>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script type="text/javascript">
   function pilih(){
        var nama_member = $("#nama_member").val();
        var alamat = $("#alamat").val();
        var no_hp = $("#no_hp").val();
        var hobby = $('input:checkbox:checked.hobbies').map(function(){
        return this.value; }).get().join(",");
        // var foto = file.replace("C:\\fakepath\\","");
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_member/create_upload",
            data:"nama_member=" + nama_member+"&alamat=" + alamat+"&no_hp=" + no_hp+"&hobby=" + hobby ,
            success: function(html)
            {
              alert("Berhasil Menambah Data");
              $('#form_member').trigger("reset");
              load_list();

            }
        });

    }
    function load_list(){
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_member/list_member_php",
            success: function(html)
            {
                $("#list_member").html(html);
            }
        });
    }
</script>
/////////////////////////////////////////////////////////////////////////

controller atau file phpnya :
 function create_upload(){

            $data = array(
                    'nama_member' => $this->input->get('nama_member',TRUE),
                    'alamat' => $this->input->get('alamat',TRUE),
                    'no_hp' => $this->input->get('no_hp',TRUE),
                    'hobby' => $this->input->get('hobby',TRUE),
                );

          $this->db->insert('tb_member',$data);

function list_member_php(){
        echo "<table class='table table-bordered'>
                <tr>
                <th>NO</th>
                <th>NAMA MEMBER</th>
                <th>ALAMAT</th>
                <th>NO HP</th>
                <th>HOBBY</th>
                </tr>";
        $sql = "SELECT * FROM tb_member";
        $list = $this->db->query($sql)->result();
        $no=1;
        foreach ($list as $row){
                    echo "<tr>
                        <td width='10'>$no</td>
                        <td>$row->nama_member</td>
                        <td>$row->alamat</td>
                        <td>$row->no_hp</td>
                        <td>$row->hobby</td>
                        </tr>";
                        $no++;
                }
        echo" </table>";
    }
