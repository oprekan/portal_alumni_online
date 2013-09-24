<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	---------------------------------------------
*	Desc 		: Controller for Menu Management
*	Created By 	: Yagi Anggar Prahara
*	Date		: 01 Sept 2012
*	---------------------------------------------
*	All right reserved
**/
class Menu extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('portal_admin/mmenu');
	}
	
	public function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'menu'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/admin/'=>'List Menu'
				)
				,'title'=>'Menu Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	public function get_menu() {
		
		$sort_name = $this->input->post('sortname');
		$sort_order = $this->input->post('sortorder');
		$limit = $this->input->post('rp');
		$page = ($this->input->post('page'))?$this->input->post('page'):1;
		$search = $this->input->post('qtype');
		$query = $this->input->post('query');
		
		$page_start = ($page-1)*$limit;
		
		$resParent = $this->mmenu->getParentMenu($sort_name,$sort_order,$limit,$page_start,$search,$query);
		
		$data = Array();
		//$data['total'] =  $this->db->count_all_results('kategori_organisasi');
		$data['page'] = $page;
		$no = $page_start;
		
		if ($resParent->num_rows() > 0) {
			foreach ($resParent->result_array() as $rowParent) {
				$this->authlib->log($rowParent);
				$no++;
				$data['rows'][] = array(
					'id' => $rowParent['id'],
					'cell' => array(
						//'no' => $no,
						'id' => $rowParent['id'],
						'parent_id' => $rowParent['parent_id'],
						'jenis_id' => $rowParent['jenis_id'],
						'nama_menu' => '<b>|&mdash; '.$rowParent['nama_menu'].'</b>',
						'nama_menu2' => $rowParent['nama_menu'],
						'urutan' => '<b>'.$rowParent['urutan'].'</b>',
						'up' => "<input class='up' type='image' style='height:15px;' title='Up' src='portal_assets/admin/images/up.png'>",
						'down' =>  "<input class='down' type='image' style='height:15px;' title='Down' src='portal_assets/admin/images/down.png'>",
						'link' => '-',
						'tipe' => '<b>'.$rowParent['tipe'].'</b>',
						'edit' => "<input type='image' style='height:13px;' title='Edit' src='portal_assets/admin/images/icn_edit.png'>",
						'delete' => "<input type='image' style='height:13px;' title='Trash' src='portal_assets/admin/images/icn_trash.png'>"
					)
				);
				$resChild = $this->mmenu->getChildMenu($sort_name,$sort_order,$limit,$page_start,$search,$query,$rowParent['id']);
				foreach ($resChild->result_array() as $rowChild){
					// if ($rowChild['parent_id'] == $rowParent['id']){
						$data['rows'][] = array(
							'id' => $rowChild['id'],
							'cell' => array(
								//'no' => $no,
								'id' => $rowChild['id'],
								'parent_id' => $rowChild['parent_id'],
								'jenis_id' => $rowChild['jenis_id'],
								'nama_menu' => '|&mdash; |&mdash; '.$rowChild['nama_menu'],
								'nama_menu2' => $rowChild['nama_menu'],
								'urutan' => $rowChild['urutan'],
								'up' => "<input class='up' type='image' style='height:15px;' title='Up' src='portal_assets/admin/images/up.png'>",
								'down' =>  "<input class='down' type='image' style='height:15px;' title='Down' src='portal_assets/admin/images/down.png'>",
								'link' => $rowChild['link'],
								'tipe' => $rowChild['tipe'],
								'edit' => "<input type='image' style='height:13px;' title='Edit' src='portal_assets/admin/images/icn_edit.png'>",
								'delete' => "<input type='image' style='height:13px;' title='Trash' src='portal_assets/admin/images/icn_trash.png'>"
							)
						);
					// }
				}
			}
		} else {
			$data['rows'][] = array();
		}
		$totalData = count($data['rows']);
		$data['total'] = $totalData;
			
		echo json_encode($data);
	}
	
	function add_menu () {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->mmenu->getAllMenu();
			$jenis = $this->mmenu->getJenisMenu();

			$data = array(
				'page'=>'menu_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/menu/'=>'List Menu',
					'portal_admin/menu/add_menu' => 'Add Menu'
				)
				,'combo_menu' => $res
				,'combo_jenis' => $jenis
				,'title'=>'Menu Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function save_process(){
		$parent_id = (trim($this->input->post('parent_id')))?trim($this->input->post('parent_id')):NULL;
		$jenis_id = (trim($this->input->post('jenis_id')))?trim($this->input->post('jenis_id')):NULL;
		$link_menu = trim($this->input->post('link_menu'));
		$nama_menu = trim($this->input->post('nama_menu'));
		$desc_menu = trim($this->input->post('desc_menu'));
		$hidden_id = trim($this->input->post('hidden_id'));
		$res = $this->mmenu->saveMenu($parent_id,$jenis_id,$link_menu,$nama_menu,$desc_menu,$hidden_id);
		echo $res;
		// redirect('index.php/webadmin/users/');
	}	
	
	function update_menu($id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->mmenu->getMenuById($id);
			$rs = $res->result_array();
			$resAllMenu = $this->mmenu->getAllMenu();
			$jenis = $this->mmenu->getJenisMenu();
			$data = array(
				'page'=>'menu_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/menu/'=>'List Menu',
					'portal_admin/menu/update_menu' => 'Update Menu'
				)
				,'combo_menu' => $resAllMenu
				,'combo_jenis' => $jenis
				,'data' => $rs
				,'title'=>'Menu Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function order () {
		if ($this->session->userdata('login') == TRUE)
		{
			$id = $this->input->post('id');
			$order = $this->input->post('order');
			$parent_id = $this->input->post('parent_id');
			$tipe = $this->input->post('tipe');
			$urutan = $this->input->post('urutan');
			$res = $this->mmenu->order($id,$order,$parent_id,$tipe,$urutan);
			echo $res;
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function delete_menu () {
		if ($this->session->userdata('login') == TRUE)
		{
			$id = $this->input->post('id');
			$res = $this->mmenu->deleteMenu($id);
			echo $res;
		}
		else {
			redirect("lapak_admin");
		}
	}
}