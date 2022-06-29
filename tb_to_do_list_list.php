<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-list-ol fa-lg"> MANAGE YOUR TO DO LIST</i></h3>
                    </div>
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;">
       <a data-toggle="modal" data-target="#tambah-data" class="btn btn-primary btn-sm">
            <i class="fa fa-list" aria-hidden="true"></i> CREATE YOUR LIST</a>
            <?php 
                    $periksa=$this->db->query("SELECT tb_to_do_list.id_to_do, COUNT(id_detail_todo) as jumlah,tb_to_do_list.judul,tb_to_do_list.tgl_list FROM tb_to_do_list INNER JOIN tb_detail_todolist ON tb_detail_todolist.id_to_do=tb_to_do_list.id_to_do WHERE tb_detail_todolist.status_list!='done'")->result_array();
                    foreach($periksa as $d1){

                        $judul=$d1['judul'];
                        $tgl_list=$d1['tgl_list'];
                        $jumlah=$d1['jumlah'];
                        $id_to_do=$d1['id_to_do'];
                        if ($jumlah==0){ 
                            echo "";
                             
                    } else {
                        echo "<div style='padding:5px' style='width:50px' ><span class='glyphicon glyphicon-info-sign'></span> YOUR <a style='color:red' href='tb_to_do_list/read/$id_to_do'>" .$judul."/".date('d-M-Y',strtotime($tgl_list))."</a> TO DO LIST NOT DONE YET </div>";
                    }
                }
                    ?>
        </div>
            </div>
            </div>

        <table class="table table-bordered" id="to_do_list" style="margin-bottom: 10px">
             <thead>
            <tr>
                <th>N0</th>
		<th>TITLE</th>
		<th>DATE LIST</th>
		<th>ACTION</th>
            </tr>
            </thead>
            <?php
             $tb_to_do_list_data=$this->db->query("SELECT * FROM tb_to_do_list")->result();
            foreach ($tb_to_do_list_data as $tb_to_do_list)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $tb_to_do_list->judul ?></td>
			<td><?php echo date('d-M-Y',strtotime($tb_to_do_list->tgl_list)) ?></td>
			<td style="text-align:center" width="200px">
                <a href="<?php echo site_url('tb_to_do_list/read/'.$tb_to_do_list->id_to_do); ?>" class="btn btn-primary btn-circle" data-popup="tooltip" data-placement="top" title="SEE YOUR LIST"><i class="fa fa-eye"></i></a>
                 <a href="<?php echo site_url('tb_to_do_list/delete/'.$tb_to_do_list->id_to_do); ?>" onclick="return confirm('Apakah Anda Ingin Menghapus Data ?');" class="btn btn-primary btn-circle" data-popup="tooltip" data-placement="top" title="DELETE DRAFT LIST"><i class="fa fa-trash"></i></a>
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


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="tambah-data" class="modal fade">
    <div class="modal-dialog">
        <section class="content">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">YOUR TO DO LIST IDENTITY ?</h3>
                </div>
                <form class="form-horizontal" class="form-horizontal" action="<?php echo site_url('tb_to_do_list/create_action'); ?>" method="post" enctype="multipart/form-data" role="form">
                    <table class='table table-bordered'>  
                       
        <tr><td width='200'>TITLE </td><td><input type="text" class="form-control" name="judul" id="judul" placeholder="TITLE" /></td></tr>
        <tr><td width='200'>DATE LIST </td><td><input type="date" class="form-control" name="tgl_list" id="tgl_list" value="<?php echo 
        $tgl = date("Y-m-d"); ?>" /></td></tr>

        <tr><td></td>
            <td>
        <button type="submit" onclick="return confirm('Apakah Anda Yakin Menyimpan Data ?');" class="btn btn-light">SAVE</button> 
                    <button type="reset" class="btn btn-light" id="searchclear" value="Reset">RESET</button>
        <button type="button" data-dismiss="modal" class="btn btn-light">BACK</button></td></tr>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $('#to_do_list').DataTable();
 });
</script>