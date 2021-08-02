<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	var $table = 'tb_supplier';

	function __construct()
	{
		parent::__construct(); 
	}

	public function get_tokens($value="") {
		if ($this->session->userdata('bayand') == "SudahMasukMas") {
			echo $this->security->get_csrf_hash();
		}
	}

	public function index()
	{
		$this->load->view('v_login');
	}

	public function login()
	{
		$recaptcha = $this->input->post('g-recaptcha-response');
		$response = $this->recaptcha->verifyResponse($recaptcha);
		if (!isset($response['success']) || $response['success'] <> true) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Klik Recaptcha</strong> 
				</div>');
			redirect('welcome','refresh');
		} else {
			$this->load->library('form_validation');
			$config = array(
				array('field' => 'username','label' => "NIK/No.HP",'rules' => 'required' ),
				array('field' => 'password','label' => 'Password','rules' => 'required' )
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('username', set_value('username') );
				$this->session->set_flashdata('password', set_value('password') );
				$this->session->set_flashdata('error', validation_errors());
				redirect('welcome','refresh');
			}else{

				// load database dengan nik/no_telp
				$query = $this->DButama->GetDBWhere('tb_supplier', array('no_telp' => $this->input->post('username'), ));
				$query_officer = $this->DButama->GetDBWhere('tb_officer',  array('nik' => $this->input->post('username')));
				
				if ($query->num_rows() == 0 && $query_officer->num_rows() == 0) {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>NIK/No.HP/Password Tidak Ada</strong> 
						</div>');
					redirect('welcome','refresh');
				}else if ($query->num_rows() == 1 ) {
					$hasil = $query->row();
					if (password_verify($this->input->post('password'), $hasil->password)) {
						foreach ($query->result() as $key ) {
							$sess_data['supplier_logged_in'] = "Sudah_Loggin";
							$sess_data['nama'] = $key->nama;
							$sess_data['id'] = $key->id;
							$sess_data['email'] = $key->email;
							$sess_data['no_telp'] = $key->no_telp;
							$sess_data['alamat'] = $key->alamat;
							$sess_data['gambar'] = $key->gambar;
							$this->session->set_userdata($sess_data);
							$this->session->unset_userdata('officer_logged_in');
							$this->session->unset_userdata('admin_logged_in');
							redirect('home', 'refresh');
						}
					}else{
						$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>No.HP / Password Tidak Ada</strong> 
							</div>');
						redirect('welcome','refresh');
					}
				}else if ($query_officer->num_rows() == 1 ) {
					$hasil_officer = $query_officer->row();
					if (password_verify($this->input->post('password'), $hasil_officer->password)) {
						foreach ($query_officer->result() as $key ) {
							$sess_data['officer_logged_in'] = "Sudah_Loggin";
							$sess_data['nama'] = $key->nama;
							$sess_data['nik'] = $key->nik;
							$sess_data['email'] = $key->email;
							$sess_data['no_telp'] = $key->no_telp;
							$sess_data['tipe'] = $key->tipe;
							$sess_data['gambar'] = $key->gambar;
							$this->session->set_userdata($sess_data);
							$this->session->unset_userdata('admin_logged_in');  //mengeluarkan session user
							$this->session->unset_userdata('supplier_logged_in');  //mengeluarkan session user
							redirect('officer/home', 'refresh');
						}
					}else{
						// menampilkan pesan error
						$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>NIK / Password Tidak Ada</strong> 
							</div>');
						redirect('welcome','refresh');
					}
				}
			}
		}
	}

	function logout()
	{
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
		redirect('welcome','refresh');
	}

	public function daftar()
	{
		$this->load->view('v_daftar');
	}

	function proses_daftar()
	{
		$this->load->library('form_validation');

		$config = array(
			array('field' => 'nama','label' => 'Nama Sesuai KTP','rules' => 'required',),
			array('field' => 'no_telp','label' => 'no_telp','rules' => 'required'),
			array('field' => 'password','label' => 'Password','rules' => 'required')
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('welcome/daftar','refresh');
		}else{
			$DataUser  = array('no_telp' => $this->input->post('no_telp'));
			if ($this->DButama->GetDBWhere($this->table,$DataUser)->num_rows() == 1) {
				// $this->_Values();
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>No. Telp sudah terdaftar</strong> 
							</div>');
				redirect('welcome/daftar','refresh');
			}else{
				$pass=$this->input->post('password');
				$hash=password_hash($pass, PASSWORD_DEFAULT);
				$data = array(
					'nama' => $this->input->post('nama'),
					'no_telp' => $this->input->post('no_telp'),
					'password' => $hash
				);

				$this->DButama->AddDB($this->table,$data);
				$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Akun anda sudah terdaftar, silahkan lakukan login</strong> 
							</div>');
				redirect('welcome','refresh');
			}
		}
	}

	public function lupa_password()
	{
		$this->load->view('v_lupa-password');
	}

	public function proses_reset()
	{
		$recaptcha = $this->input->post('g-recaptcha-response');
		$response = $this->recaptcha->verifyResponse($recaptcha);
		if (!isset($response['success']) || $response['success'] <> true) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Klik Recaptcha</strong> 
				</div>');
			redirect('welcome','refresh');
		} else {
			$this->load->library('form_validation');
			$config = array(
				array('field' => 'username','label' => "NIK/No.HP",'rules' => 'required' )
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('username', set_value('username') );
				$this->session->set_flashdata('error', validation_errors());
				redirect('welcome','refresh');
			}else{
				// load database dengan nik/no_telp
				$query = $this->DButama->GetDBWhere('tb_supplier', array('no_telp' => $this->input->post('username'), ));
				$query_officer = $this->DButama->GetDBWhere('tb_officer',  array('nik' => $this->input->post('username')));
				
				if ($query->num_rows() == 0 && $query_officer->num_rows() == 0) {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>NIK/No.HP Tidak Ada</strong> 
						</div>');
					redirect('lupa-password','refresh');
				}else if ($query->num_rows() == 1 ) {
					$where  = array('no_telp' => $this->input->post('username'));
					$hasil = $query->row();
					$pass='12345';
					$hash=password_hash($pass, PASSWORD_DEFAULT);  //membuat encrypt password
					$data = array(
						'password' => $hash					
					);
					$this->DButama->UpdateDB('tb_supplier',$where,$data);
					$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Password Sudah di-Reset : 12345</strong> 
							</div>');
					redirect('login', 'refresh');
				}else if ($query_officer->num_rows() == 1 ) {
					$where  = array('nik' => $this->input->post('username'));
					$pass='12345';
					$hash=password_hash($pass, PASSWORD_DEFAULT);  //membuat encrypt password
					$data = array(
						'password' => $hash					
					);
					$this->DButama->UpdateDB('tb_officer',$where,$data);
					$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Password Sudah di-Reset : 12345</strong> 
							</div>');
					redirect('login', 'refresh');
				}
			}
		}
	}
}
