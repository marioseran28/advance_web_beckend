VIEWNYA :
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">DATA MEMBER</h3>
                    </div>
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            </div>
            </div>
        <table class="table table-bordered" id="mytable" style="margin-bottom: 10px">
            
            <tr>
                <th>No</th>
		<th>Nama Member</th>
		<th>Alamat</th>
		<th>No Hp</th>
        <th>Foto</th>
<!-- 		<th>Action</th> -->
            </tr>
            <tbody id="list_member">
            <?php
            $start = 0;
            $member_data =  $this->db->query("SELECT * FROM tb_member GROUP BY id_member ASC LIMIT 5");
            foreach ($member_data->result() as $tb_member)
            {
               
              ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $tb_member->nama_member ?></td>
			<td><?php echo $tb_member->alamat ?></td>
			<td><?php echo $tb_member->no_hp ?></td>

            <td><img src="<?php echo base_url()?>assets/gambar/<?php echo ($tb_member->images);?>" width="50" height="50" alt="<?php echo $tb_member->images ?>" /></td>
            
            <!-- <td><a href="<?php echo site_url('tb_member/download_foto/'.$tb_member->id_member); ?>" data-popup="tooltip" data-placement="top" title="Lihat Data">DOWNLOAD</a></td> -->


			<!-- <td style="text-align:center" width="200px">
                
                 <a href="<?php echo site_url('tb_member/read/'.$tb_member->id_member); ?>" class="btn btn-info btn-sm" data-popup="tooltip" data-placement="top" title="Lihat Data"><i class="fa fa-eye"></i></a>

                 <a href="<?php echo site_url('tb_member/update/'.$tb_member->id_member); ?>" class="btn btn-warning btn-sm" data-popup="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-square-o"></i></a>

                 <a onclick="return confirm('Apakah Anda Yakin Ingin Hapus Data ?');" href="<?php echo site_url('tb_member/delete/'.$tb_member->id_member); ?>" class="btn btn-danger btn-sm" data-popup="tooltip" data-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></a>
			</td> -->

		</tr>

                <?php
            }
            ?>
             <input type="text" name="jumlah_index" id="jumlah_index" onclick="load_more()" value="<?php echo $start ?>" >
        </tbody>

        <tbody id="tampil_load_more">
             <?php
            $count_member =  $this->db->query("SELECT COUNT(id_member) AS id FROM tb_member");
            foreach ($count_member->result() as $data_count)
            {
              $data_loadnya=$data_count->id-$start;

              ?>
            <tr><td colspan='5'><button style="width: 1050px" id="load_more" onclick="load_more()" class="btn btn-tambah btn-primary btn-sm" >LOAD MORE (<?php echo $data_loadnya ?>+)</button></td></tr>
        
            <?php
        }
            ?>
            </tbody>
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

<script type="text/javascript">
    function load_more(){
    var jumlah_index = document.getElementById('jumlah_index').value;
    tambahh = jumlah_index*1+1;
    var jumlah_index1 = document.getElementById('jumlah_index').value = tambahh;

        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_member/list_member_contro",
            data:"&jumlah_index="+ jumlah_index,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                  isi_tabel+=`
                    <tr>
                      <td>`+ (index+1) +`</td>
                      <td>`+ item.nama_member +`</td>
                      <td>`+ item.alamat +`</td>
                      <td>`+ item.no_hp +`</td>
                      <td><img src="<?php echo base_url() ?>assets/gambar/`+ item.images +`" width="50" height="50" alt=" `+ item.images +`" />
                     </td>
                    </tr>
                  `;

              });                     
              $('#list_member').html(isi_tabel);
            }
        });

        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_member/list_tombol_load",
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                $data_loadnyaa=item.id-jumlah_index1;
                  $tampil_button = `<button style="width: 1050px" id="load_more" onclick="load_more()" class="btn btn-tambah btn-primary btn-sm" >LOAD MORE (`+ $data_loadnyaa +`+)</button>`;
                     if($data_loadnyaa==0)$tampil_button = ``;
                  isi_tabel+=`
                    <tr><td colspan="5">`+ $tampil_button +`</td></tr>
                  `;

              });                     
              $('#tampil_load_more').html(isi_tabel);
            }
        });
}
</script>
//////////////////////////////////////////////////////////////////////////////////////////////////////////

PHPNYA/CONTROLLERNYA :
function list_member_contro(){
        $jumlah_index = $this->input->get('jumlah_index');
        $limit_data = $jumlah_index+1;
        $hasil=$this->db->query("SELECT * FROM tb_member GROUP BY id_member ASC LIMIT $limit_data");
        echo json_encode($hasil->result());
    }

     function list_tombol_load(){
        $hasil=$this->db->query("SELECT COUNT(id_member) AS id FROM tb_member");
        echo json_encode($hasil->result());
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
SEMOGA BERMANFAAT YA, HAPPY CODING SEMUANYA :)