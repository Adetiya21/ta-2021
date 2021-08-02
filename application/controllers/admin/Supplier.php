<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_supplier';

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
		$this->load->model('m_supplier','Model');   //load model m_supplier
	}

	// fun json datatables
	public function json() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo $this->Model->json();
		}
	}

	// fun halaman supplier
	public function index()
	{
		$title = array('title' => 'Data Supplier', );
		$this->load->view('admin/temp-header',$title);
		$this->load->view('admin/v_supplier');
		$this->load->view('admin/temp-footer');
	}

	// fun tambah data
	public function tambah()
	{
		if ($this->input->is_ajax_request()) {
			$DataUser  = array('email' => $this->input->post('email'),'no_telp' => $this->input->post('no_telp'));
			// cek email yang terdaftar
			if ($this->DButama->GetDBWhere($this->table,$DataUser)->num_rows() == 1) {
				$data = array();
				$data['inputerror'][] = 'email dan no_telp';
				$data['error_string'][] = 'Email atau No Telp sudah ada / tidak boleh duplikat';
				$data['status'] = FALSE;
				echo json_encode($data);
				exit();
			}else{
				$pass='12345';
				$hash=password_hash($pass, PASSWORD_DEFAULT);  //membuat encrypt password
				$data = array(
					'nama' => $this->input->post('nama'),
					'email' => $this->input->post('email'),
					'no_telp' => $this->input->post('no_telp'),
					'alamat' => $this->input->post('alamat'),
					'password' => $hash					
				);
				// upload gambar
				$gambar = $_FILES['gambar']['name'];
				if(!empty($gambar))
				{
					$upload = $this->_do_upload();
					$data['gambar'] = $upload;
				}
				// fungsi tambah supplier
				$this->DButama->AddDB($this->table,$data);
				echo json_encode(array("status" => TRUE));
			}
		}
	}

	// fun edit
	public function edit($id)
	{
		if ($this->input->is_ajax_request()) {
			$where = array('id' => $id);
			$data = $this->DButama->GetDBWhere($this->table,$where)->row();
			echo json_encode($data);
		}
	}
	
	// fun proses update data
	public function update()
	{
		if ($this->input->is_ajax_request()) {
			$where  = array('id' => $this->input->post('id'));
			$query = $this->DButama->GetDBWhere($this->table,$where); //filter berdasarkan id
			$row = $query->row();
			$data = array(
					'nama' => $this->input->post('nama'),
					'no_telp' => $this->input->post('no_telp'),
					'email' => $this->input->post('email'),
					'alamat' => $this->input->post('alamat'),
			);

			// hapus gambar
			if($this->input->post('remove_photo')) 
			{
				if(file_exists('assets/img/supplier/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
					unlink('assets/img/supplier/'.$this->input->post('remove_photo'));
				$data['gambar'] = null;
			}

			// mengupload gambar baru
			if(!empty($_FILES['gambar']['name']))
			{
				$upload = $this->_do_upload();
        		//hapus gambar lama di folder
				$row_cek = $this->DButama->GetDBWhere($this->table,$where)->row();
				if(file_exists('assets/img/supplier/'.$row_cek->gambar) && $row_cek->gambar)
					unlink('assets/img/supplier/'.$row_cek->gambar);
				$data['gambar'] = $upload;
			}
			$this->DButama->UpdateDB($this->table,$where,$data);
			echo json_encode(array("status" => TRUE));
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
			if($tes->gambar!==null){
                unlink("assets/img/supplier/".$tes->gambar);
            }
		}
	}

	// proses upload gambar
	private function _do_upload()
	{
		$config['upload_path']   = 'assets/img/supplier/';  //lokasi folder
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

/* End of file Supplier.php */
/* Location: ./application/controllers/admin/Supplier.php */