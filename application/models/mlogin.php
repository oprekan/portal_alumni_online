<?php
class Mlogin extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function checkLogin($username, $password){
		$this->db->select('data_alumni.*,divisi.nama_divisi,program_studi.nama_prodi');
		$this->db->from('data_alumni');
		$this->db->join('divisi','data_alumni.divisi_id = divisi.id','inner');
		$this->db->join('program_studi','data_alumni.prodi_id = program_studi.id','inner');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$sql = $this->db->get();
		
		$data['result'] = $sql->result_array();
		return ($sql->num_rows()>0) ? $data : FALSE;
	}
}