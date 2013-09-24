<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	---------------------------------------------
*	Desc 		: Controller for Content Management
*	Created By 	: Yagi Anggar Prahara
*	Date		: 13 Sept 2012
*	---------------------------------------------
*	All right reserved
**/
class Content extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('portal_admin/mcontent');
	}
	
	public function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'content_menu'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/content/'=>'Content List'
				)
				,'title'=>'Content Management');
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
		
		$resParent = $this->mcontent->getParentMenu($sort_name,$sort_order,$limit,$page_start,$search,$query);
		
		$data = Array();
		//$data['total'] =  $this->db->count_all_results('kategori_organisasi');
		$data['page'] = $page;
		$no = $page_start;
		
		if ($resParent->num_rows() > 0) {
			foreach ($resParent->result_array() as $rowParent) {
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
						'edit' => null,
						'delete' => null
					)
				);
				$resChild = $this->mcontent->getChildMenu($sort_name,$sort_order,$limit,$page_start,$search,$query,$rowParent['id']);
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
	
	public function get_news() {
		$sort_name = $this->input->post('sortname');
		$sort_order = $this->input->post('sortorder');
		$limit = $this->input->post('rp');
		$page = ($this->input->post('page'))?$this->input->post('page'):1;
		$search = $this->input->post('qtype');
		$query = $this->input->post('query');
		
		$page_start = ($page-1)*$limit;
		
		$res = $this->mcontent->getNews($sort_name,$sort_order,$limit,$page_start,$search,$query);
		$data = Array();
		$data['total'] =  $this->db->count_all_results('berita');
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
						'menu_id' => $row['menu_id'],
						'kategori_id' => $row['kategori_id'],
						'nama_kategori' => $row['nama_kategori'],
						'judul' => $row['judul'],
						'created_by' => $row['created_by'],
						'modified_by' => $row['modified_by'],
						'post_date' => $row['post_date'],
						'edit' => "<input type='image' style='height:13px;' title='Edit' src='portal_assets/admin/images/icn_edit.png'>",
						'delete' => "<input type='image' style='height:13px;' title='Trash' src='portal_assets/admin/images/icn_trash.png'>"
					)
				);
				//$no++;
			}
		} else {
			$data['total'] =  0;
			$data['page'] = 1;
			$data['rows'][] = array();
			//$data['total'] = $res->num_rows();
		}
		echo json_encode($data);
	}
	
	function save_process(){
		$menu = trim($this->input->post('menu'));
		$isi = trim($this->input->post('isi'));
		$hidden_id = trim($this->input->post('hidden_id'));
		$hidden_gbr = trim($this->input->post('hidden_gbr'));
		$del_image = trim($this->input->post('del_image'));

		$res = $this->mcontent->saveData($menu, $isi, $hidden_id, $hidden_gbr, $del_image);
		if (isset($res['error'])) {
			// $resKat = $this->mcontent->getKategori();
			$data = array(
				'page'=>'content_form'
				,'information_message'=>$res['error']
				,'alert' => 'alert_error'
				,'breadcumbs'=>array(
					'portal_admin/content/'=>'Content List',
					'portal_admin/content/manage' => 'Manage Content'
				)
				,'data' => array($res)
				,'title'=>'Content Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect('portal_admin/content');
		}
	}
	
	function save_news(){
		$kategori = trim($this->input->post('kategori'));
		$judul = trim($this->input->post('judul'));
		$isi = trim($this->input->post('isi'));
		$menu_id = trim($this->input->post('hidden_menu_id'));
		$hidden_id = trim($this->input->post('hidden_id'));
		$hidden_gbr = trim($this->input->post('hidden_gbr'));
		$del_image = trim($this->input->post('del_image'));

		$res = $this->mcontent->saveNews($menu_id, $kategori, $judul, $isi, $hidden_id, $hidden_gbr, $del_image);
		if (isset($res['error'])) {
			$resNewsCat = $this->mcontent->getNewsCategory();
			$data = array(
				'page'=>'news_form'
				,'information_message'=>$res['error']
				,'alert' => 'alert_error'
				,'breadcumbs'=>array(
					'portal_admin/content/'=>'Content List',
					'portal_admin/content/manage/'.$menu_id.'/NP'=>'News List',
					'portal_admin/content/manage_news' => 'Manage News'
				)
				,'combo_kategori' => ($resNewsCat->num_rows() > 0)?$resNewsCat->result_array():null
				,'data' => array($res)
				,'title'=>'News Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect('portal_admin/content/manage/'.$menu_id.'/NP');
		}
	}	
	
	function manage($id,$jenis_page) {
		if ($this->session->userdata('login') == TRUE)
		{
			if ($jenis_page == "SP") {
				$res = $this->mcontent->getContentById($id);
				$rs = $res->result_array();
				$data = array(
					'page'=>'content_form'
					,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
					,'breadcumbs'=>array(
						'portal_admin/content/'=>'Content List',
						'portal_admin/content/manage' => 'Manage Content'
					)
					,'data' => $rs
					,'title'=>'Content Management');
				$this->parser->parse('portal_admin/template/main_template',$data);
			} else if ($jenis_page == "NP") {
				$res = $this->mcontent->getContentById($id);
				$rs = $res->result_array();
				$data = array(
					'page'=>'news'
					,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
					,'breadcumbs'=>array(
						'portal_admin/content/'=>'Content List',
						'portal_admin/content/manage/'=>'News List'
					)
					,'data' => $rs
					,'menu_id' => $id
					,'title'=>'Content Management');
				$this->parser->parse('portal_admin/template/main_template',$data);
			}
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function manage_news ($menu_id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$resNewsCat = $this->mcontent->getNewsCategory();
			$data = array(
				'page'=>'news_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/content/'=>'Content List',
					'portal_admin/content/manage/'.$menu_id.'/NP' => 'News List',
					'portal_admin/content/manage_news' => 'Manage News'
				)
				,'combo_kategori' => ($resNewsCat->num_rows() > 0)?$resNewsCat->result_array():null
				,'menu_id' => $menu_id
				,'title'=>'News Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function update_news($id,$menu_id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$resNewsCat = $this->mcontent->getNewsCategory();
			$res = $this->mcontent->getNewsById($id);
			$rs = $res->result_array();
			$data = array(
				'page'=>'news_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/content/'=>'Content List',
					'portal_admin/content/manage/'.$menu_id.'/NP' => 'News List',
					'portal_admin/content/manage_news' => 'Manage News'
				)
				,'combo_kategori' => ($resNewsCat->num_rows() > 0)?$resNewsCat->result_array():null
				,'data' => $rs
				,'menu_id' => $menu_id
				,'title'=>'News Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function delete_news () {
		if ($this->session->userdata('login') == TRUE)
		{
			$id = $this->input->post('id');
			$existImg = $this->mcontent->getExistingImgNews($id);
			$res = $this->mcontent->deleteNews($id);
			if ($res=="success") {
				echo $res;
				($existImg[0]['gambar'] != "")?unlink('./portal_assets/admin/images/news/'.$existImg[0]['gambar']):false;
			} else {
				echo $res;
			}
		}
		else {
			redirect("lapak_admin");
		}
	}
	
}