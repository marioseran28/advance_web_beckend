LISTNYA : 
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">DATA PEMINJAMAN BUKU</h3>
                    </div>
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('peminjaman_buku/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?></div>
            </div>
            <div class='col-md-3'>
            
            </div>
            </div>

        <div id="flash_data">
            <?=$this->session->flashdata('message')?>
        </div>
        
        <table class="table table-bordered" id="mytable" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
		<th>Nama Member</th>
		<th>Tgl Pinjam</th>
		<th>Tgl Kembali</th>
		<th>Keterangan</th>
<!-- 		<th>Jumlah Denda</th> -->
		<th>Action</th>
            </tr>
            </thead><?php
             $peminjaman_buku_data = $this->db->query("SELECT * FROM tb_peminjaman_buku 
                    INNER JOIN tb_member ON tb_member.id_member=tb_peminjaman_buku.id_member ORDER BY id_peminjaman ASC");

            foreach ($peminjaman_buku_data->result() as $peminjaman_buku)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $peminjaman_buku->nama_member ?></td>
			<td><?php echo date('d-M-Y',strtotime($peminjaman_buku->tgl_pinjam)) ?></td>
			<td><?php echo date('d-M-Y',strtotime($peminjaman_buku->tgl_kembali)) ?></td>
			<td><?php echo $peminjaman_buku->keterangan ?></td>
			<!-- <td><?php echo $peminjaman_buku->jumlah_denda ?></td> -->
			<td style="text-align:center" width="200px">
                <a data-toggle='modal' data-target='#lihat-data<?php echo $peminjaman_buku->id_peminjaman ?>' class='btn btn-danger btn-sm' data-popup='tooltip' data-placement='top' title='Lihat Detail Data'><i class='fa fa-eye'></i></a>
                
				<?php 
				// echo anchor(site_url('peminjaman_buku/update/'.$peminjaman_buku->id_peminjaman),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm"'); 
				// echo '  '; 
				// echo anchor(site_url('peminjaman_buku/delete/'.$peminjaman_buku->id_peminjaman),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
/////////////////////

MODALNYA :
<?php $no=0; foreach ($peminjaman_buku_data->result() as $peminjaman_buku): $no++; ?>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="lihat-data<?php echo $peminjaman_buku->id_peminjaman ?>" class="modal fade">
    <div class="modal-dialog">
    <section class="content">
        <div class="col-xs-10">
        <div style=" margin-left: 100px;" class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Detail peminjaman Buku oleh Member : <?php echo $peminjaman_buku->nama_member ?></h3>
            </div>
<table class='table table-bordered'>        
<tr>

        <td>Detail Peminjaman : </td>
</tr>

        <?php
                $list_buku = $this->db->query("SELECT * FROM tb_peminjaman_buku 
                    INNER JOIN tb_detail_peminjamanbuku ON tb_peminjaman_buku.id_peminjaman=tb_detail_peminjamanbuku.id_peminjaman
                    INNER JOIN tb_buku ON tb_buku.id_buku=tb_detail_peminjamanbuku.id_buku WHERE tb_detail_peminjamanbuku.id_peminjaman='$peminjaman_buku->id_peminjaman'");
                foreach($list_buku->result() as $data_buku){
                ?>
        <tr><td><?php echo $data_buku->nama_buku ?></td></tr>
            <?php } ?>
           
           
<tr><td></td><td>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Kembali</button></td>
                    </tr>
    </table>      </div></div>
</section>
</div>
</div>
<?php endforeach; ?>
////////////////////////