ini codingan untuk loncengnya dan isi lonceng dengan bootstrapnya :
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="box-body">
            <div class='row'>
            <div class='col-md-9'>

            <div class="btn-group dropend">
                 <?php 
                 $tgl = date("Y-m-d");
                 $count_id=$this->db->query("SELECT COUNT(id_peminjaman) AS jumlah_total FROM tb_peminjaman_buku WHERE keterangan='dipinjam' 
                        AND (tgl_kembali<'$tgl' OR tgl_kembali='$tgl' OR DATEDIFF(tgl_kembali,'$tgl')=3
                        OR DATEDIFF(tgl_kembali,'$tgl')=2 OR DATEDIFF(tgl_kembali,'$tgl')=1)");
                    foreach($count_id->result() as $brp_id) { ?>
                         
                          <button class="btn btn-link btn-xs" style="color: black;" data-bs-toggle="dropdown"><i class="fa fa-bell-o fa-lg"><input id="button_notif" style="background-color: red; width: 20px; height: 20px; border-radius: 100%; text-align: center; border-color: red; font: 8px;" value="<?php echo $brp_id->jumlah_total ?>" readonly />
                              </i></button>
    <?php } ?>

        <div class="dropdown-menu">
             <div class="box-header">
                        <h3 class="box-title"><b>NOTIFIKASI</b></h3>
                    </div>
                    <p id="garis_1" style="border-style: solid; border-width: 1px;"></p>
                    <table>

                        <td id="button_isi"></td>

                    </table>
               
        </div>
    </div>
</div>
    

            </div>

        </div>

        letakkan script ini dalam body html kalian :
        <body onmousemove="tampil_button_notif(); tampil_isi_notif();"> </body>
//////////////////////////////////////////////////////////////////////////////////////////////////////


ini javascriptnya :
<script type="text/javascript">
    function tampil_button_notif() {
           $.ajax({
                url:"<?php echo base_url() ?>index.php/peminjaman_buku/untuk_buttonnya",
                method: 'post',
                dataType: 'json',
                success: function(data)
                {
                    $("#button_notif").val(data.jumlah_total);
                    console.log(data.jumlah_total)
                }
            });
          }  
          function tampil_isi_notif() {
            $.ajax({
            url:"<?php echo base_url() ?>index.php/peminjaman_buku/untuk_isinya",
            success: function(html)
            { 
            $('#button_isi').html(html);
            }
            });
          }    
</script>
//////////////////////////////////////////////////////////////////////////////////////////////////////


ini file php/controllernya:
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