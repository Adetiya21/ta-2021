<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_admin';

	function __construct()
	{
		parent::__construct();
		// cek session admin sudah login
		if ($this->session->userdata('admin_logged_in') !=  "Sudah_Loggin") {
			echo "<script>
			alert('Login Dulu!');";
			echo 'window.location.assign("'.site_url("admin/welcome").'")
			</script>';
			// redirect('admin/welcome');
		}
	}

	// fun halaman admin
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['tungguLoket'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc Loket'))->num_rows();
		$data['tungguGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc GA'))->num_rows();
		$data['tungguFin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc Finance'))->num_rows();
		$data['tfin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Diterima Finance'))->num_rows();
		$data['tolakLoket'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak Loket'))->num_rows();
		$data['tolakGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak GA'))->num_rows();
		$data['tolakFin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak Finance'))->num_rows();
		$data['selesai'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Selesai'))->num_rows();
		$data['swall'] = $this->DButama->GetDB('tb_tagihan')->num_rows();
		$data['pdftmenunggu'] = $this->DButama->GetDBWhere('tb_supplier', array('status' => 'Menunggu'))->num_rows();
		$data['pdftditerima'] = $this->DButama->GetDBWhere('tb_supplier', array('status' => 'Diterima'))->num_rows();
		$data['pdftall'] = $this->DButama->GetDB('tb_supplier')->num_rows();
		$data['officer'] = $this->DButama->GetDB('tb_officer')->num_rows();
		$data['admin'] = $this->DButama->GetDB('tb_admin')->num_rows();
		$this->load->view('admin/temp-header',$data);
		$this->load->view('admin/v_index');
		$this->load->view('admin/temp-footer');
	}

	// fun halaman profil
	public function profil($id)
	{
		$cek = $this->DButama->GetDBWhere($this->table,array('id'=> $id));
		if ($cek->num_rows() == 1) {
			$title = array('title' => 'Profil', );
			$data['profil'] = $cek->row();
			$this->load->view('admin/temp-header',$title);
			$this->load->view('admin/v_profil',$data);
			$this->load->view('admin/temp-footer');
		}else{
			// redirect('error404','refresh');
		}
	}

	function edit_profil()
	{
		$this->load->library('form_validation');

		$config = array(
			array('field' => 'nama','label' => 'Nama','rules' => 'required',),
			array('field' => 'username','label' => 'Username','rules' => 'required'),
			array('field' => 'password','label' => 'Password','rules' => 'required')
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin/home/profil/'.$this->session->userdata('id').'','refresh');
		}else{
			$where  = array('id' => $this->input->post('id'));
			$query = $this->DButama->GetDBWhere($this->table,$where);
			$row = $query->row();
				$pass=$this->input->post('password');
				$hash=password_hash($pass, PASSWORD_DEFAULT);
				$data = array(

					'nama' => $this->input->post('nama'),
					'username' => $this->input->post('username'),
					'password' => $hash
				);

				$this->DButama->UpdateDB($this->table,$where,$data);
				$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Akun anda sudah diperbaharui</strong> 
							</div>');
				redirect('admin/home/profil/'.$this->session->userdata('id').'','refresh');
		
		}
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/admin/Home.php */