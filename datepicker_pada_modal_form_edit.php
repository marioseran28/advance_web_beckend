<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">KELOLA DATA USER</h3>
                    </div>
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('tb_user/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?></div>
            </div>
            </div>
    
        <table class="table table-bordered" id="tabel_member" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
		<th>Kode User</th>
		<th>Nama User</th>
		<th>Alamat</th>
		<th>No Hp</th>
		<th>Email</th>
		<th>Tgl Pembuatan</th>
		<th>Action</th>
            </tr>
            </thead><?php
            $tb_user_data = $this->db->query('SELECT * FROM tb_user')->result();
            foreach ($tb_user_data as $tb_user)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $tb_user->kode_user ?></td>
			<td><?php echo $tb_user->nama_user ?></td>
			<td><?php echo $tb_user->alamat ?></td>
			<td><?php echo $tb_user->no_hp ?></td>
			<td><?php echo $tb_user->email ?></td>
			<td><?php echo $tb_user->tgl_pembuatan ?></td>
			<td style="text-align:center" width="200px">
                 <a data-toggle='modal' data-target='#edit-data<?php echo $tb_user->id_user ?>' onclick='edit_data(<?php echo $tb_user->id_user ?>)' class='btn btn-warning btn-sm' data-popup='tooltip' data-placement='top' title='Edit Detail Data'><i class='fa fa-pencil-square-o'></i></a>
				<?php 
				// echo anchor(site_url('tb_user/read/'.$tb_user->id_user),'<i class="fa fa-eye" aria-hidden="true"></i>','class="btn btn-danger btn-sm"'); 
				// echo '  '; 
				// echo anchor(site_url('tb_user/update/'.$tb_user->id_user),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm"'); 
				// echo '  '; 
				// echo anchor(site_url('tb_user/delete/'.$tb_user->id_user),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        
        </div>
                    </div>
            </div>
            </div>
    </section>
</div>

<?php $no=0; foreach($tb_user_data as $tb_user): $no++; ?>
<div class="modal fade" id="edit-data<?php echo $tb_user->id_user?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: red; color: white;">
        <h5 class="modal-title" id="exampleModalLabel">EDIT DATA USER</h5>
        </button>
      </div>
      <form class="form-horizontal" action="<?php echo site_url('tb_user/update_action'); ?>" method="post" enctype="multipart/form-data" role="form">
        <table class="table table-bordered" style="margin-bottom: 10px">
      <div class="modal-body">
        <tr><td width='200'>Kode User</td><td><input type="text" class="form-control" name="kode_user" id="kode_user" placeholder="Kode User" value="<?php echo $tb_user->kode_user ?>" /></td></tr>

        <tr><td width='200'>Nama User</td><td><input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Nama User" value="<?php echo $tb_user->nama_user ?>" /></td></tr>

        <tr><td width='200'>Alamat</td><td><input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $tb_user->alamat ?>" /></td></tr>

        <tr><td width='200'>No Hp</td><td><input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Hp" value="<?php echo $tb_user->no_hp ?>" /></td></tr>

        <tr><td width='200'>Email</td><td><input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $tb_user->email ?>" /></td></tr>

        <tr><td width='200'>Tgl Pembuatan</td><td><input type="text" class="form-control" name="tgl_pembuatan" id="tgl_pembuatan<?php echo $tb_user->id_user ?>" placeholder="Tgl Pembuatan" value="<?php echo $tb_user->tgl_pembuatan ?>" /></td></tr>

        <tr><td></td><td><input type="hidden" name="id_user" value="<?php echo $tb_user->id_user ?>" />
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Ubah</button>  </td></tr>
      </div>
        </table></form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.id.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css"/>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#tabel_member').DataTable();
    });

function edit_data(id_user){
      $('#tgl_pembuatan'+id_user).datepicker({
       format: 'yyyy-mm-dd',
    todayHighlight: true,
    autoclose: true, 
    language: "id",
    locale: "id",
    });
  }
</script>