<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_faktur extends CI_Model {

	// membuat no faktur
	function find_faktur()
	{
		$q = $this->db->query("SELECT MAX(RIGHT(no_faktur,4)) AS kd_max FROM tb_tagihan WHERE DATE(tgl_input)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'TG-'.date('dmy').$kd;
	}

}

/* End of file M_faktur.php */
/* Location: ./application/models/M_faktur.php */