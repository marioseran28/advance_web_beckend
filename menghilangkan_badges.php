ini codingan untuk loncengnya dan isi lonceng dengan bootstrapnya :
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="box-body">
            <div class='row'>
            <div class='col-md-9'>

            <div class="btn-group dropend">
                 <?php 
                 $tgl = date("Y-m-d");
                 $count_id=$this->db->query("SELECT COUNT(id_peminjaman) AS jumlah_total FROM tb_peminjaman_buku WHERE keterangan='dipinjam' 
                        AND status_read='0' AND (tgl_kembali<'$tgl' OR tgl_kembali='$tgl' OR DATEDIFF(tgl_kembali,'$tgl')=3
                        OR DATEDIFF(tgl_kembali,'$tgl')=2 OR DATEDIFF(tgl_kembali,'$tgl')=1)");
                    foreach($count_id->result() as $brp_id) {
                    if ($brp_id->jumlah_total==0) {
                       echo "
                          <button title='Notifikasi' onclick='hilang_badges(); load_more();' class='btn btn-link btn-xs' style='color: black;' data-bs-toggle='dropdown'><i class='fa fa-bell-o fa-lg'><input onclick='hilang_badges(); load_more();' id='button_notif' style='background-color: red; width: 25px; height: 25px; border-radius: 100%; text-align: center; border-color: red; font: 8px;' value='' readonly hidden />
                              </i></button>"; 
                    } else if ($brp_id->jumlah_total==9) {
                       echo "
                          <button title='Notifikasi' onclick='hilang_badges(); load_more();' class='btn btn-link btn-xs' style='color: black;' data-bs-toggle='dropdown'><i class='fa fa-bell-o fa-lg'><input onclick='hilang_badges(); load_more();' id='button_notif' style='background-color: red; width: 25px; height: 25px; border-radius: 100%; text-align: center; border-color: red; font: 8px;' value='$brp_id->jumlah_total' readonly />
                              </i></button>"; 

                    } else if ($brp_id->jumlah_total<9){
                        echo "
                          <button title='Notifikasi' onclick='hilang_badges(); load_more();' class='btn btn-link btn-xs' style='color: black;' data-bs-toggle='dropdown'><i class='fa fa-bell-o fa-lg'><input onclick='hilang_badges(); load_more();' id='button_notif' style='background-color: red; width: 25px; height: 25px; border-radius: 100%; text-align: center; border-color: red; font: 8px;' value='$brp_id->jumlah_total' readonly />
                              </i></button>"; 
                       
                    } else if ($brp_id->jumlah_total>9) {
                         echo "<button title='Notifikasi' onclick='hilang_badges(); load_more();' class='btn btn-link btn-xs' style='color: black;' data-bs-toggle='dropdown'><i class='fa fa-bell-o fa-lg'><input onclick='hilang_badges(); load_more();' id='button_notif' style='background-color: red; width: 25px; height: 25px; border-radius: 100%; text-align: center; border-color: red; font: 8px;' value='9+' readonly /></i></button>";

                    } else {

                    } 
                }?>
             <div class="dropdown-menu">
             <div class="box-header">
                        <h3 class="box-title"><b>NOTIFIKASI</b></h3>
                    </div>
                    <p id="garis_1" style="border-style: solid; border-width: 1px;"></p>

                    <table>
                        <tr><td><center><button id="loading" class="btn btn-link" style="display:none; color: red;">Tunggu sebentar...<i class="fa fa-spinner" aria-hidden="true"></center></td></tr>
                        <td id="button_isi"></td>

                    </table>
               
        </div>
    </div>
</div>
    

            </div>

        </div>

        letakkan script ini dalam body html kalian :
        <body onmousemove="tampil_button_notif();"> </body>
/////////////////////////////////////////////////////////////////////////////////////////////////////


ini javascriptnya :
<script type="text/javascript">
    function tampil_button_notif() {
           $.ajax({
                url:"<?php echo base_url() ?>index.php/peminjaman_buku/untuk_buttonnya",
                method: 'post',
                dataType: 'json',
                success: function(data)
                {
                    if (data.jumlah_total==0) {
                    $("#button_notif").css("display","none");
                } else if (data.jumlah_total==9) {
                    $("#button_notif").val(data.jumlah_total);
                    console.log(data.jumlah_total)
                    $("#button_notif").fadeIn("fast");
                } else if (data.jumlah_total<9) {
                    $("#button_notif").val(data.jumlah_total);
                    console.log(data.jumlah_total)
                    $("#button_notif").fadeIn("fast");
                } else if (data.jumlah_total>9) {
                     $("#button_notif").val('9+');
                    console.log('9+')
                    $("#button_notif").fadeIn("fast");
                }
            }
            });
          }  
    function load_more(){
    $("#loading").fadeIn("fast");
    $("#loading").fadeOut("fast");
    $("#button_isi").css("display","none");
    tampil_isi_notif();
  }
          function tampil_isi_notif() {
            $("#button_notif").css("display","none");
            $.ajax({
            url:"<?php echo base_url() ?>index.php/peminjaman_buku/untuk_isinya",
            success: function(html)
            { 
            $("#button_isi").fadeIn("slow");
            $('#button_isi').html(html);
            }
            });
          }    
          function hilang_badges() {
           $.ajax({
                url:"<?php echo base_url() ?>index.php/peminjaman_buku/hilangkan_badges",
                success: function(html)
                {

                }
            });
          }    
</script>
/////////////////////////////////////////////////////////////////////////////////////////////////////


ini file php/controllernya:
 function untuk_buttonnya(){
        $tgl = date("Y-m-d");
        $s = "SELECT COUNT(id_peminjaman) AS jumlah_total FROM tb_peminjaman_buku WHERE keterangan='dipinjam' 
            AND status_read='0' AND (tgl_kembali<'$tgl' OR tgl_kembali='$tgl' OR DATEDIFF(tgl_kembali,'$tgl')=3
            OR DATEDIFF(tgl_kembali,'$tgl')=2 OR DATEDIFF(tgl_kembali,'$tgl')=1)";
    $res = $this->db->query($s)->row_array();
    echo json_encode($res);
}

    function untuk_isinya(){
        $tgl = date("Y-m-d");
        $periksa=$this->db->query("SELECT nama_member, DATEDIFF(tgl_kembali,'$tgl') AS interval_tgl FROM tb_peminjaman_buku INNER JOIN tb_member ON tb_member.id_member=tb_peminjaman_buku.id_member WHERE keterangan='dipinjam'");
        $no=1;
        foreach($periksa->result() as $buku) {
            $nama_member = $buku->nama_member;
            if($buku->interval_tgl==1){ 
                            echo "<tr><td><b>$no</b></td><td><a class='btn btn-link btn-lg' style='color: black; font-size: 12px'><span class='glyphicon glyphicon-info-sign'></span> Member <label style='color: red;'>" .$nama_member."</label>, Besok adalah Batas pengembalian buku </a></td></tr>";

                        } elseif ($buku->interval_tgl==2) {
                             echo "<tr><td><b>$no</b></td><td><a class='btn btn-link btn-lg' style='color: black; font-size: 12px'><span class='glyphicon glyphicon-info-sign'></span> Member <label style='color: red;'>" .$nama_member."</label> Batas pengembalian buku tinggal 2 hari</a></td></tr>";

                        } elseif ($buku->interval_tgl==3) {
                             echo "<tr><td><b>$no</b></td><td><a class='btn btn-link btn-lg' style='color: black; font-size: 12px'><span class='glyphicon glyphicon-info-sign'></span> Member <label style='color: red;'>" .$nama_member."</label> Batas pengembalian buku tinggal 3 hari</a></td></<tr>";

                        } elseif ($buku->interval_tgl==0) {
                             echo "<tr><td><b>$no</b></td><td><a class='btn btn-link btn-lg' style='color: black; font-size: 12px'><span class='glyphicon glyphicon-info-sign'></span> Member <label style='color: red;'>" .$nama_member."</label> Hari ini adalah batas pengembalian buku</a></td></tr>";
 
                        } elseif ($buku->interval_tgl<0) {
                             echo "<tr><td><b>$no</b></td><td><a class='btn btn-link btn-lg' style='color: black; font-size: 12px'><span class='glyphicon glyphicon-info-sign'></span> Member <label style='color: red;'>" .$nama_member."</label> Telah melewati batas pengembalian buku</a></td></tr>";
  
                        } else {
                           
                        }   
                        $no++;      
    }
}



function hilangkan_badges(){
    $update_status_r = "UPDATE tb_peminjaman_buku SET status_read='1'";
    $this->db->query($update_status_r);
}