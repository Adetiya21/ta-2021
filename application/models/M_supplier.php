<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_supplier extends CI_Model {

	// deklarasi var table
	var $table = 'tb_supplier';

	public function json() {
		$this->datatables->select('id,nama,email,no_telp,alamat,status,password,gambar');  //nama field table
		$this->datatables->from($this->table);  //nama table
		$this->datatables->add_column('view', '<div align="center">
			<a class="btn btn-warning btn-rounded btn-sm" href="javascript:void(0)" title="Edit" onclick="edit($1)"> <span class="fa fa-edit"></span></a>
			<a class="btn btn-danger btn-rounded btn-sm" href="javascript:void(0)" title="Hapus" onclick="hapus($1)" > <span class="fa fa-trash"></span></a>
			</div>', 'id');
		return $this->datatables->generate();
	}

}

/* End of file M_supplier.php */
/* Location: ./application/models/M_supplier.php */