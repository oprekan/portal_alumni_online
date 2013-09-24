<?php
class Madmin extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function check_user($username, $password){
		$this->db->select('a.*,b.level');
		$this->db->from('admin as a');
		$this->db->join('level_admin as b','a.level_id = b.id_level','inner');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->where('blokir', 'N');
		$sql = $this->db->get();
		
		$data['result'] = $sql->result_array();
		return ($sql->num_rows()>0) ? $data : FALSE;
	}
	
	function getAdmin($sort_name,$sort_order,$limit,$page_start,$search,$query)
    {
		$level = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		if ($level == "Super Administrator") {
			$this->db->select('admin.*,level_admin.level');
			$this->db->from('admin');
			$this->db->join('level_admin','admin.level_id = level_admin.id_level','inner');
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		} else {
			$this->db->select('admin.*,level_admin.level');
			$this->db->from('admin');
			$this->db->join('level_admin','admin.level_id = level_admin.id_level','inner');
			$this->db->where('created_by',$username);
			$this->db->or_where('username',$username);
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		}
		return $res;
    }
	
	function getAdminById($id) {
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('id',$id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function getLevelAdmin () {
		$this->db->select('*');
		$this->db->from('level_admin');
		$sql = $this->db->get();
		return $sql;
	}
	
	function saveAdmin($username, $nama, $email, $pass, $level, $blokir, $hidden_id) {
		if(!$hidden_id){
			$pass=md5($pass);
			$created_by = $this->session->userdata('username');
			$data = array(
			   'username' => $username ,
			   'password' => $pass ,
			   'nama_lengkap' => $nama,
			   'level_id' => $level,
			   'blokir' => $blokir,
			   'email' => $email,
			   'created_by' => $created_by
			);
			$qry = $this->db->insert('admin', $data);
		}
		else {
			$created_by = $this->session->userdata('username');
			if ($pass != "") {
				$pass=md5($pass);
				$data = array(
				   'username' => $username ,
				   'password' => $pass ,
				   'nama_lengkap' => $nama,
				   'level_id' => $level,
				   'blokir' => $blokir,
				   'email' => $email,
				   'created_by' => $created_by
				);
				$this->db->where('id', $hidden_id);
				$qry = $this->db->update('admin', $data); 
			} else {
				$data = array(
				   'username' => $username ,
				   'nama_lengkap' => $nama,
				   'level_id' => $level,
				   'blokir' => $blokir,
				   'email' => $email,
				   'created_by' => $created_by
				);
				$this->db->where('id', $hidden_id);
				$qry = $this->db->update('admin', $data); 
			}
		}
		return ($qry)?'success':$this->db->_error_message();
	}
	
	function deleteAdmin($id) {
		$qry = $this->db->delete('admin', array('id' => $id)); 
		return ($qry)?'success':$this->db->_error_message();
	}
}