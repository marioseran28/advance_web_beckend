codingan html untuk tampilan blockednya:
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ERROR 403</title>
</head>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-6" style="margin-left: 500px; color: blue;">
                <div class="box box-warning box-solid">
<div class="box-header">
                        <u><h1 class="box-title">ERROR 403</h1></u>
                        <a href="<?php echo site_url('dashboard_ak') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> BACK TO DASHBOARD</a>
                    </div>
                </div></div></div></section></div>


</html>
//////////////////////////////////////////////////////////////////////////////////////

codingan untuk diletakkan dalam controllernya atau bagian file.php
$sess = $_SESSION['username'];
         $q = $this->db->query("SELECT id_user FROM tb_user WHERE username = '$sess'")->result();
      foreach ($q as $yang_login) { 
         $hak_akses = $this->db->query("SELECT COALESCE(COUNT(tb_menu.nama_link),0) AS nama_link FROM tb_menu 
            INNER JOIN tb_hak_akses_m ON tb_menu.`id_menu`=tb_hak_akses_m.`id_menu`
            INNER JOIN tb_user ON tb_user.`id_user`=tb_hak_akses_m.`id_user` WHERE tb_hak_akses_m.id_user='$yang_login->id_user'AND tb_menu.nama_link='tb_pasien'")->result();
          foreach ($hak_akses as $akses) { 
            if ($akses->nama_link=='1') {
            $this->template->load('template','tb_pasien/tb_pasien_list', $data);
            } else if($akses->nama_link=='0') {
                $this->load->view('welcome_message');
            }
    
        }

    }


