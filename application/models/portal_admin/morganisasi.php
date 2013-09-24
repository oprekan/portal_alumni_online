<?php
class Morganisasi extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getOrganisasi($sort_name,$sort_order,$limit,$page_start,$search,$query)
    {
		$level = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		if ($level == "Super Administrator") {
			$this->db->select('organisasi.*,date_format(organisasi.ts,"%d %b %Y") as post_date,date_format(organisasi.ts,"%h:%i:%s %p") as post_time,kategori_organisasi.kategori',false);
			$this->db->from('organisasi');
			$this->db->join('kategori_organisasi','organisasi.kategori_id = kategori_organisasi.id','inner');
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		} else {
			$this->db->select('organisasi.*,date_format(organisasi.ts,"%d %b %Y") as post_date,date_format(organisasi.ts,"%h:%i:%s %p") as post_time,kategori_organisasi.kategori',false);
			$this->db->from('organisasi');
			$this->db->join('kategori_organisasi','organisasi.kategori_id = kategori_organisasi.id','inner');
			$this->db->where('created_by',$username);
			$this->db->or_where('username',$username);
			$this->db->like($search,$query);
			$this->db->order_by($sort_name,$sort_order);
			$this->db->limit($limit,$page_start);
			$res = $this->db->get();
		}
		return $res;
    }
	
	function getOrganisasiById($id) {
		$this->db->select('*');
		$this->db->from('organisasi');
		$this->db->where('id',$id);
		$sql = $this->db->get();
		return $sql;
	}
	
	function getKategori () {
		$this->db->select('*');
		$this->db->from('kategori_organisasi');
		$sql = $this->db->get();
		return $sql;
	}
	
	function getExistingImg ($id) {
		//Cek existing image
		$this->db->select('gambar');
		$this->db->from('organisasi');
		$this->db->where('id', $id);
		$res_cek = $this->db->get();
		$tot = $res_cek->num_rows();
		return ($tot > 0)?$res_cek->result_array() : false;
	}
	
	function saveData($id_kategori=null, $isi=null, $hidden_id=null, $hidden_gbr=null, $del_image=null){
		$username = $this->session->userdata('username');
		
		$config['upload_path'] = './portal_assets/admin/images/konten_organisasi/';
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
					   'kategori_id' => $id_kategori ,
					   'isi' => $isi ,
					   'created_by' => $username
					);
					$qry = $this->db->insert('organisasi', $data);
					if ($qry) {
						$status = array('status'=>true);
					} else {
						$error = $this->db->_error_message();
						$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'kategori_id'=>$id_kategori);
						return $status;
					}
					//$status['status']=true;
				}
				else {
					if ($del_image) {
						$data = array(
						   'kategori_id' => $id_kategori ,
						   'isi' => $isi ,
						   'gambar' => null,
						   'modified_by' => $username
						);
						$this->db->where('id', $hidden_id);
						$qry = $this->db->update('organisasi', $data); 
						if ($qry) {
							$status = array('status'=>true);
							unlink('./portal_assets/admin/images/konten_organisasi/'.$hidden_gbr);
						} else {
							$error = $this->db->_error_message();
							$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'kategori_id'=>$id_kategori);
							return $status;
						}
						
					}
					else {
						$data = array(
						   'kategori_id' => $id_kategori ,
						   'isi' => $isi ,
						   'modified_by' => $username
						);
						$this->db->where('id', $hidden_id);
						$qry = $this->db->update('organisasi', $data); 
						if ($qry) {
							$status = array('status'=>true);
						} else {
							$error = $this->db->_error_message();
							$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'kategori_id'=>$id_kategori);
							return $status;
						}
					}
					
				}
				return ($qry)?$status:$this->db->_error_message();
			}
			else {
				$status = array('error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'kategori_id'=>$id_kategori);
				return $status;
			}
			
			// $this->load->view('webadmin/tes_upload_form', $error);
		}
		else
		{	
			$file_data = $this->upload->data();
			
			if(!$hidden_id){
				$data = array(
				   'kategori_id' => $id_kategori,
				   'isi' => $isi,
				   'gambar' => $file_data['file_name'],
				   'created_by' => $username,
				   
				);
				$qry = $this->db->insert('organisasi', $data);
				if ($qry) {
					$status = array('status'=>true);
				} else {
					unlink('./portal_assets/admin/images/konten_organisasi/'.$file_data['file_name']);
					$error = $this->db->_error_message();
					$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'kategori_id'=>$id_kategori);
					return $status;
				}
			}
			else {
				$existImg = $this->getExistingImg($hidden_id);
				$data = array(
				   'kategori_id' => $id_kategori,
				   'isi' => $isi,
				   'gambar' => $file_data['file_name'],
				   'modified_by' => $username
				);
				$this->db->where('id', $hidden_id);
				$qry = $this->db->update('organisasi', $data); 
				
				// Error Checking
				if ($qry) {
					$status = array('status'=>true);
					($existImg[0]['gambar'] != "")?unlink('./portal_assets/admin/images/konten_organisasi/'.$existImg[0]['gambar']):false;
				} else {
					unlink('./portal_assets/admin/images/konten_organisasi/'.$file_data['file_name']);
					$error = $this->db->_error_message();
					$status = array('status'=> false,'error' => $error, 'isi' => $isi, 'gambar' => $hidden_gbr, 'id'=>$hidden_id, 'kategori_id'=>$id_kategori);
					return $status;
				}
			}
			//return ($qry)?$status:$this->db->_error_message();
			
			// $data = array('upload_data' => $this->upload->data());
			// $this->load->view('webadmin/upload_success', $data);
		}
		//-------------
		
	}
	
	function deleteOrganisasi($id) {
		$qry = $this->db->delete('organisasi', array('id' => $id)); 
		return ($qry)?'success':$this->db->_error_message();
	}
}