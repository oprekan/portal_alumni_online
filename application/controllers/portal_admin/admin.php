<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('portal_admin/madmin');
	}
	
	public function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'welcome'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/admin/'=>'Home'
				)
				,'title'=>'Administrator Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function manage_admin () {
		if ($this->session->userdata('login') == TRUE)
		{
			$data = array(
				'page'=>'admin'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/admin/'=>'Home',
					'portal_admin/admin/manage_admin' => 'Manage Admin'
				)
				,'title'=>'Administrator Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function login() {
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$res = $this->madmin->check_user($username, $password);
		if ($res == TRUE)
		{
			$_SESSION['KCFINDER']=array();
			$_SESSION['KCFINDER']['disabled'] = false;
			$_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
			$_SESSION['KCFINDER']['uploadDir'] = "";
			
			foreach($res['result'] as $row){
				$data['login'] = true;
				$data['username'] = $row['username'];
				$data['nama_lengkap']= $row['nama_lengkap'];
				$data['password'] = $row['password'];
				$data['level'] = $row['level'];
			}
			// exit;
			// $data = array('username' => $username, 'login' => TRUE);
			$this->session->set_userdata($data);
			echo "success";
			// redirect('index.php/webadmin/main/home');
		}
		else
		{
			$resp['msg'] = "Sorry, Wrong username or password";
			$resp['status'] = false;
			echo $resp['msg'];
		}
	}
	
	function logout() {
		$this->session->sess_destroy();
		redirect('lapak_admin/', 'refresh');
		// $this->load->view('webadmin/login');
	}
	
	public function get_admin() {
		
		$sort_name = $this->input->post('sortname');
		$sort_order = $this->input->post('sortorder');
		$limit = $this->input->post('rp');
		$page = ($this->input->post('page'))?$this->input->post('page'):1;
		$search = $this->input->post('qtype');
		$query = $this->input->post('query');
		
		$page_start = ($page-1)*$limit;
		
		$res = $this->madmin->getAdmin($sort_name,$sort_order,$limit,$page_start,$search,$query);
		$data = Array();
		$data['total'] =  $this->db->count_all_results('admin');
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
						'username' => $row['username'],
						'nama_lengkap' => $row['nama_lengkap'],
						'level' => $row['level'],
						'blokir' => $row['blokir'],
						'email' => $row['email'],
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
		}
		echo json_encode($data);
	}
	
	function add_admin () {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->madmin->getLevelAdmin();
			$data = array(
				'page'=>'admin_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/admin/'=>'Home',
					'portal_admin/admin/manage_admin' => 'Manage Admin',
					'portal_admin/admin/add_admin' => 'Add Admin'
				)
				,'combo_level' => ($res->num_rows() > 0)?$res->result_array():null
				,'title'=>'Administrator Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function save_process(){
		$username = trim($this->input->post('username'));
		$nama = trim($this->input->post('nama'));
		$email = trim($this->input->post('email'));
		$pass = trim($this->input->post('password'));
		$level = trim($this->input->post('level'));
		$blokir = trim($this->input->post('blokir'));
		$hidden_id = trim($this->input->post('hidden_id'));
		$res = $this->madmin->saveAdmin($username, $nama, $email, $pass, $level, $blokir, $hidden_id);
		echo $res;
		// redirect('index.php/webadmin/users/');
	}	
	
	function update_admin($id) {
		if ($this->session->userdata('login') == TRUE)
		{
			$res = $this->madmin->getAdminById($id);
			$rs = $res->result_array();
			$level_admin = $this->madmin->getLevelAdmin();
			$data = array(
				'page'=>'admin_form'
				,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
				,'breadcumbs'=>array(
					'portal_admin/admin/'=>'Home',
					'portal_admin/admin/manage_admin' => 'Manage Admin',
					'portal_admin/admin/update_admin/$id' => 'Update Admin'
				)
				,'data' => $rs
				,'combo_level' => ($level_admin->num_rows() > 0)?$level_admin->result_array():null
				,'title'=>'Administrator Management');
			$this->parser->parse('portal_admin/template/main_template',$data);
		}
		else {
			redirect("lapak_admin");
		}
	}
	
	function delete_admin () {
		if ($this->session->userdata('login') == TRUE)
		{
			$id = $this->input->post('id');
			$res = $this->madmin->deleteAdmin($id);
			echo $res;
		}
		else {
			redirect("lapak_admin");
		}
	}
}