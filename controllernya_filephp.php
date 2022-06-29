<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class InvoicesupplierF extends CI_Controller
{
    function __construct()
    {
         parent::__construct();
        is_login();
        $this->load->model('Invoicesupplier_modelF');
        $this->load->model('Jurnal_model');
        $this->load->library('form_validation');
    }



   public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'invoicesupplierf/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'invoicesupplierf/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'invoicesupplierf/index.html';
            $config['first_url'] = base_url() . 'invoicesupplierf/index.html';
        }

        $config['per_page'] = 0;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Invoicesupplier_modelF->total_rows($q);
        $invoicesupplierf = $this->Invoicesupplier_modelF->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data = array(
            'invoicesupplierf_data' => $invoicesupplierf,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'start' => $start,
        );
        $this->template->load('template','invoicesupplierf/tb_invoicesupplier_list', $data);
    }

    public function read($id) 
    {
         $sql = "SELECT id_rcv FROM tb_invoicesupplier WHERE no_invoice='$id'";
            $queri= $this->db->query($sql);
            foreach ($queri->result() as $po1) {
                $sql1 = "SELECT kode_rcv FROM tb_rcv WHERE id_rcv=$po1->id_rcv";
            $queri1= $this->db->query($sql1);
            foreach ($queri1->result() as $po11) {
        $row = $this->Invoicesupplier_modelF->get_by_id($id);
        if ($row) {
            $data = array(
        'kode_no_inv' => $row->kode_no_inv,
        'no_invoice' => $row->no_invoice,
        'tgl_invoice' => $row->tgl_invoice,
        'id_po' => $row->kode_po,
        'id_rcv' => $po11->kode_rcv,
        'id_distributor' => $row->nama_perusahaan,
        'deskripsi_inv' => $row->deskripsi_inv,
        'lama_waktu' => $row->lama_waktu,
        'status_prf' => $row->status_prf,
        'status_jurnal' => $row->status_jurnal,
        'inv_status' => $row->inv_status,
        'total_keseluruhan' => $row->total_keseluruhan,
        'id_akun' => $row->id_akun,
        );
        
             $data['sql'] ="SELECT tb3.id_obat,tb3.nama_obat,tb1.harga_satuan,tb1.qty,tb1.total,tb1.id_detail_invoicesupplier 
        FROM tb_detail_invoicesupplier as tb1 , tb_obat as tb3
        WHERE tb3.id_obat=tb1.deskripsidet_supplier AND tb1.no_invoice='$id'";
        
         $data['sql1'] ="SELECT tb3.id_obat,tb3.nama_obat,tb1.harga_satuan,tb1.qty,sum(tb1.total) as totalbiaya,tb1.id_detail_invoicesupplier 
        FROM tb_detail_invoicesupplier as tb1 , tb_obat as tb3
        WHERE tb3.id_obat=tb1.deskripsidet_supplier AND tb1.no_invoice='$id'";
            $this->template->load('template','invoicesupplierf/tb_invoicesupplier_read', $data);
        } 
        else {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">  Data Tidak Ditemukan<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(site_url('invoicesupplierf'));
        }
            }
            }
    }
 function autocomplate_distributor(){
        $this->db->like('nama_perusahaan', $_GET['term']);
        $this->db->select('nama_perusahaan');
        $datadistributor = $this->db->get('tb_perusahaan')->result();
        foreach ($datadistributor as $distributor) {
            $return_arr[] = $distributor->nama_perusahaan;
        }

        echo json_encode($return_arr);
    }

 function autocomplate_po(){
        $this->db->like('id_po', $_GET['term']);
        $this->db->select('id_po');
        $datapo = $this->db->get('tb_po')->result();
        foreach ($datapo as $po) {
            $return_arr[] = $po->id_po;
        }

        echo json_encode($return_arr);
    }

