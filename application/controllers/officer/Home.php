<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_officer';

	function __construct()
	{
		parent::__construct();
		// cek session admin sudah login
		if ($this->session->userdata('officer_logged_in') !=  "Sudah_Loggin") {
			echo "<script>
			alert('Login Dulu!');";
			echo 'window.location.assign("'.site_url("welcome").'")
			</script>';
		}
	}

	// fun halaman utama
	public function index()
	{
		$cek = $this->DButama->GetDBWhere($this->table,array('nik'=> $this->session->userdata('nik')));
		$officer = $this->session->userdata('nik');
		if ($cek->num_rows() == 1) {
			$data['title'] = 'Dashboard';
			$data['profil'] = $cek->row();

			$data['tungguLok'] = $this->DButama->GetDBWhere('tb_tagihan', array('status_faktur' => 'Menunggu'))->num_rows();
			$data['terimaLok'] = $this->DButama->GetDBWhere('tb_tagihan', array('status_faktur' => 'Diterima','nik_loket' => $officer))->num_rows();
			$data['tolakLok'] = $this->DButama->GetDBWhere('tb_tagihan', array('status_faktur' => 'Ditolak','nik_loket' => $officer))->num_rows();
			
			$data['terimaGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status_ga' => 'Diterima'))->num_rows();
			$data['tolakGGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status_ga' => 'Ditolak'))->num_rows();
			
			$data['terimaFi'] = $this->DButama->GetDBWhere('tb_tagihan', array('status_fin' => 'Diterima','nik_fin' => $officer))->num_rows();
			$data['tolakFi'] = $this->DButama->GetDBWhere('tb_tagihan', array('status_fin' => 'Ditolak','nik_fin' => $officer))->num_rows();
			
			$data['tungguLoket'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc Loket'))->num_rows();
			$data['tungguGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc GA'))->num_rows();
			$data['tungguFin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Menunggu Acc Finance'))->num_rows();

			$data['tolakLoket'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak Loket'))->num_rows();
			$data['tolakGA'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak GA'))->num_rows();
			$data['tolakFin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Ditolak Finance'))->num_rows();
			$data['tfin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Diterima Finance'))->num_rows();
			$data['selfin'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Selesai','nik_fin' => $officer))->num_rows();
			$data['selesai'] = $this->DButama->GetDBWhere('tb_tagihan', array('status' => 'Selesai'))->num_rows();
			$data['all'] = $this->DButama->GetDB('tb_tagihan')->num_rows();

			$data['officer'] = $this->DButama->GetDB('tb_officer')->num_rows();
			$data['supplier'] = $this->DButama->GetDB('tb_supplier')->num_rows();
			$this->load->view('officer/temp-header',$data);
			$this->load->view('officer/v_index',$data);
			$this->load->view('officer/temp-footer');
		}else{
			redirect('error404','refresh');
		}
	}

	// fun halaman profil
	public function profil($nik)
	{
		$cek = $this->DButama->GetDBWhere($this->table,array('nik'=> $nik));
		if ($cek->num_rows() == 1) {
			$title = array('title' => 'Profil', );
			$data['profil'] = $cek->row();
			$this->load->view('officer/temp-header',$title);
			$this->load->view('officer/v_profil',$data);
			$this->load->view('officer/temp-footer');
		}else{
			redirect('error404','refresh');
		}
	}

	// fun proses edit profil
	function edit_profil()
	{
		$this->load->library('form_validation');

		$config = array(
			array('field' => 'nama','label' => 'Nama','rules' => 'required',),
			array('field' => 'nik','label' => 'nik','rules' => 'required'),
			array('field' => 'password','label' => 'Password','rules' => 'required')
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('officer/home/profil/'.$this->session->userdata('nik').'','refresh');
		}else{
			$where  = array('nik' => $this->input->post('nik'));
			$query = $this->DButama->GetDBWhere($this->table,$where);
			$row = $query->row();
			$pass=$this->input->post('password');
			$hash=password_hash($pass, PASSWORD_DEFAULT);
			$data = array(
				'nama' => $this->input->post('nama'),
				'email' => $this->input->post('email'),
				'no_telp' => $this->input->post('no_telp'),
				'password' => $hash
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
			redirect('officer/home/profil/'.$this->session->userdata('nik').'','refresh');
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

/* End of file Home.php */
/* Location: ./application/controllers/officer/Home.php */