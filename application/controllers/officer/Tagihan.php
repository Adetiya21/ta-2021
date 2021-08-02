<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

	// deklarasi var table
	var $table = 'tb_tagihan';

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
		$this->load->model('m_tagihan','Model');   //load model m_tagihan
		$this->load->model('m_faktur','faktur');  //load model no_faktur
		$this->load->helper('rupiah');  //load helper rupiah
	}

	// fun json datatables
	public function json() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			if ($this->session->userdata('tipe')=='Loket') {
				echo $this->Model->json_loket();
			} else if ($this->session->userdata('tipe')=='GA') {
				echo $this->Model->json_ga();
			} else if ($this->session->userdata('tipe')=='Finance') {
				echo $this->Model->json_fin();
			}			
		}
	}

	// fun json datatables
	public function jsonDiterima() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo $this->Model->json_finTerima();			
		}
	}

	// fun json datatables
	public function jsonSeluruh() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo $this->Model->json_seluruh();			
		}
	}

	// fun halaman tagihan
	public function index()
	{
		$title = array('title' => 'Data Tagihan Menunggu', );
		$this->load->view('officer/temp-header',$title);
		$this->load->view('officer/v_tagihan');
		$this->load->view('officer/temp-footer');
	}

	// fun halaman seluruh tagihan
	public function i()
	{
		$title = array('title' => 'Seluruh Data Tagihan', );
		$this->load->view('officer/temp-header',$title);
		$this->load->view('officer/v_tagihan-seluruh');
		$this->load->view('officer/temp-footer');
	}

