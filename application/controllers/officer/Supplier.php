<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_supplier';

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
		$this->load->view('officer/temp-header',$title);
		$this->load->view('officer/v_supplier');
		$this->load->view('officer/temp-footer');
	}
}

/* End of file Supplier.php */
/* Location: ./application/controllers/officer/Supplier.php */