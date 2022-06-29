<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_to_do_list extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tb_to_do_list_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'tb_to_do_list/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tb_to_do_list/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'tb_to_do_list/index.html';
            $config['first_url'] = base_url() . 'tb_to_do_list/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tb_to_do_list_model->total_rows($q);
        $tb_to_do_list = $this->Tb_to_do_list_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tb_to_do_list_data' => $tb_to_do_list,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','tb_to_do_list/tb_to_do_list_list', $data);
    }

    public function read($id) 
    {
        $query = $this->db->query("SELECT * FROM tb_to_do_list WHERE id_to_do='$id'")->result();
        foreach($query as $row){
        if ($row) {
            $data = array(
		'id_to_do' => $row->id_to_do,
		'judul' => $row->judul,
		'tgl_list' => $row->tgl_list,
	    );
            $this->template->load('template','tb_to_do_list/tb_to_do_list_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_to_do_list'));
        }
    }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tb_to_do_list/create_action'),
	    'id_to_do' => set_value('id_to_do'),
	    'judul' => set_value('judul'),
	    'tgl_list' => set_value('tgl_list'),
	);
        $this->template->load('template','tb_to_do_list/tb_to_do_list_form', $data);
    }
    
    public function create_action() 
    {
        $data = array(
		'judul' => $this->input->post('judul',TRUE),
		'tgl_list' => $this->input->post('tgl_list',TRUE),
	    );
        $judul = $this->input->post('judul');
        $tgl_list = $this->input->post('tgl_list');
        
        $this->db->insert('tb_to_do_list',$data);
        $hasil=$this->db->query("SELECT * FROM tb_to_do_list WHERE judul='$judul' AND tgl_list ='$tgl_list'");
        foreach($hasil->result() as $row) {
        redirect(site_url('tb_to_do_list/read/'.$row->id_to_do));
         }

        }
    
    public function update($id) 
    {
        $row = $this->Tb_to_do_list_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tb_to_do_list/update_action'),
		'id_to_do' => set_value('id_to_do', $row->id_to_do),
		'judul' => set_value('judul', $row->judul),
		'tgl_list' => set_value('tgl_list', $row->tgl_list),
	    );
            $this->template->load('template','tb_to_do_list/tb_to_do_list_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_to_do_list'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_to_do', TRUE));
        } else {
            $data = array(
		'judul' => $this->input->post('judul',TRUE),
		'tgl_list' => $this->input->post('tgl_list',TRUE),
	    );

            $this->Tb_to_do_list_model->update($this->input->post('id_to_do', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tb_to_do_list'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tb_to_do_list_model->get_by_id($id);

        if ($row) {
            $this->Tb_to_do_list_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tb_to_do_list'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_to_do_list'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');
	$this->form_validation->set_rules('tgl_list', 'tgl list', 'trim|required');

	$this->form_validation->set_rules('id_to_do', 'id_to_do', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function set_edit_title(){
        $id_to_do = $this->input->get('id_to_do');

        $hasil=$this->db->query("SELECT * FROM tb_to_do_list WHERE id_to_do='$id_to_do'");
        echo json_encode($hasil->result());
    }

    function edit_title_c(){
        $id_to_do = $this->input->get('id_to_do');
        $title = $this->input->get('title');

        $update=$this->db->query("UPDATE tb_to_do_list SET judul='$title' WHERE id_to_do=$id_to_do");

        $hasil=$this->db->query("SELECT * FROM tb_to_do_list WHERE id_to_do='$id_to_do'");
        echo json_encode($hasil->result());
    }

    function set_edit_date(){
        $id_to_do = $this->input->get('id_to_do');

        $hasil=$this->db->query("SELECT * FROM tb_to_do_list WHERE id_to_do='$id_to_do'");
        echo json_encode($hasil->result());
    }

    function edit_date_c(){
        $id_to_do = $this->input->get('id_to_do');
        $dates = $this->input->get('dates');

        $update=$this->db->query("UPDATE tb_to_do_list SET tgl_list='$dates' WHERE id_to_do=$id_to_do");

        $hasil=$this->db->query("SELECT DATE_FORMAT(tgl_list,'%d-%b-%Y') as tgl_list FROM tb_to_do_list WHERE id_to_do='$id_to_do'");
        echo json_encode($hasil->result());
    }

     function add(){
        $id_to_do = $this->input->get('id_to_do');
        $the_list = $this->input->get('the_list');

        $hasil=$this->db->query("INSERT INTO tb_detail_todolist SET id_to_do='$id_to_do', nama_list='$the_list'");
    }

    function list_todo(){
        $id_to_do = $this->input->get('id_to_do');

        $hasil=$this->db->query("SELECT id_detail_todo,id_to_do,nama_list,status_list,COALESCE(keterangan, 0) AS keterangan FROM tb_detail_todolist WHERE id_to_do='$id_to_do' AND status_list='ready'");
        echo json_encode($hasil->result());
    }

    function list_todo_w(){
        $id_to_do = $this->input->get('id_to_do');

        $hasil=$this->db->query("SELECT id_detail_todo,id_to_do,nama_list,status_list,COALESCE(keterangan, 0) AS keterangan FROM tb_detail_todolist WHERE id_to_do='$id_to_do' AND status_list='working on it'");
        echo json_encode($hasil->result());
    }

    function list_todo_d(){
        $id_to_do = $this->input->get('id_to_do');
        
        $hasil=$this->db->query("SELECT id_detail_todo,id_to_do,nama_list,status_list,COALESCE(keterangan, 0) AS keterangan FROM tb_detail_todolist WHERE id_to_do='$id_to_do' AND status_list='delay'");
        echo json_encode($hasil->result());
    }

    function list_todo_done(){
        $id_to_do = $this->input->get('id_to_do');
        
        $hasil=$this->db->query("SELECT id_detail_todo,id_to_do,nama_list,status_list,COALESCE(keterangan, 0) AS keterangan FROM tb_detail_todolist WHERE id_to_do='$id_to_do' AND status_list='done'");
        echo json_encode($hasil->result());
    }

    function status_changing_r(){
        $status_list_ready = $this->input->get('status_list_ready');
        $id_detail_todo = $this->input->get('id_detail_todo');


        $hasil=$this->db->query("UPDATE tb_detail_todolist SET status_list='$status_list_ready' WHERE id_detail_todo='$id_detail_todo'");
    }

    function status_changing_w(){
        $status_list_working = $this->input->get('status_list_working');
        $id_detail_todo = $_GET['id_detail_todo'];

        
        $hasil=$this->db->query("UPDATE tb_detail_todolist SET status_list='$status_list_working' WHERE id_detail_todo='$id_detail_todo'");
    }

    function status_changing_d(){
        $status_list_d = $this->input->get('status_list_d');
        $id_detail_todo = $_GET['id_detail_todo'];

        
        $hasil=$this->db->query("UPDATE tb_detail_todolist SET status_list='$status_list_d' WHERE id_detail_todo='$id_detail_todo'");
    }

    function status_changing_do(){
        $status_list_done = $this->input->get('status_list_done');
        $id_detail_todo = $_GET['id_detail_todo'];

        
        $hasil=$this->db->query("UPDATE tb_detail_todolist SET status_list='$status_list_done' WHERE id_detail_todo='$id_detail_todo'");
    }

    function delete_list(){
        $id_detail_todo = $_GET['id_detail_todo'];

        
        $sql=$this->db->query("DELETE FROM tb_detail_todolist WHERE id_detail_todo='$id_detail_todo'");
    }

    function set_edit(){
         $id_detail_todo = $_GET['id_detail_todo'];

        $hasil=$this->db->query("SELECT id_detail_todo,id_to_do,nama_list,status_list,COALESCE(keterangan, 0) AS keterangan FROM tb_detail_todolist WHERE id_detail_todo='$id_detail_todo'");
        echo json_encode($hasil->result());
    }

     function save_edit_ready(){
        $id_detail_todo = $_GET['id_detail_todo'];
        $nama_list_r = $this->input->get('nama_list_r');
        $keterangan_r = $this->input->get('keterangan_r');

        $update=$this->db->query("UPDATE tb_detail_todolist SET nama_list='$nama_list_r',keterangan='$keterangan_r' WHERE id_detail_todo='$id_detail_todo'");
    }

     function set_edit_working(){
        $id_detail_todo = $_GET['id_detail_todo'];
        $nama_list_w = $this->input->get('nama_list_w');
        $keterangan_w = $this->input->get('keterangan_w');

        $update=$this->db->query("UPDATE tb_detail_todolist SET nama_list='$nama_list_w',keterangan='$keterangan_w' WHERE id_detail_todo='$id_detail_todo'");
    }


    function save_edit_delay(){
        $id_detail_todo = $_GET['id_detail_todo'];
        $nama_list_d = $this->input->get('nama_list_d');
        $keterangan_d = $this->input->get('keterangan_d');

        $update=$this->db->query("UPDATE tb_detail_todolist SET nama_list='$nama_list_d',keterangan='$keterangan_d' WHERE id_detail_todo='$id_detail_todo'");
    }


}

/* End of file Tb_to_do_list.php */
/* Location: ./application/controllers/Tb_to_do_list.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-05-20 09:04:10 */
/* http://harviacode.com */