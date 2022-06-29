 <?php 
                    $tgl = date("Y-m-d");
                    $periksa=$this->db->query("SELECT nama_member, DATEDIFF(tgl_kembali,'$tgl') AS interval_tgl FROM tb_peminjaman_buku INNER JOIN tb_member ON tb_member.id_member=tb_peminjaman_buku.id_member WHERE keterangan='dipinjam'")->result_array();
                    foreach($periksa as $buku){
                        
                        $nama_member=$buku['nama_member'];
                        if($buku['interval_tgl']==1){ 
                            echo "<div style='padding:5px' style='width:50px' ><span class='glyphicon glyphicon-info-sign'></span> Member <a style='color:red'>" .$nama_member."</a>, Besok adalah Batas pengembalian buku </div>"; 
                        } elseif ($buku['interval_tgl']==2) {
                             echo "<div style='padding:5px' style='width:50px' ><span class='glyphicon glyphicon-info-sign'></span> Member <a style='color:red'>" .$nama_member."</a> Batas pengembalian buku tinggal 2 hari </div>"; 
                        } elseif ($buku['interval_tgl']==3) {
                             echo "<div style='padding:5px' style='width:50px' ><span class='glyphicon glyphicon-info-sign'></span> Member <a style='color:red'>" .$nama_member."</a> Batas pengembalian buku tinggal 3 hari </div>"; 
                        } elseif ($buku['interval_tgl']==0) {
                             echo "<div style='padding:5px' style='width:50px' ><span class='glyphicon glyphicon-info-sign'></span> Member <a style='color:red'>" .$nama_member."</a> Hari ini adalah batas pengembalian buku </div>"; 
                        } elseif ($buku['interval_tgl']<0) {
                             echo "<div style='padding:5px' style='width:50px' ><span class='glyphicon glyphicon-info-sign'></span> Member <a style='color:red'>" .$nama_member."</a> Telah melewati batas pengembalian buku </div>"; 
                        } else {
                            echo "";
                        }
                    }
                    ?>