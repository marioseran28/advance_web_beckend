tombol tambah data (diletakkan beda file dengan form input data):
 <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('tb_user/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?></div>
//////////////////////////////////////////////////////////////////////////////////


function create pada controller :
public function create() 
    {
        $Kodeuser = $this->db->query('SELECT max(kode_user) as maxKode FROM tb_user')->result();
        foreach ($Kodeuser as $kode) {
            $kode_selanjutnya=$kode->maxKode;
            $kode_selanjutnya++;
        $data = array(
        'kode_user' => set_value('kode_user',$kode_selanjutnya),
    );
    }
        $this->load->view('tb_user/tb_user_form', $data);//ini untuk tanpa template
        $this->template->load('template','tb_user/tb_user_form', $data);//ini untuk dengan template
    }
//////////////////////////////////////////////////////////////////////////////////////

form input data :
<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA USER</h3>
            </div>
            <form action="<?php echo site_url('tb_user/create_action'); ?>" method="post">
            
<table class='table table-bordered'>        

	    <tr><td width='200'>Kode User <?php echo form_error('kode_user') ?></td><td><input type="text" class="form-control" name="kode_user" id="kode_user" placeholder="Kode User" value="<?php echo $kode_user; ?>" /></td></tr>
	    <tr><td width='200'>Nama User <?php echo form_error('nama_user') ?></td><td><input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Nama User" /></td></tr>
	    <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td><input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" /></td></tr>
	    <tr><td width='200'>No Hp <?php echo form_error('no_hp') ?></td><td><input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Hp" /></td></tr>
	    <tr><td width='200'>Username <?php echo form_error('username') ?></td><td><input type="text" class="form-control" name="username" id="username" placeholder="Username"/></td></tr>
	    <tr><td width='200'>Password <?php echo form_error('password') ?></td><td><input type="text" class="form-control" name="password" id="password" placeholder="Password" /></td></tr>
	    <tr><td width='200'>Email <?php echo form_error('email') ?></td><td><input type="text" class="form-control" name="email" id="email" placeholder="Email" /></td></tr>
	    <tr><td width='200'>Tgl Pembuatan <?php echo form_error('tgl_pembuatan') ?></td><td><input type="text" class="form-control" name="tgl_pembuatan" id="tgl_pembuatan" placeholder="Tgl Pembuatan"  /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_user"  /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Create</button> 
	    <a href="<?php echo site_url('tb_user') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div></section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.id.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css"/>

<script type="text/javascript">
	$(function() {
        $(document).ready(function() {
    $('#tgl_pembuatan').datepicker({
       format: 'yyyy-mm-dd',
    todayHighlight: true,

    language: "id",
    locale: "id",
    });
        });    
    });
</script>
//////////////////////////////////////////////////////////////////////////////////////
