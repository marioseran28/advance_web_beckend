<section class="sidebar">
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

   <ul class="sidebar-menu" data-widget="tree">
        <li class="dropdown">
          <?php echo anchor('dashboard_ak', "<i class='fa fa-tachometer'></i> DASHBOARD"); ?>
        </li>
      </ul>
      
   <?php 
   $sess1 = $_SESSION['username'];
      $q1 = $this->db->query("SELECT id_user FROM tb_user WHERE username = '$sess1'")->result();
      foreach ($q1 as $yang_login1) { 
          $treeview = $this->db->query("SELECT * FROM tb_hak_akses_t 
          INNER JOIN tb_treeview ON tb_treeview.`id_treeview`=tb_hak_akses_t.`id_treeview` 
          WHERE tb_treeview.id_treeview!='1' AND tb_treeview.status_aktif='1' AND tb_hak_akses_t.`id_user`='$yang_login1->id_user'")->result();
            foreach ($treeview as $tree)
            { ?>
   <ul class="sidebar-menu" data-widget="tree">
        <li class="treeview menu-close">
          <a href="#">
            <i class="<?php echo $tree->nama_icon ?>"></i> <span><?php echo $tree->nama_treeview ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>     
          </a>
         <ul class="treeview-menu">
          <?php 
          $sess = $_SESSION['username'];
      $q = $this->db->query("SELECT id_user FROM tb_user WHERE username = '$sess'")->result();
      foreach ($q as $yang_login) { 

          $menu = $this->db->query("SELECT * FROM tb_hak_akses_m 
            INNER JOIN tb_menu ON tb_menu.`id_menu`=tb_hak_akses_m.`id_menu` WHERE tb_menu.`id_treeview`='$tree->id_treeview' AND tb_menu.status_aktif='1' AND tb_hak_akses_m.`id_user`='$yang_login->id_user'")->result();
            foreach ($menu as $mn)
            { ?>
            <li>
              <a href="<?php echo site_url(''.$mn->nama_link) ?>"><i class="<?php echo $mn->nama_mn_icon ?>"></i> <?php echo $mn->nama_menu ?> </a>
            </li>
             <?php } 
           }?>
          </ul>
        </li> 
      </ul>
<?php }
} ?>
      

    <?php 
    $sess = $_SESSION['username'];
      $q = $this->db->query("SELECT id_user FROM tb_user WHERE username = '$sess'")->result();
      foreach ($q as $yang_login) { 
          $tree_mn = $this->db->query("SELECT * FROM tb_hak_akses_m 
            INNER JOIN tb_menu ON tb_menu.`id_menu`=tb_hak_akses_m.`id_menu` WHERE tb_menu.`id_treeview`='1' AND tb_menu.status_aktif='1' AND tb_hak_akses_m.`id_user`='$yang_login->id_user'")->result();
            foreach ($tree_mn as $mn_tree)
            { ?>
     <ul class="sidebar-menu" data-widget="tree">
        <li class="dropdown">
          <a href="<?php echo site_url(''.$mn_tree->nama_link) ?>"><i class="<?php echo $mn_tree->nama_mn_icon ?>"></i> <?php echo $mn_tree->nama_menu ?></a>
        </li>
      </ul>
         <?php }
         } ?>

       <ul class="sidebar-menu" data-widget="tree">
        <li class="dropdown" onclick="return confirm('Apakah Anda Yakin Ingin Keluar ?');">
          <?php echo anchor('log/logout', "<i class='fa fa-sign-out'></i> KELUAR"); ?>
        </li>
      </ul>
</div>

</section>