// fun halaman terima finance
	public function terima()
	{
		$data['title'] = 'Data Tagihan Diterima';
		$this->load->view('officer/temp-header',$data);
		$this->load->view('officer/v_tagihan-diterima');
		$this->load->view('officer/temp-footer');
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

	// fun proses update status loket
	public function update_fak()
	{
		if ($this->input->is_ajax_request()) {
			$where  = array('id' => $this->input->post('id'));
			$query = $this->DButama->GetDBWhere($this->table,$where); //filter berdasarkan id
			$row = $query->row();
			$status_faktur = $this->input->post('status_faktur');
			if ($status_faktur=='Diterima') {
				$no_faktur =  $this->faktur->find_faktur();  //membuat no faktur
				$data = array(
					'no_faktur' => $no_faktur,
					'tgl_input' => date('Y-m-d H:i:s'),
					'nik_loket' => $this->session->userdata('nik'),
					'status_faktur' => $status_faktur,
					'status' => 'Menunggu Acc GA',
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			} else if($status_faktur=='Ditolak') {
				$data = array(
					'nik_loket' => $this->session->userdata('nik'),
					'status_faktur' => $status_faktur,
					'status' => 'Ditolak Loket',
					'ket_status' => $this->input->post('keterangan')
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			} else {
				$data = array(
					'nik_loket' => $this->session->userdata('nik'),
					'status_faktur' => $status_faktur,
					'status' => 'Menunggu Acc Loket',
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			}
			echo json_encode(array("status" => TRUE));
		}
	}

	// fun proses update status GA
	public function update_ga()
	{
		if ($this->input->is_ajax_request()) {
			$where  = array('id' => $this->input->post('id'));
			$query = $this->DButama->GetDBWhere($this->table,$where); //filter berdasarkan id
			$row = $query->row();
			$status_ga = $this->input->post('status_ga');
			if ($status_ga=='Diterima') {
				$data = array(
					'status_ga' => $status_ga,
					'status' => 'Menunggu Acc Finance',
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			} else if($status_ga=='Ditolak') {
				$data = array(
					'status_ga' => $status_ga,
					'status' => 'Ditolak GA',
					'ket_status' => $this->input->post('keterangan')
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			} else {
				$data = array(
					'status_ga' => $status_ga,
					'status' => 'Menunggu Acc GA',
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			}
			echo json_encode(array("status" => TRUE));
		}
	}

	// fun proses update status fin
	public function update_fin()
	{
		if ($this->input->is_ajax_request()) {
			$where  = array('id' => $this->input->post('id'));
			$query = $this->DButama->GetDBWhere($this->table,$where); //filter berdasarkan id
			$row = $query->row();
			$status_fin = $this->input->post('status_fin');
			if ($status_fin=='Selesai') {
				$data = array(
					'nik_fin' => $this->session->userdata('nik'),
					'status_fin' => $status_fin,					
					'status' => 'Selesai',
				);
				// upload gambar
				$gambar = $_FILES['gambar']['name'];
				if(!empty($gambar))
				{
					$upload = $this->_do_upload();
					$data['bukti_transfer'] = $upload;
				}
				$this->DButama->UpdateDB($this->table,$where,$data);
			} else if($status_fin=='Diterimaa') {
				$tgl_transfer = $this->input->post('tgl_transfer');
		        $tgl_transfer = date('Y-m-d', strtotime($tgl_transfer));
				$data = array(
					'nik_fin' => $this->session->userdata('nik'),
					'tgl_transfer' => $tgl_transfer,
					'status_fin' => 'Diterima',
					'status' => 'Diterima Finance',
					'ket_status' => $this->input->post('keterangan')
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			} else if($status_fin=='Ditolak') {
				$data = array(
					'nik_fin' => $this->session->userdata('nik'),
					'status_fin' => $status_fin,
					'status' => 'Ditolak Finance',
					'ket_status' => $this->input->post('keterangan')
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			} else {
				$data = array(
					'status_fin' => $status_fin,
					'status' => 'Menunggu Acc fin',
				);
				$this->DButama->UpdateDB($this->table,$where,$data);
			}
			echo json_encode(array("status" => TRUE));
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
			$this->load->view('officer/temp-header',$data);
			$this->load->view('officer/v_tagihan-view',$data);
			$this->load->view('officer/temp-footer');
		}else{
			redirect('error404','refresh');
		}	
	}

	// fun laporan diterima berdasarkan tipe jabatan
	public function diterima($tipe)
	{
		$data['tipe'] = $tipe;
		$title = array('title' => 'Data Tagihan', );
		$this->load->view('officer/temp-header',$title);
		$this->load->view('officer/v_tagihan-laporan-diterima', $data);
		$this->load->view('officer/temp-footer');
	}

	// fun laporan diterima berdasarkan tipe jabatan
	public function selesai($tipe)
	{
		$data['tipe'] = $tipe;
		$title = array('title' => 'Data Tagihan', );
		$this->load->view('officer/temp-header',$title);
		$this->load->view('officer/v_tagihan-laporan-diterima', $data);
		$this->load->view('officer/temp-footer');
	}

	// fun json laporan datatables
	public function jsonTerima() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			if ($this->session->userdata('tipe')=='Loket') {
				echo $this->Model->json_terimaLoket();
			} else if ($this->session->userdata('tipe')=='GA') {
				echo $this->Model->json_terimaGa();
			} else if ($this->session->userdata('tipe')=='Finance') {
				echo $this->Model->json_terimaFin();
			}			
		}
	}

	// fun laporan ditolak berdasarkan tipe jabatan
	public function ditolak($tipe)
	{
		$data['tipe'] = $tipe;
		$title = array('title' => 'Data Tagihan', );
		$this->load->view('officer/temp-header',$title);
		$this->load->view('officer/v_tagihan-laporan-ditolak', $data);
		$this->load->view('officer/temp-footer');
	}

	// fun json laporan datatables
	public function jsonTolak() {
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			if ($this->session->userdata('tipe')=='Loket') {
				echo $this->Model->json_tolakLoket();
			} else if ($this->session->userdata('tipe')=='GA') {
				echo $this->Model->json_tolakGa();
			} else if ($this->session->userdata('tipe')=='Finance') {
				echo $this->Model->json_tolakFin();
			}			
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
/* Location: ./application/controllers/officer/Tagihan.php */