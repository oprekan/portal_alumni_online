<?php
/**
*	---------------------------------------------
*	Desc 		: Model for Content Management
*	Created By 	: Yagi Anggar Prahara
*	Date		: 13 Sept 2012
*	---------------------------------------------
*	All right reserved
**/
class Mcontent extends CI_Model {
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
	
	function getContentById($id) {
		$this->db->select('*');
		$this->db->from('menu');
		$this->db->where('id',$id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function getNewsById($id) {
		$this->db->select('berita.*');
		$this->db->from('berita');
		$this->db->where('id',$id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function getExistingImg ($id) {
		//Cek existing image
		$this->db->select('gambar');
		$this->db->from('menu');
		$this->db->where('id', $id);
		$res_cek = $this->db->get();
		$tot = $res_cek->num_rows();
		return ($tot > 0)?$res_cek->result_array() : false;
	}
	
	function getExistingImgNews ($id) {
		//Cek existing image
		$this->db->select('gambar');
		$this->db->from('berita');
		$this->db->where('id', $id);
		$res_cek = $this->db->get();
		$tot = $res_cek->num_rows();
		return ($tot > 0)?$res_cek->result_array() : false;
	}
	
	function getNews($sort_name,$sort_order,$limit,$page_start,$search,$query) {
		$level = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		if ($level == "Super Administrator") {
			$this->db->select('berita.*,date_format(berita.created_date,"%d %b %Y") as post_date,kategori_berita.nama_kategori',false);
			$this->db->from('berita');
			$this->db->join('kategori_berita','berita.kategori_id = kategori_berita.id','inner');
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		} else {
			$this->db->select('berita.*,date_format(berita.created_date,"%d %b %Y") as post_date,kategori_berita.nama_kategori',false);
			$this->db->from('berita');
			$this->db->join('kategori_berita','berita.kategori_id = kategori_berita.id','inner');
			$this->db->where('created_by',$username);
			$this->db->or_where('username',$username);
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		}
		return $res;
    }
	
	function getNewsCategory () {
		$this->db->select('*');
		$this->db->from('kategori_berita');
		$sql = $this->db->get();
		return $sql;
	}
	
	function getMenuName($menu_id) {
		$this->db->select('nama_menu');
		$this->db->from('menu');
		$this->db->where('id',$menu_id);
		$sql = $this->db->get();
		if ($sql->num_rows()>0) {
			$name = $sql->row()->nama_menu;
		} else {
			$name = "";
		}
		return $name;
	}
	
	function saveData($menu=null, $isi=null, $hidden_id=null, $hidden_gbr=null, $del_image=null){
		$username = $this->session->userdata('username');
		
		$config['upload_path'] = './portal_assets/admin/images/static/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']    = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  = true;
		$this->load->library('upload', $config);
		
		
		
		if (!$this->upload->do_upload())
		{
			$error = $this->upload->display_errors();
			if($error == '<p>You did not select a file to upload.</p>'){
				
				if(!$hidden_id){
					// $this->authlib->log($hidden_id);
					// exit;
					$data = array(
					   'isi' => $isi ,
					   'created_by' => $username
					);
					$qry = $this->db->insert('menu', $data);
					if ($qry) {
						$status = array('status'=>true);
					} else {
						$error = $this->db->_error_message();
						$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'nama_menu'=>$menu);
						return $status;
					}
					//$status['status']=true;
				}
				else {
					if ($del_image) {
						$data = array(
						   'isi' => $isi ,
						   'gambar' => null,
						   'modified_by' => $username
						);
						$this->db->where('id', $hidden_id);
						$qry = $this->db->update('menu', $data); 
						if ($qry) {
							$status = array('status'=>true);
							unlink('./portal_assets/admin/images/static/'.$hidden_gbr);
						} else {
							$error = $this->db->_error_message();
							$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'nama_menu'=>$menu);
							return $status;
						}
						
					}
					else {
						$data = array(
						   'isi' => $isi ,
						   'modified_by' => $username
						);
						$this->db->where('id', $hidden_id);
						$qry = $this->db->update('menu', $data); 
						if ($qry) {
							$status = array('status'=>true);
						} else {
							$error = $this->db->_error_message();
							$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'nama_menu'=>$menu);
							return $status;
						}
					}
					
				}
				return ($qry)?$status:$this->db->_error_message();
			}
			else {
				$status = array('error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'nama_menu'=>$menu);
				return $status;
			}
			
			// $this->load->view('webadmin/tes_upload_form', $error);
		}
		else
		{	
			$file_data = $this->upload->data();
			
			if(!$hidden_id){
				$data = array(
				   'isi' => $isi,
				   'gambar' => $file_data['file_name'],
				   'created_by' => $username,
				   
				);
				$qry = $this->db->insert('menu', $data);
				if ($qry) {
					$status = array('status'=>true);
				} else {
					unlink('./portal_assets/admin/images/static/'.$file_data['file_name']);
					$error = $this->db->_error_message();
					$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'nama_menu'=>$menu);
					return $status;
				}
			}
			else {
				$existImg = $this->getExistingImg($hidden_id);
				$data = array(
				   'isi' => $isi,
				   'gambar' => $file_data['file_name'],
				   'modified_by' => $username
				);
				$this->db->where('id', $hidden_id);
				$qry = $this->db->update('menu', $data); 
				
				// Error Checking
				if ($qry) {
					$status = array('status'=>true);
					($existImg[0]['gambar'] != "")?unlink('./portal_assets/admin/images/static/'.$existImg[0]['gambar']):false;
				} else {
					unlink('./portal_assets/admin/images/static/'.$file_data['file_name']);
					$error = $this->db->_error_message();
					$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'nama_menu'=>$menu);
					return $status;
				}
			}
			//return ($qry)?$status:$this->db->_error_message();
			
			// $data = array('upload_data' => $this->upload->data());
			// $this->load->view('webadmin/upload_success', $data);
		}
		//-------------
		
	}
	
	function saveNews($menu_id=null, $kategori=null, $judul=null, $isi=null, $hidden_id=null, $hidden_gbr=null, $del_image=null){
		$username = $this->session->userdata('username');
		
		$config['upload_path'] = './portal_assets/admin/images/news/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']    = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  = true;
		$this->load->library('upload', $config);
		
		$judul_seo = str_replace(" ","-",$judul);
		
		if (!$this->upload->do_upload())
		{
			$error = $this->upload->display_errors();
			if($error == '<p>You did not select a file to upload.</p>'){
				
				if(!$hidden_id){
					$data = array(
					   'menu_id' => $menu_id,
					   'kategori_id' => $kategori,
					   'judul' => $judul,
					   'judul_seo' => $judul_seo,
					   'headline' => null,
					   'isi_berita' => $isi ,
					   'gambar' => null,
					   'dibaca' => null,
					   'tag' => null,
					   'created_by' => $username
					);
					$qry = $this->db->insert('berita', $data);
					if ($qry) {
						$status = array('status'=>true);
					} else {
						$error = $this->db->_error_message();
						$status = array('status'=> false,'error' => $error, 'kategori_id'=>$kategori, 'judul' => $judul, 'isi_berita' => $isi, 'gambar' => $hidden_gbr, 'menu_id'=>$menu_id, 'id'=>$hidden_id);
						return $status;
					}
					//$status['status']=true;
				}
				else {
					if ($del_image) {
						$data = array(
						   'menu_id' => $menu_id,
						   'kategori_id' => $kategori,
						   'judul' => $judul,
						   'judul_seo' => $judul_seo,
						   'headline' => null,
						   'isi_berita' => $isi,
						   'gambar' => null,
						   'dibaca' => null,
						   'tag' => null,
						   'modified_by' => $username
						);
						$this->db->where('id', $hidden_id);
						$qry = $this->db->update('berita', $data); 
						if ($qry) {
							$status = array('status'=>true);
							unlink('./portal_assets/admin/images/news/'.$hidden_gbr);
						} else {
							$error = $this->db->_error_message();
							$status = array('status'=> false,'error' => $error, 'kategori_id'=>$kategori, 'judul' => $judul, 'isi_berita' => $isi, 'gambar' => $hidden_gbr, 'menu_id'=>$menu_id,'id'=>$hidden_id);
							return $status;
						}
						
					}
					else {
						$data = array(
						   'menu_id' => $menu_id,
						   'kategori_id' => $kategori,
						   'judul' => $judul,
						   'judul_seo' => $judul_seo,
						   'headline' => null,
						   'isi_berita' => $isi,
						   'dibaca' => null,
						   'tag' => null,
						   'modified_by' => $username
						);
						$this->db->where('id', $hidden_id);
						$qry = $this->db->update('berita', $data); 
						if ($qry) {
							$status = array('status'=>true);
						} else {
							$error = $this->db->_error_message();
							$status = array('status'=> false,'error' => $error, 'kategori_id'=>$kategori, 'judul' => $judul, 'isi_berita' => $isi, 'gambar' => $hidden_gbr, 'menu_id'=>$menu_id, 'id'=>$hidden_id);
							return $status;
						}
					}
					
				}
				return ($qry)?$status:$this->db->_error_message();
			}
			else {
				$status = array('error' => $error, 'kategori_id'=>$kategori, 'judul' => $judul, 'isi_berita' => $isi, 'gambar' => $hidden_gbr, 'menu_id'=>$menu_id, 'id'=>$hidden_id);
				return $status;
			}
			
			// $this->load->view('webadmin/tes_upload_form', $error);
		}
		else
		{	
			$file_data = $this->upload->data();
			
			if(!$hidden_id){
				$data = array(
				   'menu_id' => $menu_id,
				   'kategori_id' => $kategori,
				   'judul' => $judul,
				   'judul_seo' => $judul_seo,
				   'headline' => null,
				   'isi_berita' => $isi ,
				   'gambar' => $file_data['file_name'],
				   'dibaca' => null,
				   'tag' => null,
				   'created_by' => $username
				   
				);
				$qry = $this->db->insert('berita', $data);
				if ($qry) {
					$status = array('status'=>true);
				} else {
					unlink('./portal_assets/admin/images/news/'.$file_data['file_name']);
					$error = $this->db->_error_message();
					$status = array('status'=> false,'error' => $error, 'kategori_id'=>$kategori, 'judul' => $judul, 'isi_berita' => $isi, 'gambar' => $hidden_gbr, 'menu_id'=>$menu_id, 'id'=>$hidden_id);
					return $status;
				}
			}
			else {
				$existImg = $this->getExistingImgNews($hidden_id);
				$data = array(
				   'menu_id' => $menu_id,
				   'kategori_id' => $kategori,
				   'judul' => $judul,
				   'judul_seo' => $judul_seo,
				   'headline' => null,
				   'isi_berita' => $isi ,
				   'gambar' => $file_data['file_name'],
				   'dibaca' => null,
				   'tag' => null,
				   'modified_by' => $username
				);
				$this->db->where('id', $hidden_id);
				$qry = $this->db->update('berita', $data); 
				
				// Error Checking
				if ($qry) {
					$status = array('status'=>true);
					($existImg[0]['gambar'] != "")?unlink('./portal_assets/admin/images/news/'.$existImg[0]['gambar']):false;
				} else {
					unlink('./portal_assets/admin/images/news/'.$file_data['file_name']);
					$error = $this->db->_error_message();
					$status = array('status'=> false,'error' => $error, 'kategori_id'=>$kategori, 'judul' => $judul, 'isi_berita' => $isi, 'gambar' => $hidden_gbr, 'menu_id'=>$menu_id, 'id'=>$hidden_id);
					return $status;
				}
			}
			//return ($qry)?$status:$this->db->_error_message();
			
			// $data = array('upload_data' => $this->upload->data());
			// $this->load->view('webadmin/upload_success', $data);
		}
		//-------------
		
	}
	
	function deleteNews($id) {
		$qry = $this->db->delete('berita', array('id' => $id)); 
		return ($qry)?'success':$this->db->_error_message();
	}
	
}