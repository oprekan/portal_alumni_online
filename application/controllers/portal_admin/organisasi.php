<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Organisasi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('portal_admin/morganisasi');
	}
	
	public function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'organisasi'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/admin/'=>'Content List'
				)
				,'title'=>'Organizational Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	public function get_organisasi() {
		
		$sort_name = $this->input->post('sortname');
		$sort_order = $this->input->post('sortorder');
		$limit = $this->input->post('rp');
		$page = ($this->input->post('page'))?$this->input->post('page'):1;
		$search = $this->input->post('qtype');
		$query = $this->input->post('query');
		
		$page_start = ($page-1)*$limit;
		
		$res = $this->morganisasi->getOrganisasi($sort_name,$sort_order,$limit,$page_start,$search,$query);
		$data = Array();
		$data['total'] =  $this->db->count_all_results('organisasi');
		$data['page'] = $page;
		$no = $page_start;
		if ($res->num_rows() > 0) {
			foreach ($res->result_array() as $row) {
				$no++;
				if($no <= 9) $ino = '0'.$no;
				$data['rows'][] = array(
					'id' => $row['id'],
					'cell' => array(
						'no' => $no,
						'id' => $row['id'],
						'kategori_id' => $row['kategori_id'],
						'kategori' => $row['kategori'],
						'isi' => $row['isi'],
						'gambar' => $row['gambar'],
						'created_by' => $row['created_by'],
						'modified_by' => $row['modified_by'],
						'ts' => $row['post_date'],
						'time' => $row['post_time'],
						'edit' => "<input type='image' style='height:13px;' title='Edit' src='portal_assets/admin/images/icn_edit.png'>",
						'delete' => "<input type='image' style='height:13px;' title='Trash' src='portal_assets/admin/images/icn_trash.png'>"
					)
				);
				//$no++;
			}
		} else {
			$data['rows'][] = array();
			//$data['total'] = $res->num_rows();
		}
		echo json_encode($data);
	}
	
	function add_organisasi () {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->morganisasi->getKategori();
			$data = array(
				'page'=>'organisasi_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/organisasi/'=>'Content List',
					'portal_admin/organisasi/add_organisasi' => 'Manage Content'
				)
				,'combo_kategori' => ($res->num_rows() > 0)?$res->result_array():null
				,'title'=>'Content Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function save_process(){
		$kategori = trim($this->input->post('kategori'));
		$isi = trim($this->input->post('isi'));
		$hidden_id = trim($this->input->post('hidden_id'));
		$hidden_gbr = trim($this->input->post('hidden_gbr'));
		$del_image = trim($this->input->post('del_image'));

		$res = $this->morganisasi->saveData($kategori, $isi, $hidden_id, $hidden_gbr, $del_image);
		if (isset($res['error'])) {
			// print_r($res['error']); 
			//$menu = $this->get_menu();
			//$modul['data']['pengajarandata'] = $this->get_category();
			$resKat = $this->morganisasi->getKategori();
			$data = array(
				'page'=>'organisasi_form'
				,'information_message'=>$res['error']
				,'alert' => 'alert_error'
				,'breadcumbs'=>array(
					'portal_admin/organisasi/'=>'Content List',
					'portal_admin/organisasi/add_organisasi' => 'Manage Content'
				)
				,'combo_kategori' => ($resKat->num_rows() > 0)?$resKat->result_array():null
				,'data' => array($res)
				,'title'=>'Content Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
			
			
			// $modul['data']['status'] = $res;
			// $isi2['file']='pengajaran_form';
			
			// $arr_data = array_merge($menu,$isi2);
			// $arr_data2 = array_merge($arr_data,$modul);
			// $this->load->view('webadmin/media',array_merge($arr_data2));
		}
		else {
			redirect('portal_admin/organisasi');
		}
	}	
	
	function update_organisasi($id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->morganisasi->getOrganisasiById($id);
			$rs = $res->result_array();
			$resKat = $this->morganisasi->getKategori();
			$data = array(
				'page'=>'organisasi_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/organisasi/'=>'Content List',
					'portal_admin/organisasi/update_organisasi' => 'Manage Content'
				)
				,'combo_kategori' => ($resKat->num_rows() > 0)?$resKat->result_array():null
				,'data' => $rs
				,'title'=>'Content Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function delete_organisasi () {
		if ($this->session->userdata('login') == TRUE)
		{
			$id = $this->input->post('id');
			$existImg = $this->morganisasi->getExistingImg($id);
			$res = $this->morganisasi->deleteOrganisasi($id);
			if ($res=="success") {
				echo $res;
				($existImg[0]['gambar'] != "")?unlink('./portal_assets/admin/images/konten_organisasi/'.$existImg[0]['gambar']):false;
			} else {
				echo $res;
			}
		}
		else {
			redirect("lapak_admin");
		}
	}
}