<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	---------------------------------------------
*	Desc 		: Controller for kategori organisasi
*	Created By 	: Yagi Anggar Prahara
*	Date		: 09 August 2012
*	---------------------------------------------
*	All right reserved
**/
class Kategori_organisasi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('portal_admin/mkategoriorganisasi');
	}
	
	public function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'kategori_organisasi'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/admin/'=>'Kategori Organisasi'
				)
				,'title'=>'Administrator Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	public function get_kategori() {
		
		$sort_name = $this->input->post('sortname');
		$sort_order = $this->input->post('sortorder');
		$limit = $this->input->post('rp');
		$page = ($this->input->post('page'))?$this->input->post('page'):1;
		$search = $this->input->post('qtype');
		$query = $this->input->post('query');
		
		$page_start = ($page-1)*$limit;
		
		$res = $this->mkategoriorganisasi->getKategori($sort_name,$sort_order,$limit,$page_start,$search,$query);
		$data = Array();
		$data['total'] =  $this->db->count_all_results('kategori_organisasi');
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
						'kategori' => $row['kategori'],
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
	
	function add_kategori () {
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'kategori_organisasi_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/kategori_organisasi/'=>'Kategori Organisasi',
					'portal_admin/kategori_organisasi/add_kategori' => 'Add Kategori'
				)
				,'title'=>'Kategori Organisasi Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function save_process(){
		$kategori = trim($this->input->post('kategori'));
		$hidden_id = trim($this->input->post('hidden_id'));
		$res = $this->mkategoriorganisasi->saveKategori($kategori, $hidden_id);
		echo $res;
		// redirect('index.php/webadmin/users/');
	}	
	
	function update_kategori($id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->mkategoriorganisasi->getKategoriById($id);
			$rs = $res->result_array();
			
			$data = array(
				'page'=>'kategori_organisasi_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/kategori_organisasi/'=>'Kategori Organisasi',
					'portal_admin/kategori_organisasi/add_kategori' => 'Update Kategori'
				)
				,'data' => $rs
				,'title'=>'Kategori Organisasi Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function delete_kategori () {
		if ($this->session->userdata('login') == TRUE)
		{
			$id = $this->input->post('id');
			$res = $this->mkategoriorganisasi->deleteKategori($id);
			echo $res;
		}
		else {
			redirect("lapak_admin");
		}
	}
}