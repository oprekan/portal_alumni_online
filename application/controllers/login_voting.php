<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_voting extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('mlogin');
	}
	
	function index() {
		$this->load->view('online_voting/login_form');
	}
	
	function cek_login () {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$resLogin = $this->mlogin->checkLogin($username,$password);
		
		if ($resLogin == TRUE)
		{
			$token = md5(microtime(TRUE) . rand(0, 100000));
			foreach($resLogin['result'] as $row){
				$data['login'] = true;
				$data['username'] = $row['username'];
				$data['nama']= $row['nama'];
				$data['nim']= $row['nim'];
				$data['angkatan']= $row['angkatan'];
				$data['prodi']= $row['nama_prodi'];
				$data['password'] = $row['password'];
				$data['divisi'] = $row['nama_divisi'];
				$data['token'] = $token;
				$data['token-expiration'] = time() + 1800;
			}

			print_r($data);
			$this->session->set_userdata($data);
			$resp['msg'] = "Login success";
			$resp['status'] = true;
		}
		else
		{
			$resp['msg'] = "Sorry, Wrong username or password";
			$resp['status'] = false;
		}
		echo json_encode($resp);
	}
	
	function logout () {
		$this->session->sess_destroy();
		redirect('login_voting/', 'refresh');
	}
}