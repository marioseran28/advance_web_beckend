<div class="content-wrapper">
    
    <section class="content">
         <div class="row">
            <div class="col-xs-8" style="margin-left: 250px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">MANAGE YOUR TO DO LIST</h3>
            </div>
            
<table class='table table-bordered'>
<body onload="load_list();"> </body>          
        <tbody id="for_title">
            <tr><td width='200'>TITLE </td><td><?php echo $judul ?> <a class="btn btn-light" style="color: black;" title="EDIT TITLE" onclick="set_edit_title()"><i class="fa fa-pencil-square-o"></i></a></td></tr>
        </tbody>
        
        <tbody id="for_date">
             <tr><td width='200'>DATE LIST </td><td><?php echo date('d-M-Y',strtotime($tgl_list)) ?> <a class="btn btn-light" style="color: black;"  onclick="set_edit_date()"><i class="fa fa-pencil-square-o"></i></a></td></tr>
        </tbody>   
       
        <tr><td width='200'>INPUT LIST</td><td><input type="text" class="form-control" name="the_list" id="the_list" placeholder="INPUT TO DO LIST" /></td><td><button class="btn btn-light" onclick="add_list()"><i class="fa fa-plus"></i> ADD</a></button></td></tr>
        <tr><td></td>
            <td><input type="hidden" class="form-control" name="id_to_do" id="id_to_do" value="<?php echo $id_to_do ?>" />
        <a href="<?php echo site_url('tb_to_do_list') ?>" style="color: black;" class="btn btn-light"><i class="fa fa-sign-out"></i> BACK</a></td></tr>
    </table>   
</div>
</div>
<div class="col-xs-12">
                    <div class="box box-warning box-solid">
                         <div class="box-header">
                            <h3 class="box-title">READY</h3>
                        </div>
                        <table class="table table-bordered">
                         
            <tr>
                <th>LIST NAME</th>
                <th>DESCRIPTION</th>
                <th>LIST STATUS</th>
                <th>ACTION</th>
            </tr>
             <tbody id="ready">
            </tbody>
                          
                        </table>
                    </div>

                    <div class="box box-info box-solid">
                         <div class="box-header">
                            <h3 class="box-title">WORKING ON IT</h3>
                        </div>
                        <table class="table table-bordered">
                            
                          <tr>
                <th>LIST NAME</th>
                <th>DESCRIPTION</th>
                <th>LIST STATUS</th>
                <th>ACTION</th>
            </tr>
             <tbody id="working_on_it">
            </tbody>
                        </table>
                    </div>

                    <div class="box box-danger box-solid">
                         <div class="box-header">
                            <h3 class="box-title">DELAY</h3>
                        </div>
                        <table class="table table-bordered">
                            
                          <tr>
                <th>LIST NAME</th>
                <th>DESCRIPTION</th>
                <th>LIST STATUS</th>
                <th>ACTION</th>
            </tr>
             <tbody id="delay">
            </tbody>
                        </table>
                    </div>

                    <div class="box box-success box-solid">
                         <div class="box-header">
                            <h3 class="box-title">DONE</h3>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                <th>LIST NAME</th>
                <th>DESCRIPTION</th>
                <th>LIST STATUS</th>
                <th>ACTION</th>
            </tr>
             <tbody id="done">
            </tbody>
                          
                        </table>
                    </div>
