<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container-fluid">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>  

    <ul class="nav navbar-nav">

      <li class="active"><?php echo anchor('dashboard_ak', "<i class='fa fa-tachometer'></i> DASHBOARD"); ?></li>

      <?php 
          $treeview = $this->db->query("SELECT * FROM tb_treeview WHERE tb_treeview.id_treeview!='1' AND tb_treeview.status_aktif='1'")->result();
            foreach ($treeview as $tree)
            { ?>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $tree->nama_treeview ?> <span class="caret"></span></a>

        <ul class="dropdown-menu">
          <?php 
          $menu = $this->db->query("SELECT * FROM tb_menu WHERE tb_menu.`id_treeview`='$tree->id_treeview' AND tb_menu.status_aktif='1'")->result();
            foreach ($menu as $mn)
            { ?>
          <li><a href="<?php echo site_url(''.$mn->nama_link) ?>"><?php echo $mn->nama_menu ?></a></li>
          <?php 
           }?>
        </ul>
      </li>
      <?php
} ?>
      <?php 
          $tree_mn = $this->db->query("SELECT * FROM tb_menu WHERE tb_menu.`id_treeview`='1' AND tb_menu.status_aktif='1'")->result();
            foreach ($tree_mn as $mn_tree)
            { ?>
      <li><a href="<?php echo site_url(''.$mn_tree->nama_link) ?>"><?php echo $mn_tree->nama_menu ?></a></li>
       <?php
         } ?>
      
    </ul>
  </div>
</body>