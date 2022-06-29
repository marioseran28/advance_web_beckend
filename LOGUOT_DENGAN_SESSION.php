CODINGAN UNTUK TOMBOL LOGOUT :
<ul class="sidebar-menu" data-widget="tree">
        <li class="dropdown" onclick="return confirm('Apakah Anda Yakin Ingin Keluar ?');">
          <?php echo anchor('welcome/logout', "<i class='fa fa-sign-out'></i> KELUAR"); ?>
        </li>
</ul>
//////////////////////////////////////////////////////////////////////////////////////

CODINGAN UNTUK CONTROLLER/ FILE PHPNYA :
public function index()
	{
        $title = 'Login';
        $data = array(
            'title' => $title,
        );
        $this->load->view('login/welcome_message', $data);
    }

     public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $this->db->where('username',$username);
        $this->db->where('password', ($password));
        $user       = $this->db->get('tb_user');
        if($user->num_rows()>0){
            // retrive user data to session
            $this->session->set_userdata($user->row_array());
            redirect('tb_user');
        }else{
        	$this->session->set_flashdata('status_login','username atau password yang anda input salah');
            redirect('welcome');
        }
    }

 public function logout()
    {
             $this->session->sess_destroy();
             $this->session->set_flashdata('status_login','Berhasil untuk keluar!');
            redirect('welcome');
    }
/////////////////////////////////////////////////////////////////////////////////////

CODINGAN UNTUK HALAMAN LOGINNYA:
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>SILAHKAN LOGIN </b>DULU</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <?php
                $status_login = $this->session->userdata('status_login');
                if (empty($status_login)) {
                    $message = "Silahkan login untuk masuk ke aplikasi";
                } else {
                    $message = $status_login;
                }
                ?>
                <p class="login-box-msg"><?php echo $message; ?></p>

 <form action="<?php echo site_url('welcome/login'); ?>" method="post">
          <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" onclick="return confirm('Pastikan Username dan Password Benar!');" class="btn btn-primary btn-block">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center mb-3">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div> -->
        <!-- /.social-auth-links -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
 <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(); ?>/assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>/assets/adminlte/plugins/iCheck/icheck.min.js"></script>
</body>

</html>