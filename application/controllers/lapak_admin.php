<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lapak_admin extends CI_Controller {
	public function index()
	{
		$this->load->view('portal_admin/login');
		// $data = array(
            // 'page'=>'test_content'
            // ,'information_message'=>'SELAMAT DATANG DI HALAMAN ADMINISTRATOR'
			// ,'breadcumbs'=>array(
				// 'lapak_admin/'=>'Website Admin'
			// )
            // ,'title'=>'Test Cotnent');
        // $this->parser->parse('portal_admin/template/main_template',$data);
	} 
	
	public function dashboard () {
		$data = array(
            'page'=>'dashboard'
            ,'information_message'=>'Ini Halaman Dashboard'
			,'breadcumbs'=>array(
				'lapak_admin/'=>'Website Admin',
				'portal_admin/dashboard'=>'Dashboard'
			)
            ,'title'=>'Dashboard');
        $this->parser->parse('portal_admin/template/main_template',$data);
	}
}