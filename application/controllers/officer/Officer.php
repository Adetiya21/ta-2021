<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Officer extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_officer';

	function __construct()
	{
		parent::__construct();
		// cek session officer sudah login
		if ($this->session->userdata('officer_logged_in') !=  "Sudah_Loggin") {
			echo "<script>
			alert('Login Dulu!');";
			echo 'window.location.assign("'.site_url("welcome").'")
			</script>';
		}
		$this->load->model('m_officer','Model');   //load model m_officer
	}

	// fun json datatables
	public function json() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo $this->Model->json();
		}
	}

	// fun halaman officer
	public function index()
	{
		$title = array('title' => 'Data Officer', );
		$this->load->view('officer/temp-header',$title);
		$this->load->view('officer/v_officer');
		$this->load->view('officer/temp-footer');
	}

	// fun hapus
	public function hapus($nik)
	{
		if ($this->input->is_ajax_request()) {
			$where = array('nik' => $nik);  //filter berdasarkan nik
			$this->DButama->GetDBWhere($this->table,$where)->row();  //load database
			$tes = $this->DButama->GetDBWhere($this->table,$where)->row();  //load database
			$query = $this->DButama->DeleteDB($this->table,$where);  //fun delete
			echo json_encode(array("status" => TRUE));
			// hapus gambar di folder
			if($tes->gambar!==null){
                unlink("assets/img/officer/".$tes->gambar);
            }
		}
	}

    // fun tambah data
	public function tambah()
	{
		if ($this->input->is_ajax_request()) {
			$DataUser  = array('nik' => $this->input->post('nik'));
			// cek nik yang terdaftar
			if ($this->DButama->GetDBWhere($this->table,$DataUser)->num_rows() == 1) {
				$data = array();
				$data['inputerror'][] = 'nik';
				$data['error_string'][] = 'NIK sudah ada / tidak boleh duplikat';
				$data['status'] = FALSE;
				echo json_encode($data);
				exit();
			}else{
				$pass='12345';
				$hash=password_hash($pass, PASSWORD_DEFAULT);  //membuat encrypt password
				$data = array(
					'nik' => $this->input->post('nik'),
					'nama' => $this->input->post('nama'),
					'email' => $this->input->post('email'),
					'no_telp' => $this->input->post('no_telp'),
					'tipe' => $this->input->post('tipe'),
					'password' => $hash					
				);
				// upload gambar
				$gambar = $_FILES['gambar']['name'];
				if(!empty($gambar))
				{
					$upload = $this->_do_upload();
					$data['gambar'] = $upload;
				}
				// fungsi tambah officer
				$this->DButama->AddDB($this->table,$data);
				echo json_encode(array("status" => TRUE));
			}
		}
	}

    // fun edit
	public function edit($nik)
	{
		if ($this->input->is_ajax_request()) {
			$where = array('nik' => $nik);
			$data = $this->DButama->GetDBWhere($this->table,$where)->row();
			echo json_encode($data);
		}
	}
	
	// fun proses update data
	public function update()
	{
		if ($this->input->is_ajax_request()) {
			$where  = array('nik' => $this->input->post('nik'));
			$query = $this->DButama->GetDBWhere($this->table,$where); //filter berdasarkan nik
			$row = $query->row();
			$data = array(
					'nama' => $this->input->post('nama'),
					'no_telp' => $this->input->post('no_telp'),
					'email' => $this->input->post('email'),
					'tipe' => $this->input->post('tipe'),
			);

			// hapus gambar
			if($this->input->post('remove_photo')) 
			{
				if(file_exists('assets/img/officer/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
					unlink('assets/img/officer/'.$this->input->post('remove_photo'));
				$data['gambar'] = null;
			}

			// mengupload gambar baru
			if(!empty($_FILES['gambar']['name']))
			{
				$upload = $this->_do_upload();
        		//hapus gambar lama di folder
				$row_cek = $this->DButama->GetDBWhere($this->table,$where)->row();
				if(file_exists('assets/img/officer/'.$row_cek->gambar) && $row_cek->gambar)
					unlink('assets/img/officer/'.$row_cek->gambar);
				$data['gambar'] = $upload;
			}
			$this->DButama->UpdateDB($this->table,$where,$data);
			echo json_encode(array("status" => TRUE));
		}
	}

	// proses upload gambar
	private function _do_upload()
	{
		$config['upload_path']   = 'assets/img/officer/';  //lokasi folder
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

/* End of file Officer.php */
/* Location: ./application/controllers/officer/Officer.php */