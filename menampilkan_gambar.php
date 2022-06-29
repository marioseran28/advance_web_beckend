codingan select :
<?php
             $start = 0;
            $member = $this->db->query("SELECT* FROM tb_member"); 
            foreach ($member->result() as $tb_member)
            {
               
                $start++
                ?>
//////////////////////////////sesuaikan keperluan kalian

 
 codingan tag img untuk menampilkan gambar 
 <td><img src="<?php echo base_url()?>assets/gambar/<?php echo ($tb_member->images);?>" width="50" height="50" alt="<?php echo $tb_member->images ?>" /></td>
 /////////////////////////saya disini pakai baseurl, jadi sesuaikan ya
 