</div>
</section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script type="text/javascript">
    function set_edit_title(){
    var id_to_do = $("#id_to_do").val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/set_edit_title",
            data:"id_to_do="+id_to_do,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                  isi_tabel+=`
                    <tr><td width='200'>TITLE </td><td><input type="text" class="form-control" name="title" id="title" value="`+ item.judul +`" /></td><td><a class="btn btn-light" style="color: black;"  onclick="edit_title()"><i class="fa fa-save" title="SAVE EDIT TITLE"></i></a></td></tr>
                  `;

              });                    
              $('#for_title').html(isi_tabel);
            }
        });
    }

    function edit_title(){
    var id_to_do = $("#id_to_do").val();
    var title = $("#title").val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/edit_title_c",
            data:"id_to_do="+id_to_do+"&title="+title,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                  isi_tabel+=`
                   <tr><td width='200'>TITLE </td><td>`+ item.judul +`<a class="btn btn-light" style="color: black;"  onclick="set_edit_title()"><i class="fa fa-pencil-square-o"></i></a></td></tr>
                  `;

              });                    
              $('#for_title').html(isi_tabel);
            }
        });
    }

    function set_edit_date(){
    var id_to_do = $("#id_to_do").val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/set_edit_date",
            data:"id_to_do="+id_to_do,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                  isi_tabel+=`
                    <tr><td width='200'>DATE LIST </td><td><input type="date" class="form-control datepicker" name="dates" id="dates" value="`+ item.tgl_list +`" /></td><td><a class="btn btn-light" style="color: black;"  onclick="edit_date()"><i class="fa fa-save" title="SAVE EDIT DATE"></i></a></td></tr>
                  `;

              });                    
              $('#for_date').html(isi_tabel);
            }
        });
    }

    function edit_date(){
    var id_to_do = $("#id_to_do").val();
    var dates = $("#dates").val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/edit_date_c",
            data:"id_to_do="+id_to_do+"&dates="+dates,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                  isi_tabel+=`
                   <tr><td width='200'>DATE LIST </td><td>`+  item.tgl_list +`<a class="btn btn-light" style="color: black;"  onclick="set_edit_date()"><i class="fa fa-pencil-square-o"></i></a></td></tr>
                  `;

              });                    
              $('#for_date').html(isi_tabel);
            }
        });
    }

    function add_list(){
    var id_to_do = $("#id_to_do").val();
    var the_list = $("#the_list").val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/add",
            data:"id_to_do="+id_to_do+"&the_list="+the_list,
            success: function(html)
            {
              var the_list = $("#the_list").val('');
              load_list();
          }
        });
    }

 function load_list(){
    var id_to_do = $("#id_to_do").val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/list_todo",
            data:"id_to_do="+id_to_do,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){ 
                 $keterangan = ``+ item.keterangan +``;
                     if (item.keterangan=='0')$keterangan = "";
              $status_list = "<tr></tr><td></td>";
                    if(item.status_list=='ready')$status_list = `<tr><td>`+ item.nama_list +`</td><td>` +  $keterangan + `</td><td><select name='status_list_ready' onchange="edit_status_r('` + item.id_detail_todo + `')" id='status_list_ready` + item.id_detail_todo + `' style='width: 250px' class='form-control'><option value=''>--Pilih--</option><option value='ready' selected>READY</option><option value='working on it'>WORKING ON IT</option><option value='delay'>DELAY</option><option value='done'>DONE</option></select></td><td><a onclick="edit_ready('` + item.id_detail_todo + `')" class='btn btn-warning btn-xs' data-popup='tooltip' data-placement='top' title='EDIT YOUR LIST'><i class='fa fa-pencil-square-o'></i></a> <a onclick="delete_list('` + item.id_detail_todo + `')" class='btn btn-danger btn-xs' data-popup='tooltip' data-placement='top' title='DELETE LIST'><i class='fa fa-trash'></i></a>
                        </td></tr>`;          

                  isi_tabel+=`
                  `+  $status_list +`
                  `;
              });                    
              $('#ready').html(isi_tabel);
            }
        });

        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/list_todo_w",
            data:"id_to_do="+id_to_do,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){   
              $keterangan = ``+ item.keterangan +``;
                     if (item.keterangan=='0')$keterangan = "";                 
                $status_list = "<tr></tr><td></td>";
                    if(item.status_list=='working on it')$status_list = `<tr><td>`+ item.nama_list +`</td><td>`+ $keterangan +`</td><td><select name='status_list_working' onchange='edit_status_w(`+ item.id_detail_todo +`)' id='status_list_working` + item.id_detail_todo + `' style='width: 250px' class='form-control'><option value=''>--Pilih--</option><option value='ready'>READY</option><option value='working on it' selected>WORKING ON IT</option><option value='delay'>DELAY</option><option value='done'>DONE</option></select></td><td><a onclick="edit_working('` + item.id_detail_todo + `')" class='btn btn-warning btn-xs' data-popup='tooltip' data-placement='top' title='EDIT YOUR LIST'><i class='fa fa-pencil-square-o'></i></a> <a onclick="delete_list('` + item.id_detail_todo + `')" class='btn btn-danger btn-xs' data-popup='tooltip' data-placement='top' title='DELETE LIST'><i class='fa fa-trash'></i></a></td></tr>`;                 
                  isi_tabel+=`
                  `+  $status_list +`
                  `;

              });                    
              $('#working_on_it').html(isi_tabel);
            }
        });

        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/list_todo_d",
            data:"id_to_do="+id_to_do,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){ 
              $keterangan = ``+ item.keterangan +``;
                     if (item.keterangan=='0')$keterangan = "";                   
                $status_list = "<tr></tr><td></td>";
                    if(item.status_list=='delay')$status_list = `<tr><td>`+ item.nama_list +`</td><td>`+ $keterangan +`</td><td><select name='status_list_d' onchange='edit_status_d(`+ item.id_detail_todo +`)' id='status_list_d` + item.id_detail_todo + `' style='width: 250px' class='form-control'><option value=''>--Pilih--</option><option value='ready'>READY</option><option value='working on it'>WORKING ON IT</option><option value='delay' selected>DELAY</option><option value='done'>DONE</option></select></td><td><a onclick="edit_delay('` + item.id_detail_todo + `')" class='btn btn-warning btn-xs' data-popup='tooltip' data-placement='top' title='EDIT YOUR LIST'><i class='fa fa-pencil-square-o'></i></a> <a onclick="delete_list('` + item.id_detail_todo + `')" class='btn btn-danger btn-xs' data-popup='tooltip' data-placement='top' title='DELETE LIST'><i class='fa fa-trash'></i></a></td></tr>`;                 
                  isi_tabel+=`
                  `+  $status_list +`
                  `;

              });                    
              $('#delay').html(isi_tabel);
            }
        });

        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/list_todo_done",
            data:"id_to_do="+id_to_do,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){ 
              $keterangan = ``+ item.keterangan +``;
                     if (item.keterangan=='0')$keterangan = "";                   
                $status_list = "<tr></tr><td></td>";
                    if(item.status_list=='done')$status_list = `<tr><td>`+ item.nama_list +`</td><td>`+ $keterangan +`</td><td><select name='status_list_done' onchange='edit_status_done(`+ item.id_detail_todo +`)' id='status_list_done` + item.id_detail_todo + `' style='width: 250px' class='form-control' disabled='true'><option value=''>--Pilih--</option><option value='ready'>READY</option><option value='working on it'>WORKING ON IT</option><option value='delay'>DELAY</option><option value='done' selected>DONE</option></select></td><td><a onclick="delete_list('` + item.id_detail_todo + `')" class='btn btn-danger btn-xs' data-popup='tooltip' data-placement='top' title='DELETE LIST'><i class='fa fa-trash'></i></a></td></tr>`;                 
                  isi_tabel+=`
                  `+  $status_list +`
                  `;

              });                    
              $('#done').html(isi_tabel);
            }
        });
    }

    function edit_status_r(id_detail_todo){
    var status_list_ready=$("#status_list_ready"+id_detail_todo).val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/status_changing_r",
            data:"id_to_do="+id_to_do+"&id_detail_todo="+id_detail_todo+"&status_list_ready="+status_list_ready,
            success: function(html)
            {
              load_list();
            }
        });
}