function autocomplate(){
        $this->db->like('nama_akun', $_GET['term']);
        $this->db->select('nama_akun');
        $akunn = $this->db->get('tb_akun')->result();
        foreach ($akunn as $akundata) {
            $return_arr[] = $akundata->nama_akun;
        }

        echo json_encode($return_arr);
    }

    public function create() 
    {
        $sql = "SELECT no_invoice as maksimal FROM tb_invoicesupplier WHERE inv_status='Farmasi' and status_aktif_inv='0'";
            $queri= $this->db->query($sql);
            foreach ($queri->result() as $po1) {
         $sql = "SELECT * FROM tb_detail_invoicesupplier WHERE no_invoice=$po1->maksimal";
            $queri= $this->db->query($sql);
            foreach ($queri->result() as $po) {
               $sqll = "UPDATE tb_det_rcv SET status_masuk_inv='1' WHERE id_rcv=$po->id_po AND id_obat=$po->deskripsidet_supplier";
              $this->db->query($sqll);
            }
           $sql="DELETE FROM tb_detail_invoicesupplier WHERE no_invoice='$po1->maksimal'";
        $this->db->query($sql);
       }
        $tgl= tglOtomatis();
        $lamawaktu = lamawaktuOtomatis();
        $noInvbaru = noInvoiceFOtomatis();
        $noInvbaru1 = kodeInvoiceFOtomatis();
        $data = array(
            'button' => 'Simpan',
            'header' => 'TAMBAH',
            'action' => site_url('invoicesupplierf/create_action'),
         'no_invoice' => set_value('no_invoice',$noInvbaru),
         'kode_no_inv' => set_value('kode_no_inv'),
        'tgl_invoice' => set_value('tgl_invoice',$tgl),
        'id_po' => set_value('id_po'),
        'id_rcv' => set_value('id_rcv'),
        'id_distributor' => set_value('id_distributor'),
        'deskripsi_inv' => set_value('deskripsi_inv'),
        'lama_waktu' => set_value('lama_waktu',$lamawaktu),
        'status_prf' => set_value('status_prf',0),
        'status_jurnal' => set_value('status_jurnal',0),
        'inv_status' => set_value('inv_status'),
        'total_keseluruhan' => set_value('total_keseluruhan'),
        'id_akun' => set_value('id_akun'),
        'status_aktif_inv' => set_value('status_aktif_inv',1),
    );
        $this->template->load('template','invoicesupplierf/tb_invoicesupplier_form', $data);
    }
    
     public function create1() 
    {
        $tgl= tglOtomatis();
        $lamawaktu = lamawaktuOtomatis();
        $noInvbaru = noInvoiceFOtomatis();
        $noInvbaru1 = getAutoNumber('tb_invoicesupplier','kode_no_inv','INVF',9);
        $data = array(
            'button' => 'Simpan',
            'header' => 'TAMBAH',
            'action' => site_url('invoicesupplierf/create_action'),
         'no_invoice' => set_value('no_invoice',$noInvbaru),
         'kode_no_inv' => set_value('kode_no_inv',$noInvbaru1),
        'tgl_invoice' => set_value('tgl_invoice',$tgl),
        'id_po' => set_value('id_po'),
        'id_rcv' => set_value('id_rcv'),
        'id_distributor' => set_value('id_distributor'),
        'deskripsi_inv' => set_value('deskripsi_inv'),
        'lama_waktu' => set_value('lama_waktu',$lamawaktu),
        'status_prf' => set_value('status_prf',0),
        'status_jurnal' => set_value('status_jurnal',0),
        'inv_status' => set_value('inv_status'),
        'total_keseluruhan' => set_value('total_keseluruhan'),
        'id_akun' => set_value('id_akun'),
        'status_aktif_inv' => set_value('status_aktif_inv',1),
    );
        $this->template->load('template','invoicesupplierf/tb_invoicesupplier_form', $data);
    }
    
     function getkodedistributor($namadistributor) {
        $this->db->where('nama_perusahaan',$namadistributor);
        $distributor = $this->db->get('tb_perusahaan')->row_array();
        return $distributor['id_perusahaan'];
    }

    function getkodeakun($namaakun) {
        $this->db->where('nama_akun',$namaakun);
        $distributor = $this->db->get('tb_akun')->row_array();
        return $distributor['id_akun'];
    }

    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create1();
        } else {
            $data = array(
        'tgl_invoice' => $this->input->post('tgl_invoice',TRUE),
        'id_po' => $this->input->post('id_po',TRUE),
        'id_rcv' => $this->input->post('id_rcv',TRUE),
        'id_distributor' => $this->getkodedistributor($this->input->post('id_distributor',TRUE)),
        'deskripsi_inv' => $this->input->post('deskripsi_inv',TRUE),
        'lama_waktu' => $this->input->post('lama_waktu',TRUE),
        'status_prf' => $this->input->post('status_prf',TRUE),
        'status_jurnal' => $this->input->post('status_jurnal',TRUE),
        'inv_status' => $this->input->post('inv_status',TRUE),
        'total_keseluruhan' => $this->input->post('total_keseluruhan',TRUE),
        'id_akun' => $this->input->post('id_akun',TRUE),
        'status_aktif_inv' => $this->input->post('status_aktif_inv',TRUE),
        );

            $this->Invoicesupplier_modelF->update($this->input->post('no_invoice', TRUE), $data);
            $sql1="DELETE FROM tb_invoicesupplier WHERE id_akun='0'";
        $this->db->query($sql1);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert"> Data Berhasil ditambahkan<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(site_url('invoicesupplierf'));
        }


    }
    
    public function create_action1() 
    {
        
            $data = array(
		'nama_transaksi' => $this->input->post('nama_transaksi',TRUE),
	    );

            $this->db->insert('tb_jenis_transaksi', $data);

            redirect(site_url('invoicesupplierf/create'));
    }
    
    public function batal($id) 
    {
        $sql = "SELECT * FROM tb_detail_invoicesupplier WHERE no_invoice='$id'";
            $queri= $this->db->query($sql);
            foreach ($queri->result() as $po) {
               $sqll = "UPDATE tb_det_rcv SET status_masuk_inv='0' WHERE id_rcv=$po->id_po AND id_obat=$po->deskripsidet_supplier";
              $this->db->query($sqll);
            }
        $sql1="DELETE FROM tb_detail_invoicesupplier WHERE no_invoice='$id'";
        $this->db->query($sql1);
        $sql1="DELETE FROM tb_invoicesupplier WHERE id_akun='0'";
        $this->db->query($sql1);
        redirect(site_url('invoicesupplierf'));
    }

    
    public function update($id) 
    {   
        $row = $this->Invoicesupplier_modelF->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Ubah',
                'header' => 'EDIT',
                'action' => site_url('invoicesupplierf/update_action'),
        'no_invoice' => set_value('no_invoice', $row->no_invoice),
        'kode_no_inv' => set_value('kode_no_inv', $row->kode_no_inv),
        'tgl_invoice' => set_value('tgl_invoice', $row->tgl_invoice),
        'id_po' => set_value('id_po', $row->id_po),
        'id_rcv' => set_value('id_rcv', $row->id_rcv),
        'id_distributor' => set_value('id_distributor', $row->nama_perusahaan),
        'deskripsi_inv' => set_value('deskripsi_inv', $row->deskripsi_inv),
        'lama_waktu' => set_value('lama_waktu', $row->lama_waktu),
        'status_prf' => set_value('status_prf', $row->status_prf),
        'status_jurnal' => set_value('status_jurnal', $row->status_jurnal),
        'inv_status' => set_value('inv_status', $row->inv_status),
        'total_keseluruhan' => set_value('total_keseluruhan', $row->total_keseluruhan),
        'id_akun' => set_value('id_akun', $row->id_akun),
        'status_aktif_inv' => set_value('status_aktif_inv', $row->status_aktif_inv),
        );
            $this->template->load('template','invoicesupplierf/tb_invoicesupplier_update', $data);
        } else {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">  Data Tidak Ditemukan<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(site_url('invoicesupplierf'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_invoice', TRUE));
        } else {
            $data = array(
        'tgl_invoice' => $this->input->post('tgl_invoice',TRUE),
        'kode_no_inv' => $this->input->post('kode_no_inv',TRUE),
        'id_po' => $this->input->post('id_po',TRUE),
        'id_rcv' => $this->input->post('id_rcv',TRUE),
        'id_distributor' => $this->getkodedistributor($this->input->post('id_distributor',TRUE)),
        'deskripsi_inv' => $this->input->post('deskripsi_inv',TRUE),
        'lama_waktu' => $this->input->post('lama_waktu',TRUE),
        'status_prf' => $this->input->post('status_prf',TRUE),
        'status_jurnal' => $this->input->post('status_jurnal',TRUE),
        'inv_status' => $this->input->post('inv_status',TRUE),
        'total_keseluruhan' => $this->input->post('total_keseluruhan',TRUE),
        'id_akun' => $this->input->post('id_akun',TRUE),
        'status_aktif_inv' => $this->input->post('status_aktif_inv',TRUE),
        );

            $this->Invoicesupplier_modelF->update($this->input->post('no_invoice', TRUE), $data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert"> Ubah Data Berhasil<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(site_url('invoicesupplierf'));
        }
    }

      public function jurnal($id) 
    {   
            $noJurnalOtomatis = noJurnalOtomatis();
            $tgldanwaktuOtomatis= tgldanwaktuOtomatis();
            $tgl =date('Y-m-d');
            $sql1 = "SELECT tb_invoicesupplier.id_akun, tb_invoicesupplier.tgl_invoice, tb_invoicesupplier.deskripsi_inv, 
            tb_invoicesupplier.total_keseluruhan, tb_invoicesupplier.no_invoice, MONTH(tb_invoicesupplier.tgl_invoice) AS bulan, 
            DATE_FORMAT(tb_invoicesupplier.tgl_invoice, '%M') AS bulan_1, DATE_FORMAT(tb_invoicesupplier.tgl_invoice, '%d %M %Y') AS tanggal, 
            tb_jenis_transaksi.nama_transaksi as nama_akun FROM tb_invoicesupplier INNER JOIN tb_jenis_transaksi ON tb_jenis_transaksi.id_jenis_transaksi=tb_invoicesupplier.id_akun 
            WHERE tb_invoicesupplier.no_invoice='$id'";
            $queri1= $this->db->query($sql1);
            foreach ($queri1->result() as $po) {
            // $no_invoice  = $this->input->post('no_invoice');
            // $tgl_invoice  = $this->input->post('tgl_invoice');
            // $deskripsi_inv  = $this->input->post('deskripsi_inv');
            // $id_akun  = $this->input->post('id_akun');
            
            $jurnal="INSERT INTO tb_jurnal_khusus SET no_jurnal='$noJurnalOtomatis', tipe_jurnal_k='16', ref=$po->id_akun, tgl_jurnal_kus='$po->tgl_invoice', keterangan='Penerimaan Obat yang dibeli tgl $po->tanggal', jumlah=$po->total_keseluruhan, tgl_masuk_jurnak_k='$tgl', kepemilikan='invF', kode_transaksi=$po->no_invoice";
            $this->db->query($jurnal);
            
            $sql2 = "SELECT MONTH(tgl_jurnal_kus) as tgl_ringkasan FROM tb_ringkasan_transaksi WHERE MONTH(tgl_jurnal_kus)='$po->bulan' AND ref='$po->id_akun' AND kepemilikan='invF' LIMIT 1";
            $queri2= $this->db->query($sql2);
            foreach ($queri2->result() as $po1) {
                if ($po1->tgl_ringkasan!=="") {
                    $sqll1 = "UPDATE tb_ringkasan_transaksi SET tipe_jurnal_k='16', ref=$po->id_akun, tgl_jurnal_kus='$po->tgl_invoice', keterangan='Penerimaan Obat yang dibeli bulan $po->bulan_1', jumlah=jumlah+$po->total_keseluruhan, kepemilikan='invF' WHERE MONTH(tgl_jurnal_kus)='$po->bulan' AND ref='$po->id_akun' AND kepemilikan='invF'";
               $this->db->query($sqll1);
                } else {
                    
                }
            }

                $jurnal="INSERT INTO tb_ringkasan_transaksi SET tipe_jurnal_k='16', ref=$po->id_akun, tgl_jurnal_kus='$po->tgl_invoice', keterangan='Penerimaan Obat yang dibeli bulan $po->bulan_1', jumlah=$po->total_keseluruhan, tgl_masuk_jurnak_k='$tgldanwaktuOtomatis', kepemilikan='invF'";
                $this->db->query($jurnal);

                $sql2 = "SELECT max(tgl_masuk_jurnak_k) as tertinggi FROM tb_ringkasan_transaksi WHERE MONTH(tgl_jurnal_kus)='$po->bulan' AND ref='$po->id_akun' AND kepemilikan='invF'";
            $queri2= $this->db->query($sql2);
            foreach ($queri2->result() as $po1) {

                $sql3 = "SELECT COUNT(MONTH(tgl_jurnal_kus)) AS berapa FROM tb_ringkasan_transaksi WHERE MONTH(tgl_jurnal_kus)='$po->bulan' AND ref='$po->id_akun' AND kepemilikan='invF'";
            $queri3= $this->db->query($sql3);
            foreach ($queri3->result() as $po3) {
                if($po3->berapa>1) {
                    $sql="DELETE FROM tb_ringkasan_transaksi WHERE MONTH(tgl_jurnal_kus)='$po->bulan' AND tgl_masuk_jurnak_k='$po1->tertinggi' AND kepemilikan='invF'";
            $this->db->query($sql);
            } else if ($po3->berapa=='1') {

            }

                
            }
            
    }
}
            $sqll1 = "UPDATE tb_invoicesupplier SET status_jurnal='1' WHERE no_invoice='$id'";
               $this->db->query($sqll1);

            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('invoicesupplierf'));
    
    }
    
    public function delete($id) 
    {
        $row = $this->Invoicesupplier_modelF->get_by_id($id);
        $sql1 = "SELECT * FROM tb_detail_invoicesupplier WHERE no_invoice='$id'";
        $queri1= $this->db->query($sql1);
            foreach ($queri1->result() as $po) {
                $sqll = "UPDATE tb_det_rcv SET status_masuk_inv='0' WHERE id_rcv=$po->id_po AND id_obat=$po->deskripsidet_supplier";
              $this->db->query($sqll);
            }

        $sql="DELETE FROM tb_detail_invoicesupplier WHERE no_invoice='$id'";
        $this->db->query($sql);

        if ($row) {
            $this->Invoicesupplier_modelF->delete($id);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert"> Hapus Data Berhasil<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(site_url('invoicesupplierf'));
        } else {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">  Data Tidak Ditemukan<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(site_url('invoicesupplierf'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('total_keseluruhan', 'Total Keseluruhan', 'trim|required');    
    $this->form_validation->set_rules('tgl_invoice', 'tgl invoice', 'trim|required');
    $this->form_validation->set_rules('id_po', 'Kode PO', 'trim|required');
    $this->form_validation->set_rules('id_rcv', 'Nomor RCV', 'trim|required');
    $this->form_validation->set_rules('id_distributor', 'id distributor', 'trim|required');
    $this->form_validation->set_rules('deskripsi_inv', 'deskripsi inv', 'trim|required');
    $this->form_validation->set_rules('lama_waktu', 'lama waktu', 'trim|required');
    $this->form_validation->set_rules('id_akun', 'nama akun', 'trim|required');
    
    $this->form_validation->set_rules('no_invoice', 'no_invoice', 'trim');
    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

 function add_ajax(){
        $nama_obat  = $this->input->get('nama_obat');
        $harga_satuan  = $this->input->get('harga_beli');
        $qty  = $this->input->get('qty_obat');
        // $total  = $this->input->get('total');
        $noinvoice = $this->input->get('noinvoice');
        $id_po  = $this->input->get('id_rcv');
        $total = $harga_satuan*$qty;
        $id_obat = $this->input->get('id_obat');

        $data = array('deskripsidet_supplier'=>$id_obat,'id_po'=>$id_po,'harga_satuan'=>$harga_satuan,'qty'=>$qty,'total'=>$total,'no_invoice'=>$noinvoice,);
        $this->db->insert('tb_detail_invoicesupplier',$data);
        
       $sqll = "UPDATE tb_det_rcv SET status_masuk_inv='1' WHERE id_rcv='$id_po' AND id_obat='$id_obat'";
              $this->db->query($sqll);
    }
    
    function rp(){
        $total_keseluruhan = $_GET['total_keseluruhan'];
         $rp = number_format($total_keseluruhan);
        if($total_keseluruhan!=='0') {
            echo "
            <tr>
                <td width='150px'><b>Rp. $rp</b></td>
                </tr>";
           
        } else{
             echo "
            <tr>
                <td width='150px'><b></b></td>
                </tr>";
        }
        
           
    }

    function add_ajax1(){
        $waktu  = $this->input->get('waktu');
        $nama_obat  = $this->input->get('nama_obat');
        $harga_satuan  = $this->input->get('harga_beli');
        $qty  = $this->input->get('qty_obat');
        // $total  = $this->input->get('total');
        $noinvoice = $this->input->get('noinvoice');
        $id_po  = $this->input->get('id_rcv');
        $total = $harga_satuan*$qty;
        $id_obat = $this->input->get('id_obat');

        $data = array('deskripsidet_supplier'=>$id_obat,'id_po'=>$id_po,'harga_satuan'=>$harga_satuan,'qty'=>$qty,'total'=>$total,'no_invoice'=>$noinvoice,'waktu'=>$waktu,);
        $this->db->insert('tb_detail_invoicesupplier',$data);

        $sqll = "UPDATE tb_det_rcv SET status_masuk_inv='1' WHERE id_rcv='$id_po' AND id_obat='$id_obat'";
              $this->db->query($sqll);
    }

    function hapus_data(){
        $no_invoice = $this->input->get('no_invoice');
        $waktu  = $this->input->get('waktu');
        $id_rcv  = $this->input->get('id_rcv');
        $sql = "SELECT * FROM tb_detail_invoicesupplier WHERE id_po='$id_rcv' AND no_invoice='$no_invoice' AND waktu='$waktu'";
            $queri= $this->db->query($sql);
            foreach ($queri->result() as $po) {
               $sqll = "UPDATE tb_det_rcv SET status_masuk_inv='0' WHERE id_rcv=$po->id_po AND id_obat=$po->deskripsidet_supplier";
              $this->db->query($sqll);
            }
        $sql1="DELETE FROM tb_detail_invoicesupplier WHERE no_invoice='$no_invoice' AND waktu='$waktu'";
        $this->db->query($sql1);
    }

     function list_detail_f(){
        $noinvoice = $_GET['noinvoice'];
        echo "<table class='table table-bordered'>
                <tr><th>NO</th><th>ITEM</th><th>HARGA</th><th>QTY</th><th>TOTAL</th><th>ACTION</th></tr>";
        $sql = "SELECT tb3.id_obat,tb3.nama_obat,CONCAT('Rp. ',FORMAT(tb1.harga_satuan, 0)) as harga_satuan,tb1.qty,CONCAT('Rp. ',FORMAT(tb1.total, 0)) as total,tb1.id_detail_invoicesupplier, tb1.id_po,tb1.deskripsidet_supplier
        FROM tb_detail_invoicesupplier as tb1 , tb_obat as tb3
        WHERE tb3.id_obat=tb1.deskripsidet_supplier AND tb1.no_invoice='$noinvoice'";
        
        $list = $this->db->query($sql)->result();
        $no=1;
        foreach ($list as $row){
            echo "
            <tr>
                <td width='10'>$no</td>
                <td>$row->nama_obat</td>
                <td>$row->harga_satuan</td>
                <td>$row->qty</td>
                <td>$row->total</td>
                <td width='100' onClick='hapus($row->id_detail_invoicesupplier,$row->id_po,$row->deskripsidet_supplier,$row->qty)'><button class='btn btn-danger btn-sm'>Hapus</button></td>
                </tr>";
            $no++;
        }
        $noinvoice = $_GET['noinvoice'];
         echo "
                <tr><th colspan='4'><center>TOTAL KESELURUHAN</center></th>";
        $sql = "SELECT tb3.id_obat,tb3.nama_obat,tb1.harga_satuan,tb1.qty,CONCAT('Rp. ',FORMAT(sum(tb1.total), 0)) as totalkeseluruhan,tb1.id_detail_invoicesupplier 
        FROM tb_detail_invoicesupplier as tb1 , tb_obat as tb3
        WHERE tb3.id_obat=tb1.deskripsidet_supplier AND tb1.no_invoice='$noinvoice'";
        
        $list = $this->db->query($sql)->result();
        $no=1;
        foreach ($list as $row){
            echo "
                <td>$row->totalkeseluruhan</td></tr>";
            $no++;
        }
        echo" </table>";
    }
    

function hapus_ajax(){
        $id_detail_invoicesupplier = $_GET['id_detail_invoicesupplier'];
        $id_po = $_GET['id_po'];
        $deskripsidet_supplier = $_GET['deskripsidet_supplier'];
        $qty = $_GET['qty'];

         $sqll = "UPDATE tb_det_rcv SET status_masuk_inv='0' WHERE id_rcv='$id_po' AND id_obat='$deskripsidet_supplier'";
        $this->db->query($sqll);
        $this->db->where('id_detail_invoicesupplier',$id_detail_invoicesupplier);
        $this->db->delete('tb_detail_invoicesupplier');
    }
    
    function list_po(){
        $id_rcv  = $this->input->get('id_rcv');
        $limit  = $this->input->get('limit');
        $hasil=$this->db->query("SELECT * FROM tb_det_rcv INNER JOIN tb_rcv ON tb_rcv.id_rcv=tb_det_rcv.id_rcv
        INNER JOIN tb_obat ON tb_det_rcv.id_obat=tb_obat.id_obat WHERE status_rcv='AKTIF' AND tb_det_rcv.id_rcv='$id_rcv' AND tb_det_rcv.status_masuk_inv='0' LIMIT $limit");
        //print_r($hasil->result());
        echo json_encode($hasil->result());
    }

    function list_search(){
        $search  = $this->input->get('search');
        $id_rcv  = $this->input->get('id_rcv');
        $limit  = $this->input->get('limit');
        $hasil=$this->db->query("SELECT * FROM tb_det_rcv 
            INNER JOIN tb_rcv ON tb_rcv.id_rcv=tb_det_rcv.id_rcv
            INNER JOIN tb_obat ON tb_det_rcv.id_obat=tb_obat.id_obat 
            WHERE status_rcv='AKTIF' AND tb_det_rcv.id_rcv='$id_rcv' 
            AND tb_det_rcv.status_masuk_inv='0' 
            AND (tb_rcv.kode_rcv LIKE '%$search%' 
            OR tb_obat.nama_obat LIKE '%$search%'
            OR tb_det_rcv.harga_beli LIKE '%$search%'
            OR tb_det_rcv.qty_obat LIKE '%$search%') LIMIT $limit");
        //print_r($hasil->result());
        echo json_encode($hasil->result());
    }

 function total_invoice(){
        $noinvoice = $_POST['no_invoice'];
        $s = "SELECT sum(tb1.total) as totall 
        FROM tb_detail_invoicesupplier as tb1
        WHERE tb1.no_invoice='$noinvoice'";
    $res = $this->db->query($s)->row_array();
    echo json_encode($res);
    }
    
function cetak_invoice($id){
         $this->load->library('pdf');
       $pdf = new FPDF("P","mm","A4");
$cellWidth=400; 
$cellHeight=0.7;
$pdf->SetMargins(2,2,2);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',14);
$pdf->ln(7);            
$pdf->MultiCell(200,1.5,'RUMAH SAKIT PAYANGAN',0,'C');
$pdf->ln(3);
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(200,1.5,'Jalan XXX XXX',0,'C');
$pdf->ln(2);
$pdf->MultiCell(200,1.5,'No Telepon XXX XXX',0,'C');
$pdf->Line(15,20,195,20);  
$pdf->SetLineWidth(0.1);      
$pdf->ln(6);
$pdf->SetFont('Times','B',12);
$pdf->Cell(200,0,"INVOICE PEMBELIAN OBAT OLEH MODUL FARMASI",0,10,'C');
$pdf->ln(4);
$pdf->SetFont('Times','B',12);
$pdf->ln(4);
$invoice = $this->db->query("SELECT * FROM tb_invoicesupplier INNER JOIN tb_perusahaan ON tb_perusahaan.id_perusahaan=tb_invoicesupplier.id_distributor WHERE no_invoice='$id'");
foreach ($invoice->result() as $row){
    $pdf->SetFont('Times','',12);
    $pdf->Cell(70, 1, "             No Invoice",0, 0, 'L');
    $pdf->MultiCell($cellWidth,$cellHeight,": ".$row->kode_no_inv,0);
    $pdf->ln(5);
    $pdf->Cell(70, 1, "             Kode PO ",0, 0, 'L');
    $pdf->MultiCell($cellWidth,$cellHeight,": ".$row->id_po,0);
    $pdf->ln(5);
    $pdf->Cell(70, 1, "             Nomor RCV",0, 0, 'L');
    $pdf->MultiCell($cellWidth,$cellHeight,": ".$row->id_rcv,0);
    $pdf->ln(5);
    $pdf->Cell(70, 1, "             Nama Distributor",0, 0, 'L');
    $pdf->MultiCell($cellWidth,$cellHeight,": ".$row->nama_perusahaan,0);
    $pdf->ln(5);
    $pdf->Cell(70, 1, "             Tanggal Invoice Dibuat",0, 0, 'L');
    $pdf->MultiCell($cellWidth,$cellHeight,": ".date('d-M-Y',strtotime($row->tgl_invoice)),0);
    $pdf->ln(5);
    $pdf->Cell(70, 1, "             Tanggal Jatuh Tempo Invoice",0, 0, 'L');
    $pdf->MultiCell($cellWidth,$cellHeight,": ".date('d-M-Y',strtotime($row->lama_waktu)),0);
    $pdf->ln(5);
    $pdf->Cell(70, 1, "             Deskripsi Invoice",0, 0, 'L');
    $pdf->MultiCell($cellWidth,$cellHeight,": ".$row->deskripsi_inv,0);
    $pdf->ln(5);
    $pdf->Cell(70, 1, "             Berikut Daftar Barang/Obat yang dibeli :",0, 0, 'L');
    $pdf->ln(7);
}
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(15, 1, "",0, 0, 'L');
    $pdf->Cell(10, 5, 'NO', 1, 0, 'C');
    $pdf->Cell(70, 5, 'ITEM', 1, 0, 'C');
    $pdf->Cell(30, 5, 'HARGA', 1, 0, 'C');
    $pdf->Cell(30, 5, 'QTY', 1, 0, 'C');
    $pdf->Cell(30, 5, 'TOTAL', 1, 0, 'C');
    $invoice_detail = $this->db->query("SELECT tb3.id_obat,tb3.nama_obat,tb1.harga_satuan,tb1.qty,tb1.total,tb1.id_detail_invoicesupplier 
        FROM tb_detail_invoicesupplier as tb1 , tb_obat as tb3
        WHERE tb3.id_obat=tb1.deskripsidet_supplier AND tb1.no_invoice='$id'");
$no=1;
foreach ($invoice_detail->result() as $row1){
    $pdf->ln(5);
    $pdf->SetFont('Times','',12);
    $pdf->Cell(15, 1, "",0, 0, 'L');
    $pdf->Cell(10, 5, $no++, 1, 0, 'C');
    $pdf->Cell(70, 5, $row1->nama_obat, 1, 0, 'L');
    $pdf->Cell(30, 5, 'Rp. '.number_format($row1->harga_satuan), 1, 0, 'L');
    $pdf->Cell(30, 5, number_format($row1->qty), 1, 0, 'C');
    $pdf->Cell(30, 5, 'Rp. '.number_format($row1->total), 1, 0, 'L');
}
$pdf->ln(5);
$pdf->SetFont('Times','B',12);
$pdf->Cell(15, 1, "",0, 0, 'L');
$pdf->Cell(140, 5, 'TOTAL KESELURUHAN', 1, 0, 'C');
$invoice_total = $this->db->query("SELECT tb3.id_obat,tb3.nama_obat,tb1.harga_satuan,tb1.qty,SUM(tb1.total) as total_print,tb1.id_detail_invoicesupplier 
        FROM tb_detail_invoicesupplier as tb1 , tb_obat as tb3
        WHERE tb3.id_obat=tb1.deskripsidet_supplier AND tb1.no_invoice='$id'");
$no=1;
foreach ($invoice_total->result() as $total_p){
    $pdf->Cell(30, 5, 'Rp. '.number_format($total_p->total_print), 1, 0, 'L');
    
}
$pdf->Output("Invoice_Farmasi.pdf","I");

    }
}

/* End of file InvoicesupplierF.php */
/* Location: ./application/controllers/InvoicesupplierF.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-11-10 13:18:39 */
/* http://harviacode.com */