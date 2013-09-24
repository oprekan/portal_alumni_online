<?php
/**
*	---------------------------------------------
*	Desc 		: Model for kategori organisasi
*	Created By 	: Yagi Anggar Prahara
*	Date		: 09 August 2012
*	---------------------------------------------
*	All right reserved
**/

class Mkategoriorganisasi extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function getKategori($sort_name,$sort_order,$limit,$page_start,$search,$query)
    {
		$level = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		if ($level == "Super Administrator") {
			$this->db->select('*');
			$this->db->from('kategori_organisasi');
			// $this->db->join('level_admin','admin.level_id = level_admin.id_level','inner');
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		} else {
			$this->db->select('*');
			$this->db->from('kategori_organisasi');
			// $this->db->join('level_admin','admin.level_id = level_admin.id_level','inner');
			$this->db->where('created_by',$username);
			$this->db->or_where('username',$username);
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		}
		return $res;
    }
	
	function getKategoriById($id) {
		$this->db->select('*');
		$this->db->from('kategori_organisasi');
		$this->db->where('id',$id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function saveKategori($category, $hidden_id) {
		if(!$hidden_id){
			$created_by = $this->session->userdata('username');
			$data = array(
			   'kategori' => $category ,
			   'created_by' => $created_by ,
			);
			$qry = $this->db->insert('kategori_organisasi', $data);
			$this->authlib->last_query();
		}
		else {
			$data = array(
			   'kategori' => $category
			);
			$this->db->where('id', $hidden_id);
			$qry = $this->db->update('kategori_organisasi', $data); 
		}
		
		return ($qry)?'success':$this->db->_error_message();
	}
	
	function deleteKategori($id) {
		$qry = $this->db->delete('kategori_organisasi', array('id' => $id)); 
		return ($qry)?'success':$this->db->_error_message();
	}
}