function edit_status_w(id_detail_todo){
    var status_list_working = $("#status_list_working"+id_detail_todo).val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/status_changing_w",
            data:"&id_detail_todo="+id_detail_todo+"&status_list_working="+status_list_working,
            success: function(html)
            {
              load_list();
            }
        });
}
function edit_status_d(id_detail_todo){
    var status_list_d = $("#status_list_d"+id_detail_todo).val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/status_changing_d",
            data:"&id_detail_todo="+id_detail_todo+"&status_list_d="+status_list_d,
            success: function(html)
            {
              load_list();
            }
        });
}
function edit_status_done(id_detail_todo){
    var status_list_done = $("#status_list_done"+id_detail_todo).val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/status_changing_do",
            data:"&id_detail_todo="+id_detail_todo+"&status_list_done="+status_list_done,
            success: function(html)
            {
              load_list();
            }
        });
}

 function delete_list(id_detail_todo){
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/delete_list",
            data:"&id_detail_todo="+id_detail_todo,
            success: function(html)
            {
              load_list();
            }
        });
 }

 function edit_ready(id_detail_todo){
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/set_edit",
            data:"id_detail_todo="+id_detail_todo,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                $keterangan = ``+ item.keterangan +``;
                     if (item.keterangan=='0')$keterangan = ""; 
                  isi_tabel+=`
                    <tr><td><input type='text' class='form-control' name='nama_list_r`+ item.id_detail_todo +`' id='nama_list_r`+ item.id_detail_todo +`' placeholder="EDIT LIST NAME" value='`+ item.nama_list +`' /></td><td><input type='text' class='form-control' name='keterangan_r`+ item.id_detail_todo +`' id='keterangan_r`+ item.id_detail_todo +`' placeholder="EDIT DESCRIPTION" value='`+ $keterangan +`' /></td><td>`+ item.status_list +`</td><td><a onclick='save_edit_ready(`+ item.id_detail_todo +`)' style="color: black;" class='btn btn-light btn-lg' data-popup='tooltip' data-placement='top' title='SAVE YOUR LIST'><i class='fa fa-save'></i></a></td></tr>
                  `;

              });                    
              $('#ready').html(isi_tabel);
            }
        });
    }

    function save_edit_ready(id_detail_todo){
        var nama_list_r = $("#nama_list_r"+id_detail_todo).val();
        var keterangan_r = $("#keterangan_r"+id_detail_todo).val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/save_edit_ready",
            data:"id_detail_todo="+id_detail_todo+"&nama_list_r="+nama_list_r+"&keterangan_r="+keterangan_r,
            success: function(html)
            {
              load_list();
            }
        });
    }

    function edit_working(id_detail_todo){
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/set_edit",
            data:"id_detail_todo="+id_detail_todo,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                $keterangan = ``+ item.keterangan +``;
                     if (item.keterangan=='0')$keterangan = ""; 
                  isi_tabel+=`
                    <tr><td><input type='text' class='form-control' name='nama_list_w`+ item.id_detail_todo +`' id='nama_list_w`+ item.id_detail_todo +`' placeholder="EDIT LIST NAME" value='`+ item.nama_list +`' /></td><td><input type='text' class='form-control' name='keterangan_w`+ item.id_detail_todo +`' id='keterangan_w`+ item.id_detail_todo +`' placeholder="EDIT DESCRIPTION" value='`+ $keterangan +`' /></td><td>`+ item.status_list +`</td><td><a onclick='save_edit_working(`+ item.id_detail_todo +`)' class='btn btn-light btn-lg' style="color: black;" data-popup='tooltip' data-placement='top' title='SAVE YOUR LIST'><i class='fa fa-save'></i></a></td></tr>
                  `;

              });                    
              $('#working_on_it').html(isi_tabel);
            }
        });
    }

    function save_edit_working(id_detail_todo){
        var nama_list_w = $("#nama_list_w"+id_detail_todo).val();
        var keterangan_w = $("#keterangan_w"+id_detail_todo).val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/set_edit_working",
            data:"id_detail_todo="+id_detail_todo+"&nama_list_w="+nama_list_w+"&keterangan_w="+keterangan_w,
            success: function(html)
            {
              load_list();
            }
        });
    }

    function edit_delay(id_detail_todo){
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/set_edit",
            data:"id_detail_todo="+id_detail_todo,
            success: function(html)
            {
              data = JSON.parse(html);
              isi_tabel = '';
              data.forEach(function(item, index){
                $keterangan = ``+ item.keterangan +``;
                     if (item.keterangan=='0')$keterangan = ""; 
                  isi_tabel+=`
                    <tr><td><input type='text' class='form-control' name='nama_list_d`+ item.id_detail_todo +`' id='nama_list_d`+ item.id_detail_todo +`' placeholder="EDIT LIST NAME" value='`+ item.nama_list +`' /></td><td><input type='text' class='form-control' name='keterangan_d`+ item.id_detail_todo +`' id='keterangan_d`+ item.id_detail_todo +`' placeholder="EDIT DESCRIPTION" value='`+ $keterangan +`' /></td><td>`+ item.status_list +`</td><td><a onclick='save_edit_delay(`+ item.id_detail_todo +`)' class='btn btn-light btn-lg' style="color: black;" data-popup='tooltip' data-placement='top' title='SAVE YOUR LIST'><i class='fa fa-save'></i></a></td></tr>
                  `;

              });                    
              $('#delay').html(isi_tabel);
            }
        });
    }

    function save_edit_delay(id_detail_todo){
        var nama_list_d = $("#nama_list_d"+id_detail_todo).val();
        var keterangan_d = $("#keterangan_d"+id_detail_todo).val();
        $.ajax({
            url:"<?php echo base_url() ?>index.php/tb_to_do_list/save_edit_delay",
            data:"id_detail_todo="+id_detail_todo+"&nama_list_d="+nama_list_d+"&keterangan_d="+keterangan_d,
            success: function(html)
            {
              load_list();
            }
        });
    }
  </script>