<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_tagihan';
	var $table_supplier = 'tb_supplier';

	function __construct()
	{
		parent::__construct();
		// cek session supplier sudah login
		if ($this->session->userdata('supplier_logged_in') !=  "Sudah_Loggin") {
			echo "<script>
			alert('Login Dulu!');";
			echo 'window.location.assign("'.site_url("supplier/welcome").'")
			</script>';
		}
		$this->load->model('m_tagihan','Model');   //load model m_tagihan
		$this->load->model('m_faktur','faktur');  //load model no_faktur
		$this->load->helper('rupiah');  //load helper rupiah
	}

	// fun json datatables
	public function json() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo $this->Model->json_supplier();
		}
	}

	// fun halaman tagihan
	public function index()
	{
		$cek = $this->DButama->GetDBWhere($this->table_supplier,array('id'=> $this->session->userdata('id')));
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Data Tagihan';
			$data['profil'] = $cek->row();
			$this->load->view('supplier/temp-header',$data);
			$this->load->view('supplier/v_tagihan');
			$this->load->view('supplier/temp-footer');
		}else{
			redirect('error404','refresh');
		}		
	}

	// fun hapus
	public function hapus($id)
	{
		if ($this->input->is_ajax_request()) {
			$where = array('id' => $id);  //filter berdasarkan id
			$this->DButama->GetDBWhere($this->table,$where)->row();  //load database
			$tes = $this->DButama->GetDBWhere($this->table,$where)->row();  //load database
			$query = $this->DButama->DeleteDB($this->table,$where);  //fun delete
			echo json_encode(array("status" => TRUE));
			// hapus gambar di folder
			if($tes->bukti_transfer!==null){
                unlink("assets/img/tagihan/".$tes->bukti_transfer);
            }
		}
	}

	// fun halaman tambah tagihan
	public function input()
	{
		$cek = $this->DButama->GetDBWhere($this->table_supplier,array('id'=> $this->session->userdata('id')));
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Tambah Data Tagihan';
			$data['profil'] = $cek->row();
			$this->load->view('supplier/temp-header',$data);
			$this->load->view('supplier/v_tagihan-input');
			$this->load->view('supplier/temp-footer');
		}else{
			redirect('error404','refresh');
		}	
	}

	// fun proses tambah tagihan
	public function proses()
	{
		$tgl_tagihan = $this->input->post('tgl_tagihan');
        $tgl_tagihan = date('Y-m-d', strtotime($tgl_tagihan));
        $data = array(
			'id_supplier' => $this->session->userdata('id'),
			'tgl_tagihan' => $tgl_tagihan,
			'tgl_input' => date('Y-m-d H:i:s'),
			'nama' => $this->input->post('nama'),
			'biaya' => $this->input->post('biaya'),
			'keterangan' => $this->input->post('keterangan')
		);
		$this->DButama->AddDB($this->table,$data);
		redirect('tagihan','refresh');
	}

	// fun halaman edit data
	public function edit($id)
	{
		$cek = $this->DButama->GetDBWhere($this->table_supplier,array('id'=> $this->session->userdata('id')));
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Edit Data Tagihan';
			$data['profil'] = $cek->row();
			
			$cek1 = $this->DButama->GetDBWhere($this->table,array('id'=> $id, 'id_supplier' => $this->session->userdata('id')));
			if ($cek1->num_rows() == 1) {
				$data['tagihan'] = $cek1->row();
				// fun view
				$this->load->view('supplier/temp-header',$data);
				$this->load->view('supplier/v_tagihan-edit');
				$this->load->view('supplier/temp-footer');
			}else{
				redirect('error404','refresh');
			}
		}else{
			redirect('error404','refresh');
		}	
	}

	// proses edit data
	public function proses_edit()
	{
		//load form validasi
		$this->load->library('form_validation');

		// field form validasi
		$config = array(
			array('field' => 'nama','label' => "Nama Tagihan",'rules' => 'required'),
			array('field' => 'biaya','label' => 'Biaya','rules' => 'required|numeric'),
			array('field' => 'keterangan','label' => 'Keterangan','rules' => 'required'),
			array('field' => 'tgl_tagihan','label' => 'Tanggal Tagihan','rules' => 'required'),
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			// menampilkan pesan error
			$this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>'.validation_errors().'</strong> 
							</div>');
			$this->_Values();
			redirect('tagihan/edit/'.$this->input->post('id'),'refresh');
		}else{
			$where  = array('id' => $this->input->post('id'));  //menfilter berdasarkan id
			$query = $this->DButama->GetDBWhere($this->table,$where);  //load database tabel tb_tagihan
			$row = $query->row();
			$tgl_tagihan = $this->input->post('tgl_tagihan');
	        $tgl_tagihan = date('Y-m-d', strtotime($tgl_tagihan));
	        $data = array(
				'nama' => $this->input->post('nama'),
				'tgl_tagihan' => $tgl_tagihan,
				'biaya' => $this->input->post('biaya'),
				'keterangan' => $this->input->post('keterangan')
			);
			// fun update
			$this->DButama->UpdateDB($this->table,$where,$data);
			redirect('tagihan','refresh');			
		}
	}

	// fun halaman view data
	public function view($id)
	{
		$cek = $this->DButama->GetDBWhere($this->table_supplier,array('id'=> $this->session->userdata('id')));
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Detail Data Tagihan';
			$data['profil'] = $cek->row();

			$cek1 = $this->DButama->GetDBWhere($this->table,array('id'=> $id));
			if ($cek1->num_rows() == 1) {
				$data['tagihan'] = $cek1->row();
				$data['supplier'] = $this->DButama->GetDB('tb_supplier')->row();  //load database table tb_supplier
				$where  = array('tipe' => 'Loket');
				$data['loket'] = $this->DButama->GetDBWhere('tb_officer',$where)->row();  //load database table tb_officer tipe loket
				$where1  = array('tipe' => 'Finance');
				$data['finance'] = $this->DButama->GetDBWhere('tb_officer',$where1)->row();  //load database table tb_officer tipe finance
				// fun view
				$this->load->view('supplier/temp-header',$data);
				$this->load->view('supplier/v_tagihan-view',$data);
				$this->load->view('supplier/temp-footer');
			}else{
				redirect('error404','refresh');
			}
		}else{
			redirect('error404','refresh');
		}		
	}

	// fun laporan 
	public function laporan()
	{
		$cek = $this->DButama->GetDBWhere($this->table_supplier,array('id'=> $this->session->userdata('id')));
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Laporan Data Tagihan';
			$data['profil'] = $cek->row();
			// fun view
			$this->load->view('supplier/temp-header',$data);
			$this->load->view('supplier/v_tagihan-laporan',$data);
			$this->load->view('supplier/temp-footer');
		}else{
			redirect('error404','refresh');
		}
	}

	// fun json datatables
	public function jsonLaporan() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo $this->Model->json_supplierLaporan();
		}
	}

	// proses upload gambar
	private function _do_upload()
	{
		$config['upload_path']   = 'assets/img/tagihan/';  //lokasi folder
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name']  = TRUE;
        $config['file_name']     = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('gambar')) //upload and validate
        {
        	$data['inputerror'][] = 'gambar';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

}

/* End of file Tagihan.php */
/* Location: ./application/controllers/Tagihan.php */