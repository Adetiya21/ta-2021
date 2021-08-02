<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tagihan extends CI_Model {

	// deklarasi var table
	var $table = 'tb_tagihan';

	// fun admin
	public function json_admin() {
		$this->datatables->select('tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.status,
			tb_supplier.nama as nama_supplier
			');
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-primary btn-rounded btn-sm" href="'.site_url('admin/tagihan/view/$1').'" ><span class="fa fa-eye"></span></a>
			<a class="btn btn-warning btn-rounded btn-sm" href="'.site_url('admin/tagihan/edit/$1').'" ><span class="fa fa-edit"></span></a>
			<a class="btn btn-danger btn-rounded btn-sm" href="javascript:void(0)" onclick="hapus($1)" ><span class="fa fa-trash"></span></a>
			</div>', 'id');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun seluruh
	public function json_seluruh() {
		$this->datatables->select('tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.tgl_transfer,
			tb_tagihan.biaya,
			tb_tagihan.status,
			tb_supplier.nama as nama_supplier
			');
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-primary btn-rounded btn-sm" href="'.site_url('officer/tagihan/view/$1').'" ><span class="fa fa-eye"></span></a>
			</div>', 'id');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun loket
	public function json_loket() {
		$this->datatables->select('tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.status_faktur,
			tb_tagihan.status,
			tb_supplier.nama as nama_supplier
			');
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->where('tb_tagihan.status', 'Menunggu Acc Loket');
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-primary btn-rounded btn-sm" href="'.site_url('officer/tagihan/view/$1').'" ><span class="fa fa-eye"></span></a>
			<a class="btn btn-warning btn-rounded btn-sm" href="javascript:void(0)" title="Edit" onclick="edit($1)"> <span class="fa fa-edit"></span></a>
			</div>', 'id');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun ga
	public function json_ga() {
		$this->datatables->select('tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.status_faktur,
			tb_tagihan.status,
			tb_supplier.nama as nama_supplier
			');
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->where('tb_tagihan.status', 'Menunggu Acc GA');
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-primary btn-rounded btn-sm" href="'.site_url('officer/tagihan/view/$1').'" ><span class="fa fa-eye"></span></a>
			<a class="btn btn-warning btn-rounded btn-sm" href="javascript:void(0)" title="Edit" onclick="edit_ga($1)"> <span class="fa fa-edit"></span></a>
			</div>', 'id');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun fin
	public function json_fin() {
		$this->datatables->select('tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.status_faktur,
			tb_tagihan.status,
			tb_supplier.nama as nama_supplier
			');
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->where('tb_tagihan.status', 'Menunggu Acc Finance');
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-primary btn-rounded btn-sm" href="'.site_url('officer/tagihan/view/$1').'" ><span class="fa fa-eye"></span></a>
			<a class="btn btn-warning btn-rounded btn-sm" href="javascript:void(0)" title="Edit" onclick="edit_fin($1)"> <span class="fa fa-edit"></span></a>
			</div>', 'id');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun fin
	public function json_finTerima() {
		$this->datatables->select('tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.tgl_transfer,
			tb_tagihan.biaya,
			tb_tagihan.status_faktur,
			tb_tagihan.status,
			tb_supplier.nama as nama_supplier
			');
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->where('tb_tagihan.status', 'Diterima Finance');
		$this->datatables->where('tb_tagihan.nik_fin', $this->session->userdata('nik'));
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-primary btn-rounded btn-sm" href="'.site_url('officer/tagihan/view/$1').'" ><span class="fa fa-eye"></span></a>
			<a class="btn btn-warning btn-rounded btn-sm" href="javascript:void(0)" title="Edit" onclick="edit_fin($1)"> <span class="fa fa-edit"></span></a>
			</div>', 'id');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan admin
	public function json_adminLaporan() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.tgl_transfer,
			tb_tagihan.biaya,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_tagihan.status,
			tb_supplier.nama as nama_supplier
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		// $this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		// $this->datatables->where('tb_tagihan.status', 'Selesai');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan terima loket
	public function json_terimaLoket() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan as tgl,
			tb_tagihan.biaya,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_supplier.nama as nama_supplier,
			tb_officer.nama as nama_officer
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		$this->datatables->where('tb_tagihan.status_faktur', 'Diterima');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan terima ga
	public function json_terimaGa() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan as tgl,
			tb_tagihan.biaya,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_supplier.nama as nama_supplier,
			tb_officer.nama as nama_officer
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		$this->datatables->where('tb_tagihan.status_ga', 'Diterima');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan terima fin
	public function json_terimaFin() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			CONCAT('Tagihan : ', tb_tagihan.tgl_tagihan,'<hr style=\"margin-top:2px;margin-bottom:2px\"> Transfer : ',tb_tagihan.tgl_transfer) as tgl,
			tb_tagihan.biaya,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_supplier.nama as nama_supplier,
			tb_officer.nama as nama_officer
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		$this->datatables->where('tb_tagihan.status_fin', 'selesai');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan tolak loket
	public function json_tolakLoket() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.ket_status,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_supplier.nama as nama_supplier,
			tb_officer.nama as nama_officer
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		$this->datatables->where('tb_tagihan.status_faktur', 'Ditolak');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan tolak ga
	public function json_tolakGa() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.ket_status,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_supplier.nama as nama_supplier,
			tb_officer.nama as nama_officer
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		$this->datatables->where('tb_tagihan.status_ga', 'Ditolak');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan tolak fin
	public function json_tolakFin() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.ket_status,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_supplier.nama as nama_supplier,
			tb_officer.nama as nama_officer
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		$this->datatables->where('tb_tagihan.status_fin', 'Ditolak');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun supplier
	public function json_supplier() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			tb_tagihan.biaya,
			tb_tagihan.status_faktur,
			tb_tagihan.status_ga,
			tb_tagihan.status_fin,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:0px;margin-bottom:0px\"> ',tb_tagihan.keterangan) as nama,
			tb_tagihan.status,
			tb_tagihan.ket_status,
			tb_supplier.nama as nama_supplier
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->where('tb_tagihan.id_supplier', $this->session->userdata('id'));
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-primary btn-rounded btn-sm" href="'.site_url('tagihan/view/$1').'" ><span class="fa fa-eye"></span></a>
			<a class="btn btn-warning btn-rounded btn-sm" href="'.site_url('tagihan/edit/$1').'" ><span class="fa fa-edit"></span></a>
			</div>', 'id');
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

	// fun laporan terima supplier
	public function json_supplierLaporan() {
		$this->datatables->select("tb_tagihan.id,
			tb_tagihan.no_faktur,
			tb_tagihan.tgl_tagihan,
			CONCAT('Tagihan : ', tb_tagihan.tgl_tagihan,'<hr style=\"margin-top:2px;margin-bottom:2px\"> Transfer : ',tb_tagihan.tgl_transfer) as tgl,
			tb_tagihan.biaya,
			CONCAT(tb_tagihan.nama,' <hr style=\"margin-top:2px;margin-bottom:2px\"> ',tb_tagihan.keterangan) as nama_tagihan,
			tb_supplier.nama as nama_supplier,
			tb_officer.nama as nama_officer
			");
		$this->datatables->from($this->table);
		$this->datatables->join('tb_supplier', 'tb_tagihan.id_supplier=tb_supplier.id');
		$this->datatables->join('tb_officer', 'tb_tagihan.nik_loket=tb_officer.nik');
		$this->datatables->where('tb_tagihan.status', 'Selesai');
		$this->datatables->where('tb_tagihan.id_supplier', $this->session->userdata('id'));
		$this->datatables->group_by("tb_tagihan.id");
		return $this->datatables->generate();
	}

}

/* End of file M_tagihan.php */
/* Location: ./application/models/M_tagihan.php */