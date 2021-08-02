<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	var $table = 'tb_supplier';

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('supplier_logged_in') !=  "Sudah_Loggin") {
			echo "<script>
			alert('Login Dulu!');";
			echo 'window.location.assign("'.site_url("welcome").'")
			</script>';
			// redirect('admin/welcome');
		}
	}
	

	public function index()
	{
		$cek = $this->DButama->GetDBWhere($this->table,array('id'=> $this->session->userdata('id')));
		$spplr = $this->session->userdata('id');
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Dashboard';
			$data['profil'] = $cek->row();
			$data['tungguLoket'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc Loket','id_supplier' => $spplr))->num_rows();
			$data['tungguGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc GA','id_supplier' => $spplr))->num_rows();
			$data['tungguFin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc Finance','id_supplier' => $spplr))->num_rows();
			$data['tolakLoket'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak Loket','id_supplier' => $spplr))->num_rows();
			$data['tolakGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak GA','id_supplier' => $spplr))->num_rows();
			$data['tolakFin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak Finance','id_supplier' => $spplr))->num_rows();
			$data['selesai'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Selesai','id_supplier' => $spplr))->num_rows();
			$data['all'] = $this->DButama->GetDBWhere('tb_tagihan', array('id_supplier' => $spplr))->num_rows();
			$this->load->view('supplier/temp-header',$data);
			$this->load->view('supplier/v_index',$data);
			$this->load->view('supplier/temp-footer');
		}else{
			redirect('error404','refresh');
		}
	}

	public function profil($id)
	{
		$cek = $this->DButama->GetDBWhere($this->table,array('id'=> $id));
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Profil Supplier';
			$data['profil'] = $cek->row();
			$this->load->view('supplier/temp-header',$data);
			$this->load->view('supplier/v_profil',$data);
			$this->load->view('supplier/temp-footer');
		}else{
			redirect('error404','refresh');
		}
	}

	function edit_profil()
	{
		$this->load->library('form_validation');

		$config = array(
			array('field' => 'nama','label' => 'Nama','rules' => 'required',),
			array('field' => 'no_telp','label' => 'No.Telp','rules' => 'required|numeric',),
			array('field' => 'email','label' => 'Email','rules' => 'required|valid_email',),
			array('field' => 'alamat','label' => 'Alamat','rules' => 'required'),
			array('field' => 'password','label' => 'Password','rules' => 'required')
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('home/profil/'.$this->session->userdata('id').'','refresh');
		}else{
			$where  = array('id' => $this->input->post('id'));
			$query = $this->DButama->GetDBWhere($this->table,$where);
			$row = $query->row();
			$pass=$this->input->post('password');
			$hash=password_hash($pass, PASSWORD_DEFAULT);
			$data = array(
				'nama' => $this->input->post('nama'),
				'email' => $this->input->post('email'),
				'no_telp' => $this->input->post('no_telp'),
				'alamat' => $this->input->post('alamat'),
				'password' => $hash,
			);

			// upload gambar
			$gambar = $_FILES['gambar']['name'];
			if(!empty($gambar))
			{
				$upload = $this->_do_upload();
				$data['gambar'] = $upload;
			}
			$this->DButama->UpdateDB($this->table,$where,$data);
			$sess_data['nama'] = $this->input->post('nama');
			$this->session->set_userdata($sess_data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Akun anda sudah diperbaharui</strong> 
						</div>');
			redirect('home/profil/'.$this->session->userdata('id').'','refresh');
		}
	}

	private function _do_upload()
	{
		$config['upload_path']   = 'assets/img/supplier/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name']  = TRUE;
        $config['file_name']     = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('gambar')) //upload and validate
        {
        	$this->session->set_flashdata('upload_error', 'Upload error: '.$this->upload->display_errors('',''));
        	// redirect('/home/profil/'.$this->session->userdata('id').'','refresh');
        }
        return $this->upload->data('file_name');
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */