HEADER TABEL :
<tr>
        <th colspan="5"><center>Kode Akun</center></th>
        <th rowspan="2"><center>Nama Akun</center></th>
        <th colspan="2"><center>Akun Grup</center></th>
        <th rowspan="2"><center>Action</center></th>
            </tr>
            <tr><th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th><center>Debit</center></th>
                <th><center>Kredit</center></th></tr>
///////////////////////////////////////////////////////////////////////////////////////////

CARA PELEVELAN KODE AKUN
<?php
                $akun_data = $this->db->query("SELECT id_akun, akun_digunakan, level, nama_akun, akun_grup, kode_akun, status_akun, SUBSTRING(kode_akun, 1,7) AS URUT  FROM tb_akun ORDER BY URUT ASC");
                
            foreach ($akun_data->result() as $akun)
            {
 ?>
                <tr>
            <td><?php echo substr($akun->kode_akun,0,1); ?></td>
            <td><?php echo substr($akun->kode_akun,1,1) ?></td>  
            <td><?php echo substr($akun->kode_akun,2,2) ?></td>
            <td><?php echo substr($akun->kode_akun,4,2) ?></td>
            <td><?php echo substr($akun->kode_akun,6,2) ?></td>
            <?php } ?>