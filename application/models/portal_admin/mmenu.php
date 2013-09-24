<?php
/**
*	---------------------------------------------
*	Desc 		: Model for Menu Management
*	Created By 	: Yagi Anggar Prahara
*	Date		: 01 Sept 2012
*	---------------------------------------------
*	All right reserved
**/

class Mmenu extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function getParentMenu($sort_name,$sort_order,$limit,$page_start,$search,$query)
    {
		$level = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		if ($level == "Super Administrator") {
			$this->db->select('*');
			$this->db->from('menu');
			// $this->db->join('level_admin','admin.level_id = level_admin.id_level','inner');
			$this->db->where('tipe','parent');
			$this->db->like('nama_menu',$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
			//echo $this->db->last_query();
		} else {
			$this->db->select('*');
			$this->db->from('parent_menu');
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
	
	function getChildMenu($sort_name,$sort_order,$limit,$page_start,$search,$query,$parentId) {
		$this->db->select('*');
		$this->db->from('menu');
		$this->db->where('tipe','child');
		$this->db->where('parent_id',$parentId);
		$this->db->order_by('urutan','asc');
		$sql = $this->db->get();
		return $sql;
	}
	
	function getJenisMenu () {
		//-- Get Jenis
		$this->db->select('*');
		$this->db->from('jenis_menu');
		$this->db->order_by('jenis','ASC');
		$resJenis = $this->db->get();
		$data = Array();
		
		if ($resJenis->num_rows() > 0) {
			foreach ($resJenis->result_array() as $jenis) {
				$data['rows'][] = array(
					'id' => $jenis['id'],
					'jenis' => $jenis['jenis']
				);
			}
		}
		return $data['rows'];
	}
	
	function getAllMenu () {
		//-- Get Parent
		$this->db->select('*');
		$this->db->from('menu');
		$this->db->where('tipe','parent');
		$this->db->order_by('urutan','ASC');
		$resParent = $this->db->get();
		
		$data = Array();
		$data['rows'][] = array(
			'id' => '-',
			'nama_menu' => 'Item Root',
			'tipe' => null,
		);
		if ($resParent->num_rows() > 0) {
			foreach ($resParent->result_array() as $parent) {
				$data['rows'][] = array(
					'id' => $parent['id'],
					'nama_menu' => '<b>'.$parent['nama_menu'].'</b>',
					'tipe' => '<b>'.$parent['tipe'].'</b>',
				);
				
				//-- Get Child
				$this->db->select('*');
				$this->db->from('menu');
				$this->db->where('tipe','child');
				$this->db->where('parent_id',$parent['id']);
				$this->db->order_by('urutan','asc');
				$resChild = $this->db->get();
				if ($resChild->num_rows() > 0) {
					foreach ($resChild->result_array() as $child){
						$data['rows'][] = array(
							'id' => $child['id'],
							'nama_menu' => '|&mdash; '.$child['nama_menu'],
							'tipe' => '<b>'.$child['tipe'].'</b>',
						);
					}
				}
			}
		} else {
			// $data['rows'][] = array(
				// 'id' => "",
				// 'nama_menu' => "",
				// 'tipe' => "",
			// );
		}
		return $data['rows'];
	}
	
	function getMenuById($id) {
		$this->db->select('*');
		$this->db->from('menu');
		$this->db->where('id',$id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function saveMenu($parent_id,$jenis_id,$link_menu,$nama_menu,$desc_menu,$hidden_id) {
		$tipe=($parent_id=='-')?"parent":"child";
		$created_by = $this->session->userdata('username');
		$urutan = $this->cekOrder($tipe,$parent_id);
		if ($urutan->num_rows() > 0) {
			$urutan = $urutan->row()->urutan;
			$urutan = $urutan+1;
		} else {
			$urutan = 1;
		}

		if(!$hidden_id){
			$data = array(
			   'parent_id' => $parent_id ,
			   'jenis_id' => $jenis_id ,
			   'nama_menu' => $nama_menu ,
			   'desc' => $desc_menu ,
			   'urutan' => $urutan,
			   'link' => $link_menu,
			   'tipe' => $tipe,
			   'created_by' => $created_by
			);
			$qry = $this->db->insert('menu', $data);
			$this->authlib->last_query();
		}
		else {
			$data = array(
			   'parent_id' => $parent_id ,
			   'jenis_id' => $jenis_id ,
			   'nama_menu' => $nama_menu ,
			   'desc' => $desc_menu ,
			   //'urutan' => null ,
			   'link' => $link_menu,
			   'tipe' => $tipe,
			   'modified_by' => $created_by
			);
			$this->db->where('id', $hidden_id);
			$qry = $this->db->update('menu', $data); 
		}
		
		return ($qry)?'success':$this->db->_error_message();
	}
	
	function cekOrder ($tipe,$parent_id) {
		$this->db->select_max('urutan');
		$this->db->from('menu');
		$this->db->where('tipe',$tipe);
		$this->db->where('parent_id',$parent_id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function order ($id,$order,$parent_id,$tipe,$urutan) {
		if ($order == 'up') {
			$ifParent = ($parent_id == "")?"":"parent_id='$parent_id' and ";
			$get = $this->db->query("select * 
						from menu
						where tipe='$tipe' and $ifParent urutan < $urutan
						order by urutan desc
						limit 1;");
						// echo $this->db->last_query();
			if ($get->num_rows()>0) {
				$res = $get->row();
				$resId = $res->id;
				$resParentId = $res->parent_id;
				$resUrutan = $res->urutan;
				
				//-- Update current row
				$data1 = array(
				   'urutan' => $resUrutan
				);
				$this->db->where('id', $id);
				$qry1 = $this->db->update('menu', $data1); 
				
				//-- Update before row
				$data2 = array(
				   'urutan' => $urutan
				);
				$this->db->where('id', $resId);
				$qry2 = $this->db->update('menu', $data2);
				return ($qry2)?'success':$this->db->_error_message();
			} else {
				return 'onTop';
			}
		}
		else if ($order == 'down') {
			$ifParent = ($parent_id == "")?"":"parent_id='$parent_id' and ";
			$get = $this->db->query("select * 
						from menu
						where tipe='$tipe' and $ifParent urutan > $urutan
						order by urutan desc
						limit 1;");
			if ($get->num_rows()>0) {
				$res = $get->row();
				$resId = $res->id;
				$resParentId = $res->parent_id;
				$resUrutan = $res->urutan;
				
				//-- Update current row
				$data1 = array(
				   'urutan' => $resUrutan
				);
				$this->db->where('id', $id);
				$qry1 = $this->db->update('menu', $data1); 
				
				//-- Update before row
				$data2 = array(
				   'urutan' => $urutan
				);
				$this->db->where('id', $resId);
				$qry2 = $this->db->update('menu', $data2);
				return ($qry2)?'success':$this->db->_error_message();
			} else {
				return 'onBellow';
			}
		}
		// $this->db->select_max('urutan');
		// $this->db->from('menu');
		// $this->db->where('tipe',$tipe);
		// $this->db->where('parent_id',$parent_id);
		// $sql = $this->db->get();
		// return $sql;
	}
	
	function deleteMenu($id) {
		$this->db->select('*');
		$this->db->from('menu');
		$this->db->where('parent_id',$id);
		$res = $this->db->get();
		if ($res->num_rows() > 0) {
			return "Parent menu can't be deleted. Please delete child menu first";
		}
		else {
			$qry = $this->db->delete('menu', array('id' => $id)); 
			return ($qry)?'success':$this->db->_error_message();
		}
	}
}