<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_tagihan';

	function __construct()
	{
		parent::__construct();
		// cek session admin sudah login
		if ($this->session->userdata('admin_logged_in') !=  "Sudah_Loggin") {
			echo "<script>
			alert('Login Dulu!');";
			echo 'window.location.assign("'.site_url("admin/welcome").'")
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
			echo $this->Model->json_admin();
		}
	}

	// fun halaman tagihan
	public function index()
	{
		$title = array('title' => 'Data Tagihan', );
		$this->load->view('admin/temp-header',$title);
		$this->load->view('admin/v_tagihan');
		$this->load->view('admin/temp-footer');
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
		$title = array('title' => 'Tambah Tagihan', );
		$data['supplier'] = $this->DButama->GetDB('tb_supplier');  //load database table tb_supplier
		$where  = array('tipe' => 'Loket');
		$data['loket'] = $this->DButama->GetDBWhere('tb_officer',$where);  //load database table tb_officer tipe loket
		$where1  = array('tipe' => 'Finance');
		$data['finance'] = $this->DButama->GetDBWhere('tb_officer',$where1);  //load database table tb_officer tipe finance
		$this->load->view('admin/temp-header',$title);
		$this->load->view('admin/v_tagihan-input', $data);
		$this->load->view('admin/temp-footer');
	}

	// fun proses tambah tagihan
	public function proses()
	{
		$tgl_tagihan = $this->input->post('tgl_tagihan');
        $tgl_tagihan = date('Y-m-d', strtotime($tgl_tagihan));
        $tgl_transfer = $this->input->post('tgl_transfer');
        $tgl_transfer = date('Y-m-d', strtotime($tgl_transfer));
		$no_faktur =  $this->faktur->find_faktur();  //membuat no faktur
		$data = array(
			'no_faktur' => $no_faktur,
			'id_supplier' => $this->input->post('id_supplier'),
			'nik_loket' => $this->input->post('nik_loket'),
			'nik_fin' => $this->input->post('nik_fin'),
			'tgl_tagihan' => $tgl_tagihan,
			'tgl_input' => date('Y-m-d H:i:s'),
			'tgl_transfer' => $tgl_transfer,
			'nama' => $this->input->post('nama'),
			'biaya' => $this->input->post('biaya'),
			'keterangan' => $this->input->post('keterangan'),
			'status' => $this->input->post('status'),
		);

		// upload bukti transfer
		$gambar = $_FILES['gambar']['name'];
		if(!empty($gambar))
		{
			$upload = $this->_do_upload();
			$data['bukti_transfer'] = $upload;
		}

		$this->DButama->AddDB($this->table,$data);
		redirect('admin/tagihan','refresh');
	}

	// fun halaman edit data
	public function edit($id)
	{
		$cek = $this->DButama->GetDBWhere($this->table,array('id'=> $id));
		if ($cek->num_rows() == 1) {
			$data['tagihan'] = $cek->row();
			$data['title'] = 'Edit Data Tagihan';
			$data['supplier'] = $this->DButama->GetDB('tb_supplier');  //load database table tb_supplier
			$where  = array('tipe' => 'Loket');
			$data['loket'] = $this->DButama->GetDBWhere('tb_officer',$where);  //load database table tb_officer tipe loket
			$where1  = array('tipe' => 'Finance');
			$data['finance'] = $this->DButama->GetDBWhere('tb_officer',$where1);  //load database table tb_officer tipe finance
			// fun view
			$this->load->view('admin/temp-header',$data);
			$this->load->view('admin/v_tagihan-edit',$data);
			$this->load->view('admin/temp-footer');
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
			array('field' => 'id_supplier','label' => "Supplier",'rules' => 'required'),
			array('field' => 'nik_loket','label' => "Officer Loket",'rules' => 'required'),
			array('field' => 'nik_fin','label' => "Officer Finance",'rules' => 'required'),
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
			redirect('admin/tagihan/edit/'.$this->input->post('id'),'refresh');
		}else{
			$where  = array('id' => $this->input->post('id'));  //menfilter berdasarkan id
			$query = $this->DButama->GetDBWhere($this->table,$where);  //load database tabel tb_barang
			$row = $query->row();
			$where_nama = array('nama' => $this->input->post('nama'));  //menfilter berdasarkan nama
			$cari_nama = $this->DButama->GetDBWhere($this->table,$where_nama);  //load database tabel tb_barang
			$tgl_tagihan = $this->input->post('tgl_tagihan');
	        $tgl_tagihan = date('Y-m-d', strtotime($tgl_tagihan));
	        $tgl_transfer = $this->input->post('tgl_transfer');
	        $tgl_transfer = date('Y-m-d', strtotime($tgl_transfer));			

			 // jika nama tidak di ganti
			if ($row->nama == $this->input->post('nama')) {
				$data = array(
					'id_supplier' => $this->input->post('id_supplier'),
					'nik_loket' => $this->input->post('nik_loket'),
					'nik_fin' => $this->input->post('nik_fin'),
					'nama' => $this->input->post('nama'),
					'tgl_tagihan' => $tgl_tagihan,
					'tgl_transfer' => $tgl_transfer,
					'biaya' => $this->input->post('biaya'),
					'keterangan' => $this->input->post('keterangan'),
					'status' => $this->input->post('status')
				);

				// mengupload gambar
				if(!empty($_FILES['gambar']['name']))
				{
					$upload = $this->_do_upload();
					$data['bukti_transfer'] = $upload;
				}

				// fun update
				$this->DButama->UpdateDB($this->table,$where,$data);
				redirect('admin/tagihan','refresh');
	        
	        // jika nama di ganti
			}else{
				$tgl_tagihan = $this->input->post('tgl_tagihan');
		        $tgl_tagihan = date('Y-m-d', strtotime($tgl_tagihan));
		        $tgl_transfer = $this->input->post('tgl_transfer');
		        $tgl_transfer = date('Y-m-d', strtotime($tgl_transfer));
				$data = array(
					'id_supplier' => $this->input->post('id_supplier'),
					'nik_loket' => $this->input->post('nik_loket'),
					'nik_fin' => $this->input->post('nik_fin'),
					'nama' => $this->input->post('nama'),
					'tgl_tagihan' => $tgl_tagihan,
					'tgl_transfer' => $tgl_transfer,
					'biaya' => $this->input->post('biaya'),
					'keterangan' => $this->input->post('keterangan'),
					'status' => $this->input->post('status')
				);
				
				// mengupload gambar
				if(!empty($_FILES['gambar']['name']))
				{
					$upload = $this->_do_upload();
            		//hapus gambar lama di folder
					$row_cek = $this->DButama->GetDBWhere($this->table,$where)->row();
					if(file_exists('assets/img/tagihan/'.$row_cek->bukti_transfer) && $row_cek->bukti_transfer)
						unlink('assets/img/tagihan/'.$row_cek->bukti_transfer);
					$data['bukti_transfer'] = $upload;
				}

				// fun update
				$this->DButama->UpdateDB($this->table,$where,$data);
				redirect('admin/tagihan','refresh');
			}
		}
	}

	// fun halaman view data
	public function view($id)
	{
		$cek = $this->DButama->GetDBWhere($this->table,array('id'=> $id));
		if ($cek->num_rows() == 1) {
			$data['tagihan'] = $cek->row();
			$data['title'] = 'Detail Data Tagihan';
			$data['supplier'] = $this->DButama->GetDB('tb_supplier')->row();  //load database table tb_supplier
			$where  = array('tipe' => 'Loket');
			$data['loket'] = $this->DButama->GetDBWhere('tb_officer',$where)->row();  //load database table tb_officer tipe loket
			$where1  = array('tipe' => 'Finance');
			$data['finance'] = $this->DButama->GetDBWhere('tb_officer',$where1)->row();  //load database table tb_officer tipe finance
			// fun view
			$this->load->view('admin/temp-header',$data);
			$this->load->view('admin/v_tagihan-view',$data);
			$this->load->view('admin/temp-footer');
		}else{
			redirect('error404','refresh');
		}	
	}

	// fun laporan 
	public function laporan()
	{
		$title = array('title' => 'Data Laporan Tagihan', );
		$this->load->view('admin/temp-header',$title);
		$this->load->view('admin/v_tagihan-laporan');
		$this->load->view('admin/temp-footer');
	}

	// fun json datatables
	public function jsonLaporan() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo $this->Model->json_adminLaporan();
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
/* Location: ./application/controllers/admin/Tagihan.php */